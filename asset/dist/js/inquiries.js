$(function() {
    $("#plan").change(function(){
		if($(this).val()=='2'){
			$('#planmoveout').show();
		}else{
			$('#planmoveout').hide();
		}
		$.ajax({
			type	: 'POST',
			url		: baseurl+'inquiries/get_hold_living',
			data	: {'type':$("#plan").val()},
			success	: function(e){
				$("#hold-living").html(e);
			}
		});
		
		$.ajax({
			type	: 'POST',
			url		: baseurl+'inquiries/get_budget',
			data	: {'type':$("#plan").val()},
			success	: function(e){
				$("#budget").html(e);
				$("select#budget").multiselect({
					selectedList: 1,
					noneSelectedText: 'Any Budget',
					header: false
				});
			}
		});

		
		
	});
	
	$('.setbutton').click(function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		$.ajax({
			type	: 'POST',
			url		: href,
			success	: function(e){
				$('body').append(e);
				buttonfunction();
			}
		});
	});
	
	function buttonfunction(){
		$('#pop-up-window .close').click(function(){
			$('#pop-up-window').remove();
		});
		
		$('#cancel').click(function(){
			$('#pop-up-window').remove();
		});
		
		$('#submit').click(function(){
			var id = $(this).attr('rel');
			var action = $(this).attr('data-action');
			jQuery('.loading').show();
			$.ajax({
				type	: 'POST',
				url		: action,
				data	: {'id':id,'agent':$('#agent').val()},
				success	: function(e){
					if(e=='1'){
						location.reload();
					}else{
						alert(e);
					}
				}
			});
		});
		
		
		$('#submit-status').click(function(){
			var id = $(this).attr('rel');
			var action = $(this).attr('data-action');
			var lostcase = '';
			if($('#status').val()=='Lost'){
				if($('#lost-case').val()=='other'){
					lostcase = $('#other-reason').val();
				}else{
					lostcase = $('#lost-case').val();
				}
			}
			
			var dealdate='';
			if($('#status').val()=='Deal'){
				dealdate = $('#deal_date').val();
			}
			jQuery('.loading').show();
			$.ajax({
				type	: 'POST',
				url		: action,
				data	: {'id':id,'status':$('#status').val(),'lost_case':lostcase,'dealdate':dealdate},
				success	: function(e){
					if(e=='1'){
						location.reload();
					}else{
						alert(e);
					}
				}
			});
		});
	}
	
	jQuery('#filter-status').change(function(){
		var text = 'Inquiry';
		if(jQuery(this).val()=='Deal'){
			text = 'Deal';
		}
		jQuery('#date-filter-label').html(text);
	});
	
	jQuery('.client-details').click(function(e){
		e.preventDefault();
		var toUrl = jQuery(this).attr('href');
		$.ajax({
			url		: toUrl,
			success	: function(e){
				jQuery('body').append(e);
				jQuery('#pop-up-window .close').click(function(){
					jQuery('#pop-up-window').remove();
				});
			}
		});
	});
});