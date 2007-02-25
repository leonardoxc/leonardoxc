#!/usr/bin/perl -w
#---------------------------------------------------------------
# Tcp server - logger for gpspilot packet format
# Copyright 2006 Manolis Andreadakis
# andread@thenet.gr
#---------------------------------------------------------------

#--------------------------------------------------------------
#
# Mysql table creation statement:
#
# CREATE TABLE `leonardo_live_data` (
#  `id` bigint(20) unsigned NOT NULL auto_increment,
#  `ip` varchar(32) NOT NULL,
#  `port` mediumint(8) unsigned NOT NULL default '0',
#  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
#  `tm` bigint(20) unsigned NOT NULL default '0',
#  `username` varchar(40) NOT NULL default '',
#  `passwd` varchar(40) NOT NULL default '',
#  `lat` float(10,7) NOT NULL default '0.0000000',
#  `lon` float(10,7) NOT NULL default '0.0000000',
#  `alt` smallint(5) unsigned NOT NULL default '0',
#  `sog` smallint(5) unsigned NOT NULL default '0',
#  `cog` smallint(5) unsigned NOT NULL default '0',
#  PRIMARY KEY  (`id`),
#  KEY `phone` (`username`)
#) ENGINE=MyISAM ;
#
#--------------------------------------------------------------

use IO::Socket;
use DBI;
use Proc::Daemon;
use Proc::PID::File;

#use strict;

sub proccessPacket($);
sub logDbg($);
sub logmsg($);

#---------------------------------------------------
# Configuration
#---------------------------------------------------
#-- Port to use
$server_port = 999;

# basic DB info 
#my $DBname="paraglidingforum";
#my $DBhost="thales.thenet.gr";
#my $user = "pgforumftp";
#my $password = "K7v#3E!2";

my $DBname="pgforum";
my $DBhost="localhost";
my $user = "pgforumftp";
my $password = "K7v#3E!2";
#---------------------------------------------------
# end of configuration
#---------------------------------------------------



$scriptName=$0;
$scriptName =~/\/(\w+).pl$/g;
$scriptName=$1;

if ( $#ARGV >= 0 ) {
  $cmd= $ARGV[0];
} else {
  print "Usage : $scriptName (start|stop|status)\n";
  exit;
}

 ($scriptDIR=$0) =~ s/([^\/\\]*)$// ;
 push (@INC,$scriptDIR);

 $ipAddr="";
 $port="";

# proc manipulation stuff
  $proc_name=$scriptName;

  # when we get a INT signal, set the exit flag
  $SIG{'INT'} =
  sub {
    logmsg("Got INT signal , preparing for exit");

    #local $SIG{INTHUP} = 'IGNORE';   # exempt myself
    #kill(INT, -$$); 

    $::exit = 1;
  } ;

  $SIG{CHLD} ='IGNORE';

  # did we get a stop command?
  if ($cmd eq "stop" )
  {
    # we need to send a signal to the running process to tell it to quit
    # get the pid file (in /var/run by default)
    my $pid = Proc::PID::File->running(name => $proc_name);
    unless ($pid)
     { die "Not already running!" }

    # and send a signal to that process
    kill(2,$pid);  # you may need a different signal for your system
    print "Stop signal sent!\n";
    exit;
  }  elsif ($cmd eq "status") {
      $proc_id=Proc::PID::File->running(name => $proc_name );
      if ($proc_id) { 
	print "Running ($proc_name) with PID : $proc_id\n";
      }
      else { print "Not running\n"; }

	print ">>>> Sockets -----------------------------------------------------------------------------------\n";
	system ("netstat -an |grep :$server_port");
	print ">>>> Logfile -----------------------------------------------------------------------------------\n";
	system ("tail -20 $scriptDIR$scriptName.log");
      exit;
  }

  # write the pid file, exiting if there's one there already.
  # this pid file will automatically be deleted when this script
  # exits.
  $proc_id=Proc::PID::File->running(name => $proc_name );
  if ($proc_id)
  {
    print "Already running ($proc_name) with PID : $proc_id\n";
    exit;
  }



