$(document).ready(function ()
{
	ondo_managepaper();
	$(document).on('pjax:success', function() {
		ondo_managepaper();
	})
	
})
function ondo_managepaper()
{
    $('#paperadd_submit').unbind('click').click(function(){
    	$.get(
			'/home/admin/paperadd_ajax', 
			{uid: $('#managepaper_uid').text(), month: $('#paperadd_month_input').val(), addnum: $('#paperadd_input').val()},
			function(data){
				if(data["wrongcode"] != 999)
		        	alertify.error(data["wrongmsg"]);
		        else
		        {
		        	alertify.success("添加成功");
					$.pjax({url: window.location.href, container: '#mainpage'});
		        }
					
			},
			"json");
    })
    $('#change_paperlimit_submit').unbind('click').click(function(){
    	$.get(
			'/home/admin/change_paperlimit_ajax', 
			{uid: $('#managepaper_uid').text(), paperlimit: $('#change_paperlimit_input').val()},
			function(data){
		    	if(data["wrongcode"] == 72)
		        	alertify.log(data["wrongmsg"]);
		    	else if(data["wrongcode"] != 999)
		        	alertify.error(data["wrongmsg"]);
		        else
		        {
		        	alertify.success("修改成功");
		        }
					
			},
			"json");
    })
}
function change_paperadd_available(obj)
{
 	$.get(
		'/home/admin/change_paperadd_available_ajax', 
		{id: $(obj).attr('name')},
		function(data){
			if(data["wrongcode"] != 999)
				alertify.error(data["wrongmsg"]);
			else
			{
				alertify.success("修改成功");
				if(data['available'] != 0)
				{
					$(obj).removeClass('grey');
					$(obj).addClass('blue');
					$(obj).text('有效')
				}
				else
				{
					$(obj).removeClass('blue');
					$(obj).addClass('grey');
					$(obj).text('无效')
				}
			}
		},
		"json");
}