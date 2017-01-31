<?php
/*=======================================================================
// File: 	JPGRAPH_LINE.PHP
// Description:	Line plot extension for JpGraph
// Created: 	2001-01-08
// Author:	Johan Persson (johanp@aditus.nu)
// Ver:		$Id: jpgraph_line.php,v 1.1 2006/12/29 22:35:15 manolis Exp $
//
// License:	This code is released under QPL
// Copyright (C) 2001,2002 Johan Persson
//========================================================================
*/
 
// constants for the (filled) area
DEFINE("LP_AREA_FILLED", true);
DEFINE("LP_AREA_NOT_FILLED", false);
DEFINE("LP_AREA_BORDER",false);
DEFINE("LP_AREA_NO_BORDER",true);

//===================================================
// CLASS LinePlot
// Description: 
//===================================================
class LinePlot extends Plot{
    var $filled=false;
    var $fill_color='blue';
    var $mark=null;
    var $step_style=false, $center=false;
    var $line_style=1;	// Default to solid
    var $filledAreas = array(); // array of arrays(with min,max,col,filled in them)
    var $barcenter=false;  // When we mix line and bar. Should we center the line in the bar.
    var $fillFromMin = false ;
    var $fillgrad=false,$fillgrad_fromcolor='navy',$fillgrad_tocolor='silver',$fillgrad_numcolors=100;

//---------------
// CONSTRUCTOR
    function LinePlot(&$datay,$datax=false) {
	$this->Plot($datay,$datax);
	$this->mark = new PlotMark();
    }
//---------------
// PUBLIC METHODS	

    // Set style, filled or open
    function SetFilled($aFlag=true) {
    	JpGraphError::Raise('LinePlot::SetFilled() is deprecated. Use SetFillColor()');
    }
	
    function SetBarCenter($aFlag=true) {
	$this->barcenter=$aFlag;
    }

    function SetStyle($aStyle) {
	$this->line_style=$aStyle;
    }
	
    function SetStepStyle($aFlag=true) {
	$this->step_style = $aFlag;
    }
	
    function SetColor($aColor) {
	parent::SetColor($aColor);
    }
	
    function SetFillFromYMin($f=true) {
	$this->fillFromMin = $f ;
    }
    
    function SetFillColor($aColor,$aFilled=true) {
	$this->fill_color=$aColor;
	$this->filled=$aFilled;
    }

    function SetFillGradient($aFromColor,$aToColor,$aNumColors=100,$aFilled=true) {
	$this->fillgrad_fromcolor = $aFromColor;
	$this->fillgrad_tocolor   = $aToColor;
	$this->fillgrad_numcolors = $aNumColors;
	$this->filled = $aFilled;
	$this->fillgrad = true;
    }
	
    function Legend(&$graph) {
	if( $this->legend!="" ) {
	    if( $this->filled ) {
		$graph->legend->Add($this->legend,
				    $this->fill_color,$this->mark,0,
				    $this->legendcsimtarget,$this->legendcsimalt);
	    } else {
		$graph->legend->Add($this->legend,
				    $this->color,$this->mark,$this->line_style,
				    $this->legendcsimtarget,$this->legendcsimalt);
	    }
	}	
    }

    function AddArea($aMin=0,$aMax=0,$aFilled=LP_AREA_NOT_FILLED,$aColor="gray9",$aBorder=LP_AREA_BORDER) {
	if($aMin > $aMax) {
	    // swap
	    $tmp = $aMin;
	    $aMin = $aMax;
	    $aMax = $tmp;
	} 
	$this->filledAreas[] = array($aMin,$aMax,$aColor,$aFilled,$aBorder);
    }
	
    // Gets called before any axis are stroked
    function PreStrokeAdjust(&$graph) {

	// If another plot type have already adjusted the
	// offset we don't touch it.
	// (We check for empty in case the scale is  a log scale 
	// and hence doesn't contain any xlabel_offset)
	if( empty($graph->xaxis->scale->ticks->xlabel_offset) ||
	    $graph->xaxis->scale->ticks->xlabel_offset == 0 ) {
	    if( $this->center ) {
		++$this->numpoints;
		$a=0.5; $b=0.5;
	    } else {
		$a=0; $b=0;
	    }
	    $graph->xaxis->scale->ticks->SetXLabelOffset($a);
	    $graph->SetTextScaleOff($b);						
	    //$graph->xaxis->scale->ticks->SupressMinorTickMarks();
	}
    }
	
