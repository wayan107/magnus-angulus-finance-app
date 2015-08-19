jQuery(document).ready(function(){
		var s1 = inquiryanddealData['inquiry'];
        var s2 = inquiryanddealData['inspection'];
		var s3 = inquiryanddealData['deal'];
        var ticks = inquiryanddealData.agent;

	plot2 = $.jqplot('chart2', [s1,s2,s3], {
		stackSeries: true,
		seriesDefaults: {
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true },
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		},
		legend: {
                show: true,
                location: 'ne',
                placement: 'inside',
				labels:['Inquiry','Inspection','Deal'],
				rowSpacing:'0.9em'
            },
		seriesColors:['#17BDB8', '#F7F715', '#73C774'],
	});
	
	var placeholder = jQuery('#popular-area');
	$.plot(placeholder, popularAreaData, {
		series: {
			pie: {
				show: true,
				combine: {
					color: "#999",
					threshold: 0.05
				}
			}
		},
		legend: {
			show: false
		}
	});
});

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
		var period = jQuery(this).val();
		jQuery('.inquiry-loading-layer').addLoadingLayer();
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'dashboard/get_inquiry_graph_data',
			data	: {'period':period},
			success	: function(e){
				inquiryData = JSON.parse(e);
				inquiryChart.setData(inquiryData);
				jQuery('.inquiry-loading-layer').removeLoadingLayer();
			}
		});
	});
});
