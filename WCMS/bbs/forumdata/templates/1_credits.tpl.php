<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 积分策略说明</div>

<div class="mainbox">
	<h1>积分策略说明</h1>
	<table summary="积分策略说明" cellspacing="0" cellpadding="0">

		<thead>
			<tr>
				<th>&nbsp;</th><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><td><?=$credit['title']?></td><? } } ?></tr>
		</thead>
		<tbody><? if(is_array($policyarray)) { foreach($policyarray as $operation => $policy) { ?><tr>
				<th>
				<? if($operation == 'post') { ?>
					发新主题
				<? } elseif($operation == 'forum_post') { ?>
					本版发新主题
				<? } elseif($operation == 'reply') { ?>
					发表回复
				<? } elseif($operation == 'forum_reply') { ?>
					本版发表回复
				<? } elseif($operation == 'digest') { ?>
					加入精华
				<? } elseif($operation == 'forum_digest') { ?>
					本版加入精华
				<? } elseif($operation == 'postattach') { ?>
					发表附件
				<? } elseif($operation == 'forum_postattach') { ?>
					本版发表附件
				<? } elseif($operation == 'getattach') { ?>
					下载附件
				<? } elseif($operation == 'forum_getattach') { ?>
					本版下载附件
				<? } elseif($operation == 'pm') { ?>
					发短消息
				<? } elseif($operation == 'search') { ?>
					搜索
				<? } elseif($operation == 'promotion_visit') { ?>
					访问推广
				<? } elseif($operation == 'promotion_register') { ?>
					注册推广
				<? } elseif($operation == 'tradefinished') { ?>
					成功交易
				<? } elseif($operation == 'votepoll') { ?>
					参与投票
				<? } elseif($operation == 'lowerlimit') { ?>
					积分下限
				<? } ?>
				</th><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { if(isset($view) && $operation == $view) { ?>
						<td><?=$creditsarray[$operation][$id]?></td>
					<? } else { ?>
						<td><?=$creditsarray[$operation][$id]?></td>
					<? } } } ?></tr><? } } ?></tbody>
	</table>
</div>
<div class="notice">
	<p>积分下限: 当您该项积分低于此下限设置的数值时，将无法执行积分策略中涉及扣减此项积分的操作</p>
	<p>总积分计算公式: <?=$creditsformulaexp?></p>
</div>
<? include template('footer'); ?>
