<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 忘记密码</div>

<form method="post" action="member.php?action=lostpasswd">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<div class="mainbox formbox">
		<h1>忘记密码</h1>
		<table summary="忘记密码" cellspacing="0" cellpadding="0">
			<tr>
				<th><label for="username">用户名</label></th>
				<td><input type="text" id="username" name="username" size="25" /></td>
			</tr>
			<tr>
				<th><label for="email">Email</label></th>
				<td ><input type="text" id="email" name="email" size="25" />
			</tr>
			<tr>
				<th><label for="questionid">安全提问</label></th>
				<td>
					<select id="questionid" name="questionid">
						<option value="0">&nbsp;</option>
						<option value="1">母亲的名字</option>
						<option value="2">爷爷的名字</option>
						<option value="3">父亲出生的城市</option>
						<option value="4">您其中一位老师的名字</option>
						<option value="5">您个人计算机的型号</option>
						<option value="6">您最喜欢的餐馆名称</option>
						<option value="7">驾驶执照的最后四位数字</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="answer">回答</label></th>
				<td><input type="text" name="answer" size="25" /></td>
			</tr>
			<tr class="btns">
				<th>&nbsp;</th>
				<td><button type="submit" class="submit" name="lostpwsubmit" value="true">提交</button></td>
			</tr>
		</table>
	</div>
</form>
<? include template('footer'); ?>
