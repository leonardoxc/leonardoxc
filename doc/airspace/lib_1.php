<?





static function CalculateSector(TCHAR *Text)
{
  double Radius;
  double StartBearing;
  double EndBearing;
  TCHAR *Stop;

  Radius = NAUTICALMILESTOMETRES * (double)StrToDouble(&Text[2], &Stop);
  StartBearing = (double)StrToDouble(&Stop[1], &Stop);
  EndBearing = (double)StrToDouble(&Stop[1], &Stop);

  while(fabs(EndBearing-StartBearing) > 7.5)
  {
    if(StartBearing >= 360)
      StartBearing -= 360;
    if(StartBearing < 0)
      StartBearing += 360;

    //	  if (bFillMode)	// Trig calcs not needed on first pass
    {  
      FindLatitudeLongitude(CenterY, CenterX, StartBearing, Radius,
                            &TempPoint.Latitude,
                            &TempPoint.Longitude);
    }
    AddPoint(&TempPoint, &TempArea.NumPoints);

    StartBearing += Rotation *5 ;
  }

//  if (bFillMode)	// Trig calcs not needed on first pass
  {
    FindLatitudeLongitude(CenterY, CenterX, EndBearing, Radius,
                          &TempPoint.Latitude,
                          &TempPoint.Longitude);
  }
  AddPoint(&TempPoint, &TempArea.NumPoints);
}

// hack, should be replaced with a data change notifier in the future...
function AirspaceQnhChangeNotify(double newQNH){

  int i;
  AIRSPACE_ALT *Alt;

  if (newQNH != lastQNH){

    for(i=0;i<(int)NumberOfAirspaceAreas;i++) {
    
      Alt = &AirspaceArea[i].Top;

      if (Alt->Base == abFL){
        Alt->Altitude = AltitudeToQNHAltitude((Alt->FL * 100)/TOFEET);
      }

      Alt = &AirspaceArea[i].Base;

      if (Alt->Base == abFL){
        Alt->Altitude = AltitudeToQNHAltitude((Alt->FL * 100)/TOFEET);
      }
    }

    for(i=0;i<(int)NumberOfAirspaceCircles;i++) {
    
      Alt = &AirspaceCircle[i].Top;

      if (Alt->Base == abFL){
        Alt->Altitude = AltitudeToQNHAltitude((Alt->FL * 100)/TOFEET);
      }

      Alt = &AirspaceCircle[i].Base;

      if (Alt->Base == abFL){
        Alt->Altitude = AltitudeToQNHAltitude((Alt->FL * 100)/TOFEET);
      }
    }

    lastQNH = newQNH; 

  }


}



int FindNearestAirspaceCircle(double longitude, double latitude, 
			      double *nearestdistance, double *nearestbearing,
			      double *height=NULL)
{
  unsigned int i;
//  int NearestIndex = 0;
  double Dist;
  int ifound = -1;

  if(NumberOfAirspaceCircles == 0) {
      return -1;
  }
		
  for(i=0;i<NumberOfAirspaceCircles;i++) {
    if (MapWindow::iAirspaceMode[AirspaceCircle[i].Type]< 2) {
      // don't want warnings for this one
      continue;
    }
    
    bool altok;
    if (height) {
      altok = ((*height>AirspaceCircle[i].Base.Altitude)&&
	       (*height<AirspaceCircle[i].Top.Altitude));
    } else {
      altok = CheckAirspaceAltitude(AirspaceCircle[i].Base.Altitude, 
				    AirspaceCircle[i].Top.Altitude)==TRUE;
    }
    if(altok) {
      
      Dist = RangeAirspaceCircle(longitude, latitude, i);
      
      if(Dist < *nearestdistance ) {
	  *nearestdistance = Dist;
          DistanceBearing(latitude,
                          longitude,
                          AirspaceCircle[i].Latitude, 
                          AirspaceCircle[i].Longitude,
                          NULL, nearestbearing);
	  if (Dist<0) {
	    // no need to continue search, inside
	    return i;
	  }
	  ifound = i;
      }
    }
  }
  return ifound;
}



// this is a slow function
// adapted from The Aviation Formulary 1.42

// finds the point along a distance dthis between p1 and p2, which are
// separated by dtotal
function IntermediatePoint(double lon1, double lat1,
		       double lon2, double lat2,
		       double dthis,
		       double dtotal,
		       double *lon3, double *lat3) {
  double A, B, x, y, z, d, f;
  /*
  lat1 *= DEG_TO_RAD;
  lat2 *= DEG_TO_RAD;
  lon1 *= DEG_TO_RAD;
  lon2 *= DEG_TO_RAD;
  */

  if (dtotal>0) {
    f = dthis/dtotal;
    d = dtotal;
  } else {
    dtotal=1.0e-7;
    f = 0.0;
  }
  f = min(1.0,max(0.0,f));

  double coslat1 = cos(lat1);
  double coslat2 = cos(lat2);

  A=sin((1-f)*d)/sin(d);
  B=sin(f*d)/sin(d);
  x = A*coslat1*cos(lon1) +  B*coslat2*cos(lon2);
  y = A*coslat1*sin(lon1) +  B*coslat2*sin(lon2);
  z = A*sin(lat1)           +  B*sin(lat2);
  *lat3=atan2(z,sqrt(x*x+y*y))*RAD_TO_DEG;
  *lon3=atan2(y,x)*RAD_TO_DEG;
}



