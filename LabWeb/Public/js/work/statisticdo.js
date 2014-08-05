$(document).ready(function ()
{
	//initialise datatables
	ondo_statisticdo();
	$(document).on('pjax:success', function() {
		ondo_statisticdo();
	})
	
})
function ondo_statisticdo()
{
	$('#statisticdo_form').unbind("ajaxForm").ajaxForm();
	$('#statisticdo_form').unbind("submit").submit(function(){
		var emptyflag = true;
		$('.item_input').each(function(){
			if($.trim($(this).val()).length != 0)
			{
				emptyflag = false;
			}
		})
		if(emptyflag == true)
		{
			alertify.error("需要填写的信息不能全为空");
			return false;
		}
		StatisticdoAjaxSubmit();
		return false;
	});
	$('#announcement_title').focus();
}
function StatisticdoAjaxSubmit()
{
	$('#statisticdo_form').ajaxSubmit(function(data){
		jsondata = data;
		if(jsondata["wrongcode"] == 72)
			alertify.log(jsondata["wrongmsg"]);
		else if(jsondata["wrongcode"] < 900)
			alertify.error(jsondata["wrongmsg"]);
		else
			alertify.success(jsondata["wrongmsg"]);
		return false;
	});
	return false;
}