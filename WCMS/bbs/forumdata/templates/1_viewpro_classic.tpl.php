<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<script src="include/javascript/viewthread.js" type="text/javascript"></script>

<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 资料</div>
<div class="mainbox viewthread specialthread">
	<h6>个人资料</h6>
	<table summary="Profile" cellspacing="0" cellpadding="0">
		<tr>
			<td class="postcontent">
				<h1><?=$member['username']?> 的个人资料</h1>
				<table summary="Profile" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<td colspan="2" align="center">
								<? if($supe['status'] && $xspacestatus) { ?>[ <a href="<?=$supe['siteurl']?>/?uid/<?=$member['uid']?>" target="_blank">个人空间</a> ]&nbsp;<? } ?>
								[ <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank">信用评价</a> ]&nbsp;
								<? if($discuz_uid && $magicstatus) { ?>
									[ <a href="magic.php?action=user&amp;username=<?=$member['usernameenc']?>" target="_blank">使用道具</a> ]&nbsp;
								<? } ?>
								[ <a href="search.php?srchuid=<?=$member['uid']?>&amp;srchfid=all&amp;srchfrom=0&amp;searchsubmit=yes">搜索帖子</a> ]&nbsp;
								<? if($allowedituser || $allowbanuser) { ?>
									<? if($adminid == 1) { ?>
										[ <a href="admincp.php?action=members&amp;username=<?=$member['usernameenc']?>&amp;searchsubmit=yes&amp;frames=yes" target="_blank">编辑用户</a> ]&nbsp;
									<? } else { ?>
										[ <a href="admincp.php?action=editmember&amp;uid=<?=$member['uid']?>&amp;membersubmit=yes&amp;frames=yes" target="_blank">编辑用户</a> ]&nbsp;
									<? } ?>
									[ <a href="admincp.php?action=banmember&amp;uid=<?=$member['uid']?>&amp;membersubmit=yes&amp;frames=yes" target="_blank">禁止用户</a> ]&nbsp;
								<? } ?>
								<? if($member['adminid'] > 0 && $modworkstatus) { ?>
									[ <a href="stats.php?type=modworks&amp;uid=<?=$member['uid']?>">工作统计</a> ]&nbsp;
								<? } ?>
							</td>
						</tr>
					</thead>
					<tr><th>UID:</th><td><?=$member['uid']?></td></tr>
					<tr><th>注册日期:</th><td><?=$member['regdate']?></td></tr>
					<? if($allowviewip) { ?>
						<tr><th>注册 IP:</th><td><?=$member['regip']?> - <?=$member['regiplocation']?></td></tr>
						<tr><th>上次访问 IP:</th><td><?=$member['lastip']?> - <?=$member['lastiplocation']?></td></tr>
					<? } ?>
					<tr><th>上次访问:</th><td><? if($member['invisible'] && $adminid != 1) { ?>隐身模式<? } else { ?><?=$member['lastvisit']?><? } ?></td></tr>
					<tr><th>最后发表:</th><td><?=$member['lastpost']?></td></tr>
					<? if($pvfrequence) { ?>
						<tr><th>页面访问量:</th><td><?=$member['pageviews']?></td></tr>
					<? } ?>
					<? if($oltimespan) { ?>
						<tr><th valign="top">在线时间:</th><td>总计在线 <em><?=$member['totalol']?></em> 小时, 本月在线 <em><?=$member['thismonthol']?></em> 小时 <? showstars(ceil(($member['totalol'] + 1) / 50)); ?><br />升级剩余时间 <span class="bold"><?=$member['olupgrade']?></span> 小时</td></tr>
					<? } ?>
					<? if($modforums) { ?>
						<tr><th>版主:</th><td><?=$modforums?></td></tr>
					<? } ?>
					<thead><tr><td colspan="2" style="line-height: 3px; font-size: 3px;">&nbsp;</td></tr></thead>
					<? if($member['medals']) { ?>
						<tr><th>勋章:</th><td><? if(is_array($member['medals'])) { foreach($member['medals'] as $medal) { ?>							<img src="images/common/<?=$medal['image']?>" border="0" alt="<?=$medal['name']?>" /> &nbsp;
						<? } } ?></td></tr>
					<? } ?>
					<tr><th>昵称:</th><td><? if($member['allownickname'] && $member['nickname']) { ?><?=$member['nickname']?><? } else { ?>无<? } ?></td></tr>
					<tr><th valign="top">用户组:</th><td><?=$member['grouptitle']?> <? showstars($member['groupstars']); if($member['maingroupexpiry']) { ?><br /><em>有效期至 <?=$member['maingroupexpiry']?></em><? } ?></td></tr>
					<? if($extgrouplist) { ?>
						<th>扩展用户组:</th><td><? if(is_array($extgrouplist)) { foreach($extgrouplist as $extgroup) { ?>							<?=$extgroup['title']?><? if($extgroup['expiry']) { ?>&nbsp;(有效期至 <?=$extgroup['expiry']?>)<? } ?><br />
						<? } } ?></td></tr>
					<? } ?>
					<th>发帖数级别:</th><td><?=$member['ranktitle']?> <? showstars($member['rankstars']); ?></td></tr>
					<th>阅读权限:</th><td><?=$member['readaccess']?></td></tr>
					<th>积分:</th><td><?=$member['credits']?></td></tr><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><tr><th><?=$credit['title']?>:</th><td><?=$member[extcredits.$id]?> <?=$credit['unit']?></td></tr><? } } ?><tr><th>帖子:</th><td><?=$member['posts']?> (占全部帖子的 <?=$percent?>%)</td></tr>
					<tr><th>平均每日发帖:</th><td><?=$postperday?> 帖子</td></tr>
					<tr><th>精华:</th><td><?=$member['digestposts']?> 帖子</td></tr>
					<thead><tr><td colspan="2" style="line-height: 3px; font-size: 3px;">&nbsp;</td></tr></thead>
					<tr><th>性别:</th><td><? if($member['gender'] == 1) { ?>男<? } elseif($member['gender'] == 2) { ?>女<? } else { ?>保密<? } ?></td></tr>
					<tr><th>来自:</th><td><?=$member['location']?>&nbsp;</td></tr>
					<tr><th>生日:</th><td><?=$member['bday']?></td></tr><? if(is_array($_DCACHE['fields'])) { foreach($_DCACHE['fields'] as $field) { ?>						<tr><th><?=$field['title']?>:</th><td>
						<? if($field['selective']) { ?>
							<?=$field['choices'][$member['field_'.$field['fieldid']]]?>
						<? } else { ?>
							<?=$member['field_'.$field['fieldid']]?>
						<? } ?>
						&nbsp;</td></tr>
					<? } } ?></table>
		</td>
		<td class="postauthor">
			<div class="avatar">
				<? if($member['avatar']) { ?>
					<img src="<?=$member['avatar']?>" width="<?=$member['avatarwidth']?>" height="<?=$member['avatarheight']?>" alt="<?=$member['username']?>" />
				<? } else { ?>
					<img src="images/avatars/noavatar.gif" alt="<?=$member['username']?>" />
				<? } ?>
			</div>
			<ul>
				<li class="pm"><a href="pm.php?action=send&amp;uid=<?=$member['uid']?>" target="_blank">发短消息</a></li>
				<li class="buddy"><a href="my.php?item=buddylist&amp;newbuddyid=<?=$member['uid']?>&amp;buddysubmit=yes" id="ajax_buddy" onclick="ajaxmenu(event, this.id)">加为好友</a></li>
			</ul>
			<? if($member['bio']) { ?><div class="bio"><?=$member['bio']?></div><? } ?>
			<dl class="profile">
				<? if($member['site']) { ?><dt>个人网站:</dt><dd><a href="<?=$member['site']?>" target="_blank"><?=$member['site']?></a></dd><? } ?>
				<? if($member['showemail']) { ?><dt>Email:</dt><dd><?=$member['email']?></dd><? } ?>
				<? if($member['qq']) { ?><dt>QQ:</dt><dd><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$member['qq']?>&amp;Site=<?=$bbname?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?=$member['qq']?>:4"  border="0" alt="QQ" /><?=$member['qq']?></a></dd><? } ?>
				<? if($member['icq']) { ?><dt>ICQ:</dt><dd><?=$member['icq']?></dd><? } ?>
				<? if($member['yahoo']) { ?><dt>Yahoo:</dt><dd><?=$member['yahoo']?></dd><? } ?>
				<? if($member['msn']) { ?><dt>MSN:</dt><dd><?=$member['msn']?></dd><? } ?>
				<? if($member['taobao']) { ?><dt>阿里旺旺:</dt><dd><script type="text/javascript">document.write('<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&amp;uid='+encodeURIComponent('<?=$member['taobaoas']?>')+'&amp;s=2"><img src="http://amos1.taobao.com/online.ww?v=2&amp;uid='+encodeURIComponent('<?=$member['taobaoas']?>')+'&amp;s=1" alt="阿里旺旺" border="0" /></a>&nbsp;');</script></dd><? } ?>
				<? if($member['alipay']) { ?><dt>支付宝账号:</dt><dd><a href="https://www.alipay.com/payto:<?=$member['alipay']?>?partner=20880020258585430156" target="_blank"><?=$member['alipay']?></a></dd><? } ?>
				<dt>买家信用评价:</dt><dd><?=$member['sellercredit']?> <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank"><img src="images/rank/seller/<?=$member['sellerrank']?>.gif" border="0" class="absmiddle"></a></dd>
				<dt>卖家信用评价:</dt><dd><?=$member['buyercredit']?> <a href="eccredit.php?uid=<?=$member['uid']?>" target="_blank"><img src="images/rank/buyer/<?=$member['buyerrank']?>.gif" border="0" class="absmiddle"></a></dd>
			</dl>
		</td>
		</tr>
	</table>
</div>
<? include template('footer'); ?>
