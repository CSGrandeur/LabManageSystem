$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_report_edit();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_report_edit();
})
function ondo_report_edit()
{
	$('#select_report_kind').unbind('dropdown').dropdown();
	
	$('#report_edit_form').unbind("ajaxForm").ajaxForm();
    $('#report_edit_form').unbind("submit").submit(function(){
    	if($.trim($('#report_title').val()).length == 0)
    	{
        	alertify.error("标题不能为空");
        	return false;
    	}
    	Report_editAjaxSubmit();
    	return false;
    });
    $('#report_title').focus();
}
function Report_editAjaxSubmit()
{
    $('#report_edit_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] == 72)
        	alertify.log( "内容已最新!");
    	else if(jsondata["wrongcode"] < 900)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
			$.pjax({url: "/home/work/report?id="+jsondata["id"], container: '#mainpage'});
        	alertify.success( "修改成功!");
        }
        return false;
    });
    return false;
}