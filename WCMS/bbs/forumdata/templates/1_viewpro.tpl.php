<? if(!defined('IN_DISCUZ')) exit('Access Denied'); function userinfo($member) {
global $spacelanguage, $spacesettings, $uid;
 ?><table class="module" cellpadding="0" cellspacing="0" border="0"><tr><td class="header"><div class="title"><?=$spacelanguage['userinfo']?></div></td></tr>
	<tr><td>
	<div id="module_userinfo">
		<div class="status">状态: <span><? if($member['online']) { ?>当前在线<? } else { ?>当前离线<? } ?></span></div>
		<div class="info">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed; overflow: hidden">
		<tr><td align="center">
		<? if($member['avatar']) { ?>
			<img src="<?=$member['avatar']?>" width="<?=$member['avatarwidth']?>" height="<?=$member['avatarheight']?>" border="0" alt="" />
		<? } else { ?>
			<img src="images/avatars/noavatar.gif" alt="" />
		<? } ?>
		</td></tr></table></div>
		<div class="username"><?=$member['username']?><? if($member['nickname']) { ?><br /><?=$member['nickname']?><? } ?></div>
		<div class="operation">
		<img src="mspace/<?=$spacesettings['style']?>/sendmail.gif" alt="" /><a target="_blank" href="pm.php?action=send&amp;uid=<?=$member['uid']?>">发短消息</a>
		<img src="mspace/<?=$spacesettings['style']?>/buddy.gif" alt="" /><a target="_blank" href="my.php?item=buddylist&amp;newbuddyid=<?=$member['uid']?>&amp;buddysubmit=yes" id="ajax_buddy" onclick="ajaxmenu(event, this.id)">加为好友</a>
		</div>
		<? if($member['bio']) { ?>
		<div class="more">
		<br /><?=$member['bio']?>
		</div>
		<? } ?>
	</div>
	</td></tr></table><? }
 if($spacesettings['side'] != 2) { ?>
	<td id="main_layout0"><? userinfo($member) ?></td>
<? } ?>

<td id="main_layout1">
<div id="module_userdetails">

<table class="module" cellpadding="0" cellspacing="0" border="0"><tr><td class="header">
<div class="title">详细信息</div>
<div class="more">
<? if($member['uid'] == $discuz_uid) { ?>
	<a href="memcp.php?action=profile" target="_blank">编辑个人资料</a>
<? } ?>
<a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank">信用评价</a>
<? if($allowmagics && $magicstatus) { ?>
	<a href="magic.php?action=user&amp;username=<?=$member['usernameenc']?>" target="_blank">使用道具</a>
<? } ?>
<a href="search.php?srchuid=<?=$member['uid']?>&amp;srchfid=all&amp;srchfrom=0&amp;searchsubmit=yes">搜索帖子</a>
<? if($allowedituser || $allowbanuser) { ?>
	<? if($adminid == 1) { ?>
		<a href="admincp.php?action=members&amp;username=<?=$member['usernameenc']?>&amp;searchsubmit=yes&amp;frames=yes" target="_blank">编辑用户</a>
	<? } else { ?>
		<a href="admincp.php?action=editmember&amp;uid=<?=$member['uid']?>&amp;membersubmit=yes&amp;frames=yes" target="_blank">编辑用户</a>
	<? } ?>
	<a href="admincp.php?action=banmember&amp;uid=<?=$member['uid']?>&amp;membersubmit=yes&amp;frames=yes" target="_blank">禁止用户</a>
<? } if($member['adminid'] > 0 && $modworkstatus) { ?>
	<a href="stats.php?type=modworks&amp;uid=<?=$member['uid']?>">工作统计</a>
<? } ?>
</div>
</td></tr>
</table>

