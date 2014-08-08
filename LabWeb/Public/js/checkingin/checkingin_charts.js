$(document).ready(function ()
{
	var pjaxflag = false;
	$(document).on('pjax:end', function() {
		ondo_pcinfo();
		pjaxflag = true;
	})
	if(!pjaxflag)
		ondo_pcinfo();
})
function ondo_pcinfo()
{
	$(".chart").height(150);
	ChartDatas($('#pcinfo_uid').val());
	setInterval(function(){AddPoints($('#pcinfo_uid').val());}, timeperiod);
	
}
var name_table = new Array();
name_table['cpuload'] = 'CPU利用率';
name_table['memload'] = '内存利用率';
name_table['mousebutton0'] = '鼠标左键';
name_table['mousebutton1'] = '鼠标右键';
name_table['mousemove'] = '鼠标移动';
name_table['keybutton'] = '键盘敲击';
name_table['upload'] = '上行流量';
name_table['download'] = '下行流量';
name_table['appprocessnum'] = '应用程序数';
name_table['processnum'] = '进程数';

var timeperiod = 60000;//间隔采样时间
var pointnum = 120;//采样点个数
//在chartname表中加一个点
function AddPoint(chartname, datas, firstin){          
    var x, y, latex;
    if(datas.length == 0)
    {
    	x = (new Date()).getTime();
    	y = 0;
    }
    else
    {
    	chart = $('#' + chartname).highcharts();
    	x = new Date(Date.parse(datas['receivetime'])).getTime();
    	y = parseFloat(datas[chartname]);
    	latex = 0;
    	for(i = 0; i < chart.series[0].data.length; i ++)
    	{
    		if(chart.series[0].data[i].x > latex) 
    			latex = chart.series[0].data[i].x;
    	}
    	if(latex >= x)
    	{
    		now = (new Date()).getTime();
    		if((now - latex) / 1000.0 > timeperiod / 1000.0 - 1)
    		{//未得到数据库数据，五秒后重试
    			if(firstin)
    			{
    				setTimeout(function(){AddPoint(chartname, datas, false);}, timeperiod / 6);
    				return;
    			}
    		//五秒后重试依然未得到，插入空值。
    			else
    			{
	    			x = now - timeperiod / 6;
	    			y = 0;
    			}
    		}
    		else return;
    	}
    }
	chart.series[0].addPoint([x, y], true, true);
}  
function AddPoints(uid){

 	$.get(
 		"/home/checkingin/display_charts_ajax", 
		{uid:uid, type:'one'},
		function(data){
			$('.chart').each(function(){
				AddPoint($(this).attr('id'), data['data'], true);
			});
		//	WhatIsSomeoneDoing();
		},
 		"json");
	
}
function ChartDatas(uid)
{

 	$.get(
 		"/home/checkingin/display_charts_ajax", 
		{uid:uid, type:'all'},
		function(data){
			$('.chart').each(function(){
				MakeCharts($(this).attr('id'), data['data']);
			});
	//		WhatIsSomeoneDoing();
		},
		"json");
}
function JudgeDoing(jdatas)
{
	j = 0;
	for(i = 0; i < jdatas['memload'].length; i ++)
	{
		if(jdatas['memload'][i].x > jdatas['memload'][j].x) 
			j = i;
	}
	if(jdatas['memload'][j].y < 1) $('#whatdoing').text('未连接');
	else if(jdatas['memload'][j].y < 30) $('#whatdoing').text('什么都没干');
	else if(jdatas['memload'][j].y > 60 && jdatas['keybutton'][j].y > 10) $('#whatdoing').text('写代码');
	else if(jdatas['appprocessnum'][j].y > 10) $('#whatdoing').text('检查代码');
	else $('#whatdoing').text('逛淘宝 XD');
}
//判断在干什么
function WhatIsSomeoneDoing()
{
	var jdatas = new Array();
	$('.chart').each(function(){
		jdatas[$(this).attr('id')] = $(this).highcharts().series[0].data;
	});
	JudgeDoing(jdatas);

}
function MakeCharts(chartname, datas){
	
	Highcharts.setOptions({ 
        global: {           
            useUTC: false   
        }                   
    });
    $('#' + chartname).highcharts({
        chart: {            
            type: 'area', 
            animation: false,//Highcharts.svg, // don't animate in old IE               
            marginRight: 10            
        },                  
        title: {            
            text: false                                        
        },                  
        xAxis: {            
            type: 'datetime',   
            tickPixelInterval: 100                                              
        },                  
        yAxis: {            
            title: {        
                text: name_table[chartname]   
            },              
            plotLines: [{   
                value: 0,   
                width: 1,   
                color: '#808080'
            }]              
        },                  
        tooltip: {          
            formatter: function() {                                             
                    return '<b>'+ this.series.name +'</b><br>'+                
                    Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br>'+
                    Highcharts.numberFormat(this.y, 2);                         
            }               
        },                  
        legend: {           
            enabled: false  
        },                  
        exporting: {        
            enabled: false  
        },       
        credits:{
        	enabled:false,
        	text:'By CSGrandeur',
        	href:'http://www.cnblogs.com/CSGrandeur'
        },
        plotOptions:{
        	area:{
        		lineWidth:1
        	},
	        series:{
	        	marker:{
	        		radius:1
	        	}
	        }
        },
        series: [{
            name: name_table[chartname],
//            id  : 0,
            data: (function() { 
                var data = [],  
                time = (new Date()).getTime();                             
                var i, j, len = datas.length, datastart, dataend;
                if(datas.length != 0)
                {
                	datastart = new Date(Date.parse(datas[0]['receivetime'])).getTime();
                	dataend = new Date(Date.parse(datas[len - 1]['receivetime'])).getTime();
                	j = 0;
                }
                else j = -1;
                for(i = -(pointnum - 1); i <= 0; i ++)
                {
                	xx = time + i * timeperiod;
	               	if(j == -1 || xx < datastart)
	               	{
		                data.push({     
	                        x: xx,
	                        y: 0
	                    });
	               	}
	               	else
	               		break;
                }
                var np, lp;
                for(; j != -1 && j < len; j ++)
                {
                	np = new Date(Date.parse(datas[j]['receivetime'])).getTime();
                	if(j > 0 && np - lp > timeperiod * 1.5)//间距较大，插值
                	{
                		for(xx = lp + timeperiod; xx < np - timeperiod * 0.4; xx += timeperiod)
                		{
                			data.push({     
                                x: xx,
                                y: 0
                            });
                		}
                	}
                    data.push({     
                        x: np,
                        y: parseFloat(datas[j][chartname])
                    });
                    lp = np;
                }
				for(; i <= 0; i ++)
				{
					xx = time + i * timeperiod;
					if(j == -1 || xx > dataend + timeperiod)
                    data.push({     
                        x: xx,
                        y: 0
                    });
				}

                return data;
            })()
        }]                  
    });      
}                                  
function printArray(arr)
{
    var t = 'array(\n';
    for (var key in arr)
    {
        if (typeof(arr[key]) == 'array' || typeof(arr[key]) == 'object')
        {
            var t_tmp = key + ' = ' + printArray(arr[key]);
            t += '\t' + t_tmp + '\n';
        }
        else
        {
            var t_tmp = key + ' = ' + arr[key];
            t += '\t' + t_tmp + '\n';
        }
    }
    t = t + ')';
    return t;
}