/*
	ClusterMarker Version 1.3.0 modified to use dynamic icons for cluster markers
	ClusterMarker.prototype._clusterMarker method has been modified
	and in constructor i have created a base icon for cluster markers with no image property, image property will be defined when cluster marker is created and reflect the number of markers within each cluster 
	
	A marker manager for the Google Maps API
	http://googlemapsapi.martinpearman.co.uk/clustermarker
	
	Copyright Martin Pearman 2008
	Last updated 24th August 2008

	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

	You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
*/

function ClusterMarker($map, $options){
	this._map=$map;
	this._mapMarkers=[];
	this._iconBounds=[];
	this._clusterMarkers=[];
	this._eventListeners=[];
	if(typeof($options)==='undefined'){
		$options={};
	}
	this.borderPadding=($options.borderPadding)?$options.borderPadding:256;
	this.clusteringEnabled=($options.clusteringEnabled===false)?false:true;
	if($options.clusterMarkerClick){
		this.clusterMarkerClick=$options.clusterMarkerClick;
	}
	
	if($options.clusterClass){
		this.clusterClass=$options.clusterClass;
	}else {
		this.clusterClass=1;
	}
	
	// modified code here
	this.clusterMarkerIcon=new GIcon();

	this.clusterMarkerIcon.image='img/thermals/cluster_'+this.clusterClass+'.png';	
	//this.clusterMarkerIcon.iconSize=new GSize(12, 20);
	this.clusterMarkerIcon.iconSize=new GSize(32, 32);
	this.clusterMarkerIcon.iconAnchor=new GPoint(6, 20);
	this.clusterMarkerIcon.infoWindowAnchor=new GPoint(6, 1);
		
	this.clusterMarkerTitle=($options.clusterMarkerTitle)?$options.clusterMarkerTitle:'Click to zoom in and see %count markers';
	if($options.fitMapMaxZoom){
		this.fitMapMaxZoom=$options.fitMapMaxZoom;
	}
	this.intersectPadding=($options.intersectPadding)?$options.intersectPadding:0;
	if($options.markers){
		this.addMarkers($options.markers);
	}
	this.minClusterSize=($options.minClusterSize)?$options.minClusterSize:1;
	GEvent.bind(this._map, 'moveend', this, this._moveEnd);
	GEvent.bind(this._map, 'zoomend', this, this._zoomEnd);
	GEvent.bind(this._map, 'maptypechanged', this, this._mapTypeChanged);
}

ClusterMarker.prototype.addMarkers=function($markers){
	var i;
	if(!$markers[0]){
		//	assume $markers is an associative array and convert to a numerically indexed array
		var $numArray=[];
		for(i in $markers){
			$numArray.push($markers[i]);
		}
		$markers=$numArray;
	}
	for(i=$markers.length-1; i>=0; i--){
		$markers[i]._isVisible=false;
		$markers[i]._isActive=false;
		$markers[i]._makeVisible=false;
	}
	this._mapMarkers=this._mapMarkers.concat($markers);
};

ClusterMarker.prototype._clusterMarker=function($clusterGroupIndexes){
	function $newClusterMarker($location, $icon, $title){
		return new GMarker($location, {icon:$icon, title:$title});
	}
	var $clusterGroupBounds=new GLatLngBounds(), i, $clusterMarker, $clusteredMarkers=[], $marker, $this=this;
	for(i=$clusterGroupIndexes.length-1; i>=0; i--){
		$marker=this._mapMarkers[$clusterGroupIndexes[i]];
		$marker.index=$clusterGroupIndexes[i];	//	rename index to less likely name _index ?
		$clusterGroupBounds.extend($marker.getLatLng());
		$clusteredMarkers.push($marker);
	}
	
	// modified code here, simply define image property of cluster marker icon depending upon number of markers within cluster
	var myIcon=new GIcon(this.clusterMarkerIcon), markerCount=$clusterGroupIndexes.length;
	if (markerCount<10){
		myIcon.iconSize=new GSize(22, 22)
		//myIcon.image='img/thermals/cluster_5.png';
	} else if (markerCount<50) {
		myIcon.iconSize=new GSize(35, 35)
		//myIcon.image='img/thermals/cluster_4.png';
	} else if (markerCount<100) {
		myIcon.iconSize=new GSize(50, 50)
		//myIcon.image='img/thermals/cluster_3.png';
	} else if (markerCount<300) {
		myIcon.iconSize=new GSize(70, 70)
		//myIcon.image='img/thermals/cluster_2.png';
	} else {
		myIcon.iconSize=new GSize(90, 90)
		//myIcon.image='img/thermals/cluster_1.png';
	}
	
	// modified code here - myIcon now passed to $newClusterMarker instead of this.clusterMarkerIcon
	$clusterMarker=$newClusterMarker($clusterGroupBounds.getCenter(), myIcon, this.clusterMarkerTitle.replace(/%count/gi, $clusterGroupIndexes.length));
	
	$clusterMarker.clusterGroupBounds=$clusterGroupBounds;	//	only req'd for default cluster marker click action
	this._eventListeners.push(GEvent.addListener($clusterMarker, 'click', function(){
		$this.clusterMarkerClick({clusterMarker:$clusterMarker, clusteredMarkers:$clusteredMarkers });
	}));
	return $clusterMarker;
};

