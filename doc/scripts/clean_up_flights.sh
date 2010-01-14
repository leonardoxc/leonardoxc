#!/bin/bash

  # move to the main dir
  cd ../../data/flights

  daysLimit=15

  # foreach directory in data/flights/
  # except photos/  pilots/  tracks/  these are the PRIMARY SOURCE FILES
  for dr in charts intermediate  js  kml  maps
  do
     find $dr -atime +$daysLimit
     #find $dr -atime +$daysLimit -exec rm -f \{\} \;
  done
  

  # delete all tmp files older than 1 day
  cd ../tmp
  find . -ctime +1 -exec rm -f \{\} \;
  #find . -ctime +1 

  # delete all cache files older than 15 day
  cd ../cache
  find . -ctime +15 -exec rm -f \{\} \;
  #find . -ctime +15 