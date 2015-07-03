$(function() {
    $("#plan").change(function(){
		$.ajax({
			type	: 'POST',
			url		: baseurl+'inquiries/get_budget',
			data	: {'type':$("#plan").val()},
			success	: function(e){
				$("#budget").html(e);
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
});