    function Stroke(&$img,&$xscale,&$yscale) {
	$numpoints=count($this->coords[0]);
	if( isset($this->coords[1]) ) {
	    if( count($this->coords[1])!=$numpoints )
		JpGraphError::Raise("Number of X and Y points are not equal. Number of X-points:".count($this->coords[1])." Number of Y-points:$numpoints");
	    else
		$exist_x = true;
	}
	else 
	    $exist_x = false;

	if( $this->barcenter ) 
	    $textadj = 0.5-$xscale->text_scale_off;
	else
	    $textadj = 0;

	// Find the first numeric data point
	$startpoint=0;
	while( $startpoint < $numpoints && !is_numeric($this->coords[0][$startpoint]) )
	    ++$startpoint;

	// Bail out if no data points
	if( $startpoint == $numpoints ) 
	    return;

	if( $exist_x )
	    $xs=$this->coords[1][$startpoint];
	else
	    $xs= $textadj+$startpoint;

	$img->SetStartPoint($xscale->Translate($xs),
			    $yscale->Translate($this->coords[0][$startpoint]));

		
	if( $this->filled ) {
	    $cord[] = $xscale->Translate($xs);
	    $min = $yscale->GetMinVal();
	    if( $min > 0 || $this->fillFromMin )
		$cord[] = $yscale->Translate($min);
	    else
		$cord[] = $yscale->Translate(0);
	}
	$xt = $xscale->Translate($xs);
	$yt = $yscale->Translate($this->coords[0][$startpoint]);
	$cord[] = $xt;
	$cord[] = $yt;
	$yt_old = $yt;

	$this->value->Stroke($img,$this->coords[0][$startpoint],$xt,$yt);

	$img->SetColor($this->color);
	$img->SetLineWeight($this->weight);
	$img->SetLineStyle($this->line_style);
	for( $pnts=$startpoint+1; $pnts<$numpoints; ++$pnts) {
	    
	    if( $exist_x ) $x=$this->coords[1][$pnts];
	    else $x=$pnts+$textadj;
	    $xt = $xscale->Translate($x);
	    $yt = $yscale->Translate($this->coords[0][$pnts]);
	    
	    $y=$this->coords[0][$pnts];
	    if( $this->step_style && is_numeric($y) ) {
		$img->StyleLineTo($xt,$yt_old);
		$img->StyleLineTo($xt,$yt);

		$cord[] = $xt;
		$cord[] = $yt_old;
	
		$cord[] = $xt;
		$cord[] = $yt;

	    }
	    else {
		if( is_numeric($y) || (is_string($y) && $y != "-") ) {
		    $tmp1=$this->coords[0][$pnts];
		    $tmp2=$this->coords[0][$pnts-1]; 		 			
		    if( is_numeric($tmp1)  && (is_numeric($tmp2) || $tmp2=="-" ) ) { 
			$img->StyleLineTo($xt,$yt);
		    } 
		    else {
			$img->SetStartPoint($xt,$yt);
		    }
		    if( is_numeric($tmp1)  && 
			(is_numeric($tmp2) || $tmp2=="-" || ($this->filled && $tmp2=='') ) ) { 
			$cord[] = $xt;
			$cord[] = $yt;
		    } 
		}
	    }
	    $yt_old = $yt;

	    $this->StrokeDataValue($img,$this->coords[0][$pnts],$xt,$yt);
	}	

	if( $this->filled  ) {
	    $cord[] = $xt;
	    if( $min > 0 || $this->fillFromMin )
		$cord[] = $yscale->Translate($min);
	    else
		$cord[] = $yscale->Translate(0);
	    if( $this->fillgrad ) {
		$img->SetLineWeight(1);
		$grad = new Gradient($img);
		$grad->SetNumColors($this->fillgrad_numcolors);
		$grad->FilledFlatPolygon($cord,$this->fillgrad_fromcolor,$this->fillgrad_tocolor);
		$img->SetLineWeight($this->weight);
	    }
	    else {
		$img->SetColor($this->fill_color);	
		$img->FilledPolygon($cord);
	    }
	    if( $this->line_weight > 0 ) {
		$img->SetColor($this->color);
		$img->Polygon($cord);
	    }
	}

	if(!empty($this->filledAreas)) {

	    $minY = $yscale->Translate($yscale->GetMinVal());
	    $factor = ($this->step_style ? 4 : 2);

	    for($i = 0; $i < sizeof($this->filledAreas); ++$i) {
		// go through all filled area elements ordered by insertion
		// fill polygon array
		$areaCoords[] = $cord[$this->filledAreas[$i][0] * $factor];
		$areaCoords[] = $minY;

		$areaCoords =
		    array_merge($areaCoords,
				array_slice($cord,
					    $this->filledAreas[$i][0] * $factor,
					    ($this->filledAreas[$i][1] - $this->filledAreas[$i][0] + ($this->step_style ? 0 : 1))  * $factor));
		$areaCoords[] = $areaCoords[sizeof($areaCoords)-2]; // last x
		$areaCoords[] = $minY; // last y
	    
		if($this->filledAreas[$i][3]) {
		    $img->SetColor($this->filledAreas[$i][2]);
		    $img->FilledPolygon($areaCoords);
		    $img->SetColor($this->color);
		}
		// Check if we should draw the frame.
		// If not we still re-draw the line since it might have been
		// partially overwritten by the filled area and it doesn't look
		// very good.
		// TODO: The behaviour is undefined if the line does not have
		// any line at the position of the area.
		if( $this->filledAreas[$i][4] )
		    $img->Polygon($areaCoords);
		else
	    	    $img->Polygon($cord);

		$areaCoords = array();
	    }
	}	

	if( $this->mark->type == -1 || $this->mark->show == false )
	    return;

	for( $pnts=0; $pnts<$numpoints; ++$pnts) {

	    if( $exist_x ) $x=$this->coords[1][$pnts];
	    else $x=$pnts+$textadj;
	    $xt = $xscale->Translate($x);
	    $yt = $yscale->Translate($this->coords[0][$pnts]);

	    if( is_numeric($this->coords[0][$pnts]) ) {
		if( !empty($this->csimtargets[$pnts]) ) {
		    $this->mark->SetCSIMTarget($this->csimtargets[$pnts]);
		    $this->mark->SetCSIMAlt($this->csimalts[$pnts]);
		}
		if( $exist_x )
		    $x=$this->coords[1][$pnts];
		else
		    $x=$pnts;
		$this->mark->SetCSIMAltVal($this->coords[0][$pnts],$x);
		$this->mark->Stroke($img,$xt,$yt);	
		$this->csimareas .= $this->mark->GetCSIMAreas();
		$this->StrokeDataValue($img,$this->coords[0][$pnts],$xt,$yt);
	    }
	}


    }
} // Class