logmsg("Starting Leo Live Server Non-blocking TCP Server");
logmsg("Working dir: $scriptDIR");

$server = IO::Socket::INET->new(LocalPort => $server_port,
                                Type      => SOCK_STREAM,
                                Reuse     => 1,
                                Listen    => 15 )   # or SOMAXCONN
    or die "Couldn't be a tcp server on port $server_port : $@\n";

logmsg( "Listening on Port: $server_port.");


#we get the proccessId of the server thread
#$parentProcID=$$;

REQUEST:
while ( (!$::exit) && ( $client = $server->accept() )  ) {
    if ($kidpid = fork) {
        close ($client);  # parent closes unused handle
        next REQUEST;
    } 
    defined($kidpid)   or die "cannot fork: $!" ;
    
    close($server);             # child closes unused handle
    
    select($client);           # new default for prints
    $| = 1;                   # autoflush
    $client->autoflush(1);


    #-- Here we lookup the client's address
    my($portNum, $ipaddrNum) = sockaddr_in($client->peername);
    $ipAddr= inet_ntoa($ipaddrNum);
    $port=$portNum;
    $hostInfo = $ipAddr.":".$port;

    # $client is the new connection and we can use this like a file handle
    # Here we do some work for this connection
    
    logmsg("Connection request received from ($hostInfo)");

    $packetStr="";
    $dbgStr="";
    $flushedInput=0;

    $prevInChar=255; # not 0 

 $data_source = 'dbi:mysql:database='.$DBname.';host='.$DBhost;
 $dbh = DBI->connect($data_source, $user, $password)
      or die "Can't connect to $data_source: $DBI::errstr";
# $sql_stmt;

$sql_stmt = q{ INSERT INTO leonardo_live_data (ip,port,tm,username,passwd,lat,lon,alt,sog,cog) VALUES (?,?,?,?,?,?,?,?,?,?) };
$sth = $dbh->prepare( $sql_stmt ) or die "Can't prepare statement: $DBI::errstr";

    while ( sysread $client,$buffer,1 ) {

      $dbgStr.=$buffer;

      $inChr=ord($buffer);

      if ($inChr==0 && $prevInChar==0) {
	# we got a packet
	# lets log it 
        logmsg("message->$packetStr*");

	# analyze it and take appropriate action
	proccessPacket($packetStr);

        $packetStr="";
        $flushedInput=1;
       } else {
         $flushedInput=0;
	 if ($inChr > 31) {
           $packetStr= $packetStr.$buffer;
         }
      }
      $prevInChar=$inChr; 

    } # end while sysread

   if ( $flushedInput != 1) { 
	logmsg("Flushing last unfinished input");
	logmsg("message->$packetStr*");
	proccessPacket($packetStr);
   }

   logDbg($dbgStr);
   logmsg("Closing socket");
   close ($client);
   logmsg("Child exits");
   exit;
}

logmsg( "Server terminated.");
close($server);
close OUT1;

# now send INT signal to close all childs
local $SIG{INT} = 'IGNORE';   # exempt myself
kill(INT, -$$);               # signal my own process group


sub logmsg($) {
 my $logfilename= "$scriptDIR$scriptName.log";
 open OUT, ">> $logfilename " or die "Cannot open $logfilename for write :$!";
 print OUT scalar( localtime ), ": ip->$ipAddr port->$port pid->$$: @_ \n";
 close OUT;
}

