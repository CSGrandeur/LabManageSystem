$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_statistic_res();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_statistic_res();
})
function ondo_statistic_res()
{
	if(!$.fn.DataTable.isDataTable($('#statistic_res_table')))
		InitStatistic_resTable();
}
function InitStatistic_resTable()
{
	 $('#statistic_res_table').unbind("dataTable").dataTable({
		"scrollX": true,
		stateSave: true,// restore table state on page reload
		"pageLength": 100,
		"lengthMenu": [ 10, 25, 50, 100],
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"sSwfPath": "/Public/DataTables-1.10.2/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                         {
                             "sExtends": "copy",
                             "sButtonText": "复制表格"
                         },
                         {
                             "sExtends": "print",
                             "sButtonText": "打印表格"
                         }
                     ]
        }

	});
}

function del_statisticdo(obj)
{
	alertify.confirm("删除后不可恢复，确认删除？", function (e) {
	    if (e) 
	    {
	    	$.get(
				'/home/admin/del_statisticdo_ajax', 
				{id: $(obj).attr('name')},
				function(data){
					if(data["wrongcode"] < 900)
						alertify.error(data["wrongmsg"]);
					else
					{
						alertify.success("删除成功");
						$('#statistic_res_table').DataTable().row($(obj).parents('tr')).remove().draw();
					}
				},
				"json");
	    }
	});
}