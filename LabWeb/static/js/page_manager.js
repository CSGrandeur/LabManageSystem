$(document).ready(function(){

	//set theme
	//JsSetTheme();
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
    //step page
    ChangeCurrentPageStep();
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
	ChangeCurrentPageStep();
})
//登录表单ajax提交
function LoginAjaxSubmit()
{
	$('#login_form').ajaxSubmit(function(data){
    	jsondata = $.parseJSON(data);
    	if(jsondata["valid"] == false)
	    	alertify.error( jsondata["retMsg"] );
        else
        {
			ChangeLoginLogoutDiv(jsondata["username"], true);
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
    	jsondata = $.parseJSON(data);
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
//顶栏step page链接设置
function ChangeCurrentPageStep()
{
	urlstr = window.location.href;
	var reg = new RegExp("^(.*/)(powerjudge[\\w/]*?)(?:[^\\w/]|$)");
	pagestrs = reg.exec(urlstr);
	pages = pagestrs[2].split("/");
	var i, j;
	for(i = 0, j = 0; i < pages.length; i ++)
		if(pages[i].trim() != "") pages[j ++] = pages[i].trim();
	targeturl = pagestrs[1] + "";
	htmlstr = "";
	for(i = 0; i < j; i ++)
	{
		targeturl += pages[i] + "/";
		htmlstr += "<a href='" + targeturl + "' data-pjax  class='ui " + (i == j - 1 ? "" : "active") + " step'><div class='one_page_step'> " + pages[i] +" </div> </a>\n"
	}
	$('#current_page_step').html(htmlstr);
}
//判断用户是否登录，设置用户栏
function WhetherLoggedIn()
{
	$.get(
		"/powerjudge/whether_loggedin_ajax/", 
		function(data){
			if(data['valid'] == true)
				ChangeLoginLogoutDiv(data['username'], true);
			else
				ChangeLoginLogoutDiv("", false);
				
		},
		"json");
}


//Django Cross Site Request Forgery protection -- for ajax post
function getCookie(name) {
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = jQuery.trim(cookies[i]);
            // Does this cookie string begin with the name we want?
            if (cookie.substring(0, name.length + 1) == (name + '=')) {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}
var csrftoken = getCookie('csrftoken');
function csrfSafeMethod(method) {
    // these HTTP methods do not require CSRF protection
    return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}
$.ajaxSetup({
    beforeSend: function(xhr, settings) {
        if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
            xhr.setRequestHeader("X-CSRFToken", csrftoken);
        }
    }
});
//set theme
var theme_color = "black";
var theme_invert = true;
function JsSetTheme()
{
	if(theme_invert)
		$('.js_invertset').each(function(){
			$(this).addClass('inverted');
		});
	$('.js_colorset').each(function(){
		$(this).addClass(theme_color);
	});
	
}