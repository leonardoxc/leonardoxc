#!/bin/sh
#
# To test, run as 
#	ssh -T localhost SSH.sh $user@host
#	enter-password
# this will run this script under NO TTY.
#
# NOTES:
# 1.	You can remove the "read password" and substitute $password by $2
#	Then the password will be taken from the command line
#	But this is insecure as it shows up on 'ps'
#
# 2.	You can simplify it a lot by removing all pipe-related stuff and
#	just making './catp' echo the password.
#	But then the password will be stored on './catp' which is root
#	readable. Do you trust your 'root'?
#
# 3.	There's a race condition here between the issuance of the 'echo'
#	command and the reading of the pipe by 'catp'. After you write the
#	password on the pipe, it will be available there while ssh starts
#	and then while it calls './catp' and this in turn calls 'cat' or
#	'head'. Someone might read the pipe meanwhile, get the password,
#	save it and re-write it on the pipe.
#	But the time window is a lot shorter than simply leaving the 
#	password around in the './catp' script.
#
# 4.	When we are trusted, the password is ignored for login. Anything
#	will do.
#	But for some reason the ssh process hangs waiting on exit... this
#	needs further investigation.
#
# Copyright Jose R. Valverde <jrvalverde@es.embnet.org>
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
# 

# read password (from stdin)
read password

# set environment
export DISPLAY=none:0.0
export SSH_ASKPASS=/tmp/catp.${RANDOM}.${RANDOM}
pipename=/tmp/ssh.${RANDOM}.${RANDOM}

# create auxiliary command
umask 077
cat > $SSH_ASKPASS << END
#!/bin/sh
# cat $pipename # also works
head -1 $pipename
# echo $password	# this stores the password on this file, which is 'root' readable
# clean up ASAP
rm -f $pipename $SSH_ASKPASS
exit
END
chmod 700 $SSH_ASKPASS

# let's go!
mknod $pipename p
echo $password > $pipename &
# echo $2 > $pipename & # for password on the command line

# run remote command under a login shell so it gets its full environment setup
ssh -x -t -t /bin/sh --login -c $1

# clean-up: note -- this is needed 'cos if we are trusted the script is not
# run and can't clean itself.
rm -f $pipename $SSH_ASKPASS

echo done


