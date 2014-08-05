$(document).ready(function ()
{
	//initialise datatables
	ondo_addannouncement();
	$(document).on('pjax:success', function() {
		ondo_addannouncement();
	})
	
})
function ondo_addannouncement()
{
	$('#addannouncement_form').unbind("ajaxForm").ajaxForm();
    $('#addannouncement_form').unbind("submit").submit(function(){
    	if($.trim($('#announcement_title').val()).length == 0)
    	{
        	alertify.error("标题不能为空");
        	return false;
    	}
    	else if($.trim($('#announcement_title').val()).length > 80)
    	{
        	alertify.error("标题不能超过80个英文字符或40个汉字");
        	return false;
    	}
    		
    	AddannouncementAjaxSubmit();
    	return false;
    });
    $('#announcement_title').focus();
}
function AddannouncementAjaxSubmit()
{
    $('#addannouncement_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] != 999)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success( "添加成功!");
			$.pjax({url: "/home/admin/announcementlist", container: '#mainpage'});
        }
        return false;
    });
    return false;
}