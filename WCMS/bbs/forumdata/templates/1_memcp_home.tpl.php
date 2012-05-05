<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div class="container">
	<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 控制面板</div>
	<div class="content">
		<table id="memberinfo" class="portalbox" cellpadding="0" cellspacing="1">
			<tr>
				<td class="memberinfo_avatar">
					<?=$avatar?>
					<p><a href="space.php?action=viewpro&amp;uid=<?=$discuz_uid?>"><?=$discuz_userss?></a></p>
				</td>
				<td class="memberinfo_forum">
					<ul>
						<li><label>UID:</label> <?=$member['uid']?></li>
						<li><label>用户组:</label> <?=$grouptitle?><? if($regverify == 1 && $groupid == 8) { ?>&nbsp; [ <a href="member.php?action=emailverify">重新验证 Email 有效性</a> ]<? } ?></li>
						<li><label>注册日期:</label><?=$member['regdate']?></li>
						<li><label>注册 IP:</label><?=$member['regip']?> <?=$member['regiplocation']?></li>
						<li><label>上次访问 IP:</label><?=$member['lastip']?> <?=$member['lastiplocation']?></li>
						<li><label>上次访问:</label><?=$member['lastvisit']?></li>
						<li><label>最后发表:</label><?=$member['lastpost']?></li>

					</ul>
				</td>
				<td class="memberinfo_forum" style="width: 12em;">
					<ul>
						<li>积分: <?=$credits?></li><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><li>
							<? if($id == $creditstrans) { ?>
							<?=$credit['title']?>: <span style="font-weight: bold;"><?=$GLOBALS['extcredits'.$id]?></span> <?=$credit['unit']?>
							<? } else { ?>
							<?=$credit['title']?>: <?=$GLOBALS['extcredits'.$id]?> <?=$credit['unit']?>
							<? } ?>
						</li><? } } ?><li>帖子: <?=$member['posts']?> </li>
						<li>精华: <?=$member['digestposts']?></li>
					</ul>
				</td>
			</tr>
		</table>
		<? if($validating) { ?>
		<div class="mainbox formbox">
			<h1>账户审核</h1>
			<form method="post" action="member.php?action=regverify">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
				<table summary="" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<td>管理员设置了新注册用户需要人工验证，您的帐号已提交过 <strong><?=$validating['submittimes']?></strong> 次验证请求，目前尚未通过验证。</td>
						</tr>
					</thead>
					<tr>
						<th>当前状态</th>
						<td><strong><? if($validating['status'] == 0) { ?>等待管理人员进行审核<? } elseif($validating['status'] == 1) { ?>审核被拒绝，您可以修改注册原因后再次提交<? } ?></strong></td>
					</tr>
					<? if($validating['admin']) { ?>
					<tr>
						<th>审核管理员</th>
						<td><a href="space.php?username=<?=$validating['adminenc']?>"><?=$validating['admin']?></a></td>
					</tr>
					<? } ?>
					<? if($validating['moddate']) { ?>
					<tr>
						<th>审核时间</th>
						<td><?=$validating['moddate']?></td>
					</tr>
					<? } ?>
					<? if($validating['remark']) { ?>
					<tr>
						<th>管理员给您的留言</th>
						<td><?=$validating['remark']?></td>
					</tr>
					<? } ?>
					<tr>
						<th valign="top"><label for="regmessagenew">注册原因</label></th>
						<td><textarea rows="5" cols="50" id="regmessagenew" name="regmessagenew"><?=$validating['message']?></textarea></td>
					</tr>
					<? if($validating['status'] == 1) { ?>
					<tr class="btns">
						<th>&nbsp;</th>
						<td><button type="submit" class="submit" name="verifysubmit" id="verifysubmit" value="true">提交</button></td>
					</tr>
					<? } ?>
				</table>
			</form>
		</div>
		<? } ?>

		<div class="mainbox">
			<h3>最近的五条短消息</h3>
			<table summary="最近的五条短消息" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
					<th>标题</th>
					<td class="user">来自</td>
					<td class="time">时间</td>
					</tr>
				</thead>
				<tbody>
				<? if($msgexists) { if(is_array($msglist)) { foreach($msglist as $message) { ?>					<tr>
					<th><a href="pm.php?action=view&amp;pmid=<?=$message['pmid']?>" target="_blank"><?=$message['subject']?></a></th>
					<td class="user"><a href="space.php?uid=<?=$message['msgfromid']?>"><?=$message['msgfrom']?></a></td>
					<td class="time"><?=$message['dateline']?></td>
					</tr>
					<? } } } else { ?>
					<tr><th colspan="3">目前收件箱中没有消息。</th></tr>
				<? } ?>
				</tbody>
			</table>
		</div>
		<div class="mainbox">
			<h3>最近的五条转账与兑换记录</h3>
			<table summary="最近的五条转账与兑换记录" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td class="user">来自/到</td>
						<td class="time">时间</td>
						<td class="nums">支出</td>
						<td class="nums">收入</td>
						<td>操作</td>
					</tr>
				</thead>
				<tbody>
				<? if($loglist) { if(is_array($loglist)) { foreach($loglist as $log) { ?>					<tr>
						<td class="user"><? if($log['fromto'] == 'BANK ACCOUNT') { ?>银行现金转入<? } else { ?><a href="space.php?username=<?=$log['fromtoenc']?>"><?=$log['fromto']?></a><? } ?></td>
						<td class="time"><?=$log['dateline']?></td>
						<td class="nums"><? if($log['send']) { ?><?=$extcredits[$log['sendcredits']]['title']?> <?=$log['send']?> <?=$extcredits[$log['sendcredits']]['unit']?><? } ?></td>
						<td class="nums"><? if($log['receive']) { ?><?=$extcredits[$log['receivecredits']]['title']?> <?=$log['receive']?> <?=$extcredits[$log['receivecredits']]['unit']?><? } ?></td>
						<td>
						<? if($log['operation'] == 'TFR') { ?>
							积分转出
						<? } elseif($log['operation'] == 'RCV') { ?>
							积分转入
						<? } elseif($log['operation'] == 'EXC') { ?>
							积分兑换
						<? } elseif($log['operation'] == 'UGP') { ?>
							公众用户组收费
						<? } elseif($log['operation'] == 'AFD') { ?>
							银行现金转入
						<? } ?>
						</td>
					</tr>
					<? } } } else { ?>
					<tr><td colspan="5">目前没有积分交易记录。</td></tr>
				<? } ?>
				</tbody>
			</table>
		</div>

	</div>
	<div class="side">
<? include template('personal_navbar'); ?>
</div>
</div>
<? include template('footer'); ?>
