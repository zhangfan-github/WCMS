<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<script src="include/javascript/calendar.js" type="text/javascript"></script>

<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 注册</div>

<? if($bbrules && !$rulesubmit) { ?>
	<form name="bbrules" method="post" action="<?=$link_register?>">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<input type="hidden" name="referer" value="<?=$referer?>" />
	<? if($invitecode) { ?>
		<input type="hidden" name="invitecode" value="<?=$invitecode?>" />
	<? } ?>
	<div class="mainbox formbox">
	<h1>注册</h1>
	<table cellspacing="0" cellpadding="0" width="100%" align="center" class="register">
	<tbody>
	<tr>
	<td><?=$bbrulestxt?></td>
	</tr>
	</tbody>
	<tr class="btns" style="height: 40px">
		<td align="center" id="rulebutton">请仔细阅读以上的注册许可协议</td>
	</tr>

	</table>
	</div>
	</form>

	<script type="text/javascript">
	var secs = 9;
	var wait = secs * 1000;
	$('rulebutton').innerHTML = "请仔细阅读以上的注册许可协议 (" + secs + ")";
	for(i = 1; i <= secs; i++) {
		window.setTimeout("update(" + i + ")", i * 1000);
	}
	window.setTimeout("timer()", wait);
	function update(num, value) {
		if(num == (wait/1000)) {
			$('rulebutton').innerHTML = "请仔细阅读以上的注册许可协议";
		} else {
			printnr = (wait / 1000) - num;
			$('rulebutton').innerHTML = "请仔细阅读以上的注册许可协议 (" + printnr + ")";
		}
	}
	function timer() {
		$('rulebutton').innerHTML = '<button type="submit" id="rulesubmit" name="rulesubmit" value="true">同 意</button> &nbsp; <button type="button" onclick="location.href=\'<?=$boardurl?>\'">不同意</button>';
	}
	</script>
<? } else { ?>
	<script type="text/javascript">
	function showadv() {
		if(document.register.advshow.checked == true) {
			$("adv").style.display = "";
		} else {
			$("adv").style.display = "none";
		}
	}
	</script>
	<script src="include/javascript/msn.js" type="text/javascript"></script>
	<form method="post" name="register" action="<?=$link_register?>?regsubmit=yes" <?=$enctype?> onSubmit="this.regsubmit.disabled=true;">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<input type="hidden" name="referer" value="<?=$referer?>" />
	<div class="mainbox formbox">
		<span class="headactions"><a href="member.php?action=credits&amp;view=promotion_register" target="_blank">查看积分策略说明</a></span>
		<h1>注册</h1>
		<table summary="注册" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>基本信息 ( * 为必填项)</th>
					<td>&nbsp;</td>
				</tr>
			</thead>
		<? if($seccodecheck) { ?>
			<tr>
				<th><label for="seccodeverify">验证码  *</label></th>
				<td>
					<div id="seccodeimage"></div>
					<input type="text" onfocus="updateseccode();this.onfocus = null" id="seccodeverify" name="seccodeverify" size="8" maxlength="4" onBlur="checkseccode()" tabindex="1" />
					<em class="tips" id="checkseccodeverify"><strong>点击输入框显示验证码</strong> <? if($seccodedata['type'] == 2) { ?>请确认您的浏览器支持 Flash 的显示，如果看不清验证码，请点<a href="###" onclick="updateseccode()">这里</a>刷新<? } elseif($seccodedata['animator'] == 1) { ?>请确认您的浏览器支持动画的显示，如果看不清验证码，请点图片刷新<? } else { ?>如果看不清验证码，请点图片刷新<? } ?></em></td>
					<script type="text/javascript">
						var seccodedata = [<?=$seccodedata['width']?>, <?=$seccodedata['height']?>, <?=$seccodedata['type']?>];
					</script>
			</tr>
		<? } ?>

		<? if($secqaa['status']['1']) { ?>
			<tr>
				<th><label for="secanswer">验证问答  *</label></th>
				<td>
					<p id="secquestion">Loading question</p>
					<input type="text" name="secanswer" size="25" maxlength="50" id="secanswer" onBlur="checksecanswer()" tabindex="2" />
					<span id="checksecanswer">&nbsp;</span>
					<script type="text/javascript">
					<? if(($attackevasive & 1) && $seccodecheck) { ?>
						setTimeout("ajaxget('ajax.php?action=updatesecqaa&inajax=1', 'secquestion')", 2001);
					<? } else { ?>
						ajaxget('ajax.php?action=updatesecqaa&inajax=1', 'secquestion');
					<? } ?>
					</script>
				</td>
			</tr>
		<? } ?>

		<tr>
			<th><label for="username">用户名 *</label></th>
			<td>
				<input type="text" id="username" name="username" size="25" maxlength="15" onBlur="checkusername()" tabindex="3" />
				<span id="checkusername">&nbsp;</span>
			</td>
		</tr>

		<tr>
			<th><label for="password">密码  *</label></td>
			<td>
				<input type="password" name="password" size="25" id="password" onBlur="checkpassword()" tabindex="4" />
				<span id="checkpassword">&nbsp;</span>
			</td>
		</tr>

		<tr>
			<th><label for="password2">确认密码 *</label></th>
			<td>
				<input type="password" name="password2" size="25" id="password2" onBlur="checkpassword2()" tabindex="5" />
				<span id="checkpassword2">&nbsp;</span>
			</td>
		</tr>

		<tr>
			<th><label for="email">Email *</label></td>
			<td>
				<input type="text" name="email" size="25" id="email" onBlur="checkemail()" tabindex="6" />
				<span id="checkemail"><a href="#" onclick="msnoperate('reghotmail')">免费注册5G超大Hotmail邮箱</a><? if($regverify == 1) { ?>&nbsp; 请确保信箱有效，我们将发送激活说明到这个地址<? } ?>
				<? if($accessemail) { ?>&nbsp; 您只能使用以 <?=$accessemail?> 结尾的信箱<? } elseif($censoremail) { ?>&nbsp; 请不要使用以 <?=$censoremail?> 结尾的信箱<? } ?></span>
			</td>
		</tr>

		<? if($regstatus > 1) { ?>
			<tr>
				<th><label for="invitecode">邀请码<? if($regstatus == 2) { ?> *<? } ?></label></th>
				<td><input type="text" name="invitecode" size="25" maxlength="16" value="<?=$invitecode?>" id="invitecode" onBlur="checkinvitecode()" tabindex="7" />
				<span id="checkinvitecode"></span>
			</td>
			</tr>
		<? } ?>		

		<? if(!empty($fromuser)) { ?>
			<tr>
				<th>推荐人</th>
				<td><input type="text" name="fromuser" size="25" value="<?=$fromuser?>" disabled="disabled" tabindex="9" /></td>
			</tr>
		<? } if(is_array($_DCACHE['fields_required'])) { foreach($_DCACHE['fields_required'] as $field) { ?>			<tr>
			<th><?=$field['title']?>  *<? if($field['description']) { ?><br /><?=$field['description']?><? } ?></th>
			<td>
			<? if($field['selective']) { ?>
				<select name="field_<?=$field['fieldid']?>new" tabindex="10">
				<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>" <? if($index == $member['field_'.$field['fieldid']]) { ?>selected="selected"<? } ?>><?=$choice?></option>
				<? } } ?></select>
			<? } else { ?>
				<input type="text" name="field_<?=$field['fieldid']?>new" size="25" value="<?=$member['field_'.$field['fieldid']]?>" tabindex="10" />
			<? } ?>
			<? if($field['unchangeable']) { ?>&nbsp;请认真填写本项目，一旦确定将不可修改<? } ?>
			</td></tr><? } } if($regverify == 2) { ?>
			<tr>
			<th>注册原因 *</th>
			<td><textarea rows="4" cols="30" name="regmessage" tabindex="11"></textarea></td>
			</tr>
		<? } ?>
		<tr>
			<th><label for="advshow">高级选项</label></th>
			<td><label><input id="advshow" name="advshow" class="checkbox" type="checkbox" <?=$advcheck?> value="1" onclick="showadv()" tabindex="12" />显示高级用户设置选项</label></td>
		</tr>
	</table>

	<table summary="注册 高级选项" cellspacing="0" cellpadding="0" id="adv" style="display: <?=$advdisplay?>;">
		<thead>
			<tr>
				<th>扩展信息</th>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tr>
			<th><label for="questionid">安全提问</label></th>
			<td>
				<select id="questionid" name="questionid" tabindex="13">
					<option value="0">无安全提问</option>
					<option value="1">母亲的名字</option>
					<option value="2">爷爷的名字</option>
					<option value="3">父亲出生的城市</option>
					<option value="4">您其中一位老师的名字</option>
					<option value="5">您个人计算机的型号</option>
					<option value="6">您最喜欢的餐馆名称</option>
					<option value="7">驾驶执照的最后四位数字</option>
				</select> 如果您启用安全提问，登录时需填入相应的项目才能登录
			</td>
		</tr>

		<tr>
			<th><label for="answer">回答</label></th>
			<td><input type="text" id="answer" name="answer" size="25" tabindex="14" /></td>
		</tr><? if(is_array($_DCACHE['fields_optional'])) { foreach($_DCACHE['fields_optional'] as $field) { ?>			<tr>
				<th><?=$field['title']?><? if($field['description']) { ?><br /><?=$field['description']?><? } ?></th>
				<td>
				<? if($field['selective']) { ?>
					<select name="field_<?=$field['fieldid']?>new" tabindex="15">
					<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>"><?=$choice?></option>
					<? } } ?></select>
				<? } else { ?>
					<input type="text" name="field_<?=$field['fieldid']?>new" size="25" tabindex="15" />
				<? } ?>
				<? if($field['unchangeable']) { ?>&nbsp;请认真填写本项目，一旦确定将不可修改<? } ?>
				</td>
			</tr><? } } if($groupinfo['allownickname']) { ?>
			<tr>
				<th>昵称</th>
				<td><input type="text" name="nickname" size="25" tabindex="16" />
			</tr>
		<? } ?>

		<tr>
			<th>性别</th>
			<td>
				<label><input type="radio" name="gendernew" value="1" tabindex="17" /> 男</label>
				<label><input type="radio" name="gendernew" value="2" tabindex="18" /> 女</label>
				<label><input type="radio" name="gendernew" value="0" tabindex="19" checked="checked"> 保密</label>
			</td>
		</tr>

		<tr>
			<th><label for="bday">生日</label></th>
			<td><input type="text" id="bday" name="bday" size="25" onclick="showcalendar(event, this)" onfocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''" value="0000-00-00" tabindex="20" /></td>
		</tr>

		<tr>
			<th><label for="loactionnew">来自</label></th>
			<td><input type="text" id="loactionnew" name="locationnew" size="25" tabindex="21" /></td>
		</tr>

		<tr>
			<th><label for="site">个人网站</label></th>
			<td><input type="text" id="site" name="site" size="25" tabindex="22" /></td>
		</tr>

		<tr>
			<th><label for="qq">QQ</label></th>
			<td><input type="text" id="qq" name="qq" size="25" tabindex="23" /></td>
		</tr>
		
		<tr>
			<th><label for="msn">MSN</label></th>
			<td>
				<input type="text" name="msn" size="25" tabindex="8" />
				<span id="checkmsn"><a href="#" onclick="msnoperate('download')">下载最新版MSN Messenger</a></span>
			</td>
		</tr>

		<tr>
			<th><label for="icq">ICQ</label></th>
			<td><input type="text" id="icq" name="icq" size="25" tabindex="24" /></td>
		</tr>

		<tr>
			<th><label for="yahoo">Yahoo</label></td>
			<td><input type="text" id="yahoo" name="yahoo" size="25" tabindex="25" /></td>
		</tr>

		<tr>
			<th><label for="taobao">阿里旺旺</label></th>
			<td><input type="text" id="taobao" name="taobao" size="25" tabindex="26" /></td>
		</tr>

		<tr>
			<th><label for="alipay">支付宝账号</label></td>
			<td><input type="text" id="alipay" name="alipay" size="25" tabindex="27" /></td>
		</tr>

		<tr>
			<th valign="top"><label for="bio">自我介绍</label></td>
			<td><textarea rows="5" cols="30" id="bio" name="bio" tabindex="28"></textarea></td>
		</tr>

		<thead>
			<tr>
				<th>论坛个性化设置</th>
				<td>&nbsp;</td>
			</tr>
		</thead>

		<tr>
			<th><label for="styleidnew">界面风格</label></th>
			<td>
				<select id="styleidnew" name="styleidnew" tabindex="29">
					<option value="">- 使用默认 -</option>
					<?=$styleselect?>
				</select>
			</td>
		</tr>

		<tr>
			<th><label for="tppnew">每页主题数</label></th>
			<td>
				<select id="tppnew" name="tppnew" tabindex="30">
					<option value="0">- 使用默认 -</option>
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
				</select>
			</td>
		</tr>

		<tr>
			<th><label for="pppnew">每页帖数</label></th>
			<td>
				<select id="pppnew" name="pppnew" tabindex="31">
					<option value="0">- 使用默认 -</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="15">15</option>
				</select>
			</td>
		</tr>

		<tr>
			<th><label for="timeoffsetnew">时差设定</label></td>
			<td>
				<select id="timeoffsetnew" name="timeoffsetnew" tabindex="32">
					<option value="9999" selected="selected">- 使用默认 -</option>
					<option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
					<option value="-11">(GMT -11:00) Midway Island, Samoa</option>
					<option value="-10">(GMT -10:00) Hawaii</option>
					<option value="-9">(GMT -09:00) Alaska</option>
					<option value="-8">(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
					<option value="-7">(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
					<option value="-6">(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
					<option value="-5">(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
					<option value="-4">(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
					<option value="-3.5">(GMT -03:30) Newfoundland</option>
					<option value="-3">(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
					<option value="-2">(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
					<option value="-1">(GMT -01:00) Azores, Cape Verde Islands</option>
					<option value="0">(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
					<option value="1">(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
					<option value="2">(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
					<option value="3">(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
					<option value="3.5">(GMT +03:30) Tehran</option>
					<option value="4">(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
					<option value="4.5">(GMT +04:30) Kabul</option>
					<option value="5">(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
					<option value="5.5">(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
					<option value="5.75">(GMT +05:45) Katmandu</option>
					<option value="6">(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
					<option value="6.5">(GMT +06:30) Rangoon</option>
					<option value="7">(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
					<option value="8">(GMT +08:00) &#x5317;&#x4eac;(Beijing), Hong Kong, Perth, Singapore, Taipei</option>
					<option value="9">(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
					<option value="9.5">(GMT +09:30) Adelaide, Darwin</option>
					<option value="10">(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
					<option value="11">(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
					<option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
				</select>
			</td>
		</tr>

		<tr>
			<th><label for="">时间格式</label></th>
			<td>
				<label><input type="radio" value="0" name="timeformatnew" tabindex="33" checked="checked" />默认</label>
				<label><input type="radio" value="1" name="timeformatnew" tabindex="34" />12 小时</label>
				<label><input type="radio" value="2" name="timeformatnew" tabindex="35" />24 小时</label>
			</td>
		</tr>

		<tr>
			<th><label for="dateformatnew">日期格式</label></th>
			<td>
				<select id="dateformatnew" name="dateformatnew" tabindex="36">
					<option value="0">默认</option><? if(is_array($dateformatlist)) { foreach($dateformatlist as $key => $value) { ?><option value="<?=$key?>"><?=$value?></option><? } } ?></select>
			</td>
		</tr>

		<tr>
			<th>短消息提示音</th>
			<td>
				<label><input type="radio" value="0" name="pmsoundnew" />无</label>
				<input type="radio" value="1" name="pmsoundnew" tabindex="37" checked><a href="images/sound/pm_1.wav" />#1</a>
				<input type="radio" value="2" name="pmsoundnew" tabindex="38"><a href="images/sound/pm_2.wav" />#2</a>
				<input type="radio" value="3" name="pmsoundnew" tabindex="39"><a href="images/sound/pm_3.wav" />#3</a>
			</td>
		</tr>

		<? if($groupinfo['allowcstatus']) { ?>
			<tr>
			<th>自定义头衔</th>
			<td>
			<input type="text" name="cstatus" size="25" tabindex="40" /></td>
			</tr>
		<? } ?>

		<tr>
		<th>其他选项</th>
		<td>
		<? if($groupinfo['allowinvisible']) { ?>
			<input type="checkbox" name="invisiblenew" value="1" tabindex="41" /> 在线列表中隐身<br />
		<? } ?>
		<input type="checkbox" name="showemailnew" value="1" tabindex="42" checked="checked" /> Email 地址可见<br />
		<input type="checkbox" name="newsletter" value="1" tabindex="43" checked="checked" /> 同意接收论坛通知 (Email 或短消息)<br />
		</tr>

		<? if($groupinfo['allowavatar'] == 1) { ?>
			<tr>
			<th>头像</th>
			<td><input type="text" name="urlavatar" id="urlavatar" size="25" tabindex="44" /><a href="member.php?action=viewavatars&amp;page=1" onclick="ajaxget(this.href, 'avatardiv');doane(event);">论坛头像列表</a>
			<div id="avatardiv" style="display: none; margin-top: 10px;"></div>
			</td>
			</tr>
		<? } elseif($groupinfo['allowavatar'] == 2) { ?>
			<tr>
			<th>头像</th>
			<td><input type="text" name="urlavatar" id="urlavatar" size="25" tabindex="44" /> <a href="member.php?action=viewavatars&amp;page=1" onclick="ajaxget(this.href, 'avatardiv');doane(event);">论坛头像列表</a>
			<div id="avatardiv" style="display: none; margin-top: 10px;"></div>
			<br />宽: <input type="text" name="avatarwidth" size="1" value="*" /> &nbsp; 高: <input type="text" name="avatarheight" size="1" value="*" /></td>
			</tr>
		<? } ?>

		<? if($groupinfo['maxsigsize']) { ?>
			<tr>
			<th>个人签名<? if($maxsigsize) { ?> (<?=$maxsigsize?> 字节以内)<? } ?><br /><br />
			<a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a> <? if($groupinfo['allowsigbbcode']) { ?>可用<? } else { ?>禁用<? } ?><br />
			[img] 代码 <? if($groupinfo['allowsigimgcode']) { ?>可用<? } else { ?>禁用<? } ?>
			</th>
			<td><textarea rows="4" cols="30" name="signature" tabindex="45"></textarea></td>
			</tr>
		<? } ?>
		</tbody>
	</table>
	<table summary="Submit Button" cellpadding="0" cellspacing="0">
		<tr>
			<th>&nbsp;</th>
			<td><button class="submit" type="submit" name="regsubmit" value="true" tabindex="100">提交</button></td>
		</tr>
		</table>
	</div>
	</form>

	<script type="text/javascript">
	var profile_seccode_invalid = '验证码输入错误，请重新填写。';
	var profile_secanswer_invalid = '验证问答回答错误，请重新填写。';
	var profile_username_toolong = '对不起，您的用户名超过 15 个字符，请输入一个较短的用户名。';
	var profile_username_tooshort = '对不起，您输入的用户名小于3个字符, 请输入一个较长的用户名。';
	var profile_username_illegal = '用户名包含敏感字符或被系统屏蔽，请重新填写。';
	var profile_passwd_illegal = '密码空或包含非法字符，请重新填写。';
	var profile_passwd_notmatch = '两次输入的密码不一致，请检查后重试。';
	var profile_email_illegal = 'Email 地址无效，请重新填写。';
	var profile_email_invalid = '您只能使用以 <?=$accessemail?> 结尾的信箱，请重新填写。';
	var profile_email_censor = '请不要使用以 <?=$censoremail?> 结尾的信箱，请重新填写。';
	var profile_email_msn = '<a href="#" onclick="msnoperate(\'regliveid\')">把您的邮箱注册为MSN帐号</a>';
	var doublee = parseInt('<?=$doublee?>');
	var lastseccode = lastsecanswer = lastusername = lastpassword = lastemail = lastinvitecode = '';
	var xml_http_building_link = '请等待，正在建立连接...';
	var xml_http_sending = '请等待，正在发送数据...';
	var xml_http_loading = '请等待，正在接受数据...';
	var xml_http_load_failed = '通信失败，请刷新重新尝试！';
	var xml_http_data_in_processed = '通信成功，数据正在处理中...';

	$('username').focus();
	function showAvatar(page) {
		var x = new Ajax('XML', 'statusid');
		x.get('member.php?action=viewavatars&page='+page, function(s){
			$("avatardiv").innerHTML = s;
			if($('multipage')) {
				var multiChildNodes = $('multipage').firstChild.childNodes;
				for(k in multiChildNodes) {
					if(multiChildNodes[k].href) {
						var r = multiChildNodes[k].href.match(/page=(\d*)/);
						var currpage = parseInt(r[1]);
		 				if(multiChildNodes) {
							multiChildNodes[k].href = isNaN(currpage) ? '' : 'javascript:showAvatar("'+currpage+'")';
						}
					}
				}
			}
		});
	}

	function checkseccode() {
		var seccodeverify = $('seccodeverify').value;
		if(seccodeverify == lastseccode) {
			return;
		} else {
			lastseccode = seccodeverify;
		}
		var cs = $('checkseccodeverify');
		<? if($seccodedata['type'] != 1) { ?>
			if(!(/[0-9A-Za-z]{4}/.test(seccodeverify))) {
				warning(cs, profile_seccode_invalid);
				return;
			}
		<? } else { ?>
			if(seccodeverify.length != 2) {
				warning(cs, profile_seccode_invalid);
				return;
			}
		<? } ?>
		ajaxresponse('checkseccodeverify', 'action=checkseccode&seccodeverify=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(seccodeverify) : seccodeverify));
	}
	function checksecanswer() {
	        var secanswer = $('secanswer').value;
		if(secanswer == lastsecanswer) {
			return;
		} else {
			lastsecanswer = secanswer;
		}
		ajaxresponse('checksecanswer', 'action=checksecanswer&secanswer=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(secanswer) : secanswer));
	}
	function checkusername() {
		var username = trim($('username').value);
		if(username == lastusername) {
			return;
		} else {
			lastusername = username;
		}
		var cu = $('checkusername');
		var unlen = username.replace(/[^\x00-\xff]/g, "**").length;

		if(unlen < 3 || unlen > 15) {
			warning(cu, unlen < 3 ? profile_username_tooshort : profile_username_toolong);
			return;
		}
                ajaxresponse('checkusername', 'action=checkusername&username=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(username) : username));
	}
	function checkpassword(confirm) {
		var password = $('password').value;
		if(!confirm && password == lastpassword) {
			return;
		} else {
			lastpassword = password;
		}
		var cp = $('checkpassword');
		if(password == '' || /[\'\"\\]/.test(password)) {
			warning(cp, profile_passwd_illegal);
			return false;
		} else {
			cp.style.display = 'none';
			if(!confirm) {
				checkpassword2(true);
			}
			return true;
		}
	}
	function checkpassword2(confirm) {
		var password = $('password').value;
		var password2 = $('password2').value;
		var cp2 = $('checkpassword2');
		if(password2 != '') {
			checkpassword(true);
		}
		if(password == '' || (confirm && password2 == '')) {
			cp2.style.display = 'none';
			return;
		}
		if(password != password2) {
			warning(cp2, profile_passwd_notmatch);
		} else {
			cp2.style.display = 'none';
		}
	}
	function checkemail() {
		var email = trim($('email').value);
		if(email == lastemail) {
			return;
		} else {
			lastemail = email;
		}
		var ce = $('checkemail');
		var accessemail = '<?=$accessemail?>';
		var censoremail = '<?=$censoremail?>';
		var accessexp = accessemail != '' ? <?=$accessexp?> : null;
		var censorexp = censoremail != '' ? <?=$censorexp?> : null;

		illegalemail = !(/^[\-\.\w]+@[\.\-\w]+(\.\w+)+$/.test(email));
		invalidemail = accessemail != '' ? !accessexp.test(email) : censoremail != '' && censorexp.test(email);
		if(illegalemail || invalidemail) {
			warning(ce, illegalemail ? profile_email_illegal : (accessemail != '' ? profile_email_invalid : profile_email_censor));
			return;
		}

		if(!(/@(msn|hotmail|live)\.com$/.test(email))) {
			$('checkemail').style.display = '';
			$('checkemail').innerHTML = ' &nbsp; ' + profile_email_msn;
			return;
		}

		if(!doublee) {
			ajaxresponse('checkemail', 'action=checkemail&email=' + email);
		} else {
			ce.innerHTML = '<img src="<?=IMGDIR?>/check_right.gif" width="13" height="13">';
		}

	}
	function checkinvitecode() {
		var invitecode = trim($('invitecode').value);
		if(invitecode == lastinvitecode) {
			return;
		} else {
			lastinvitecode = invitecode;
		}
                ajaxresponse('checkinvitecode', 'action=checkinvitecode&invitecode=' + invitecode);
	}
	function trim(str) {
		return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
	}
        function ajaxresponse(objname, data) {
        	var x = new Ajax('XML', objname);
        	x.get('ajax.php?inajax=1&' + data, function(s){
        	        var obj = $(objname);
        	        if(s == 'succeed') {
        	        	obj.style.display = '';
        	                obj.innerHTML = '<img src="<?=IMGDIR?>/check_right.gif" width="13" height="13">';
        			obj.className = "warning";
        		} else {
        			warning(obj, s);
        		}
        	});
        }
	function warning(obj, msg) {
		if((ton = obj.id.substr(5, obj.id.length)) != 'password2') {
			$(ton).select();
		}
		obj.style.display = '';
		obj.innerHTML = '<img src="<?=IMGDIR?>/check_error.gif" width="13" height="13"> &nbsp; ' + msg;
		obj.className = "warning";
	}
	</script>

<? } include template('footer'); ?>
