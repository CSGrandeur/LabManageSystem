$(document).ready(function ()
{
	//initialise datatables
	ondo_editstatistic();
	$(document).on('pjax:success', function() {
		ondo_editstatistic();
	})
	
})
function ondo_editstatistic()
{
	$('#editstatistic_form').unbind("ajaxForm").ajaxForm();
    $('#editstatistic_form').unbind("submit").submit(function(){
    	var starttime = new Date($('#statistic_starttime').val());
    	var endtime = new Date($('#statistic_endtime').val());
    	if(endtime < starttime)
    	{
    		alertify.error("结束时间不能早于开始时间");
    		return false;
    	}
    	
    	EditstatisticAjaxSubmit();
    	return false;
    });
}
function EditstatisticAjaxSubmit()
{
    $('#editstatistic_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] != 999)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success("修改成功");
        }
        return false;
    });
    return false;
}