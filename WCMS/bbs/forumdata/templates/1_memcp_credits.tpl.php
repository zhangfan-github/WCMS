<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div class="container">
	<div id="foruminfo">
		<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo;
		<? if($action == 'credits') { ?>
			积分交易
		<? } elseif($action == 'creditslog') { ?>
			积分记录
		<? } ?>
		</div>
	</div>
	<div class="content">
		<div class="mainbox formbox">

<? if($action == 'credits') { ?>
	<h1>积分交易</h1>
	<ul class="tabs">
	<? if($exchangestatus) { ?>
		<li <? if($operation == 'exchange') { ?> class="current"<? } ?>><a href="memcp.php?action=credits&amp;operation=exchange">积分兑换</a></li>
	<? } ?>
	<? if($transferstatus) { ?>
		<li <? if($operation == 'transfer') { ?> class="current"<? } ?>><a href="memcp.php?action=credits&amp;operation=transfer">积分转账</a></li>
	<? } ?>
	<? if($ec_ratio) { ?>
		<li <? if($operation == 'addfunds') { ?> class="current"<? } ?>><a href="memcp.php?action=credits&amp;operation=addfunds">积分充值</a></li>
	<? } ?>
	</ul>
<? } elseif($action == 'creditslog') { ?>
	<h1>积分记录</h1>
	<ul class="tabs headertabs">
	<li <? if($operation == 'creditslog') { ?> class="current"<? } ?>><a href="memcp.php?action=creditslog&amp;operation=creditslog">转账与兑换记录</a></li>
	<li <? if($operation == 'paymentlog') { ?> class="current"<? } ?>><a href="memcp.php?action=creditslog&amp;operation=paymentlog">主题付费记录</a></li>
	<li <? if($operation == 'incomelog') { ?> class="current"<? } ?>><a href="memcp.php?action=creditslog&amp;operation=incomelog">主题收益记录</a></li>
	<li <? if($operation == 'rewardpaylog') { ?> class="current"<? } ?>><a href="memcp.php?action=creditslog&amp;operation=rewardpaylog">悬赏付费记录</a></li>
	<li <? if($operation == 'rewardincomelog') { ?> class="current"<? } ?>><a href="memcp.php?action=creditslog&amp;operation=rewardincomelog">悬赏收益记录</a></li>
	</ul>
<? } if($operation == 'transfer') { ?>
	<form id="creditsform" method="post" action="memcp.php?action=credits">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<input type="hidden" name="operation" value="transfer" />

	<table summary="积分转账" cellspacing="0" cellpadding="0" width="100%">
	<tbody>

	<tr>
	<th><label for="password">密码</label></th>
	<td><input type="password" size="15" name="password" id="password" /></td>
	</tr>

	<tr>
	<th><label for="to">发送到</label></th>
	<td><input type="text" size="15" name="to" id="to" /></td>
	</tr>

	<tr>
	<th><label for="amount"><?=$extcredits[$creditstrans]['title']?></label></th>
	<td><input type="text" size="15" id="amount" name="amount" value="0" onkeyup="calcredit()" /> <?=$extcredits[$creditstrans]['unit']?></td>
	</tr>

	<tr>
	<th>转账最低余额</th>
	<td><?=$transfermincredits?> <?=$extcredits[$creditstrans]['unit']?></td>
	</tr>

	<tr>
	<th>积分交易税</span></th>
	<td><?=$taxpercent?></td>
	</tr>

	<tr>
	<th>接收者收入</span></th>
	<td><span id="desamount">0</span> <?=$extcredits[$creditstrans]['unit']?></td>
	</tr>

	<tr>
		<th valign="top"><label for="transfermessage">附言</label></th>
		<td>
			<textarea name="transfermessage" id="transfermessage" rows="6" style="width: 85%;"></textarea>
			<div class="tips">如果输入附言，系统将自动向接收者发送短消息通知</div>
		</td>
	</tr>
	</tbody>

	<tr>
		<th>&nbsp;</th><td><ul><li>积分转账可以根据论坛管理员设置的交易积分，将您的积分转让给其他用户。<li>接收者收到积分的实际数值，是被扣除交易税后计算出来的，即只要进行积分交易，就可能会产生交易损失。<li>积分交易一旦提交不可恢复，请确定无误后再进行操作。</td>
	</tr>

	<tr class="btns">
		<th>&nbsp;</th><td><button class="submit" type="submit" name="creditssubmit" id="creditssubmit" value="true" onclick="return confirm('积分操作不能恢复，您确认吗?');" tabindex="1">提交</button></td>
	</tr>

	</table>

	</form>
	<script type="text/javascript">
	function calcredit() {
		var amount = parseInt($('amount').value);
		$('desamount').innerHTML = !isNaN(amount) ? Math.floor(amount * (1 - <?=$creditstax?>)) : 0;
	}
	</script>
<? } elseif($operation == 'exchange') { ?>
	<form id="creditsform" method="post" action="memcp.php?action=credits">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>">
	<input type="hidden" name="operation" value="exchange">

	<script type="text/javascript">
	var ratioarray = new Array();<? if(is_array($exchcredits)) { foreach($exchcredits as $id => $ecredits) { ?>ratioarray[<?=$id?>] = <?=$ecredits['ratio']?>;<? } } ?></script>

	<table summary="积分兑换"  cellspacing="0" cellpadding="0" width="100%">
	<tbody>

	<tr>
	<th><label for="password">密码</label></th>
	<td><input type="password" size="15" name="password" /></td>
	</tr>

	<tr>
	<th><label for="amount">支出</label></th>
	<td>
	<input type="text" size="15" name="amount" id="amount" value="0" onkeyup="calcredit();" />&nbsp;&nbsp;<select name="fromcredits" onChange="calcredit();"><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { if($credit['allowexchangeout'] && $credit['ratio']) { ?>
			<option value="<?=$id?>" unit="<?=$credit['unit']?>" title="<?=$credit['title']?>" ratio="<?=$credit['ratio']?>"><?=$credit['title']?></option>
		<? } } } ?></select>
	</td>
	</tr>
	<tr>
	<th><label for="desamount">收入</label></th>
	<td>
	<input type="text" size="15" id="desamount" value="0" disabled />&nbsp;&nbsp;<select name="tocredits" onChange="calcredit();"><? if(is_array($extcredits)) { foreach($extcredits as $id => $ecredits) { if($ecredits['allowexchangein'] && $ecredits['ratio']) { ?>
			<option value="<?=$id?>" unit="<?=$ecredits['unit']?>" title="<?=$ecredits['title']?>" ratio="<?=$ecredits['ratio']?>"><?=$ecredits['title']?></option>
		<? } } } ?></select>
	</td>
	</tr>

	<tr>
	<th>兑换比率</th>
	<td><span class="bold">1</span><span id="orgcreditunit"></span><span id="orgcredittitle"></span>换<span class="bold" id="descreditamount"></span><span id="descreditunit"></span><span id="descredittitle"></span></td>
	</tr>

	<tr>
	<th>兑换最低余额</th>
	<td><?=$exchangemincredits?></td>
	</tr>

	<tr>
	<th>积分交易税</th>
	<td><?=$taxpercent?></td>
	</tr>

	<tr>
	<th>&nbsp;</th><td><ul><li>积分兑换是根据论坛管理员设置的可兑换积分，将您自己的某种积分，兑换成另外一种积分。<li>兑换比率为该项积分对应一个单位标准积分的值。例如兑换比率为 2 的积分 1 分，相当于兑换比率为 1 的积分 2 分，即兑换比率越大，该项积分越有价值。<li>兑换成目标积分的实际数值，是按照兑换比率折算的目标积分，并扣除交易税后计算出来的，即只要进行积分交易，就可能会产生交易损失。<li>积分交易一旦提交不可恢复，请确定无误后再进行操作。</td>
	</tr>
	</tbody>
	<tr class="btns">
		<th>&nbsp;</th><td><button class="submit" type="submit" name="creditssubmit" id="creditssubmit" value="true" onclick="return confirm('积分操作不能恢复，您确认吗?');" tabindex="2">提交</button></td>
	</tr>
	</table>
	</form>
	<script type="text/javascript">
	function calcredit() {
		with($('creditsform')) {
			fromcredit = fromcredits[fromcredits.selectedIndex];
			tocredit = tocredits[tocredits.selectedIndex];
			var ratio = Math.round(((fromcredit.getAttribute('ratio') / tocredit.getAttribute('ratio')) * 100)) / 100;
			$('orgcreditunit').innerHTML = fromcredit.getAttribute('unit');
			$('orgcredittitle').innerHTML = fromcredit.getAttribute('title');
			$('descreditunit').innerHTML = tocredit.getAttribute('unit');
			$('descredittitle').innerHTML = tocredit.getAttribute('title');
			$('descreditamount').innerHTML = ratio;
			$('amount').value = $('amount').value.toInt();
			if(fromcredit.getAttribute('title') != tocredit.getAttribute('title') && $('amount').value != 0) {
				$('desamount').value = Math.floor(fromcredit.getAttribute('ratio') / tocredit.getAttribute('ratio') * $('amount').value * (1 - <?=$creditstax?>));
			} else {
				$('desamount').value = $('amount').value;
			}
		}
	}
	String.prototype.toInt = function() {
		var s = parseInt(this);
		return isNaN(s) ? 0 : s;
	}
	calcredit();
	</script>
