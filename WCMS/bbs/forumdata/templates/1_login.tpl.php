<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 会员登录</div>

<form method="post" name="login" action="logging.php?action=login&amp;">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="referer" value="<?=$referer?>" />
<div class="mainbox formbox">
	<span class="headactions"><a href="faq.php?action=message&amp;id=3" target="_blank">登录帮助</a></span>
	<h1>会员登录</h1>
	<table summary="会员登录" cellspacing="0" cellpadding="0">
		<? if($seccodecheck) { ?>
			<tr>
				<th><label for="seccodeverify">验证码</label></th>
				<td>
					<div id="seccodeimage"></div>
					<input type="text" onfocus="updateseccode();this.onfocus = null" id="seccodeverify" name="seccodeverify" size="8" maxlength="4" tabindex="1" />
					<em class="tips"><strong>点击输入框显示验证码</strong> <? if($seccodedata['type'] == 2) { ?>请确认您的浏览器支持 Flash 的显示，如果看不清验证码，请点<a href="###" onclick="updateseccode()">这里</a>刷新<? } elseif($seccodedata['animator'] == 1) { ?>请确认您的浏览器支持动画的显示，如果看不清验证码，请点图片刷新<? } else { ?>如果看不清验证码，请点图片刷新<? } ?></em></td>
					<script type="text/javascript">
						var seccodedata = [<?=$seccodedata['width']?>, <?=$seccodedata['height']?>, <?=$seccodedata['type']?>];
					</script>
			</tr>
		<? } ?>
		<tr>
			<th onclick="document.login.username.focus();">
				<label><input class="radio" type="radio" name="loginfield" value="username" tabindex="2" checked="checked" />用户名</label>
				<label><input class="radio" type="radio" name="loginfield" value="uid" tabindex="3" />UID</label>
			</th>
			<td>
				<input type="text" id="username" name="username" size="25" maxlength="40" tabindex="4" />
				<a href="<?=$regname?>">立即注册</a>
			</td>
		</tr>
		<tr>
			<th><label for="password">密码</label></th>
			<td>
				<input type="password" id="password" name="password" size="25" tabindex="5" />
				<a href="member.php?action=lostpasswd">忘记密码</a>
			</td>
		</tr>
		<tr>
			<th><label for="questionid">安全提问</label></th>
			<td>
				<select id="questionid" name="questionid" tabindex="6">
					<option value="0">无安全提问</option>
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
			<td><input type="text" id="answer" name="answer" size="25" tabindex="7" /> 如果您设置了安全提问，请回答正确的答案</td>
		</tr>
		<tr>
			<th>登录有效期</th>
			<td>
				<label><input class="radio" type="radio" name="cookietime" value="315360000" tabindex="8" <?=$cookietimecheck['315360000']?> /> 永久</label>
				<label><input class="radio" type="radio" name="cookietime" value="2592000" tabindex="9" <?=$cookietimecheck['2592000']?> /> 一个月</label>
				<label><input class="radio" type="radio" name="cookietime" value="86400" tabindex="10" <?=$cookietimecheck['86400']?> /> 一天</label>
				<label><input class="radio" type="radio" name="cookietime" value="3600" tabindex="11" <?=$cookietimecheck['3600']?> /> 一小时</label>
				<label><input class="radio" type="radio" name="cookietime" value="0" tabindex="12" <?=$cookietimecheck['0']?> /> 浏览器进程</label>
			</td>
		</tr>
		<tr>
			<th><label for="loginmode">隐身登录</label></th>
			<td>
				<select id="loginmode" name="loginmode" tabindex="13">
					<option value="">- 使用默认 -</option>
					<option value="normal"> 正常模式</option>
					<option value="invisible"> 隐身模式</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="styleid">界面风格</label></th>
			<td>
				<select id="styleid" name="styleid" tabindex="14">
					<option value="">- 使用默认 -</option>
					<?=$styleselect?>
				</select>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><button class="submit" type="submit" name="loginsubmit" value="true" tabindex="100">提交</button></td>
		</tr>
	</table>
</div>
</form>

<script type="text/javascript">
document.login.username.focus();

var mydate = new Date();
var mytimestamp = parseInt(mydate.valueOf() / 1000);
if(Math.abs(mytimestamp - <?=$timestamp?>) > 86400) {
	window.alert('注意:\n\n您本地计算机的时间设定与论坛时间相差超过 24 个小时，\n这可能会影响您的正常登录，请调整本地计算机设置。\n\n当前论坛时间是: <?=$thetimenow?>\n如果您认为论坛时间不准确，请与论坛管理员联系。');
}
</script>
<? include template('footer'); ?>
