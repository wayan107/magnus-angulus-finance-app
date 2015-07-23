$(function() {
    $('#side-menu').metisMenu();
	
	//Add Client ajax start
	var dialog = $( "#client-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Add Client": saveClient,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
      }
    });
	
	var form = dialog.find( "form" ).submit(function( event ) {
		event.preventDefault();
		var name = $(this).find('#name').val();
		var email = $(this).find('#email').val();
		var phone = $(this).find('#phone').val();
		$.ajax({
			type	: 'post',
			url		: baseurl+'client/ajax_insert/',
			data	: {'name':name,'email':email,'phone':phone},
			success	: function(e){
				if($.isNumeric(e)){
					$('#client-box').append('<option value="'+e+'" selected>'+name+'</option>');
				}else{
					alert(e);
				}
				dialog.dialog( "close" );
			}
		});
    });
	
	$( "#add-client" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
	
	function saveClient() {
      form.find('[type="submit"]').trigger('click');
    }
	//Add Client ajax end
	
	//Add owner ajax start
	var OwnerDialog = $( "#owner-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Add Owner": saveOwner,
        Cancel: function() {
          OwnerDialog.dialog( "close" );
        }
      },
      close: function() {
        OwnerForm[ 0 ].reset();
      }
    });
	
	var OwnerForm = OwnerDialog.find( "form" ).submit(function( event ) {
		event.preventDefault();
		var name = $(this).find('#name').val();
		var email = $(this).find('#email').val();
		var phone = $(this).find('#phone').val();
		$.ajax({
			type	: 'post',
			url		: baseurl+'owner/ajax_insert/',
			data	: {'name':name,'email':email,'phone':phone},
			success	: function(e){
				if($.isNumeric(e)){
					$('#owner-box').append('<option value="'+e+'" selected>'+name+'</option>');
				}else{
					alert(e);
				}
				OwnerDialog.dialog( "close" );
			}
		});
    });
	
	$( "#add-owner" ).button().on( "click", function() {
      OwnerDialog.dialog( "open" );
    });
	
	function saveOwner() {
      OwnerForm.find('[type="submit"]').trigger('click');
    }
	//Add owner ajax end
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

