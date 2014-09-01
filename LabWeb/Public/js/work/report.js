$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_report();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_report();
})
//添加focusEnd方法，将光标放到文字末尾
$.fn.focusEnd = function(){
    this.setCursorPosition(this.val().length);
}
function ondo_report()
{
	$('#add_discuss_form').unbind("ajaxForm").ajaxForm();
    $('#add_discuss_form').unbind("submit").submit(function(){
    	if(getBytesLength($.trim($('#add_discuss_text').val())) < 2)
    	{
        	alertify.error("内容不能太短");
        	return false;
    	}
    	else if(getBytesLength($.trim($('#add_discuss_text').val())) > 1000)
    	{
        	alertify.error("评论内容不能超过1000个字节");
        	return false;
    	}
    	Add_discussAjaxSubmit();
    	return false;
    });
    CountWordNum();
    ReplySetFocus();
}
//光标放到回复框末尾
function ReplySetFocus()
{
	$('#add_discuss_text').focusEnd();
}
function SetReplyTo(obj)
{
	$('#add_discuss_text').val($(obj).attr('reply_str') + "\n");
	SetWordNum();
	ReplySetFocus();
	$("body,html").animate(
		{ 
			scrollTop: $('#add_discuss_text').offset().top - 100
		}, 
		500
		); 
}
function ChangeReplyDisplay(obj)
{
 	$.get(
		'/home/work/change_discuss_available_ajax', 
		{id: $(obj).attr('name')},
		function(data){
			if(data["wrongcode"] < 990)
				alertify.error(data["wrongmsg"]);
			else
			{
				if(data['available'] == 0)
				{
					alertify.success("删除成功");
					$(obj).parent().siblings().find('.dimmer').css('display', 'block');
					$(obj).text('恢复显示');
				}
				else
				{
					alertify.success("恢复成功");
					$(obj).parent().siblings().find('.dimmer').css('display', 'none');
					$(obj).text('删除');
				}
			}
		},
		"json");
}
function getBytesLength(str)//获取中英混合字符串字节数
{
	return str.replace(/[^\x00-\xff]/g, 'xx').length;
}
function SetWordNum() 
{
	len = getBytesLength($.trim($('#add_discuss_text').val()));
	$('#num_of_words').text(len);
	if(len < 1000)
		$('#num_of_words').removeClass('red');
	else
		$('#num_of_words').addClass('red');
};
function CountWordNum()
{
	$('#add_discuss_text').unbind('input propertychange').bind('input propertychange', SetWordNum);
}
function Add_discussAjaxSubmit()
{
    $('#add_discuss_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] < 900)
        	alertify.error(jsondata["wrongmsg"]);
        else
        {
			$.pjax({url: window.location.href, container: '#mainpage'});
        	alertify.success(jsondata["wrongmsg"]);
        }
        return false;
    });
    return false;
}
function change_report_available(obj)
{
 	$.get(
		'/home/work/change_report_available_ajax', 
		{id: $(obj).attr('name')},
		function(data){
			if(data["wrongcode"] < 900)
				alertify.error(data["wrongmsg"]);
			else
			{
				alertify.success("修改成功");
				if(data['available'] != 0)
				{
					$(obj).removeClass('grey');
					$(obj).addClass('blue');
					$(obj).text('显示=>隐藏');
				}
				else
				{
					$(obj).removeClass('blue');
					$(obj).addClass('grey');
					$(obj).text('隐藏=>显示');
				}
			}
		},
		"json");
}

//将光标置于文本结尾
$.fn.setCursorPosition = function(position){
    if(this.lengh == 0) return this;
    return $(this).setSelection(position, position);
}

$.fn.setSelection = function(selectionStart, selectionEnd) {
    if(this.lengh == 0) return this;
    input = this[0];

    if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    } else if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    }

    return this;
}