ClusterMarker.prototype.clusterMarkerClick=function($args){
	this._map.setCenter($args.clusterMarker.getLatLng(), this._map.getBoundsZoomLevel($args.clusterMarker.clusterGroupBounds));
};

ClusterMarker.prototype._filterActiveMapMarkers=function(){
	var $borderPadding=this.borderPadding, $mapZoomLevel=this._map.getZoom(), $mapProjection=this._map.getCurrentMapType().getProjection(), $mapPointSw, $activeAreaPointSw, $activeAreaLatLngSw, $mapPointNe, $activeAreaPointNe, $activeAreaLatLngNe, $activeAreaBounds=this._map.getBounds(), i, $marker, $uncachedIconBoundsIndexes=[], $oldState;
	if($borderPadding){
		$mapPointSw=$mapProjection.fromLatLngToPixel($activeAreaBounds.getSouthWest(), $mapZoomLevel);
		$activeAreaPointSw=new GPoint($mapPointSw.x-$borderPadding, $mapPointSw.y+$borderPadding);
		$activeAreaLatLngSw=$mapProjection.fromPixelToLatLng($activeAreaPointSw, $mapZoomLevel);
		$mapPointNe=$mapProjection.fromLatLngToPixel($activeAreaBounds.getNorthEast(), $mapZoomLevel);
		$activeAreaPointNe=new GPoint($mapPointNe.x+$borderPadding, $mapPointNe.y-$borderPadding);
		$activeAreaLatLngNe=$mapProjection.fromPixelToLatLng($activeAreaPointNe, $mapZoomLevel);
		$activeAreaBounds.extend($activeAreaLatLngSw);
		$activeAreaBounds.extend($activeAreaLatLngNe);
	}
	this._activeMarkersChanged=false;
	if(typeof(this._iconBounds[$mapZoomLevel])==='undefined'){
		//	no iconBounds cached for this zoom level
		//	no need to check for existence of individual iconBounds elements
		this._iconBounds[$mapZoomLevel]=[];
		this._activeMarkersChanged=true;	//	force refresh(true) as zoomed to uncached zoom level
		
		/*
			update to:
			this._forceFullRefresh=true;
			
			set to false once refreshed in refresh method etc
		*/
		
		for(i=this._mapMarkers.length-1; i>=0; i--){
			$marker=this._mapMarkers[i];
			$marker._isActive=$activeAreaBounds.containsLatLng($marker.getLatLng())?true:false;
			$marker._makeVisible=$marker._isActive;
			if($marker._isActive){
				$uncachedIconBoundsIndexes.push(i);
			}
		}
	}else{
		//	icondBounds array exists for this zoom level
		//	check for existence of individual iconBounds elements
		for(i=this._mapMarkers.length-1; i>=0; i--){
			$marker=this._mapMarkers[i];
			$oldState=$marker._isActive;
			$marker._isActive=$activeAreaBounds.containsLatLng($marker.getLatLng())?true:false;
			$marker._makeVisible=$marker._isActive;
			if(!this._activeMarkersChanged && $oldState!==$marker._isActive){
				this._activeMarkersChanged=true;
			}
			if($marker._isActive && typeof(this._iconBounds[$mapZoomLevel][i])==='undefined'){
				$uncachedIconBoundsIndexes.push(i);
			}
		}
	}
	return $uncachedIconBoundsIndexes;
};

ClusterMarker.prototype._filterIntersectingMapMarkers=function(){
	var $clusterGroup, i, j, $mapZoomLevel=this._map.getZoom(), $minClusterSize=this.minClusterSize;
	for(i=this._mapMarkers.length-1; i>0; i--)
	{
		if(this._mapMarkers[i]._makeVisible){
			$clusterGroup=[];
			for(j=i-1; j>=0; j--){
				if(this._mapMarkers[j]._makeVisible && this._iconBounds[$mapZoomLevel][i].intersects(this._iconBounds[$mapZoomLevel][j])){
					$clusterGroup.push(j);
				}
			}
			if($clusterGroup.length>=$minClusterSize){
				$clusterGroup.push(i);
				for(j=$clusterGroup.length-1; j>=0; j--){
					this._mapMarkers[$clusterGroup[j]]._makeVisible=false;
				}
				this._clusterMarkers.push(this._clusterMarker($clusterGroup));
			}
		}
	}
};

ClusterMarker.prototype.fitMapToMarkers=function(){
	var $markers=this._mapMarkers, $markersBounds=new GLatLngBounds(), i;
	for(i=$markers.length-1; i>=0; i--){
		$markersBounds.extend($markers[i].getLatLng());
	}
	var $fitMapToMarkersZoom=this._map.getBoundsZoomLevel($markersBounds);
		
	if(this.fitMapMaxZoom && $fitMapToMarkersZoom>this.fitMapMaxZoom){
		$fitMapToMarkersZoom=this.fitMapMaxZoom;
	}
	this._map.setCenter($markersBounds.getCenter(), $fitMapToMarkersZoom);
	this.refresh();
};

