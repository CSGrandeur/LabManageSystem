$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_statisticdo();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_statisticdo();
})
var cansubmit_flag = true;
function submit_timeout()
{
	cansubmit_flag = true;
}
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
		if(cansubmit_flag == false)
		{
			alertify.error("提交过于频繁，请5秒后再试");
			return false;
		}
		StatisticdoAjaxSubmit();
		cansubmit_flag = false;
		setTimeout('submit_timeout()', 5000); 
		return false;
	});
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