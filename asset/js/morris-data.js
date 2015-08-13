$(function() {
    var salesChart = Morris.Line({
        element: 'morris-area-chart',
        data: salesData,
        xkey: 'month',
        ykeys: ['sales', 'income'],
        labels: ['Sales', 'Income'],
		xLabels: 'month',
        pointSize: 5,
        hideHover: 'auto',
        resize: true,
		parseTime: false
    });
	
	var inquiryChart = Morris.Line({
        element: 'inquiry-area-chart',
        data: inquiryData,
        xkey: 'month',
        ykeys: ['inquiry'],
        labels: ['Inquiry'],
		xLabels: 'month',
        pointSize: 5,
        hideHover: 'auto',
        resize: true,
		parseTime: false
    });
	
	var inquiryAndDeal = Morris.Line({
        element: 'inquiryanddeal-area-chart',
        data: inquiryanddealData,
        xkey: 'agent',
        ykeys: ['inquiry','deal'],
        labels: ['Inquiry','Deal'],
		xLabels: 'agent',
        pointSize: 5,
        hideHover: 'auto',
        resize: true,
		parseTime: false
    });
	
	jQuery('#year-period').change(function(){
		var year = jQuery(this).val();
		jQuery('.loading-layer').addLoadingLayer();
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'dashboard/get_sales_graph_data',
			data	: {'year':year},
			success	: function(e){
				salesData = JSON.parse(e);
				salesChart.setData(salesData);
				jQuery('.loading-layer').removeLoadingLayer();
			}
		});
	});
	
	jQuery('#inquiry-year-period').change(function(){
		var year = jQuery(this).val();
		jQuery('.inquiry-loading-layer').addLoadingLayer();
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'dashboard/get_inquiry_graph_data',
			data	: {'year':year},
			success	: function(e){
				inquiryData = JSON.parse(e);
				inquiryChart.setData(inquiryData);
				jQuery('.inquiry-loading-layer').removeLoadingLayer();
			}
		});
	});

});