ClusterMarker.prototype._mapTypeChanged=function(){
	this.refresh(true);
};

ClusterMarker.prototype._moveEnd=function(){
	if(!this._cancelMoveEnd){
		this.refresh();
	}else{
		this._cancelMoveEnd=false;
	}
};

ClusterMarker.prototype._preCacheIconBounds=function($indexes){
	var $mapProjection=this._map.getCurrentMapType().getProjection(), $mapZoomLevel=this._map.getZoom(), i, $marker, $iconSize, $iconAnchorPoint, $iconAnchorPointOffset, $iconBoundsPointSw, $iconBoundsPointNe, $iconBoundsLatLngSw, $iconBoundsLatLngNe, $intersectPadding=this.intersectPadding;
	for(i=$indexes.length-1; i>=0; i--){
		$marker=this._mapMarkers[$indexes[i]];
		$iconSize=$marker.getIcon().iconSize;
		$iconAnchorPoint=$mapProjection.fromLatLngToPixel($marker.getLatLng(), $mapZoomLevel);
		$iconAnchorPointOffset=$marker.getIcon().iconAnchor;
		$iconBoundsPointSw=new GPoint($iconAnchorPoint.x-$iconAnchorPointOffset.x-$intersectPadding, $iconAnchorPoint.y-$iconAnchorPointOffset.y+$iconSize.height+$intersectPadding);
		$iconBoundsPointNe=new GPoint($iconAnchorPoint.x-$iconAnchorPointOffset.x+$iconSize.width+$intersectPadding, $iconAnchorPoint.y-$iconAnchorPointOffset.y-$intersectPadding);
		$iconBoundsLatLngSw=$mapProjection.fromPixelToLatLng($iconBoundsPointSw, $mapZoomLevel);
		$iconBoundsLatLngNe=$mapProjection.fromPixelToLatLng($iconBoundsPointNe, $mapZoomLevel);
		this._iconBounds[$mapZoomLevel][$indexes[i]]=new GLatLngBounds($iconBoundsLatLngSw, $iconBoundsLatLngNe);
	}
};

ClusterMarker.prototype.refresh=function($forceFullRefresh){
	var i,$marker, $uncachedIconBoundsIndexes=this._filterActiveMapMarkers();
	if(this._activeMarkersChanged || $forceFullRefresh){
		this._removeClusterMarkers();
		if(this.clusteringEnabled && this._map.getZoom()<this._map.getCurrentMapType().getMaximumResolution()){
			if($uncachedIconBoundsIndexes.length>0){
				this._preCacheIconBounds($uncachedIconBoundsIndexes);
			}
			this._filterIntersectingMapMarkers();
		}
		for(i=this._clusterMarkers.length-1; i>=0; i--){
			this._map.addOverlay(this._clusterMarkers[i]);
		}
		for(i=this._mapMarkers.length-1; i>=0; i--){
			$marker=this._mapMarkers[i];
			if(!$marker._isVisible && $marker._makeVisible){
				this._map.addOverlay($marker);
				$marker._isVisible=true;
			}
			if($marker._isVisible && !$marker._makeVisible){
				this._map.removeOverlay($marker);
				$marker._isVisible=false;
			}
		}
	}
};

ClusterMarker.prototype._removeClusterMarkers=function(){
	for(var i=this._clusterMarkers.length-1; i>=0; i--){
		this._map.removeOverlay(this._clusterMarkers[i]);
	}
	for(i=this._eventListeners.length-1; i>=0; i--){
		GEvent.removeListener(this._eventListeners[i]);
	}
	this._clusterMarkers=[];
	this._eventListeners=[];
};

ClusterMarker.prototype.removeMarkers=function(){
	for(var i=this._mapMarkers.length-1; i>=0; i--){
		if(this._mapMarkers[i]. _isVisible){
			this._map.removeOverlay(this._mapMarkers[i]);
		}
		delete this._mapMarkers[i]._isVisible;
		delete this._mapMarkers[i]._isActive;
		delete this._mapMarkers[i]._makeVisible;
	}
	this._removeClusterMarkers();
	this._mapMarkers=[];
	this._iconBounds=[];
};


ClusterMarker.prototype.triggerClick=function($index){
	var $marker=this._mapMarkers[$index];
	if($marker._isVisible){
		//	$marker is visible
		GEvent.trigger($marker, 'click');
	}
	else if($marker._isActive){
		//	$marker is clustered
		this._map.setCenter($marker.getLatLng());
		this._map.zoomIn();
		this.triggerClick($index);
	}else{
		// $marker is not within active area (map bounds + border padding)
		this._map.setCenter($marker.getLatLng());
		this.triggerClick($index);
	}
};

ClusterMarker.prototype._zoomEnd=function(){
	this._cancelMoveEnd=true;
	this.refresh(true);
};
