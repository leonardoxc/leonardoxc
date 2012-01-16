#!/bin/bash

#exit;

#LEODIR=/home/p19/public_html/modules/leonardo
LOG=data/tmp/jobs/output.html

#cd $LEODIR
#chmod +x EXT_perform_sync.php 


a=`ps ax| grep CLI_proccess_jobs | grep -v grep  |wc -l`

if [ $a -gt 0 ]; then
  date >> $LOG ;
  echo "proccess jobs still running" >> $LOG ;
  exit;
fi



php -f CLI_proccess_jobs.php 

