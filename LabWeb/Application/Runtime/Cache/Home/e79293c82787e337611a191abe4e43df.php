<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="keywords" content="html5, ui, library, framework, javascript" />
	
	
	

	
		<title>实验室内部信息站</title>
	
	<link href="/Public/css/labserver.css" rel="stylesheet" type="text/css">
	<link href="/Public/semantic/packaged/css/semantic.min.css" rel="stylesheet" type="text/css" class="ui">
	<link href="/Public/css/alertify.core.css" rel="stylesheet" type="text/css">
	<link href="/Public/css/alertify.default.css" rel="stylesheet" type="text/css">
	<link href="/Public/DataTables-1.10.1/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<link href="/Public/DataTables-1.10.1/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css">
	
	
	
	
	<script src="/Public/js/jquery-2.1.1.min.js" type="text/javascript"></script>
	<script src="/Public/js/page_manager.js" type="text/javascript" ></script>
	<script src="/Public/semantic/packaged/javascript/semantic.min.js" type="text/javascript"></script>
	<script src="/Public/js/jquery.pjax.min.js" type="text/javascript" ></script>
	<script src="/Public/js/jquery.form.min.js" type="text/javascript" ></script>
	<script src="/Public/js/alertify.min.js" type="text/javascript" ></script>
	<script src="/Public/DataTables-1.10.1/media/js/jquery.dataTables.min.js" type="text/javascript" ></script>
	
	
	
	
</head>

<body id="labserverbody">
	
			<div id="sidemenu" class="ui vertical inverted labeled thin sidebar menu black">
			
				<h3 class="item ui header">用户信息</h3>
				
				<div class="item" id="logout_form_div" style="display: none;">
					<form id="logout_form" action="/labserver/logout_function/" method="post" >
						<label>
							<a id="welcome" class="ui red huge label">
								欢迎！
							</a>
						</label>
						<div id="username_display">
								<?php echo session('username'); ?>
						</div>
						<div>
							<button id="logout_submit" type="submit" class="ui black mini submit button">
								登出
							</button>
						</div>
						
					</form>
				</div>
				<div class="item" id="login_form_div" >
					<form id="login_form" action="/labserver/login_function/" method="post" >
						<label>用户名:</label>
						<div class="ui input">
							<input name="username" type="text" placeholder="userid">
						</div>
							<label>密码:</label>
						<div class="ui input">
							<input name="password" type="password">
						</div>
						<div class="ui two column divided grid">
							<div class="column">
								<button id="login_submit" type="submit" class="ui black mini submit button">
									登录
								</button>
							</div>
							<div  class="column">
								<a data-pjax href="/labserver/register">
									<div class="column ui black mini submit button">注册</div>
								</a>
							</div>
						</div>
					</form>
				</div>
				<!-- 登录信息end -->
			
			
			
				<div class="header item">
					<i class="desktop icon"></i>
					信息站
				</div>
				<a class="item" data-pjax href="/labserver">
					主页
				</a>
				<a class="item" data-pjax href="/labserver/problem_list">
					考勤
				</a>
				<a class="item">
					打印机
				</a>
				<a class="item">
					Contest
				</a>
				<div class="header item">
					<i class="home icon"></i>
					Other Things
				</div>
				<a class="item">
					Contact Us
				</a>
			
				<a class="item">
					F.A.Qs
				</a>
			
		</div>
	

	
		<div id="topbar" class="ui fixed transparent js_invertset inverted thin menu js_colorset black">
			<div class="container">
				<div id="menubutton" class="item ui big button js_colorset black">
					<i class="icon list layout"></i>
					<span class="text" style="display: none;">Menu</span>
				</div>
				<div id="current_page_step" class="item ui small steps">
					<a href="/home/index" data-pjax class="ui blue step">
						<div class="one_page_step">
							Home
						</div>
					</a>
				</div>
				<div class="right menu">
					<div class="item">
						<h2 class="ui large header ojtitle">
			        		实验室内部信息站
						</h2>
			        </div>
					<div class="item">
						<a href="http://www.csu.edu.cn/" target=_blank class="ui image">
							<img src="/Public/img/csulogo_small.png">
						</a>
			        </div>
				</div>
			</div>
		</div>
	

	
		<div id="mainpage" class="mainpage container">
			<div id="page_loader" class="ui active inverted dimmer">
				<div class="ui loader">Loading</div>
			</div>
			
			
			
			
		</div>
	
	
	
	
</body>

</html>