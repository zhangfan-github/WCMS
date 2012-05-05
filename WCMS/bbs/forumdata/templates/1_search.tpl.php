<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 搜索</div>

<form method="post" action="search.php" <? if($qihoo['status']) { ?>onSubmit="if(this.srchtype[0].value=='qihoo' && this.srchtype[0].checked) this.target='_blank'; else this.target=''; return true;"<? } ?>>
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<div class="mainbox formbox">
	<span class="headactions"><a href="member.php?action=credits&amp;view=search" target="_blank">查看积分策略说明</a></span>
	<h1><? if($srchtype == 'threadtype') { ?>搜索更多分类信息<? } else { ?>搜索<? } ?></h1>
	<table summary="搜索" cellspacing="0" cellpadding="0">
		<? if($srchtype == 'threadtype') { ?>
			<tr>
				<th style="border-bottom: 0px"><label for="typeid">分类信息</label></th>
				<td style="border-bottom: 0px">
					<select name="typeid" onchange="ajaxget('post.php?action=threadtypes&typeid='+this.options[this.selectedIndex].value+'&operate=1&sid=<?=$sid?>', 'threadtypes', 'threadtypeswait')">
						<option value="0">无</option><?=$threadtypes?>
					</select>
					<span id="threadtypeswait"></span>
				</td>
			</tr>
			<tbody id="threadtypes"></tbody>
		<? } else { ?>
		<tr>
			<th><label for="srchtxt">关键字</label></th>
			<td><input type="text" id="srchtxt" name="srchtxt" size="45" maxlength="40" />
			<? if($tagstatus) { ?><p><?=$hottaglist?></p><? } ?>
			</td>
			<td>关键字中可使用通配符 "<strong>*</strong>"<br />匹配多个关键字全部，可用<strong>空格</strong>或 "<strong>AND</strong>" 连接。如 win32 <strong>AND</strong> unix<br />匹配多个关键字其中部分，可用 "<strong>|</strong>" 或 "<strong>OR</strong>" 连接。如 win32 <strong>OR</strong> unix</td>
		</tr>
		<tr>
			<th><label for="srchname">用户名</label></th>
			<td><input type="text" id="srchname" name="srchuname" size="45" maxlength="40" /></td>
			<td>用户名中可使用通配符 "<strong>*</strong>"，如 <strong>*user*</strong></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><button class="submit" type="submit" name="searchsubmit" value="true">搜索</button></td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table summary="搜索选项" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>搜索选项</th>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tr>
			<th>搜索方式</th>
			<td>
				<label><input type="radio" name="srchtype" onclick="orderbyselect(1)" value="title" <?=$checktype['title']?> <?=$disabled['title']?> /> 标题搜索</label>
				<label><input type="radio" name="srchtype" onclick="orderbyselect(1)" value="blog" <?=$disabled['blog']?> /> 搜索文集</label>
				<label><input type="radio" name="srchtype" onclick="orderbyselect(2)" value="trade" /> 搜索商品</label>
				<label><input type="radio" name="srchtype" onclick="window.location=('search.php?srchtype=threadtype')" value="trade" /> 搜索分类信息</label>
				<label><input type="radio" name="srchtype" onclick="orderbyselect(1)" value="fulltext" <?=$disabled['fulltext']?> /> 全文搜索</label>
				<? if($qihoo['status']) { ?><label><input type="radio" name="srchtype" onclick="orderbyselect(1)" value="qihoo" <?=$checktype['qihoo']?> /> 奇虎全文</label><? } ?>
			</td>
		</tr>
		<tr>
			<td>主题范围</td>
			<td>
				<label><input type="radio" name="srchfilter" value="all" checked="checked" /> 全部主题</label>
				<label><input type="radio" name="srchfilter" value="digest" /> 精华主题</label>
				<label><input type="radio" name="srchfilter" value="top" /> 置顶主题</label>
			</td>
		</tr>
		<tbody id="specialtr1">
		<tr>
			<td>特殊主题</td>
			<td>
				<label><input type="checkbox" name="special[]" value="1" /> 投票主题</label>
				<label><input type="checkbox" name="special[]" value="2" /> 商品主题</label>
				<label><input type="checkbox" name="special[]" value="3" /> 悬赏主题</label>
				<label><input type="checkbox" name="special[]" value="4" /> 活动主题</label>
				<label><input type="checkbox" name="special[]" value="5" /> 辩论主题</label>
				<label><input type="checkbox" name="special[]" value="6" /> 视频主题</label>
			</td>
		</tr>
		</tbody>
		<tbody id="specialtr2" style="display: none">
		<tr>
			<td>商品类别</td>
			<td>
				<select name="srchtypeid"><option value="">全部</option><? if(is_array($tradetypes)) { foreach($tradetypes as $typeid => $typename) { ?><option value="<?=$typeid?>"><?=$typename?></option><? } } ?></select>
			</td>
		</tr>
		</tbody>
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
			<td><label for="orderby">排序类型</label></td>
			<td>
				<select id="orderby1" name="orderby">
					<option value="lastpost" selected="selected">回复时间</option>
					<option value="dateline">发布时间</option>
					<option value="replies">回复数量</option>
					<option value="views">浏览次数</option>
				</select>
				<select id="orderby2" name="orderby" style="position: absolute; display: none" disabled>
					<option value="dateline" selected="selected">发布时间</option>
					<option value="price">商品现价</option>
					<option value="expiration">剩余时间</option>
				</select>
				<label><input type="radio" name="ascdesc" value="asc" /> 按升序排列</label>
				<label><input type="radio" name="ascdesc" value="desc" checked="checked" /> 按降序排列</label>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td valign="top"><label for="srchfid">搜索范围</label></td>
			<td>
				<select id="srchfid" name="srchfid[]" multiple="multiple" size="10" style="width: 26em;">
					<option value="all"<? if(!$srchfid) { ?> selected="selected"<? } ?>>搜索所有开放的版块</option>
					<option value="">&nbsp;</option>
					<?=$forumselect?>
				</select>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><button class="submit" type="submit" name="searchsubmit" value="true">搜索</button></td>
		</tr>
	</table>
</div>
</form>

<script type="text/javascript">
function orderbyselect(ordertype) {
	$('orderby1').style.display = 'none';
	$('orderby1').style.position = 'absolute';
	$('orderby1').disabled = true;
	$('specialtr1').style.display = 'none';
	$('orderby2').style.display = 'none';
	$('orderby2').style.position = 'absolute';
	$('orderby2').disabled = true;
	$('specialtr2').style.display = 'none';
	$('orderby' + ordertype).style.display = '';
	$('orderby' + ordertype).style.position = 'static';
	$('orderby' + ordertype).disabled = false;
	$('specialtr' + ordertype).style.display = '';
}
<? if($typeid) { ?>
	ajaxget('post.php?action=threadtypes&typeid=<?=$typeid?>&operate=1&inajax=1', 'threadtypes');
<? } ?>
</script>
<? include template('footer'); ?>
