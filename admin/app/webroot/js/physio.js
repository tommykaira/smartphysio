(function($){
	
	Physio = {
		upload: function(){
			jQuery.ajaxFileUpload
			(
				{
					url:'/Users/logo_upload',
					secureuri:false,
					fileElementId:'file',
					dataType: 'json',
					data:{name:'test', id:'id'},
					success: function (data, status)
					{
						if(typeof(data.error) != 'undefined')
						{
							if(data.error != '')
							{
								alert(data.error);
							}else
							{
								alert(data.msg);
							}
						}
					},
					error: function (data, status, e)
					{
						alert(e);
					}
				}
			)
		}			
	}
	
	
	
})(jQuery);