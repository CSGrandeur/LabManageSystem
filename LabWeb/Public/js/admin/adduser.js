$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_adduser();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_adduser();
	
})
function ondo_adduser()
{
	$('#adduser_form').unbind("ajaxForm").ajaxForm();
    $('#adduser_form').unbind("submit").submit(function(){
    	AdduserAjaxSubmit();
    	return false;
    });
}
function AdduserAjaxSubmit()
{
    $('#adduser_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] < 900)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success( "增加:"+jsondata['add_cnt'] + "\n更新:" + jsondata['update_cnt'] + "\n失败:" + jsondata['fail_cnt']);
        }
        return false;
    });
    return false;
}