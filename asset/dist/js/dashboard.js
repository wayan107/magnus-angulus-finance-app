jQuery(document).ready(function(){
	inquiryVsDeal(inquiryanddealData);
	
	function inquiryVsDeal(inquiryanddealData){
		var s1 = inquiryanddealData['inquiry'];
		var s2 = inquiryanddealData['inspection'];
		var s3 = inquiryanddealData['deal'];
		var ticks = inquiryanddealData.agent;

		var ivdPlot = $.jqplot('chart2', [s1,s2,s3], {
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
			seriesColors:['#17BDB8', '#F7F715', '#73C774']
		});

		var tick = dealrate['agent'];
		 var plot2 = $.jqplot('dealrate', [dealrate['dealrate']], {
			seriesDefaults: {
				renderer:$.jqplot.BarRenderer,
				pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
				shadowAngle: 135,
				rendererOptions: {
					barDirection: 'horizontal'
				}
			},
			axes: {
				yaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
					ticks:tick
				}
			}
		});
	}
	
	function inquiryVsDealUpdate(inquiryanddealData){
		var s1 = inquiryanddealData['inquiry'];
		var s2 = inquiryanddealData['inspection'];
		var s3 = inquiryanddealData['deal'];
		var ticks = inquiryanddealData.agent;

		var ivdPlot = $.jqplot('chart2', [s1,s2,s3], {
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
			seriesColors:['#17BDB8', '#F7F715', '#73C774']
		}).replot();
	}
	
	function dealRateUpdate(dealrate){
		var tick = dealrate['agent'];
		 var plot2 = $.jqplot('dealrate', [dealrate['dealrate']], {
			seriesDefaults: {
				renderer:$.jqplot.BarRenderer,
				pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
				shadowAngle: 135,
				rendererOptions: {
					barDirection: 'horizontal'
				}
			},
			axes: {
				yaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
					ticks:tick
				}
			}
		}).replot();
	}
	
	jQuery('#ivd-month').change(function(){
		var month=jQuery(this).val();
		var year = jQuery('#ivd-year').val();
		jQuery('.inquiryvsdeal-loading-layer').addLoadingLayer();
		jQuery('.dealrate-loading-layer').addLoadingLayer();
		
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'dashboard/inquiryanddeal',
			data	: {'month':month, 'year':year},
			success	: function(e){
				var inquiryanddealData = JSON.parse(e);
				inquiryVsDealUpdate(inquiryanddealData);
				jQuery('.inquiryvsdeal-loading-layer').removeLoadingLayer();
			}
		});
		
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'dashboard/dealrate',
			data	: {'month':month, 'year':year},
			success	: function(e){
				var dealrateData = JSON.parse(e);
				dealRateUpdate(dealrateData);
				jQuery('.dealrate-loading-layer').removeLoadingLayer();
			}
		});
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
		drawInquiryGraph();
	});
	
	jQuery('#inquiry-date-range').click(function(){
		drawInquiryGraph();
	});
	
	function drawInquiryGraph(){
		var period = jQuery('#inquiry-year-period').val();
		var from = jQuery('#from').val();
		var to = jQuery('#to').val();
		jQuery('.inquiry-loading-layer').addLoadingLayer();
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'dashboard/get_inquiry_graph_data',
			data	: {'period':period,'from':from,'to':to},
			success	: function(e){
				
				inquiryData = JSON.parse(e);
				//console.log(inquiryData);
				inquiryChart.setData(inquiryData);
				jQuery('.inquiry-loading-layer').removeLoadingLayer();
			}
		});
	}
	
	jQuery( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
	  defaultDate:"-1m",
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    jQuery( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
});
