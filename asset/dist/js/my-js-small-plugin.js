(function( $ ) {
	$.fn.addLoadingLayer = function(){
		var layer = "<div class='loading-data'><i class='load fa fa-spinner fa-pulse fa-3x'></i></div>";
		this.append(layer);
		return this;
	};
	
	$.fn.removeLoadingLayer = function(){
		this.find('.loading-data').remove();
		return this;
	};
}( jQuery ));