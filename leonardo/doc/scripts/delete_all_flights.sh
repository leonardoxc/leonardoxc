
  # move to the main dir
  cd ../../data/flights
  # foreach directory in data/flights/ 
  for dr in charts  intermediate  js  kml  maps  photos  pilots  tracks
  do
    # delete all subdirs
    echo Uncomment the line to really delete ALL flights data

    # uncoment this line
    # rm -rf $dr/*
  done