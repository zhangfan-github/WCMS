<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <a href="stats.php">论坛统计</a> &raquo; 管理团队</div>
	<div class="container">
		<div class="side">
<? include template('stats_navbar'); ?>
</div>
		<div class="content">
			<? if($team['admins']) { ?>
				<div class="mainbox">
					<h1>管理团队 - 管理员和超级版主</h1>
					<table summary="管理员和超级版主" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<td>用户名</td>
								<td>管理头衔</td>
								<td>上次访问</td>
								<td>离开天数</td>
								<td>积分</td>
								<td>帖子</td>
								<td>最近 30 天发帖</td>
								<? if($modworkstatus) { ?><td>本月管理</td><? } ?>
								<? if($oltimespan) { ?>
									<td>总计在线</td>
									<td>本月在线</td>
								<? } ?>
							</tr>
						</thead><? if(is_array($team['admins'])) { foreach($team['admins'] as $uid) { ?>							<tr>
								<td><a href="space.php?uid=<?=$uid?>"><?=$team['members'][$uid]['username']?></a></td>
								<td><? if($team['members'][$uid]['adminid'] == 1) { ?>论坛管理员<? } elseif($team['members'][$uid]['adminid'] == 2) { ?>超级版主<? } elseif($team['members'][$uid]['adminid'] == 3) { ?>版主<? } ?></td>
								<td><?=$team['members'][$uid]['lastactivity']?></td>
								<td><?=$team['members'][$uid]['offdays']?></td>
								<td><?=$team['members'][$uid]['credits']?></td>
								<td><?=$team['members'][$uid]['posts']?></td>
								<td><?=$team['members'][$uid]['thismonthposts']?></td>
								<? if($modworkstatus) { ?>
									<td><a href="stats.php?type=modworks&amp;uid=<?=$uid?>"><?=$team['members'][$uid]['modactions']?></a></td>
								<? } ?>
								<? if($oltimespan) { ?>
									<td><?=$team['members'][$uid]['totalol']?> 小时</td>
									<td><?=$team['members'][$uid]['thismonthol']?> 小时</td>
								<? } ?>
							</tr>
						<? } } ?></table>
				</div>
			<? } if(is_array($team['categories'])) { foreach($team['categories'] as $category) { ?>				<div class="mainbox">
					<h3><a href="<?=$indexname?>?gid=<?=$category['fid']?>"><?=$category['name']?></a></h3>
					<table summary="<?=$category['fid']?>" cellspacing="0" cellpadding="0">
						<thead>
						<? if($oltimespan) { ?>
							<tr>
								<td>版块</td>
								<td>用户名</td>
								<td>管理头衔</td>
								<td>上次访问</td>
								<td>离开天数</td>
								<td>积分</td>
								<td>帖子</td>
								<td>最近 30 天发帖</td>
								<td>本月管理</td>
								<td>总计在线</td>
								<td>本月在线</td>
							</tr>
						<? } else { ?>
							<tr>
								<td>版块</td>
								<td>用户名</td>
								<td>管理头衔</td>
								<td>上次访问</td>
								<td>离开天数</td>
								<td>积分</td>
								<td>帖子</td>
								<td>最近 30 天发帖</td>
								<td>本月管理</td>
							</tr>
						<? } ?>
						</thead><? if(is_array($team['forums'][$category['fid']])) { foreach($team['forums'][$category['fid']] as $fid => $forum) { if(is_array($team['moderators'][$fid])) { foreach($team['moderators'][$fid] as $key => $uid) { ?><tr>
								<? if($key == 0) { ?><td class="altbg1" rowspan="<?=$forum['moderators']?>"><? if($forum['type'] == 'group') { ?><a href="<?=$indexname?>?gid=<?=$fid?>"><? } else { ?><a href="forumdisplay.php?fid=<?=$fid?>"><? } ?><?=$forum['name']?></a></td><? } ?>
								<td><a href="space.php?uid=<?=$uid?>"><? if($forum['inheritedmod']) { ?><b><?=$team['members'][$uid]['username']?></b><? } else { ?><?=$team['members'][$uid]['username']?><? } ?></a></td>
								<td><? if($team['members'][$uid]['adminid'] == 1) { ?>论坛管理员<? } elseif($team['members'][$uid]['adminid'] == 2) { ?>超级版主<? } elseif($team['members'][$uid]['adminid'] == 3) { ?>版主<? } ?></td>
								<td><?=$team['members'][$uid]['lastactivity']?></td>
								<td><?=$team['members'][$uid]['offdays']?></td>
								<td><?=$team['members'][$uid]['credits']?></td>
								<td><?=$team['members'][$uid]['posts']?></td>
								<td><?=$team['members'][$uid]['thismonthposts']?></td>
								<td><? if($modworkstatus) { ?><a href="stats.php?type=modworks&amp;uid=<?=$uid?>"><?=$team['members'][$uid]['modactions']?></a><? } else { ?>N/A<? } ?></td>
								<? if($oltimespan) { ?>
									<td><?=$team['members'][$uid]['totalol']?> 小时</td>
									<td><?=$team['members'][$uid]['thismonthol']?> 小时</td>
								<? } ?>
								</tr>
							<? } } } } ?></table>
				</div><? } } ?><div class="notice">统计数据已被缓存，上次于 <?=$lastupdate?> 被更新，下次将于 <?=$nextupdate?> 进行更新</div>
		</div>
	</div>
<? include template('footer'); ?>
