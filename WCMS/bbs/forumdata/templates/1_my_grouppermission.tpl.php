<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav">
<a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 用户组权限查询
</div>
<div class="container">
<div class="content">
<div class="mainbox">
<h1>用户组权限查询</h1>
<ul class="tabs headertabs">
<li <? if(empty($type)) { ?> class="current"<? } ?>><a href="my.php?item=grouppermission">我的权限</a></li>
<li class="dropmenu<? if($type == 'member') { ?> current"<? } ?>"><a href="###" id="membergroup" onmouseover="showMenu(this.id)">会员用户组</a></li>
<li class="dropmenu<? if($type == 'system') { ?> current"<? } ?>"><a href="###" id="systemgroup" onmouseover="showMenu(this.id)">系统用户组</a></li>
<? if(!empty($grouplist['special'])) { ?>
	<li class="dropmenu<? if($type == 'special') { ?> current"<? } ?>"><a href="###" id="specialgroup" onmouseover="showMenu(this.id)">特殊用户组</a></li>
<? } ?>
</ul>

<ul class="popupmenu_popup headermenu_popup" id="membergroup_menu" style="display: none">
<?=$grouplist['member']?>
</ul>
<ul class="popupmenu_popup headermenu_popup" id="systemgroup_menu" style="display: none">
<?=$grouplist['system']?>
</ul>
<? if(!empty($grouplist['special'])) { ?>
	<ul class="popupmenu_popup headermenu_popup" id="specialgroup_menu" style="display: none">
	<?=$grouplist['special']?>
	</ul>
<? } ?>
<table cellspacing="0" cellpadding="0" width="100%">
<thead><tr><td colspan="2">用户组</td></tr></thead>
<tr>
<th>用户组头衔:</th>
<td><?=$group['grouptitle']?></td>
</tr>

