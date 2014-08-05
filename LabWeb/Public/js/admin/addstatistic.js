$(document).ready(function ()
{
	//initialise datatables
	ondo_addstatistic();
	$(document).on('pjax:success', function() {
		ondo_addstatistic();
	})
	
})
function ondo_addstatistic()
{
	$('#addstatistic_form').unbind("ajaxForm").ajaxForm();
    $('#addstatistic_form').unbind("submit").submit(function(){
    	var starttime = new Date($('#statistic_starttime').val());
    	var endtime = new Date($('#statistic_endtime').val());
    	if(endtime < starttime)
    	{
    		alertify.error("结束时间不能早于开始时间");
    		return false;
    	}
    	if($.trim($('#statistic_title').val()).length == 0)
    	{
        	alertify.error("标题不能为空");
        	return false;
    	}
    	else if($.trim($('#statistic_title').val()).length > 80)
    	{
        	alertify.error("标题不能超过80个英文字符或40个汉字");
        	return false;
    	}
    	if($.trim($('#statistic_items').val()).length == 0)
    	{
        	alertify.error("统计项不能为空");
        	return false;
    	}
    	var okflag = false;
    	alertify.confirm("信息项列表提交后不可修改，确认信息项都正确？", function (e) {
    	    if (e) 
    	    {
    	    	okflag = true;
    	    }
    	});
    	if(okflag)
    		AddstatisticAjaxSubmit();
    	return false;
    });
    $('#allow_anonymouse_div').checkbox();

}
function AddstatisticAjaxSubmit()
{
    $('#addstatistic_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] != 999)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success("添加成功");
        }
        return false;
    });
    return false;
}