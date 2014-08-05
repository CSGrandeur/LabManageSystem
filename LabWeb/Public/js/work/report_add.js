$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_report_add();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_report_add();
})
var can_reportadd_submit_flag = true;
function submit_reportadd_timeout()
{
	can_reportadd_submit_flag = true;
}
function ondo_report_add()
{
	$('#select_report_kind').unbind('dropdown').dropdown();
	
	$('#report_add_form').unbind("ajaxForm").ajaxForm();
    $('#report_add_form').unbind("submit").submit(function(){
    	if($.trim($('#report_title').val()).length == 0)
    	{
        	alertify.error("标题不能为空");
        	return false;
    	}
		if(can_reportadd_submit_flag == false)
		{
			alertify.error("提交过于频繁，请5秒后再试");
			return false;
		}
    	Report_addAjaxSubmit();
    	can_reportadd_submit_flag = false;
		setTimeout('submit_reportadd_timeout()', 5000); 
    	return false;
    });
    $('#report_title').focus();
}
function Report_addAjaxSubmit()
{
    $('#report_add_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] < 900)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success(jsondata["wrongmsg"]);
			$.pjax({url: "/home/work/report?id="+jsondata["newid"], container: '#mainpage'});
        }
        return false;
    });
    return false;
}