<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <a href="stats.php">论坛统计</a> &raquo; 基本概况</div>
	<div class="container">
		<div class="side">
<? include template('stats_navbar'); ?>
</div>
		<div class="content">
			<div class="mainbox">
				<h3>会员统计</h3>
				<table summary="会员统计" cellspacing="0" cellpadding="0">
					<tr>
						<th>注册会员</th><td><?=$members?></td>
						<th>发帖会员</th><td><?=$mempost?></td>
					</tr>
					
					<tr>
						<th>管理成员</th><td><?=$admins?></td>
						<th>未发帖会员</th><td><?=$memnonpost?></td>
					</tr>
					
					<tr>
						<th>新会员</th><td><?=$lastmember?></td>
						<th>发帖会员占总数</th><td><?=$mempostpercent?>%</td>
					</tr>
					
					<tr>
						<th>今日论坛之星</th><td><?=$bestmem?> <em title="发帖数">(<?=$bestmemposts?>)</em></td>
						<th>平均每人发帖数</th><td><?=$mempostavg?></td>
					</tr>
			
				</table>
			</div>
			<div class="mainbox">
				<h3>论坛统计</h3>
				<table summary="论坛统计" cellspacing="0" cellpadding="0">
					<tr>
						<th>版块数</th><td><?=$forums?></td>
						<th>平均每日新增帖子数</th><td><?=$postsaddavg?></td>
						<th>最热门的版块</th><td><a href="forumdisplay.php?fid=<?=$hotforum['fid']?>" target="_blank"><?=$hotforum['name']?></a></td>
					</tr>
					
					<tr>
						<th>主题数</th><td><?=$threads?></td>
						<th>平均每日注册会员数</th><td><?=$membersaddavg?></td>
						<th>主题数</th><td><?=$hotforum['threads']?></td>
					</tr>
					
					<tr>
						<th>帖子数</th><td><?=$posts?></td>
						<th>最近 24 小时新增帖子数</th><td><?=$postsaddtoday?></td>
						<th>帖子数</th><td><?=$hotforum['posts']?></td>
					</tr>
					
					<tr>
						<th>平均每个主题被回复次数</th><td><?=$threadreplyavg?></td>
						<th>最近 24 小时新增会员数</th><td><?=$membersaddtoday?></td>
						<th>论坛活跃指数</th><td><?=$activeindex?></td>
					</tr>
				</table>
			</div>
			<? if($statstatus) { ?>
				<div class="mainbox">
					<h3>流量概况</h3>
					<table summary="流量概况" cellspacing="0" cellpadding="0">
						<tr>
							<th>总页面流量</th><td><?=$stats_total['hits']?></td>
							<th>访问量最多的月份</th><td><?=$maxmonth_year?> 年 <?=$maxmonth_month?> 月</td>
						</tr>
					
						<tr>
							<th>共计来访</th><td><?=$stats_total['visitors']?> 人次</td>
							<th>月份总页面流量</th><td><?=$maxmonth?></td>
						</tr>
					
						<tr>
							<th>会员</th><td><?=$stats_total['members']?></td>
							<th>时段</th><td><?=$maxhourfrom?> - <?=$maxhourto?></td>
						</tr>
					
						<tr>
							<th>游客</th><td><?=$stats_total['guests']?></td>
							<th>时段总页面流量</th><td><?=$maxhour?></td>
						</tr>
					
						<tr>
							<th>平均每人浏览</th><td><?=$pageviewavg?></td>
							<th>&nbsp;</th><td>&nbsp;</td>
						</tr>
					
					</table>
				</div>
			<? } ?>
			<div class="mainbox">
				<h3>月份流量</h3>
				<table summary="月份流量" cellpadding="0" cellspacing="0">
				<? if($statstatus) { ?>
					<?=$statsbar_month?>
				<? } else { ?>
					<thead>
						<td colspan="2">每月新增帖子记录</td>
					</thead>
					<?=$statsbar_monthposts?>
					<thead>
						<td colspan="2">每日新增帖子记录</td>
					</thead>
					<?=$statsbar_dayposts?>
				<? } ?>
				</table>
			</div>
			<div class="notice">统计数据已被缓存，上次于 <?=$lastupdate?> 被更新，下次将于 <?=$nextupdate?> 进行更新</div>
		</div>
	</div>
<? include template('footer'); ?>
