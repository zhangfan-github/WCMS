<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<form method="post" action="pm.php?action=archive" target="_blank">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<div class="mainbox formbox">
		<h1>导出短消息</h1>
		<ul class="tabs">
			<li class="sendpm"><a href="pm.php?action=send">发送短消息</a></li>
			<li><a href="pm.php?folder=inbox">收件箱[<span id="pm_unread"><?=$pm_inbox_newpm?></span>]</a></li>
			<li><a href="pm.php?folder=outbox">草稿箱</a></li>
			<li><a href="pm.php?folder=track">已发送</a></li>
			<li><a href="pm.php?action=search">搜索短消息</a></li>
			<li class="current"><a href="pm.php?action=archive">导出短消息</a></li>
			<li><a href="pm.php?action=ignore">忽略列表</a></li>
		</ul>
		<table summary="导出短消息" cellspacing="0" cellpadding="0">
			<tr>
				<th>文件夹</th>
				<td>
					<label><input type="radio" name="folder" value="inbox" checked="checked" /> 收件箱</label>
					<label><input type="radio" name="folder" value="outbox" /> 草稿箱</label>
				</td>
			</tr>
			
			<tr>
				<th>时间范围</th>
				<td>
					<select name="days">
						<option value="1">1 天</option>
						<option value="2">2 天</option>
						<option value="7">1 周</option>
						<option value="30">1 个月</option>
						<option value="90">3 个月</option>
						<option value="180">6 个月</option>
						<option value="365">1 年</option>
						<option value="0">全部</option>
					</select>
					<label><input type="radio" name="newerolder" value="newer" checked="checked" /> 以内</label>
					<label><input type="radio" name="newerolder" value="older" /> 以前</label>
				</td>
			</tr>
			
			<tr>
				<th><label for="amount">导出短消息数量</label></th>
				<td>
					<select id="amount" name="amount">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
						<option value="0">全部</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<th>&nbsp;</th>
				<td><label><input class="checkbox" type="checkbox" name="delete" value="1" /> 导出后删除短消息</label></td>
			</tr>
			
			<tr>
				<th>&nbsp;</th>
				<td><button type="submit" class="submit" name="archivesubmit" value="true">导出短消息</button></td>
			</tr>
			
		</table>
	</div>
</form>