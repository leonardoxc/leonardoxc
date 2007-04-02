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



static function ScanAirspaceCircleBounds(int i, double bearing) {
  double lat, lon;
  FindLatitudeLongitude(AirspaceCircle[i].Latitude, 
                        AirspaceCircle[i].Longitude, 
                        bearing, AirspaceCircle[i].Radius,
                        &lat, &lon);

  AirspaceCircle[i].bounds.minx = min(lon, AirspaceCircle[i].bounds.minx);
  AirspaceCircle[i].bounds.maxx = max(lon, AirspaceCircle[i].bounds.maxx);
  AirspaceCircle[i].bounds.miny = min(lat, AirspaceCircle[i].bounds.miny);
  AirspaceCircle[i].bounds.maxy = max(lat, AirspaceCircle[i].bounds.maxy);
}


static function FindAirspaceCircleBounds() {
  unsigned int i;
  for(i=0; i<NumberOfAirspaceCircles; i++) {
    AirspaceCircle[i].bounds.minx = AirspaceCircle[i].Longitude;
    AirspaceCircle[i].bounds.maxx = AirspaceCircle[i].Longitude;
    AirspaceCircle[i].bounds.miny = AirspaceCircle[i].Latitude;
    AirspaceCircle[i].bounds.maxy = AirspaceCircle[i].Latitude;
    ScanAirspaceCircleBounds(i,0);
    ScanAirspaceCircleBounds(i,90);
    ScanAirspaceCircleBounds(i,180);
    ScanAirspaceCircleBounds(i,270);
    AirspaceCircle[i].WarningLevel = 0; // clear warnings to initialise
  }
}


function FindAirspaceAreaBounds() {
  unsigned i, j;
  for(i=0; i<NumberOfAirspaceAreas; i++) {
    bool first = true;

    for(j= AirspaceArea[i].FirstPoint; 
        j< AirspaceArea[i].FirstPoint+AirspaceArea[i].NumPoints; j++) {

      if (first) {

        CheckAirspacePoint(j);

        AirspaceArea[i].bounds.minx = AirspacePoint[j].Longitude;
        AirspaceArea[i].bounds.maxx = AirspacePoint[j].Longitude;
        AirspaceArea[i].bounds.miny = AirspacePoint[j].Latitude;
        AirspaceArea[i].bounds.maxy = AirspacePoint[j].Latitude;
        first = false;
      } else {
        AirspaceArea[i].bounds.minx = min(AirspacePoint[j].Longitude,
                                          AirspaceArea[i].bounds.minx);
        AirspaceArea[i].bounds.maxx = max(AirspacePoint[j].Longitude,
                                          AirspaceArea[i].bounds.maxx);
        AirspaceArea[i].bounds.miny = min(AirspacePoint[j].Latitude,
                                          AirspaceArea[i].bounds.miny);
        AirspaceArea[i].bounds.maxy = max(AirspacePoint[j].Latitude,
                                          AirspaceArea[i].bounds.maxy);
      }
    }
    AirspaceArea[i].WarningLevel = 0; // clear warnings to initialise
  }
}


extern TCHAR szRegistryAirspaceFile[];
extern TCHAR szRegistryAdditionalAirspaceFile[];

// ToDo add exception handler to protect parser code against chrashes

function ReadAirspace(void)
{
  TCHAR	szFile1[MAX_PATH] = TEXT("\0");
  TCHAR	szFile2[MAX_PATH] = TEXT("\0");
	
  FILE *fp=NULL;
  FILE *fp2=NULL;
  FILETIME LastWriteTime;
  FILETIME LastWriteTime2;

  GetRegistryString(szRegistryAirspaceFile, szFile1, MAX_PATH);
  ExpandLocalPath(szFile1);
  GetRegistryString(szRegistryAdditionalAirspaceFile, szFile2, MAX_PATH);
  ExpandLocalPath(szFile2);

  if (_tcslen(szFile1)>0)      
    fp  = _tfopen(szFile1, TEXT("rt"));
  if (_tcslen(szFile2)>0)
    fp2 = _tfopen(szFile2, TEXT("rt"));

  SetRegistryString(szRegistryAirspaceFile, TEXT("\0"));
  SetRegistryString(szRegistryAdditionalAirspaceFile, TEXT("\0"));

  if (fp != NULL){

    GetFileTime((void *)_fileno(fp), NULL, NULL, &LastWriteTime);

    if (fp2 != NULL) {
      GetFileTime((void *)_fileno(fp2), NULL, NULL, &LastWriteTime2);
      if (LastWriteTime2.dwHighDateTime>
          LastWriteTime.dwHighDateTime) {
        // this file is newer, so use it as the time stamp
        LastWriteTime = LastWriteTime2;
      }
    }

    if (AIRSPACEFILECHANGED
        #if AIRSPACEUSEBINFILE > 0
        ||!LoadAirspaceBinary(LastWriteTime)
        #else
        || (true)
        #endif
      ) {

      ReadAirspace(fp);
      // file 1 was OK, so save it
      ContractLocalPath(szFile1);
      SetRegistryString(szRegistryAirspaceFile, szFile1);

      // also read any additional airspace
      if (fp2 != NULL) {
        ReadAirspace(fp2);
	// file 2 was OK, so save it
        ContractLocalPath(szFile2);
	 SetRegistryString(szRegistryAdditionalAirspaceFile, szFile2);
      }
      #if AIRSPACEUSEBINFILE > 0
      SaveAirspaceBinary(LastWriteTime);
      #endif
    }

    fclose(fp);

  }

  if (fp2 != NULL) {
    fclose(fp2);
  }

  FindAirspaceAreaBounds();
  FindAirspaceCircleBounds();

}