//===================================================
// CLASS AccLinePlot
// Description: 
//===================================================
class AccLinePlot extends Plot {
    var $plots=null,$nbrplots=0,$numpoints=0;
//---------------
// CONSTRUCTOR
    function AccLinePlot($plots) {
        $this->plots = $plots;
	$this->nbrplots = count($plots);
	$this->numpoints = $plots[0]->numpoints;		
    }

//---------------
// PUBLIC METHODS	
    function Legend(&$graph) {
	foreach( $this->plots as $p )
	    $p->DoLegend($graph);
    }
	
    function Max() {
	list($xmax) = $this->plots[0]->Max();
	$nmax=0;
	for($i=0; $i<count($this->plots); ++$i) {
	    $n = count($this->plots[$i]->coords[0]);
	    $nmax = max($nmax,$n);
	    list($x) = $this->plots[$i]->Max();
	    $xmax = Max($xmax,$x);
	}
	for( $i = 0; $i < $nmax; $i++ ) {
	    // Get y-value for line $i by adding the
	    // individual bars from all the plots added.
	    // It would be wrong to just add the
	    // individual plots max y-value since that
	    // would in most cases give to large y-value.
	    $y=$this->plots[0]->coords[0][$i];
	    for( $j = 1; $j < $this->nbrplots; $j++ ) {
		$y += $this->plots[ $j ]->coords[0][$i];
	    }
	    $ymax[$i] = $y;
	}
	$ymax = max($ymax);
	return array($xmax,$ymax);
    }	

