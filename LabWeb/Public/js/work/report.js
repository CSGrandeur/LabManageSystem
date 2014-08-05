$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_report();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_report();
})
function ondo_report()
{
	
}

function change_report_available(obj)
{
 	$.get(
		'/home/work/change_report_available_ajax', 
		{id: $(obj).attr('name')},
		function(data){
			if(data["wrongcode"] < 900)
				alertify.error(data["wrongmsg"]);
			else
			{
				alertify.success("修改成功");
				if(data['available'] != 0)
				{
					$(obj).removeClass('grey');
					$(obj).addClass('blue');
					$(obj).text('显示=>隐藏');
				}
				else
				{
					$(obj).removeClass('blue');
					$(obj).addClass('grey');
					$(obj).text('隐藏=>显示');
				}
			}
		},
		"json");
}