sub logDbg($) {
  my $msg=shift;
  $logfilename1= $scriptDIR."raw.log";
  open OUT1, ">> $logfilename1 " or die "Cannot open $logfilename1 for write :$!";


  print OUT1 "----------------------------------------------------------------------\n";
  print OUT1 scalar( localtime ), ": ip->$ipAddr port->$port pid->$$\n";
  # print OUT1 "$msg\n--------------------------------\n";

  @chars = split(//, $msg);

  $out1="";
  $out2="";
  $i=0;

  foreach $c (@chars) {

        $out2.=sprintf(" %02x",ord($c) );
  	$c =~ tr/[\n\r\t\000-\x1f]/./;
        $out1.=$c;

        $i++;
        if ($i==16) {
                $i=0;
                print OUT1 $out1."   ".$out2."\n";
                $out1="";
                $out2="";
        }
  }
  if ($i!=16) {
        printf OUT1 "%-16s   %s\n", $out1, $out2;
  }
  close OUT1;

} # end function

sub log_gps_pos {

  my $username=shift;
  my $passwd=shift;
  my $lat=shift;
  my $lon=shift;
  my $alt=shift;
  my $sog=shift;
  my $cog=shift;

  my $tm=time();

  my $rc = $sth->execute($ipAddr,$port,$tm,$username,$passwd,$lat,$lon,$alt,$sog,$cog)
 		or logmsg("Cant execute statement with VALUES($ipAddr,$port,$tm,$username,$passwd,$lat,$lon,$alt,$sog,$cog) ");
     # or die "Can't execute statement: $DBI::errstr";

}


sub scanLine {
   my $inStr=shift;

   $_=$inStr;
   # the first string from a connection is
   # norad:live|268|01|1$*
   if ( $inStr=~/[^\w]*(.+):(.+)\|\d+\|\d+\|\d/ ) {
      $username=$1;
      $pass=$2;
      return (1,$username,$pass);
   }

   # next we need
   #!P03384280N<<091715W<<140<<0<<256"

   if ( $inStr=~/P..(.+)<<(.+)<<(.+)<<(.+)<<([0-9]+)/ ) {
      $lat=$1;
      $lon=$2;
      $alt=$3;
      $sog=$4;
      $cog=$5;

      if ( $lat=~/(\d{2})(\d{2})(\d{2})([SN])/i ) {
                $lat=$1+($2+$3/100)/60 ;
                $orientation=$4;
                if ($orientation eq 'S') { $lat=-$lat;}
                $lat+=0;
      }
      if ( $lon=~/(\d{2})(\d{2})(\d{2})([EW])/i ) {
                $lon=$1+($2+$3/100)/60 ;
                $orientation=$4;
                if ($orientation eq 'W') { $lon=-$lon; }
                $lon+=0;
      }

      return (2,$lat,$lon,$alt,$sog,$cog);
   }

   return (0);

}

sub proccessPacket($) {
	my $packetStr=shift;
        if ($packetStr ne "" ) {
		(@res)=scanLine($packetStr);
        	if ( $res[0] == 1) {
            		$username=$res[1];
            		$passwd=$res[2];
            		logmsg("GOT (username,pass) = (".$username.",".$passwd.")");
        	} elsif ( $res[0]==2 ) {
        	  $lat=$res[1];
        	  $lon=$res[2];
        	  $alt=$res[3]+0;
         	  $sog=$res[4]+0;
          	  $cog=$res[5]+0;

		  if ( $username eq '' || $passwd eq '') {
            		logmsg("I havent got username,pass ->setting them to guest,guest");
		  	$username="guest";$passwd ="guest";
		  }

		  if ( $lat==0 && $lon==0  ) {
            		logmsg("Got ZERO lat/lon ->wont log it");
		  } elsif ( $username eq '' || $passwd eq '') {
            		logmsg("I still havent got username,pass");
		  } else { # all is ok -> procced with logging
			logmsg("(username,pass,lat,lon,alt,sog,cog) = ($username,$passwd,$lat,$lon,$alt,$sog,$cog)");
               	  	log_gps_pos($username,$passwd,$lat,$lon,$alt,$sog,$cog);
            	  }
		} else {
		  logmsg("Invalid packet format !!!!");
		}

	} else {
		logmsg("Empty packet !!!!");
	}
}
