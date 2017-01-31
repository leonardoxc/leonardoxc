/************************************************************************/
/* Leonardo: Gliding XC Server				                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


--------------------------------------------------------------------------
  PROJECT DESCRIPTION
--------------------------------------------------------------------------

Leonardo is a server for logging glider (paragliding at this time) flights 
over the internet. The flights can then be presented in a nice interface,
statistics bae be viewed for all the flights or a selected subset of them,
and a various Leagues (XC distance) are formed.


On its present form it is suitable for small to medium gliding communities 
but it's design is flexible enough to cope with large groups.


1.  Flight analysis and scoring both open distance and OLC type
2.  Each flight can be viewed and the track log can be donwloaded.
    In the flight analisis window the flight is shown on a map of the
    area. 4 graphs are also available, showing altitude 
    over time, speed over time, vario over time and "distance from 
    takeoff" over time especially valuable on XC flights.
3.  The takeoff and landing location are calculated automatically based
    on a database of known points.
4.  The data can be presented in a number of ways  sorted by
    pilotName, duration, distance, olc score, takeoff Name, etc
5.  There are 5 competition leagues: open distance, FAI triangle, 
    olc scoring, flight duration, and altitude gained over takeoff.
6   There is a powerfull filtering on almost all fields of the data.
7.  the uploading of the flights is *very* easy : just one click
8.  Multilingual (currently greek and english)
9.  Automatic - multple uploads of many flights in one zip file
10. Automatic submission of  XC flights to the OLC

Features to come in the near future
11. Comparison of flights on the same page
12. More statistics

Features to come , but dont hold your breath
13. Artificial Inteligence module - automatic profilling of flights, 
    pilots and takeoffs
14. wind direction and strength during the flight (the tracklog must have Z values)
15. Other Scoring formulas (GAP ...)
16. Competition Setup
17. Distributed servers, each having its own users, but having the 
    ability to show global stattistics


The project page on sourceforge is http://sourceforge.net/projects/leonardoserver/
CVS access (module name: leonardo).

The project is already running on the following sites:

- www.sky.gr for the greek paragliding community
     http://www.sky.gr/modules.php?name=leonardo&op=list_flights&newlang=english  

- www.vololibero.net for the italian paragliding community
     http://www.vololibero.net/modules.php?name=leonardo&op=list_flights&sortOrder=DATE&year=0&month=0

- www.paraglidingforum.com for the international paragliding community     http://www.paraglidingforum.com/modules.php?name=leonardo&op=list_flights&sortOrder=DATE&year=0&month=0&pilotID=0

- British paragliding competitions
   http://www.pgcomps.org.uk/

--------------------------------------------------------------------------
  INSTALLATION
--------------------------------------------------------------------------

See file docs/install.txt 

--------------------------------------------------------------------------
  MAP MAKING
--------------------------------------------------------------------------

See file docs/maps/Maps_howto_auto.txt 


--------------------------------------------------------------------------
  F.A.Q.
--------------------------------------------------------------------------

See file docs/faq.txt 