double RangeAirspaceCircle(const double &longitude,
			   const double &latitude,
			   int i) {
  double distance;
  DistanceBearing(latitude,longitude,
                  AirspaceCircle[i].Latitude, 
                  AirspaceCircle[i].Longitude,
                  &distance, NULL);
  return distance-AirspaceCircle[i].Radius;
}


bool InsideAirspaceCircle(const double &longitude,
			    const double &latitude,
			    int i) {
  if ((latitude> AirspaceCircle[i].bounds.miny)&&
      (latitude< AirspaceCircle[i].bounds.maxy)&&
      (longitude> AirspaceCircle[i].bounds.minx)&&
      (longitude< AirspaceCircle[i].bounds.maxx)) {

    if (RangeAirspaceCircle(longitude, latitude, i)<0) {
      return true;
    }
  }
  return false;
}


int FindAirspaceCircle(double Longitude,double Latitude, bool visibleonly)
{
  unsigned i;
 // int NearestIndex = 0;

  if(NumberOfAirspaceCircles == 0)
    {
      return -1;
    }
		
  for(i=0;i<NumberOfAirspaceCircles;i++) {
    if (MapWindow::iAirspaceMode[AirspaceCircle[i].Type]< 2) {
      // don't want warnings for this one
      continue;
    }
    if(AirspaceCircle[i].Visible || (!visibleonly)) {
      if(CheckAirspaceAltitude(AirspaceCircle[i].Base.Altitude, 
			       AirspaceCircle[i].Top.Altitude)) {
	if (InsideAirspaceCircle(Longitude,Latitude,i)) {
	  return i;
	}
      }
    }
  }
  return -1;
}


