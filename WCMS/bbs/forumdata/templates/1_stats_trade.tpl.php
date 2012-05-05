<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav">
<a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <a href="stats.php">论坛统计</a> &raquo; 交易排行
</div>


<div class="container">
	<div class="side">
<? include template('stats_navbar'); ?>
</div>
	<div class="content">
	<div class="mainbox">
		<h3>交易排行</h3>
<div class="msgtabs"><strong>交易额排行</strong></div>
<table cellspacing="0" cellpadding="0" width="100%" align="center">
<thead>
<tr>
<td>商品名称</td>
<td>卖家</td>
<td>总金额(元)</td>
</tr>
</thead>
<tbody><? if(is_array($tradesums)) { foreach($tradesums as $tradesum) { ?>	<tr>
	<td><a target="_blank" href="viewthread.php?do=tradeinfo&amp;tid=<?=$tradesum['tid']?>&amp;pid=<?=$tradesum['pid']?>"><?=$tradesum['subject']?></a></td>
	<td><a target="_blank" href="space.php?uid=<?=$tradesum['sellerid']?>"><?=$tradesum['seller']?></a></td>
	<td><?=$tradesum['tradesum']?></td>
	</tr><? } } ?></tbody>

</table>
<table cellspacing="0" cellpadding="0" width="100%" align="center">
<div class="msgtabs"><strong>交易数排行</strong></div>

<thead>
<tr>
<td>商品名称</td>
<td>卖家</td>
<td>售出数量</td>
</tr>
</thead>
<tbody><? if(is_array($totalitems)) { foreach($totalitems as $totalitem) { ?>	<tr>
	<td><a target="_blank" href="viewthread.php?do=tradeinfo&amp;tid=<?=$tradesum['tid']?>&amp;pid=<?=$tradesum['pid']?>"><?=$totalitem['subject']?></a></td>
	<td><a target="_blank" href="space.php?uid=<?=$totalitem['sellerid']?>"><?=$totalitem['seller']?></a></td>
	<td><?=$totalitem['totalitems']?></td>
	</tr><? } } ?></tbody>
</table></div>


<div class="notice">统计数据已被缓存，上次于 <?=$lastupdate?> 被更新，下次将于 <?=$nextupdate?> 进行更新</div>
</div>
</div>
<? include template('footer'); ?>
