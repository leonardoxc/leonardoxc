<?php
/**
 * Routines to make an SSH connection to a remote host
 *
 * @package SExec
 * @author José R. Valverde <jrvalverde@acm.org>
 * @version 0.1
 * @copyright José R. Valverde <jrvalverde@es.embnet.org>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */
 
/** 
 * Do a remote ssh connection with local password
 */
function do_ssh($host, $user, $password, $command)
{
	umask(0077);
	$tmpfname = tempnam("/tmp", "egTinker");
	chmod($tmpfname, 0700);
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	fclose($fp);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	system("ssh -x -t -t $host -l$user $command");
	unlink($tmpfname);
}

/**
 * Do a remote scp connection with local password
 */
function do_scp($origin, $destination, $password)
{
	umask(0077);
	$tmpfname = tempnam("/tmp", "ssh");
	chmod($tmpfname, 0700);
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	fclose($fp);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	system("scp -pqrC $origin $destination &");
	unlink($tmpfname);
}

do_ssh("example.com", "user", "example.com", "ls");

do_scp("SSH", "user@example.com:.", "password");

do_ssh("example.com", "user", "password", "ls");
do_ssh("example.com", "user", "password", "ls SSH");


?>