BOOL CheckAirspaceAltitude(const double &Base, const double &Top)
{
  double alt;
  if (GPS_INFO.BaroAltitudeAvailable) {
    alt = GPS_INFO.BaroAltitude;
  } else {
    alt = GPS_INFO.Altitude;
  }

  switch (AltitudeMode)
    {
    case ALLON : return TRUE;
		
    case CLIP : 
      if(Base < ClipAltitude)
	return TRUE;
      else
	return FALSE;

    case AUTO:
      if( ( alt > (Base - AltWarningMargin) ) 
	  && ( alt < (Top + AltWarningMargin) ))
	return TRUE;
      else
	return FALSE;

    case ALLBELOW:
      if(  (Base - AltWarningMargin) < alt )
	return  TRUE;
      else
	return FALSE;
    case INSIDE:
      if( ( alt >= (Base) ) && ( alt < (Top) ))
	return TRUE;
      else
	return FALSE;
    }
  return TRUE;
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

///////////////////////////////////////////////////

// Copyright 2001, softSurfer (www.softsurfer.com)
// This code may be freely used and modified for any purpose
// providing that this copyright notice is included with it.
// SoftSurfer makes no warranty for this code, and cannot be held
// liable for any real or imagined damage resulting from its use.
// Users of this code must verify correctness for their application.

//    a Point is defined by its coordinates {int x, y;}
//===================================================================

// isLeft(): tests if a point is Left|On|Right of an infinite line.
//    Input:  three points P0, P1, and P2
//    Return: >0 for P2 left of the line through P0 and P1
//            =0 for P2 on the line
//            <0 for P2 right of the line
//    See: the January 2001 Algorithm "Area of 2D and 3D Triangles and Polygons"
inline static double
isLeft( AIRSPACE_POINT P0, AIRSPACE_POINT P1, AIRSPACE_POINT P2 )
{
    return ( (P1.Longitude - P0.Longitude) * (P2.Latitude - P0.Latitude)
            - (P2.Longitude - P0.Longitude) * (P1.Latitude - P0.Latitude) );
}
//===================================================================

// wn_PnPoly(): winding number test for a point in a polygon
//      Input:   P = a point,
//               V[] = vertex points of a polygon V[n+1] with V[n]=V[0]
//      Return:  wn = the winding number (=0 only if P is outside V[])
static int
wn_PnPoly( AIRSPACE_POINT P, AIRSPACE_POINT* V, int n )
{
    int    wn = 0;    // the winding number counter

    // loop through all edges of the polygon
    for (int i=0; i<n; i++) {   // edge from V[i] to V[i+1]
        if (V[i].Latitude <= P.Latitude) {         // start y <= P.Latitude
            if (V[i+1].Latitude > P.Latitude)      // an upward crossing
                if (isLeft( V[i], V[i+1], P) > 0)  // P left of edge
                    ++wn;            // have a valid up intersect
        }
        else {                       // start y > P.Latitude (no test needed)
            if (V[i+1].Latitude <= P.Latitude)     // a downward crossing
                if (isLeft( V[i], V[i+1], P) < 0)  // P right of edge
                    --wn;            // have a valid down intersect
        }
    }
    return wn;
}
//===================================================================


bool InsideAirspaceArea(const double &longitude,
			  const double &latitude,
			  int i) {
  AIRSPACE_POINT thispoint;
  thispoint.Longitude = longitude;
  thispoint.Latitude = latitude;

  // first check if point is within bounding box
  if (
      (latitude> AirspaceArea[i].bounds.miny)&&
      (latitude< AirspaceArea[i].bounds.maxy)&&
      (longitude> AirspaceArea[i].bounds.minx)&&
      (longitude< AirspaceArea[i].bounds.maxx)
      ) {

    CheckAirspacePoint(AirspaceArea[i].FirstPoint);

    // it is within, so now do detailed polygon test
    if (wn_PnPoly(thispoint,
		  &AirspacePoint[AirspaceArea[i].FirstPoint],
		  AirspaceArea[i].NumPoints-1) != 0) {
      // we are inside the i'th airspace area
      return true;
    }
  }
  return false;
}


int FindAirspaceArea(double Longitude,double Latitude, bool visibleonly)
{
  unsigned i;

  if(NumberOfAirspaceAreas == 0)
    {
      return -1;
    }
  for(i=0;i<NumberOfAirspaceAreas;i++) {
    if (MapWindow::iAirspaceMode[AirspaceArea[i].Type]< 2) {
      // don't want warnings for this one
      continue;
    }
    if(AirspaceArea[i].Visible || (!visibleonly)) {
      if(CheckAirspaceAltitude(AirspaceArea[i].Base.Altitude, 
			       AirspaceArea[i].Top.Altitude)) {
	if (InsideAirspaceArea(Longitude,Latitude,i)) {
	  return i;
	}
      }
    }
  }
  // not inside any airspace
  return -1;
}





/////////////////////////////////////////////////////////////////////////////////


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

// finds cross track error in meters and closest point p4 between p3 and
// desired track p1-p2.
// very slow function!
double CrossTrackError(double lon1, double lat1,
		     double lon2, double lat2,
		     double lon3, double lat3,
		     double *lon4, double *lat4) {

  double dist_AD, crs_AD;
  DistanceBearing(lat1, lon1, lat3, lon3, &dist_AD, &crs_AD);
  dist_AD/= (RAD_TO_DEG * 111194.9267); crs_AD*= DEG_TO_RAD;

  double dist_AB, crs_AB;
  DistanceBearing(lat1, lon1, lat2, lon2, &dist_AB, &crs_AB);
  dist_AB/= (RAD_TO_DEG * 111194.9267); crs_AB*= DEG_TO_RAD;

  lat1 *= DEG_TO_RAD;
  lat2 *= DEG_TO_RAD;
  lat3 *= DEG_TO_RAD;
  lon1 *= DEG_TO_RAD;
  lon2 *= DEG_TO_RAD;
  lon3 *= DEG_TO_RAD;

  double XTD; // cross track distance
  double ATD; // along track distance

  //  The "along track distance", ATD, the distance from A along the
  //  course towards B to the point abeam D

  double sindist_AD = sin(dist_AD);

  XTD = asin(sindist_AD*sin(crs_AD-crs_AB));

  double sinXTD = sin(XTD);
  ATD = asin(sqrt( sindist_AD*sindist_AD - sinXTD*sinXTD )/cos(XTD));
  
  if (lon4 && lat4) {
    IntermediatePoint(lon1, lat1, lon2, lat2, ATD, dist_AB,
		      lon4, lat4);
  }

  // units
  XTD *= (RAD_TO_DEG * 111194.9267);

  return XTD;
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


double RangeAirspaceArea(const double &longitude,
			 const double &latitude,
			 int i, double *bearing) {

  // find nearest distance to line segment
  unsigned int j;
  double dist=100000;
  double nearestdistance = dist;
  double nearestbearing = *bearing;
  double lon4, lat4;
  for (j=0; j<AirspaceArea[i].NumPoints-1; j++) {

    CheckAirspacePoint(AirspaceArea[i].FirstPoint+j);
    CheckAirspacePoint(AirspaceArea[i].FirstPoint+j+1);

    dist = ScreenCrossTrackError(
				 AirspacePoint[AirspaceArea[i].FirstPoint+j].Longitude,
				 AirspacePoint[AirspaceArea[i].FirstPoint+j].Latitude,
				 AirspacePoint[AirspaceArea[i].FirstPoint+j+1].Longitude,
				 AirspacePoint[AirspaceArea[i].FirstPoint+j+1].Latitude,
				 longitude, latitude,
				 &lon4, &lat4);
    if (dist<nearestdistance) {
      nearestdistance = dist;
      
      DistanceBearing(latitude, longitude,
                      lat4, lon4, NULL, 
                      &nearestbearing);
    }
  }
  *bearing = nearestbearing;
  return nearestdistance;
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

function DumpAirspaceFile(void){

  FILE * fp;
  int i;

  fp  = _tfopen(TEXT("XCSoarAirspace.dmp"), TEXT("wt"));

  for (i=0; i < (int)NumberOfAirspaceAreas; i++){

    _ftprintf(fp, TEXT("*** Aera id: %d %s "), i, AirspaceArea[i].Name);

    switch (AirspaceArea[i].Type){
      case RESTRICT:
        _ftprintf(fp, TEXT("Restricted")); break;
      case PROHIBITED:
        _ftprintf(fp, TEXT("Prohibited")); break;
      case DANGER:
        _ftprintf(fp, TEXT("Danger Area")); break;
      case CLASSA:
        _ftprintf(fp, TEXT("Class A")); break;
      case CLASSB:
        _ftprintf(fp, TEXT("Class B")); break;
      case CLASSC:
        _ftprintf(fp, TEXT("Class C")); break;
      case CLASSD:
        _ftprintf(fp, TEXT("Class D")); break;
      case CLASSE:
        _ftprintf(fp, TEXT("Class E")); break;
      case CLASSF:
        _ftprintf(fp, TEXT("Class F")); break;
      case NOGLIDER:
        _ftprintf(fp, TEXT("No Glider")); break;
      case CTR:
        _ftprintf(fp, TEXT("CTR")); break;
      case WAVE:
        _ftprintf(fp, TEXT("Wave")); break;
      default:
        _ftprintf(fp, TEXT("Unknown"));
    }

    _ftprintf(fp, TEXT(")\r\n"), i);

    switch (AirspaceArea[i].Top.Base){
      case abUndef:
        _ftprintf(fp, TEXT("  Top  : %.0f[m] %.0f[ft] [?]\r\n"), AirspaceArea[i].Top.Altitude, AirspaceArea[i].Top.Altitude*TOFEET);
      break;
      case abMSL:
        _ftprintf(fp, TEXT("  Top  : %.0f[m] %.0f[ft] [MSL]\r\n"), AirspaceArea[i].Top.Altitude, AirspaceArea[i].Top.Altitude*TOFEET);
      break;
      case abAGL:
        _ftprintf(fp, TEXT("  Top  : %.0f[m] %.0f[ft] [AGL]\r\n"), AirspaceArea[i].Top.Altitude, AirspaceArea[i].Top.Altitude*TOFEET);
      break;
      case abFL:
        _ftprintf(fp, TEXT("  Top  : FL %.0f (%.0f[m] %.0f[ft])\r\n"), AirspaceArea[i].Top.FL, AirspaceArea[i].Top.Altitude, AirspaceArea[i].Top.Altitude*TOFEET);
      break;
    }

    switch (AirspaceArea[i].Base.Base){
      case abUndef:
        _ftprintf(fp, TEXT("  Base : %.0f[m] %.0f[ft] [?]\r\n"), AirspaceArea[i].Base.Altitude, AirspaceArea[i].Base.Altitude*TOFEET);
      break;
      case abMSL:
        _ftprintf(fp, TEXT("  Base : %.0f[m] %.0f[ft] [MSL]\r\n"), AirspaceArea[i].Base.Altitude, AirspaceArea[i].Base.Altitude*TOFEET);
      break;
      case abAGL:
        _ftprintf(fp, TEXT("  Base : %.0f[m] %.0f[ft] [AGL]\r\n"), AirspaceArea[i].Base.Altitude, AirspaceArea[i].Base.Altitude*TOFEET);
      break;
      case abFL:
        _ftprintf(fp, TEXT("  Base : FL %.0f (%.0f[m] %.0f[ft])\r\n"), AirspaceArea[i].Base.FL, AirspaceArea[i].Base.Altitude, AirspaceArea[i].Base.Altitude*TOFEET);
      break;
    }

    _ftprintf(fp, TEXT("\r\n"), i);
  }

  for (i=0; i < (int)NumberOfAirspaceCircles; i++){

    _ftprintf(fp, TEXT("\r\n*** Circle id: %d %s ("), i, AirspaceCircle[i].Name);

    switch (AirspaceArea[i].Type){
      case RESTRICT:
        _ftprintf(fp, TEXT("Restricted")); break;
      case PROHIBITED:
        _ftprintf(fp, TEXT("Prohibited")); break;
      case DANGER:
        _ftprintf(fp, TEXT("Danger Area")); break;
      case CLASSA:
        _ftprintf(fp, TEXT("Class A")); break;
      case CLASSB:
        _ftprintf(fp, TEXT("Class B")); break;
      case CLASSC:
        _ftprintf(fp, TEXT("Class C")); break;
      case CLASSD:
        _ftprintf(fp, TEXT("Class D")); break;
      case CLASSE:
        _ftprintf(fp, TEXT("Class E")); break;
      case CLASSF:
        _ftprintf(fp, TEXT("Class F")); break;
      case NOGLIDER:
        _ftprintf(fp, TEXT("No Glider")); break;
      case CTR:
        _ftprintf(fp, TEXT("CTR")); break;
      case WAVE:
        _ftprintf(fp, TEXT("Wave")); break;
      default:
        _ftprintf(fp, TEXT("Unknown"));
    }

    _ftprintf(fp, TEXT(")\r\n"), i);

    switch (AirspaceCircle[i].Top.Base){
      case abUndef:
        _ftprintf(fp, TEXT("  Top  : %.0f[m] %.0f[ft] [?]\r\n"), AirspaceCircle[i].Top.Altitude, AirspaceCircle[i].Top.Altitude*TOFEET);
      break;
      case abMSL:
        _ftprintf(fp, TEXT("  Top  : %.0f[m] %.0f[ft] [MSL]\r\n"), AirspaceCircle[i].Top.Altitude, AirspaceCircle[i].Top.Altitude*TOFEET);
      break;
      case abAGL:
        _ftprintf(fp, TEXT("  Top  : %.0f[m] %.0f[ft] [AGL]\r\n"), AirspaceCircle[i].Top.Altitude, AirspaceCircle[i].Top.Altitude*TOFEET);
      break;
      case abFL:
        _ftprintf(fp, TEXT("  Top  : FL %.0f (%.0f[m] %.0f[ft])\r\n"), AirspaceCircle[i].Top.FL, AirspaceCircle[i].Top.Altitude, AirspaceCircle[i].Top.Altitude*TOFEET);
      break;
    }

    switch (AirspaceCircle[i].Base.Base){
      case abUndef:
        _ftprintf(fp, TEXT("  Base : %.0f[m] %.0f[ft] [?]\r\n"), AirspaceCircle[i].Base.Altitude, AirspaceCircle[i].Base.Altitude*TOFEET);
      break;
      case abMSL:
        _ftprintf(fp, TEXT("  Base : %.0f[m] %.0f[ft] [MSL]\r\n"), AirspaceCircle[i].Base.Altitude, AirspaceCircle[i].Base.Altitude*TOFEET);
      break;
      case abAGL:
        _ftprintf(fp, TEXT("  Base : %.0f[m] %.0f[ft] [AGL]\r\n"), AirspaceCircle[i].Base.Altitude, AirspaceCircle[i].Base.Altitude*TOFEET);
      break;
      case abFL:
        _ftprintf(fp, TEXT("  Base : FL %.0f (%.0f[m] %.0f[ft])\r\n"), AirspaceCircle[i].Base.FL, AirspaceCircle[i].Base.Altitude, AirspaceCircle[i].Base.Altitude*TOFEET);
      break;
    }

  _ftprintf(fp, TEXT("\r\n"), i);

  }

  fclose(fp);

}


///////////////////////////////////////////////////////////////////////////////


?>