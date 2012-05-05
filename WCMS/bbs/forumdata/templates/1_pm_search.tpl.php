<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<form method="post" onSubmit="if(this.srchtype[0].value=='qihoo' && this.srchtype[0].checked) this.target='_blank'; else this.target=''; return true;">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<div class="mainbox formbox">
		<h1>搜索短消息</h1>
		<ul class="tabs headertabs">
			<li class="sendpm"><a href="pm.php?action=send">发送短消息</a></li>
			<li><a href="pm.php?folder=inbox">收件箱[<span id="pm_unread"><?=$pm_inbox_newpm?></span>]</a></li>
			<li><a href="pm.php?folder=outbox">草稿箱</a></li>
			<li><a href="pm.php?folder=track">已发送</a></li>
			<li class="current"><a href="pm.php?action=search">搜索短消息</a></li>
			<li><a href="pm.php?action=archive">导出短消息</a></li>
			<li><a href="pm.php?action=ignore">忽略列表</a></li>
		</ul>
		<table summary="搜索短消息" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>搜索</th>
					<td>&nbsp;</td>
				</tr>
			</thead>
			<tr>
				<th><label for="srchtxt">关键字</label></th>
				<td colspan="2">
					<input type="text" id="srchtxt" name="srchtxt" size="25" maxlength="40" />
					<div class="tips">关键字中可使用通配符 "<strong>*</strong>"<br />匹配多个关键字全部，可用<strong>空格</strong>或 "<strong>AND</strong>" 连接。如 win32 <strong>AND</strong> unix<br />匹配多个关键字其中部分，可用 "<strong>|</strong>" 或 "<strong>OR</strong>" 连接。如 win32 <strong>OR</strong> unix</div>
				</td>
			</tr>
			
			<tr>
				<th><label for="srchname">发信人或收信人</label></th>
				<td colspan="2">
					<input type="text" id="srchname" name="srchuname" size="25" maxlength="40" />
					<div class="tips">发信人或收信人用户名中可使用通配符 "*"，如 *user*</div>
				</td>
			</tr>
			
			<tr>
				<th>&nbsp;</th>
				<td><button type="submit" class="submit" name="searchsubmit" value="true">搜索</button></td>
			</tr>
			
			<thead>
				<tr>
					<th>搜索选项</th>
					<td>&nbsp;</td>
				</tr>
			</thead>
			
			<tr>
				<th><label for="srchfolder">搜索范围</label></th>
				<td>
					<select id="srchfolder" name="srchfolder">
						<option value="inbox">收件箱</option>
						<option value="outbox">草稿箱</option>
						<option value="track">已发送</option>
					</select>
					<label><input type="radio" name="srchtype" value="title" checked="checked" /> 标题搜索</label>
					<label><input type="radio" name="srchtype" value="fulltext" <?=$ftdisabled?> /> 全文搜索</label>
				</td>
			</tr>
			
			<tr>
				<th>&nbsp;</th>
				<td>
					<label><input type="checkbox" name="srchread" value="1" checked="checked" /> 已读短消息</label>
					<label><input type="checkbox" name="srchunread" value="1" checked="checked" /> 未读短消息</label>
				</td>
			</tr>
			
			<tr>
				<th><label for="srchfrom">搜索时间</label></th>
				<td>
					<select id="srchfrom" name="srchfrom">
						<option value="0">全部时间</option>
						<option value="86400">1 天</option>
						<option value="172800">2 天</option>
						<option value="432000">1 周</option>
						<option value="1296000">1 个月</option>
						<option value="5184000">3 个月</option>
						<option value="8640000">6 个月</option>
						<option value="31536000">1 年</option>
					</select>
					<label><input type="radio" name="before" value="" checked="checked" /> 以内</label>
					<label><input type="radio" name="before" value="1" /> 以前</label>
				</td>
			</tr>
			
			
			<tr>
				<th><label for="orderby">排序类型</label></th>
				<td>
					<select id="orderby" name="orderby">
						<option value="dateline"> 按收发时间</option>
						<option value="msgfrom"> 按收发信人名</option>
					</select>
					<label><input type="radio" name="ascdesc" value="asc" /> 按升序排列</label>
					<label><input type="radio" name="ascdesc" value="desc" checked /> 按降序排列</label>
				</td>
			</tr>
			
			<tr>
				<th>&nbsp;</th>
				<td><button type="submit" class="submit" name="searchsubmit" value="true">搜索</button></td>
			</tr>
		</table>
	</div>
</form>