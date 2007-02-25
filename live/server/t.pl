#!/usr/bin/perl -w
    use IO::Socket;

 $host = "127.0.0.1";

     $remote = IO::Socket::INET->new( Proto     => "tcp",
                                      PeerAddr  => $host,
                                      PeerPort  => "999",
                                     );
     unless ($remote) { die "cannot connect to http daemon on $host" }
     #$remote->autoflush(1);
     print $remote "TEST MESSAGE";
     close $remote;


