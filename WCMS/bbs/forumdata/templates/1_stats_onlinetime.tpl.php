<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <a href="stats.php">论坛统计</a> &raquo; 在线时间</div>
	<div class="container">
		<div class="side">
<? include template('stats_navbar'); ?>
</div>
		<div class="content">
			<div class="mainbox">
				<h1>在线时间</h1>
				<table summary="在线时间" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<td colspan="2">总在线时间排行(小时)</td>
							<td colspan="2">本月在线时间排行(小时)</td>
						</tr>
					</thead>
					<?=$onlines?>
				</table>
			</div>
			<div class="notice">统计数据已被缓存，上次于 <?=$lastupdate?> 被更新，下次将于 <?=$nextupdate?> 进行更新</div>
		</div>
	</div>
<? include template('footer'); ?>
