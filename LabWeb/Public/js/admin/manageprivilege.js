$(document).ready(function ()
{
	ondo_addprivilege();
	$(document).on('pjax:success', function() {
		ondo_addprivilege();
	})
	
})
function ondo_addprivilege()
{
	$('#addprivilege_form').unbind("ajaxForm").ajaxForm();
    $('#addprivilege_form').unbind("submit").submit(function(){
    	addprivilegeAjaxSubmit();
    	return false;
    });
    $('.del_privi_button').unbind('click').click(function(){
    	$.get(
			'/home/admin/del_privilege_ajax', 
			{id: $(this).attr('name')},
			function(data){
				if(data["wrongcode"] != 999)
		        	alertify.error(data["wrongmsg"]);
		        else
		        {
		        	alertify.success("删除成功");
					$.pjax({url: window.location.href, container: '#mainpage'});
		        }
					
			},
			"json");
    })
}
function addprivilegeAjaxSubmit()
{
    $('#addprivilege_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] != 999)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
        	alertify.success("添加成功");
			$.pjax({url: window.location.href, container: '#mainpage'});
        }
        return false;
    });
    return false;
}