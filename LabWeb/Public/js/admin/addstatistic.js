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
    	
    	AddstatisticAjaxSubmit();
    	return false;
    });
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