mrsiddecode readme.txt

The mrsiddecode tool extracts (decodes) all or a portion of a MrSID image to one of several image formats. 

Examples:

    * To decode a MrSID file to a JPG file:

      mrsiddecode -i input.sid -o output.jpg

 

    * To decode a MrSID file to a GeoTIFF file:

      mrsiddecode -i input.sid -o geotiff.tif -of tifg

 

    * To decode the upper-left 50x50 pixel scene from a MrSID image:

      mrsiddecode -i input.sid -o output.tif -ulxy 0 0 -wh 50 50

 

    * To decode an image at scale 2, i.e. one-quarter resolution:

      mrsiddecode -i input.sid -o output.tif -s 2


For further help with mrsiddecode, type: mrsiddecode -help