<table class="info" border="0" cellspacing="0" cellpadding="<?=TABLESPACE?>" width="100%">
<tr><th>UID:</th><td><?=$member['uid']?></td></tr>
<tr><th>注册日期:</th><td><?=$member['regdate']?></td></tr>
<? if($allowviewip) { ?>
	<tr><th>注册 IP:</th><td><?=$member['regip']?> <?=$member['regiplocation']?></td></tr>
	<tr><th>上次访问 IP:</th><td><?=$member['lastip']?> <?=$member['lastiplocation']?></td></tr>
<? } ?>
<tr><th>上次访问:</th><td><? if($member['invisible'] && $adminid != 1) { ?>隐身模式<? } else { ?><?=$member['lastvisit']?><? } ?></td></tr>
<tr><th>最后发表:</th><td><?=$member['lastpost']?></td></tr>
<? if($pvfrequence) { ?>
	<tr><th>页面访问量:</th><td><?=$member['pageviews']?></td></tr>
<? } if($oltimespan) { ?>
	<tr><th valign="top">在线时间:</th><td>总计在线 <span class="bold"><?=$member['totalol']?></span> 小时, 本月在线 <span class="bold"><?=$member['thismonthol']?></span> 小时 <? showstars(ceil(($member['totalol'] + 1) / 50)); ?><br />升级剩余时间 <span class="bold"><?=$member['olupgrade']?></span> 小时</td></tr>
<? } if($modforums) { ?>
	<tr><th>版主:</th><td><?=$modforums?></td></tr>
<? } ?>
<tr><td colspan="2"><hr class="line" size="0"></td></tr>
<? if($member['medals']) { ?>
	<tr><th>勋章:</th><td><? if(is_array($member['medals'])) { foreach($member['medals'] as $medal) { ?>		<img src="images/common/<?=$medal['image']?>" border="0" alt="<?=$medal['name']?>" /> &nbsp;
	<? } } ?></td></tr>
<? } ?>
<tr><th valign="top">用户组:</th><td><?=$member['grouptitle']?> <? showstars($member['groupstars']); if($member['maingroupexpiry']) { ?><br /><span class="smalltxt">有效期至 <?=$member['maingroupexpiry']?></span><? } ?></td></tr>
<? if($extgrouplist) { ?>
	<tr><th valign="top">扩展用户组:</th><td><? if(is_array($extgrouplist)) { foreach($extgrouplist as $extgroup) { ?>		<?=$extgroup['title']?><? if($extgroup['expiry']) { ?>&nbsp;(有效期至 <?=$extgroup['expiry']?>)<? } ?><br />
	<? } } ?></td></tr>
<? } ?>
<tr><th>发帖数级别:</th><td><?=$member['ranktitle']?> <? showstars($member['rankstars']); ?></td></tr>
<tr><th>阅读权限:</th><td><?=$member['readaccess']?></td></tr>
<tr><th>积分:</th><td><?=$member['credits']?></td></tr><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><tr><th><?=$credit['title']?>:</th><td><?=$member[extcredits.$id]?> <?=$credit['unit']?></td></tr><? } } ?><tr><th>帖子:</th><td><?=$member['posts']?> (占全部帖子的 <?=$percent?>%)</td></tr>
<tr><th>平均每日发帖:</th><td><?=$postperday?> 帖子</td></tr>
<tr><th>精华:</th><td><?=$member['digestposts']?> 帖子</td></tr>
<tr><td colspan="2"><hr class="line" size="0"></td></tr>
<tr><th>性别:</th><td><? if($member['gender'] == 1) { ?>男<? } elseif($member['gender'] == 2) { ?>女<? } else { ?>保密<? } ?></td></tr>
<? if($member['location']) { ?><tr><th>来自:</th><td><?=$member['location']?>&nbsp;</td></tr><? } ?>
<tr><th>生日:</th><td><?=$member['bday']?></td></tr>
<? if($member['site']) { ?><tr><th>个人网站: </th><td><a href="<?=$member['site']?>" target="_blank"><?=$member['site']?></a></td></tr><? } if($member['showemail']) { ?><tr><th>Email: </th><td><?=$member['email']?></td></tr><? } if($member['qq']) { ?><tr><th>QQ: </th><td><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$member['qq']?>&amp;Site=<?=$bbname?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?=$member['qq']?>:4"  border="0" alt="QQ" /><?=$member['qq']?></a></td></tr><? } if($member['icq']) { ?><tr><th>ICQ: </th><td><?=$member['icq']?></td></tr><? } if($member['yahoo']) { ?><tr><th>Yahoo: </th><td><?=$member['yahoo']?></td></tr><? } if($member['msn']) { ?><tr><th>MSN: </th><td><?=$member['msn']?></td></tr><? } if($member['taobao']) { ?><tr><th>阿里旺旺: </th><td><script type="text/javascript">document.write('<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&amp;uid='+encodeURIComponent('<?=$member['taobaoas']?>')+'&amp;s=2"><img src="http://amos1.taobao.com/online.ww?v=2&amp;uid='+encodeURIComponent('<?=$member['taobaoas']?>')+'&amp;s=1" alt="阿里旺旺" border="0" /></a>');</script></td></tr><? } if($member['alipay']) { ?><tr><th>支付宝账号: </th><td><a href="https://www.alipay.com/payto:<?=$member['alipay']?>?partner=20880020258585430156" target="_blank"><?=$member['alipay']?></a></td></tr><? } ?>
<tr><th>买家信用评价:</th><td><?=$member['sellercredit']?> <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank"><img src="images/rank/seller/<?=$member['sellerrank']?>.gif" border="0" class="absmiddle"></a></td></tr>
<tr><th>卖家信用评价:</th><td><?=$member['buyercredit']?> <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank"><img src="images/rank/buyer/<?=$member['buyerrank']?>.gif" border="0" class="absmiddle"></a></td></tr><? if(is_array($_DCACHE['fields'])) { foreach($_DCACHE['fields'] as $field) { ?>	<tr><th><?=$field['title']?>:</th><td>
	<? if($field['selective']) { ?>
		<?=$field['choices'][$member['field_'.$field['fieldid']]]?>
	<? } else { ?>
		<?=$member['field_'.$field['fieldid']]?>
	<? } ?>
	&nbsp;</td></tr><? } } ?></table>
</div>
</td>

<? if($spacesettings['side'] != 0 && $spacesettings['side'] != 1) { ?>
	<td id="main_layout2"><? userinfo($member) ?></td>
<? } ?>