    function Min() {
	$nmax=0;
	list($xmin,$ysetmin) = $this->plots[0]->Min();
	for($i=0; $i<count($this->plots); ++$i) {
	    $n = count($this->plots[$i]->coords[0]);
	    $nmax = max($nmax,$n);
	    list($x,$y) = $this->plots[$i]->Min();
	    $xmin = Min($xmin,$x);
	    $ysetmin = Min($y,$ysetmin);
	}
	for( $i = 0; $i < $nmax; $i++ ) {
	    // Get y-value for line $i by adding the
	    // individual bars from all the plots added.
	    // It would be wrong to just add the
	    // individual plots min y-value since that
	    // would in most cases give to small y-value.
	    $y=$this->plots[0]->coords[0][$i];
	    for( $j = 1; $j < $this->nbrplots; $j++ ) {
		$y += $this->plots[ $j ]->coords[0][$i];
	    }
	    $ymin[$i] = $y;
	}
	$ymin = Min($ysetmin,Min($ymin));
	return array($xmin,$ymin);
    }

    // Gets called before any axis are stroked
    function PreStrokeAdjust(&$graph) {

	// If another plot type have already adjusted the
	// offset we don't touch it.
	// (We check for empty in case the scale is  a log scale 
	// and hence doesn't contain any xlabel_offset)
	
	if( empty($graph->xaxis->scale->ticks->xlabel_offset) ||
	    $graph->xaxis->scale->ticks->xlabel_offset == 0 ) {
	    if( $this->center ) {
		++$this->numpoints;
		$a=0.5; $b=0.5;
	    } else {
		$a=0; $b=0;
	    }
	    $graph->xaxis->scale->ticks->SetXLabelOffset($a);
	    $graph->SetTextScaleOff($b);						
	    $graph->xaxis->scale->ticks->SupressMinorTickMarks();
	}
	
    }

    // To avoid duplicate of line drawing code here we just
    // change the y-values for each plot and then restore it
    // after we have made the stroke. We must do this copy since
    // it wouldn't be possible to create an acc line plot
    // with the same graphs, i.e AccLinePlot(array($pl,$pl,$pl));
    // since this method would have a side effect.
    function Stroke(&$img,&$xscale,&$yscale) {
	$img->SetLineWeight($this->weight);
	$this->numpoints = count($this->plots[0]->coords[0]);
	// Allocate array
	$coords[$this->nbrplots][$this->numpoints]=0;
	for($i=0; $i<$this->numpoints; $i++) {
	    $coords[0][$i]=$this->plots[0]->coords[0][$i]; 
	    $accy=$coords[0][$i];
	    for($j=1; $j<$this->nbrplots; ++$j ) {
		$coords[$j][$i] = $this->plots[$j]->coords[0][$i]+$accy; 
		$accy = $coords[$j][$i];
	    }
	}
	for($j=$this->nbrplots-1; $j>=0; --$j) {
	    $p=$this->plots[$j];
	    for( $i=0; $i<$this->numpoints; ++$i) {
		$tmp[$i]=$p->coords[0][$i];
		$p->coords[0][$i]=$coords[$j][$i];
	    }
	    $p->Stroke($img,$xscale,$yscale);
	    for( $i=0; $i<$this->numpoints; ++$i) 
		$p->coords[0][$i]=$tmp[$i];
	    $p->coords[0][]=$tmp;
	}
    }
} // Class


/* EOF */
?>