jQuery(document).ready(function(){
	jQuery( ".datepicker" ).datepicker();
	
	function override(){
		jQuery('.remove-plan').click(function(){
			var id = jQuery(this).attr('rel');
			if(id!=''){
				var obj = jQuery(this);
				obj.removeClass('fa-minus-circle').addClass('fa-spinner fa-pulse');
				jQuery.ajax({
					type	: 'POST',
					url		: baseurl+'deals/delete_payment_plan/',
					data	: {'id':id},
					success	: function(e){
						jQuery(obj).parent().parent().slideUp('fast',function(){
							jQuery(this).remove();
						});
					}
				});
			}else{
				jQuery(obj).parent().parent().slideUp('fast',function(){
						jQuery(this).remove();
					});
			}
			
		});
	}
	
	override();
	
	jQuery('.add-plan').click(function(){
		var prefix=jQuery(this).attr('rel');
		jQuery(this).before('<div class="plan"><div class="col-sm-5"><input type="hidden" name="'+prefix+'payment_id[]" value="null"><input type="number" name="'+prefix+'amount[]" required value="" class="form-control small-common-box"></div><div class="col-sm-2"><select name="'+prefix+'currency[]" class="form-control small-currency-box" required=""><option value="" selected="selected">Choose</option><option value="IDR">IDR</option><option value="USD">USD</option><option value="EUR">EUR</option><option value="AUD">AUD</option></select></div><div class="col-sm-4"><input type="text" name="'+prefix+'date[]" required class="datepicker form-control small-common-box"></div><div class="col-sm-1"><i class="fa fa-minus-circle remove-plan"></i></div></div>');
		override();
		jQuery( ".datepicker" ).datepicker();
	});
	
	jQuery('#occupation').change(function(){
		if(jQuery(this).val()=='Listing Agent'){
			jQuery('#commission').attr('disabled','disabled');
		}else{
			jQuery('#commission').removeAttr('disabled');
		}
	});
	
	jQuery('.button-view.pop-up').click(function(){
		var url = jQuery(this).attr('href');
		jQuery.ajax({
			type	: 'POST',
			url		: url,
			success	: function(e){
				jQuery('body').append(e);
				jQuery('#pop-up-window .close').click(function(){
					jQuery('#pop-up-window').remove();
				});
			}
		});
		return false;
	});
	
	jQuery('#generate').submit(function(e){
		e.preventDefault();
		var start=jQuery('#date-start').val();
		var end=jQuery('#date-end').val();
		var type=jQuery('#type').val();
		jQuery('.panel-body').append('<div class="loading-data"><i class="load fa fa-spinner fa-3x fa-pulse"></i></div>');
		jQuery.ajax({
			type	: 'POST',
			url		: baseurl+'moneyin/generate/',
			data	: {'type':type,'start':start,'end':end},
			success	: function(e){
				jQuery('.data').html(e);
				jQuery('.loading-data').remove();
			}
		});
	});
	
	jQuery('.status-toogle-paymentplan-paid').click(function(){
		var obj = jQuery(this);
		if(jQuery(this).hasClass('activate')){
			jQuery.ajax({
				url		: baseurl+'paymentplan/opensetform/'+jQuery(this).attr('rel'),
				success	: function(e){
					jQuery('body').append(e);
					jQuery( ".datepicker" ).datepicker();
					payment_plan_paid_button_func();
				}
			});
		}else{
			$confirm=confirm('Are your sure want to set this data as unpaid?');
			if($confirm){
				jQuery(this).removeClass('deactivate').addClass('fa fa-circle-o-notch fa-spin');
				jQuery.ajax({
					url		: baseurl+'paymentplan/deactivate/'+jQuery(this).attr('rel'),
					success	: function(e){
						obj.removeClass('fa fa-circle-o-notch fa-spin').addClass('activate');
						obj.attr('title','Unpaid');
						obj.parent().find('.button-view').remove();
					}
				});
			}
		}
		
		return false;
	});
	
	function payment_plan_paid_button_func(){
		jQuery('#pop-up-window .close').click(function(){
			jQuery('#pop-up-window').remove();
		});
		
		jQuery('#cancel').click(function(){
			jQuery('#pop-up-window').remove();
		});
		
		jQuery('#submit').click(function(){
			jQuery('.loading').show();
			jQuery.ajax({
				type	: 'POST',
				url		: baseurl+'paymentplan/activate/',
				data	:{'id':jQuery(this).attr('rel'),'paid_amount':jQuery('#paid_amount').val(),'currency':jQuery('#currency').val(),'pay_date':jQuery('#pay_date').val(),'payment_via':jQuery('#payment_via').val()},
				success	: function(){
					location.reload();
				}
			});
		});
	}
	
	jQuery('.status-toogle-agentcommission-comm_paid').click(function(){
		var obj = jQuery(this);
		if(jQuery(this).hasClass('activate')){
			jQuery.ajax({
				type	: 'POST',
				url		: baseurl+'agentcommission/opensetform/',
				data	: {'rel':jQuery(this).attr('rel')},
				success	: function(e){
					jQuery('body').append(e);
					jQuery( ".datepicker" ).datepicker();
					agentcommission_paid_button_func();
				}
			});
		}else{
			$confirm=confirm('Are your sure want to set this data as unpaid?');
			if($confirm){
				jQuery(this).removeClass('deactivate').addClass('fa fa-circle-o-notch fa-spin');
				jQuery.ajax({
					type	: 'POST',
					url		: baseurl+'agentcommission/deactivate/',
					data	: {'rel':jQuery(this).attr('rel')},
					success	: function(e){
						obj.removeClass('fa fa-circle-o-notch fa-spin').addClass('activate');
						obj.attr('title','Unpaid');
						obj.next().remove();
					}
				});
			}
		}
		
		return false;
	});
	
	function agentcommission_paid_button_func(){
		jQuery('#pop-up-window .close').click(function(){
			jQuery('#pop-up-window').remove();
		});
		
		jQuery('#cancel').click(function(){
			jQuery('#pop-up-window').remove();
		});
		
		jQuery('#submit').click(function(){
			jQuery('.loading').show();
			jQuery.ajax({
				type	: 'POST',
				url		: baseurl+'agentcommission/activate/',
				data	:{'id':jQuery(this).attr('rel'),'paid_amount':jQuery('#paid_amount').val(),'currency':jQuery('#currency').val(),'pay_date':jQuery('#pay_date').val(),'payment_via':jQuery('#payment_via').val()},
				success	: function(){
					location.reload();
				}
			});
		});
	}
	
	jQuery('#role').change(function(){
		if(jQuery(this).val()=='sales' || jQuery(this).val()=='sales_manager'){
			jQuery('#ra').removeAttr('disabled').attr('required','required');
		}else{
			jQuery('#ra').removeAttr('required').attr('disabled','disabled');
		}
	});
	
	//import script
			
	 $('#MyUploadForm').submit(function(e) {
		 e.preventDefault();
		var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			uploadProgress: OnProgress, //upload progress callback
			resetForm: true        // reset the form after successful submit 
		}; 
		$(this).ajaxSubmit(options);            
		return false; 
	});
	
	function beforeSubmit(){
		$('#progressbox').hide();
		$('#progressbar').width('0%') //update progressbar percent complete
		$('#statustxt').html('0%'); //update status text
		$('#output').html('');
   //check whether client browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob){
		   var fsize = $('#FileInput')[0].files[0].size; //get file size
			   var ftype = $('#FileInput')[0].files[0].type; // get file type
			//allow file types 
		  /*switch(ftype)
			   {
				case 'image/png': 
				case 'image/gif': 
				case 'image/jpeg': 
				case 'image/pjpeg':
				case 'text/plain':
				case 'text/html':
				case 'application/x-zip-compressed':
				case 'application/pdf':
				case 'application/msword':
				case 'application/vnd.ms-excel':
				case 'video/mp4':
				break;
				default:
				 $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
			 return false
			   }*/
		
		   //Allowed file size is less than 5 MB (1048576 = 1 mb)
		   if(fsize>5242880) 
		   {
			 alert("<b>"+fsize +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
			 return false
		   }
			}
			else
		{
		   //Error for older unsupported browsers that doesn't support HTML5 File API
		   alert("Please upgrade your browser, because your current browser lacks some new features we need!");
			   return false
		}
	}
	
	function OnProgress(event, position, total, percentComplete){
		//Progress bar
		$('#progressbox').show();
		$('#progressbar').width(percentComplete + '%') //update progressbar percent complete
		$('#statustxt').html(percentComplete + '%'); //update status text
		if(percentComplete>50)
		{
			$('#statustxt').css('color','#fafafa'); //change status text to white after 50%
		}
		if(percentComplete==100){
			$('#output').html('<i class="fa fa-spinner fa-pulse"></i> Saving Data, please wait...');
		}
	}
});