<? } elseif($operation == 'addfunds') { ?>
	<form id="creditsform" method="post" action="memcp.php?action=credits" target="_blank">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<input type="hidden" name="operation" value="addfunds" />
	<table summary="积分充值" cellspacing="0" cellpadding="0" width="100%">
	<tbody>

	<tr>
	<th>充值规则</th>
	<td>
	人民币现金 <strong>1</strong> 元 = <?=$extcredits[$creditstrans]['title']?> <b><?=$ec_ratio?></b> <?=$extcredits[$creditstrans]['unit']?>
	<? if($ec_mincredits) { ?><br />单次最低充值 <?=$extcredits[$creditstrans]['title']?> <b><?=$ec_mincredits?></b> <?=$extcredits[$creditstrans]['unit']?><? } ?>
	<? if($ec_maxcredits) { ?><br />单次最高充值 <?=$extcredits[$creditstrans]['title']?> <b><?=$ec_maxcredits?></b> <?=$extcredits[$creditstrans]['unit']?><? } ?>
	<? if($ec_maxcreditspermonth) { ?><br />最近 30 天最高充值 <?=$extcredits[$creditstrans]['title']?> <b><?=$ec_maxcreditspermonth?></b> <?=$extcredits[$creditstrans]['unit']?><? } ?>
	</td>
	</tr>

	<tr>
	<th><?=$extcredits[$creditstrans]['title']?> 账户充值数额</th>
	<td><input type="text" size="15" id="amount" name="amount" value="0" onkeyup="calcredit()" /> <?=$extcredits[$creditstrans]['unit']?></td>
	</tr>

	<tr>
	<th>您需要在线支付的金额为</th>
	<td>人民币<span id="desamount">0</span>元</td>
	</tr>

	<tr>
	<th>&nbsp;</th><td>您可以以人民币现金在线支付的形式，为您的交易积分账户充值用于购买帖子、用户组权限或其他虚拟消费活动。<br />积分充值不能撤销或退款，因此请您在充值前确定是否需要，及仔细核对充值的金额。<br /><strong>您成功支付后有系统可能需要几分钟的时间等待支付结果，因此可能无法瞬间入账，请注意查收系统发送的短消息。如果超过 48 小时仍未收到通知短消息，请与论坛管理员联系。</strong></td>
	</tr>
	</tbody>
	<tr class="btns">
		<th>&nbsp;</th><td><button class="submit" type="submit" name="creditssubmit" id="creditssubmit" value="true" tabindex="3">提交</button></td>
	</tr>
	</table>

	</form>
	<script type="text/javascript">
	function calcredit() {
		var amount = parseInt($('amount').value);
		$('desamount').innerHTML = !isNaN(amount) ? Math.round(((amount / <?=$ec_ratio?>) * 10)) / 10 : 0;
	}
	</script>
<? } elseif($operation == 'paymentlog') { ?>

	<table summary="主题付费记录" cellspacing="0" cellpadding="0" width="100%" align="center">

	<thead>
	<tr>
	<td>标题</td>
	<td class="user">作者</td>
	<td class="time">发布时间</td>
	<td>版块</td>
	<td>付费时间</td>
	<td>售价</td>
	<td>作者所得</td>
	</tr>
	</thead>
	<tbody>
	<? if($loglist) { if(is_array($loglist)) { foreach($loglist as $log) { ?>			<tr>
			<td><a href="viewthread.php?tid=<?=$log['tid']?>"><?=$log['subject']?></a></td>
			<td><a href="space.php?uid=<?=$log['authorid']?>"><?=$log['author']?></a></td>
			<td><?=$log['tdateline']?></td>
			<td><a href="forumdisplay.php?fid=<?=$log['fid']?>"><?=$log['name']?></a></td>
			<td><?=$log['dateline']?></td>
			<? if(!$log['amount'] && !$log['netamount']) { ?>
				<td colspan="2">已退款</td>
			<? } else { ?>
				<td><?=$extcredits[$creditstrans]['title']?> <?=$log['amount']?> <?=$extcredits[$creditstrans]['unit']?></td>
				<td><?=$extcredits[$creditstrans]['title']?> <?=$log['netamount']?> <?=$extcredits[$creditstrans]['unit']?></td>
			<? } ?>
			</tr>
		<? } } } else { ?>
		<td colspan="7">目前没有积分交易记录。</td></tr>
	<? } ?>
	</tbody>
	</table>
	<div class="subtable"><?=$multipage?></div>
<? } elseif($operation == 'incomelog') { ?>


	<table summary="主题收益记录" cellspacing="0" cellpadding="0" width="100%" align="center">
	<thead>
	<tr>
	<td align="left">标题</td>
	<td>发布时间</td>
	<td>版块</td>
	<td>购买者</td>
	<td>付费时间</td>
	<td>售价</td>
	<td>作者所得</td>
	</tr>
	</thead>
	<tbody>
	<? if($loglist) { if(is_array($loglist)) { foreach($loglist as $log) { ?>			<tr>
			<td><a href="viewthread.php?tid=<?=$log['tid']?>"><?=$log['subject']?></a></td>
			<td><?=$log['tdateline']?></td>
			<td><a href="forumdisplay.php?fid=<?=$log['fid']?>"><?=$log['name']?></a></td>
			<td><a href="space.php?uid=<?=$log['uid']?>"><?=$log['username']?></a></td>
			<td><?=$log['dateline']?></td>
			<? if(!$log['amount'] && !$log['netamount']) { ?>
				<td colspan="2">已退款</td>
			<? } else { ?>
				<td><?=$extcredits[$creditstrans]['title']?> <?=$log['amount']?> <?=$extcredits[$creditstrans]['unit']?></td>
				<td><?=$extcredits[$creditstrans]['title']?> <?=$log['netamount']?> <?=$extcredits[$creditstrans]['unit']?></td>
			<? } ?>
			</tr>
		<? } } } else { ?>
		<td colspan="7">目前没有积分交易记录。</td></tr>
	<? } ?>
	</tbody>
	</table>
	<div class="subtable"><?=$multipage?></div>
<? } elseif($operation == 'rewardpaylog') { ?>

	<table summary="悬赏付费记录" cellspacing="0" cellpadding="0" width="100%" align="center">
	<thead>
	<tr>
	<td>标题</td>
	<td>发布时间</td>
	<td>版块</td>
	<td>回答者</td>
	<td>悬赏总额</td>
	<td>实际付费</td>
	</tr></thead>
	<tbody>
	<? if($loglist) { if(is_array($loglist)) { foreach($loglist as $log) { ?>			<tr>
			<td><a href="viewthread.php?tid=<?=$log['tid']?>"><?=$log['subject']?></a></td>
			<td><?=$log['dateline']?></td>
			<td><a href="forumdisplay.php?fid=<?=$log['fid']?>"><?=$log['name']?></a></td>
			<td><a href="space.php?uid=<?=$log['uid']?>"><?=$log['username']?></a></td>
			<td><?=$extcredits[$creditstrans]['title']?> <?=$log['price']?><? if($extcredits[$creditstrans]['unit'] != '') { ?> <?=$extcredits[$creditstrans]['unit']?><? } ?></td>
			<td><?=$extcredits[$creditstrans]['title']?> <?=$log['netamount']?><? if($extcredits[$creditstrans]['unit'] != '') { ?> <?=$extcredits[$creditstrans]['unit']?><? } ?></td>
			</tr>
		<? } } } else { ?>
		<td colspan="7">目前没有积分交易记录。</td></tr>
	<? } ?>
	</tbody>
	</table>
	<table cellspacing="0" cellpadding="0" border="0" align="center"><tr><td><?=$multipage?></td></tr></table>
<? } elseif($operation == 'rewardincomelog') { ?>

	<table summary="悬赏收益记录" cellspacing="0" cellpadding="0" width="100%" align="center">
	<thead>
	<tr>
	<td>标题</td>
	<td>发布时间</td>
	<td>版块</td>
	<td>提问者</td>
	<td>悬赏总额</td>
	</tr>
	</thead>
	<tbody>
	<? if($loglist) { if(is_array($loglist)) { foreach($loglist as $log) { ?>			<tr>
			<td><a href="viewthread.php?tid=<?=$log['tid']?>"><?=$log['subject']?></a></td>
			<td><?=$log['dateline']?></td>
			<td><a href="forumdisplay.php?fid=<?=$log['fid']?>"><?=$log['name']?></a></td>
			<td><a href="space.php?uid=<?=$log['uid']?>"><?=$log['username']?></a></td>
			<td><?=$extcredits[$creditstrans]['title']?> <?=$log['price']?><? if($extcredits[$creditstrans]['unit'] != '') { ?> <?=$extcredits[$creditstrans]['unit']?><? } ?></td>
			</tr>
		<? } } } else { ?>
		<td colspan="7">目前没有积分交易记录。</td></tr>
	<? } ?>
	</tbody>
	</table>

	<table cellspacing="0" cellpadding="0" border="0" align="center"><tr><td><?=$multipage?></td></tr></table>
<? } elseif($operation == 'creditslog') { ?>

	<table summary="转账与兑换记录" cellspacing="0" cellpadding="0" width="100%" align="center">
	<thead>
	<tr>
		<td>来自/到</td>
		<td>时间</td><td width="15%">支出</td>
		<td>收入</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody>
	<? if($loglist) { if(is_array($loglist)) { foreach($loglist as $log) { ?>			<tr>
			<td><? if($log['fromto'] == 'BANK ACCOUNT') { ?>银行现金转入<? } else { ?><a href="space.php?username=<?=$log['fromtoenc']?>"><?=$log['fromto']?></a><? } ?></td>
			<td><?=$log['dateline']?></td>
			<td><? if($log['send']) { ?><?=$extcredits[$log['sendcredits']]['title']?> <?=$log['send']?> <?=$extcredits[$log['sendcredits']]['unit']?><? } ?></td>
			<td><? if($log['receive']) { ?><?=$extcredits[$log['receivecredits']]['title']?> <?=$log['receive']?> <?=$extcredits[$log['receivecredits']]['unit']?><? } ?></td>
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
	<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } } ?>

	</div>
	</div>
	<div class="side">
<? include template('personal_navbar'); ?>
</div>
</div>
<? include template('footer'); ?>