// this one uses screen coordinates to avoid as many trig functions
// as possible.. it means it is approximate but for our use it is ok.
double ScreenCrossTrackError(double lon1, double lat1,
		     double lon2, double lat2,
		     double lon3, double lat3,
		     double *lon4, double *lat4) {
  int x1, y1, x2, y2, x3, y3;
  
  MapWindow::LatLon2Screen(lon1, lat1, x1, y1);
  MapWindow::LatLon2Screen(lon2, lat2, x2, y2);
  MapWindow::LatLon2Screen(lon3, lat3, x3, y3);

  int v12x, v12y, v13x, v13y;

  v12x = x2-x1; v12y = y2-y1;
  v13x = x3-x1; v13y = y3-y1;

  int mag12 = isqrt4(v12x*v12x+v12y*v12y);
  if (mag12>1) {

    // projection of v13 along v12 = v12.v13/|v12|
    int proj = (v12x*v13x+v12y*v13y)/mag12;
    
    // distance between 3 and tangent to v12
//    int dist = abs(isqrt4(v13x*v13x+v13y*v13y-proj*proj));
    
    // fractional distance
    double f = min(1.0,max(0,proj*1.0/mag12));
    
    // location of 'closest' point 
    int x, y;
    x = (int)((v12x)*f+x1);
    y = (int)((v12y)*f+y1);
    MapWindow::Screen2LatLon(x, y, *lon4, *lat4);
  } else {
    *lon4 = lon1;
    *lat4 = lat1;
  }
  
  // compute accurate distance
  double tmpd;
  DistanceBearing(lat3, lon3, *lat4, *lon4, &tmpd, NULL); 
  return tmpd;
}


// Calculates projected distance from P3 along line P1-P2
double ProjectedDistance(double lon1, double lat1,
                         double lon2, double lat2,
                         double lon3, double lat3) {
  double lon4, lat4;

  CrossTrackError(lon1, lat1,
                  lon2, lat2,
                  lon3, lat3,
                   &lon4, &lat4);
  double tmpd;
  DistanceBearing(lat1, lon1, lat4, lon4, &tmpd, NULL);
  return tmpd;
}








int FindNearestAirspaceArea(double longitude, 
			    double latitude, 
			    double *nearestdistance, 
			    double *nearestbearing,
			    double *height=NULL)
{
  unsigned i;
  int ifound = -1;
  bool inside=false;
  // location of point the target is abeam along line in airspace area 

  if(NumberOfAirspaceAreas == 0)
    {
      return -1;
    }

  for(i=0;i<NumberOfAirspaceAreas;i++) {
    if (MapWindow::iAirspaceMode[AirspaceArea[i].Type]< 2) {
      // don't want warnings for this one
      continue;
    }
    bool altok;
    if (!height) {
      altok = CheckAirspaceAltitude(AirspaceArea[i].Base.Altitude,
				    AirspaceArea[i].Top.Altitude)==TRUE;
    } else {
      altok = ((*height<AirspaceArea[i].Top.Altitude)&&
	       (*height>AirspaceArea[i].Base.Altitude));
    }
    if(altok) {
      inside = InsideAirspaceArea(longitude, latitude, i);
      double dist, bearing;
      
      dist = RangeAirspaceArea(longitude, latitude, i, &bearing);

      if (dist< *nearestdistance) {
	*nearestdistance = dist;
	*nearestbearing = bearing;
	ifound = i;
      }
      if (inside) {
	// no need to continue the search
	*nearestdistance = -(*nearestdistance);
	return i;
      }
    }
  }
  // not inside any airspace, so return closest one
  return ifound;
}




////////////////////////
//
// Finds nearest airspace (whether circle or area) to the specified point.
// Returns -1 in foundcircle or foundarea if circle or area is not found
// Otherwise, returns index of the circle or area that is closest to the specified 
// point.
//
// Also returns the distance and bearing to the boundary of the airspace,
// (and the vertical separation TODO).  
//
// Distance <0 means interior.
//
// This only searches within a range of 100km of the target

function FindNearestAirspace(double longitude, double latitude,
			 double *nearestdistance, double *nearestbearing,
			 int *foundcircle, int *foundarea,
			 double *height)
{
  double nearestd1 = 100000; // 100km
  double nearestd2 = 100000; // 100km
  double nearestb1 = 0;
  double nearestb2 = 0;

  *foundcircle = FindNearestAirspaceCircle(longitude, latitude,
					   &nearestd1, &nearestb1, height);

  *foundarea = FindNearestAirspaceArea(longitude, latitude,
				       &nearestd2, &nearestb2, height);

  if ((*foundcircle>=0)&&(*foundarea<0)) {
      *nearestdistance = nearestd1;
      *nearestbearing = nearestb1;
      *foundarea = -1;
      return;
  }
  if ((*foundarea>=0)&&(*foundcircle<0)) {
      *nearestdistance = nearestd2;
      *nearestbearing = nearestb2;
      *foundcircle = -1;
      return;
  }


  if (nearestd1<nearestd2) {
    if (nearestd1<100000) {
      *nearestdistance = nearestd1;
      *nearestbearing = nearestb1;
      *foundarea = -1;
    }
  } else {
    if (nearestd2<100000) {
      *nearestdistance = nearestd2;
      *nearestbearing = nearestb2;
      *foundcircle = -1;
    }
  }
  return;
}


