<?php if (!defined('THINK_PATH')) exit();?><div class='infotablediv'>
<table class="ui celled table segment">
	<tbody>
	<tr>
		<th colspan="8">个人信息（<?php echo ($strlist[$userinfo['kind']]); ?>）：</th>
	</tr>
	<tr>
		<td class="positive">姓名：</td>
		<td><?php echo ($userinfo['name']); ?></td>
		<td class="positive">学号：</td>
		<td><?php echo ($userinfo['uid']); ?></td>
		<td class="positive">性别：</td>
		<td><?php echo ($strlist[$userinfo['sex']]); ?></td>
		<td class="positive">攻读学位：</td>
		<td><?php echo ($strlist[$userinfo['degree']]); ?></td>
	</tr>
	<tr>
		<td class="positive">学院：</td>
		<td colspan="3"><?php echo ($strlist[$userinfo['institute']]); ?></td>	
		<td class="positive">专业：</td>
		<td colspan="3"><?php echo ($strlist[$userinfo['major']]); ?></td>	
		</tr>
	<tr>
		<td class="positive">年级：</td>
		<td><?php echo ($userinfo['grade']); ?></td>
		<td class="positive">出生年月：</td>
		<td><?php echo ($userinfo['birthday']); ?></td>
		<td class="positive">手机号：</td>
		<td><?php echo ($userinfo['phone']); ?></td>
		<td class="positive">邮箱：</td>
		<td><?php echo ($userinfo['email']); ?></td>
	</tr>
	<tr>
		<td class="positive">民族：</td>
		<td ><?php echo ($userinfo['nation']); ?></td>	
		<td class="positive">政治面貌：</td>
		<td><?php echo ($userinfo['political']); ?></td>
		<td class="positive">导师：</td>
		<td><a data-pjax href="/home/user/userinfo?uid=<?php echo ($userinfo['supervisorid']); ?>"><?php echo ($userinfo['supervisor']); ?></a></td>
		<td class="positive">负责老师：</td>
		<td><a data-pjax href="/home/user/userinfo?uid=<?php echo ($userinfo['teacherid']); ?>"><?php echo ($userinfo['teacher']); ?></a></td>
	</tr>
	<tr>
		<th colspan="8">学术/项目成果：</th>
	</tr>
	<tr>
		<td colspan="8">敬请期待。。。</td>
	</tr>
	</tbody>
</table>
</div>