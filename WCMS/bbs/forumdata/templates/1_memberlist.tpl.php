<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="foruminfo">
	<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <? if($type != 'birthdays') { ?>会员列表<? } else { ?>今日生日会员列表<? } ?></div>
</div>

<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } ?>
<div class="mainbox">
	<h3><? if($type != 'birthdays') { ?>会员列表<? } else { ?>今日生日会员列表<? } ?></h3>
	<table summary="<? if($type != 'birthdays') { ?>会员列表<? } else { ?>今日生日会员列表<? } ?>" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
			<td><a href="member.php?action=list&amp;order=username">用户名</a></td>
			<td>UID</td>
			<td><a href="member.php?action=list&amp;order=gender">性别</a></td>
			<td><a href="member.php?action=list&amp;order=regdate">注册日期</a></td>
			<td>上次访问</td>
			<td>帖子</td>
			<? if($type != 'birthdays') { ?>
				<td><a href="member.php?action=list&amp;order=credits">积分</a></td>
			<? } else { ?>
				<td><a href="member.php?action=list&amp;type=birthdays">今日生日</a></td>
			<? } ?>
			</tr>
		</thead>
		<tbody><? if(is_array($memberlist)) { foreach($memberlist as $member) { ?>			<tr>
				<td><a href="space.php?uid=<?=$member['uid']?>" class="bold"><?=$member['username']?></a></td>
				<td ><?=$member['uid']?></td>
				<td><? if($member['gender'] == '1') { ?>男<? } elseif($member['gender'] == 2) { ?>女<? } else { ?>&nbsp;<? } ?></td>
				<td><?=$member['regdate']?></td>
				<td><?=$member['lastvisit']?></td>
				<td><?=$member['posts']?></td>
				<? if($type != 'birthdays') { ?>
					<td><?=$member['credits']?></td>
				<? } else { ?>
					<td><?=$member['bday']?></td>
				<? } ?>
			</tr>
		<? } } ?></tbody>
	</table>
</div>
<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } if($type != 'birthdays') { ?>
<div id="footfilter" class="box">
	<form method="post" action="member.php?action=list">
		<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
		<input type="text" size="15" name="srchmem" />
		&nbsp;<button type="submit">搜索</button>
	</form>
	排序方式:
	<a href="member.php?action=list&amp;order=regdate">注册日期</a> -
	<a href="member.php?action=list&amp;order=username">用户名</a> -
	<a href="member.php?action=list&amp;order=credits">积分</a> -
	<a href="member.php?action=list&amp;order=gender">性别</a> -
	<a href="member.php?action=list&amp;type=admins">管理头衔</a>
</div>
<? } include template('footer'); ?>
