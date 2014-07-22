$(document).ready(function ()
{
    $('#user_list').unbind("dataTable").dataTable( {
        "serverSide": true,
        "ajax": {
            "url": "/home/admin/user_list_ajax/",
            "type": "POST",
            pages: 5 // number of pages to cache
        },
        "columns": [
                    { "data": "uid" },
                    { "data": "name" },
                    { "data": "sex" },
                    { "data": "grade" },
                    { "data": "degree" },
                    { "data": "supervisor" },
                    {"data": "teacher" },
                    {"data": "phone" },
                    {"data": "email" }
                ]
    } );
	
});