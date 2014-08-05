$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_editstatistic();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_editstatistic();
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
    if(allow_anonymous != 0)
        $('#allow_anonymouse_div').checkbox('enable');
    else
        $('#allow_anonymouse_div').checkbox('disable');
    	
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