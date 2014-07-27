$(document).ready(function ()
{
	//initialise datatables
	ondo_modify();
	$(document).on('pjax:success', function() {
		ondo_modify();
	})
	
})
function ondo_modify()
{
	$('#selectsex').unbind('dropdown').dropdown();
	$('#selectdegree').unbind('dropdown').dropdown();
	$('#selectinstitute').unbind('dropdown').dropdown();
	$('#selectmajor').unbind('dropdown').dropdown();
	$('#selectkind').unbind('dropdown').dropdown();
	$('#selectgraduate').unbind('dropdown').dropdown();


	$('#modify_form').unbind("ajaxForm").ajaxForm();
    $('#modify_form').unbind("submit").submit(function(){
    	ModifyAjaxSubmit();
    	return false;
    });
}
function ModifyAjaxSubmit()
{
    $('#modify_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] == 72)
        	alertify.log(jsondata["wrongmsg"]);
    	else if(jsondata["wrongcode"] == 81)
        	alertify.error('输入导师的姓名和所输入帐号对应导师的姓名不相符');
    	else if(jsondata["wrongcode"] != 999)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success( "用户信息已更新!");
        }
        return false;
    });
    return false;
}