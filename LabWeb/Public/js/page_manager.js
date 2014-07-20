$(document).ready(function(){

	//sidebar menu
	$('#sidemenu').unbind("sidebar").sidebar({
		overlay: false
	});
	//menubutton
	$('#sidemenu').sidebar('attach events', '#menubutton');
	$('#menubutton').unbind("mouseover").mouseover(function(){
		$('#menubutton>span').show();
	});
	$('#menubutton').unbind("mouseout").mouseout(function(){
		$('#menubutton>span').hide();
	});
	//pjax
	$(document).unbind("pjax").pjax('[data-pjax] a, a[data-pjax]', '#mainpage');
	$('#page_loader').unbind("hide").hide();
	//初始化ajaxform
	$('#login_form').unbind("ajaxForm").ajaxForm();
	$('#logout_form').unbind("ajaxForm").ajaxForm();
	//login
	$('#login_form').unbind("submit").submit(function(){
		LoginAjaxSubmit();
		return false;
    });
    //logout
	$('#logout_form').unbind("submit").submit(function(){
		LogoutAjaxSubmit()
		return false;
    });
    //whether loggedin
    WhetherLoggedIn();
})
$(document).on('pjax:send', function() {
	$('#page_loader').show()
})
$(document).on('pjax:complete', function() {
	$('#page_loader').hide()
})
$(document).on('pjax:success', function() {

})
//登录表单ajax提交
function LoginAjaxSubmit()
{
	$('#login_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] != 999)
	    	alertify.error( jsondata["wrongmsg"] );
        else
        {
			ChangeLoginLogoutDiv(jsondata["uname"], true);
			alertify.success("Successfully logged in");
			$.pjax({url: window.location.href, container: '#mainpage'});
        }
    });
	return false;
}
//登出表单ajax提交
function LogoutAjaxSubmit()
{
    $('#logout_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["valid"] == false)
        	alertify.error(jsondata["retMsg"]);
        else
        {
			ChangeLoginLogoutDiv("", false);
			alertify.success("Successfully logged out");
			$.pjax({url: window.location.href, container: '#mainpage'});
        }
    });
    return false;
}
//登录状态div修改
function ChangeLoginLogoutDiv(username, boolLoggedin)
{
	if(boolLoggedin)
	{
		$('#logout_form_div').show();
		$('#username_display').text(username);
		$('#login_form_div').hide();
	}
	else
	{
		$('#logout_form_div').hide();
		$('#username_display').text("");
		$('#login_form_div').show();
	}
}
//判断用户是否登录，设置用户栏
function WhetherLoggedIn()
{
	$.get(
		"/home/user/whether_loggedin_ajax/", 
		function(data){
			if(data['valid'] == true && data['loggedin'] == true)
				ChangeLoginLogoutDiv(data['uname'], true);
			else
				ChangeLoginLogoutDiv("", false);
				
		},
		"json");
}
