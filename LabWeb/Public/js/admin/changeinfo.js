$(document).ready(function ()
{
	//initialise datatables
	ondo_changeinfo();
	$(document).on('pjax:success', function() {
		ondo_changeinfo();
	})
	
})
function ondo_changeinfo()
{
	$('#selectsex').unbind('dropdown').dropdown();
	$('#selectdegree').unbind('dropdown').dropdown();
	$('#selectinstitute').unbind('dropdown').dropdown();
	$('#selectmajor').unbind('dropdown').dropdown();
	$('#selectkind').unbind('dropdown').dropdown();
	$('#selectgraduate').unbind('dropdown').dropdown();
	$.tools.dateinput.localize("en", {
		months: '1月,2月,3月,4月,5月,6月,7月,8月,9月,10月,11月,12月',
		shortMonths:	'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
		days:			'日,一,二,三,四,五,六',
		shortDays:		'日,一,二,三,四,五,六'
	});
	$(":date").unbind('dateinput').dateinput({
		selectors: true,             	// whether month/year dropdowns are shown
		offset: [-100, -20],            	// tweak the position of the calendar
		speed: 'fast',               	// calendar reveal speed
		firstDay: 1,                  	// which day starts a week. 0 = sunday, 1 = monday etc..
		yearRange: [-60, 1],
		format:	'yyyy-mm-dd',				//Specifies how the date value is formatted in the input field. See formatting for more details.
		value : setbirthdate
	});

	$('#changeinfo_form').unbind("ajaxForm").ajaxForm();
    $('#changeinfo_form').unbind("submit").submit(function(){
    	ChangeinfoAjaxSubmit();
    	return false;
    });
}
function ChangeinfoAjaxSubmit()
{
    $('#changeinfo_form').ajaxSubmit(function(data){
    	jsondata = data;
    	if(jsondata["wrongcode"] == 72)
        	alertify.log(jsondata["wrongmsg"]);
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