<tr>
<th>用户级别:</th>
<td><? if($group['stars']) { showstars($group['stars']); } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>
<thead>
<tr><td colspan="2">管理权限</td></tr>
</thead>
<tr>
<th width="50%">管理权限:</th>
<td width="50%"><? if($group['radminid']==1 || $group['radminid']==2) { ?>全论坛管理<? } elseif($group['radminid']==3 ) { ?>部分版块管理<? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<? if($group['radminid']) { ?>
	<tr>
	<th>允许编辑帖子:</th>
	<td><? if($group['alloweditpost'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许编辑投票:</th>
	<td><? if($group['alloweditpoll'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许置顶帖子:</th>
	<td><? if($group['allowstickthread']==1 ) { ?>允许置顶 I<? } elseif($group['allowstickthread']==2 ) { ?>允许置顶 I/II<? } elseif($group['allowstickthread']==3 ) { ?>允许置顶 I/II/III<? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许审核帖子:</th>
	<td><? if($group['allowmodpost'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许删除帖子:</th>
	<td><? if($group['allowdelpost'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许批量删帖:</th>
	<td><? if($group['allowmassprune'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许过滤词语:</th>
	<td><? if($group['allowcensorword'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许查看 IP:</th>
	<td><? if($group['allowviewip'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许禁止 IP:</th>
	<td><? if($group['allowbanip'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许编辑用户:</th>
	<td><? if($group['allowedituser'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许禁止用户:</th>
	<td><? if($group['allowbanuser'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许审核用户:</th>
	<td><? if($group['allowmoduser'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许发布公告:</th>
	<td><? if($group['allowpostannounce'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许查看记录:</th>
	<td><? if($group['allowviewlog'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>发帖不受限制:</th>
	<td><? if($group['disablepostctrl'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

	<tr>
	<th>允许收录主题:</th>
	<td><? if($group['supe_allowpushthread'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
	</tr>

<? } ?>
<thead>
<tr><td colspan="2">基本权限</td></tr>
</thead>
<tr>
<th>允许访问论坛:</th>
<td><? if($group['allowvisit'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>阅读权限:</th>
<td><?=$group['readaccess']?></td>
</tr>

<tr>
<th>允许查看用户资料:</th>
<td><? if($group['allowviewpro'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许隐身:</th>
<td><? if($group['allowinvisible'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许使用搜索:</th>
<td><? if($group['allowsearch']=='0') { ?>禁用搜索<? } elseif($group['allowsearch']=='1') { ?>只允许搜索标题<? } else { ?>允许搜索帖子内容<? } ?></td>
</tr>

<tr>
<th>允许使用头像:</th>
<td><? if($group['allowavatar'] =="0") { ?>禁用头像<? } elseif($group['allowavatar'] =="1") { ?>允许使用论坛头像<? } else { ?>允许自定义头像<? } ?></td>
</tr>

<tr>
<th>允许使用文集:</th>
<td><? if($group['allowuseblog'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许使用昵称:</th>
<td><? if($group['allownickname'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许自定义头衔:</th>
<td><? if($group['allowcstatus'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>短消息收件箱容量:</th>
<td><?=$group['maxpmnum']?></td>
</tr>
<thead>
<tr><td colspan="2">帖子相关</td></tr>
</thead>
<tr>
<th>允许发新话题:</th>
<td><? if($group['allowpost'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发表回复:</th>
<td><? if($group['allowreply'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发起投票:</th>
<td><? if($group['allowpostpoll'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许参与投票:</th>
<td><? if($group['allowvote'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发表悬赏:</th>
<td><? if($group['allowpostreward'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发表活动:</th>
<td><? if($group['allowpostactivity'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发表辩论:</th>
<td><? if($group['allowpostdebate'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发表交易:</th>
<td><? if($group['allowposttrade'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发表视频:</th>
<td><? if($group['allowpostvideo'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>最大签名长度:</th>
<td><?=$group['maxsigsize']?> 字节</td>
</tr>

<tr>
<th>允许签名中使用 Discuz! 代码:</th>
<td><? if($group['allowsigbbcode'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许签名中使用 [img] 代码:</th>
<td><? if($group['allowsigimgcode'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>自我介绍最大长度:</th>
<td><?=$group['maxbiosize']?> 字节</td>
</tr>

<tr>
<th>允许自我介绍中使用 Discuz! 代码:</th>
<td><? if($group['allowbiobbcode'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许自我介绍中使用 [img] 代码:</th>
<td><? if($group['allowbioimgcode'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>
<thead>
<tr><td colspan="2">附件相关</td></tr>
</thead>
<tr>
<th>允许下载/查看附件:</th>
<td><? if($group['allowgetattach'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许发布附件:</th>
<td><? if($group['allowpostattach'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>允许设置附件权限:</th>
<td><? if($group['allowsetattachperm'] == 1) { ?><img src="<?=IMGDIR?>/check_right.gif" /><? } else { ?><img src="<?=IMGDIR?>/check_error.gif" /><? } ?></td>
</tr>

<tr>
<th>最大附件尺寸:</th>
<td><? if($group['maxattachsize']) { ?><?=$group['maxattachsize']?> KB<? } else { ?>没有限制<? } ?></td>
</tr>

<tr>
<th>每天最大附件总尺寸:</th>
<td><? if($group['maxsizeperday']) { ?><?=$group['maxsizeperday']?> KB<? } else { ?>没有限制<? } ?></td>
</tr>

<tr>
<th>允许附件类型:</th>
<td>
<? if($group['allowpostattach'] == 1) { ?>
	<? if($group['attachextensions']) { ?>
		<?=$group['attachextensions']?>
	<? } else { ?>
		没有限制
	<? } } else { ?>
	<img src="<?=IMGDIR?>/check_error.gif" />
<? } ?>
</td></tr>
</tr>

</table>
</div>
</div>
<div class="side">
<? include template('personal_navbar'); ?>
</div>
</div>
<? include template('footer'); ?>