/////////////////////////////


function SortAirspaceAreaCompare(const void *elem1, const void *elem2 )
{
  if (AirspacePriority[((AIRSPACE_AREA *)elem1)->Type] >
      AirspacePriority[((AIRSPACE_AREA *)elem2)->Type])
    return (-1);
  if (AirspacePriority[((AIRSPACE_AREA *)elem1)->Type] <
      AirspacePriority[((AIRSPACE_AREA *)elem2)->Type])
    return (+1);

  // otherwise sort on height?
  return (0);
}

function SortAirspaceCircleCompare(const void *elem1, const void *elem2 )
{
  if (AirspacePriority[((AIRSPACE_CIRCLE *)elem1)->Type] >
      AirspacePriority[((AIRSPACE_CIRCLE *)elem2)->Type])
    return (-1);
  if (AirspacePriority[((AIRSPACE_CIRCLE *)elem1)->Type] <
      AirspacePriority[((AIRSPACE_CIRCLE *)elem2)->Type])
    return (+1);

  // otherwise sort on height?
  return (0);
}


function SortAirspace(void) {
  // StartupStore(TEXT("SortAirspace\r\n"));

  // force acknowledgement before sorting
  ClearAirspaceWarnings(true, false);

  qsort(AirspaceArea,
	NumberOfAirspaceAreas,
	sizeof(AIRSPACE_AREA),
	SortAirspaceAreaCompare);

  qsort(AirspaceCircle,
	NumberOfAirspaceCircles,
	sizeof(AIRSPACE_CIRCLE),
	SortAirspaceCircleCompare);

}


/////////////

function ScanAirspaceLine(double *lats, double *lons, double *heights, 
		      int airspacetype[AIRSPACE_SCANSIZE_H][AIRSPACE_SCANSIZE_X]) 
{		      

  int i,j;
  unsigned int k;
  double latitude, longitude, height, Dist;

  for(k=0;k<NumberOfAirspaceCircles;k++) {
    for (i=0; i<AIRSPACE_SCANSIZE_X; i++) {
      latitude = lats[i];
      longitude = lons[i];
      if ((latitude> AirspaceCircle[k].bounds.miny)&&
	  (latitude< AirspaceCircle[k].bounds.maxy)&&
	  (longitude> AirspaceCircle[k].bounds.minx)&&
	  (longitude< AirspaceCircle[k].bounds.maxx)) {
	
        DistanceBearing(latitude,longitude,
                        AirspaceCircle[k].Latitude, 
                        AirspaceCircle[k].Longitude, &Dist, NULL);
	Dist -= AirspaceCircle[k].Radius;
	
	if(Dist < 0) {
	  for (j=0; j<AIRSPACE_SCANSIZE_H; j++) {
	    height = heights[j];
	    if ((height>AirspaceCircle[k].Base.Altitude)&&
		(height<AirspaceCircle[k].Top.Altitude)) {
	      airspacetype[j][i] = AirspaceCircle[k].Type;  
	    } // inside height
	  } // finished scanning height
	} // inside
      } // in bound
    } // finished scanning range
  } // finished scanning circles

  for(k=0;k<NumberOfAirspaceAreas;k++) {
    for (i=0; i<AIRSPACE_SCANSIZE_X; i++) {
      latitude = lats[i];
      longitude = lons[i];

      if ((latitude> AirspaceArea[k].bounds.miny)&&
	  (latitude< AirspaceArea[k].bounds.maxy)&&
	  (longitude> AirspaceArea[k].bounds.minx)&&
	  (longitude< AirspaceArea[k].bounds.maxx)) {
	AIRSPACE_POINT thispoint;
	thispoint.Longitude = longitude;
	thispoint.Latitude = latitude;

  CheckAirspacePoint(AirspaceArea[k].FirstPoint);

	if (wn_PnPoly(thispoint,
		      &AirspacePoint[AirspaceArea[k].FirstPoint],
		      AirspaceArea[k].NumPoints-1) != 0) {
	  for (j=0; j<AIRSPACE_SCANSIZE_H; j++) {
	    height = heights[j];
	    if ((height>AirspaceArea[k].Base.Altitude)&&
		(height<AirspaceArea[k].Top.Altitude)) {
	      airspacetype[j][i] = AirspaceArea[k].Type;
	    } // inside height
	  } // finished scanning height
	} // inside
      } // in bound
    } // finished scanning range
  } // finished scanning areas

}

///////////////////////////////////////////////////////////////////////////////


?>