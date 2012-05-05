<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 我的道具箱</div>
	<div class="container">
		<div class="side">
<? include template('magic_navbar'); ?>
</div>
		<div class="content">
			<? if(!$magicstatus && $adminid == 1) { ?>
				<div class="notice">道具系统已关闭，仅管理员可以正常使用</div>
			<? } ?>
			<? if($operation == '') { ?>
				<div class="mainbox">
					<h1>我的道具箱</h1>
					<ul class="tabs">
						<li<? if(empty($typeid)) { ?> class="current"<? } ?>><a href="magic.php?action=user&amp;pid=<?=$pid?>">全部</a></li>
						<li<? if($typeid==1) { ?> class="current"<? } ?>><a href="magic.php?action=<?=$action?>&amp;typeid=1&amp;pid=<?=$pid?>">帖子类</a></li>
						<li<? if($typeid==2) { ?> class="current"<? } ?>><a href="magic.php?action=<?=$action?>&amp;typeid=2&amp;pid=<?=$pid?>">会员类</a></li>
						<li<? if($typeid==3) { ?> class="current"<? } ?>><a href="magic.php?action=<?=$action?>&amp;typeid=3&amp;pid=<?=$pid?>">其他类</a></li>
					</ul>
					<table summary="我的道具箱" cellspacing="0" cellpadding="0">
						<? if($magiclist) { if(is_array($magiclist)) { foreach($magiclist as $key => $magic) { if($key && ($key % 2 == 0)) { ?>
									</tr>
									<? if($key < $magicnum) { ?>
										<tr>
									<? } ?>
								<? } ?>
								<td width="50%" class="attriblist">
									<dl>
										<dt><img src="images/magics/<?=$magic['pic']?>" alt="<?=$magic['name']?>" /></dt>
										<dd class="name"><?=$magic['name']?></dd>
										<dd><?=$magic['description']?></dd>
										<dd>数量: <b><?=$magic['num']?></b> 总重量: <b><?=$magic['weight']?></b></dd>
										<dd>
											<a href="magic.php?action=user&amp;operation=use&amp;magicid=<?=$magic['magicid']?>&amp;pid=<?=$pid?>&amp;username=<?=$username?>">使用</a>&nbsp;|&nbsp;
											<? if($allowmagics > 1) { ?>
												<a href="magic.php?action=user&amp;operation=give&amp;magicid=<?=$magic['magicid']?>">赠送</a>&nbsp;|&nbsp;
											<? } ?>
											<a href="magic.php?action=user&amp;operation=drop&amp;magicid=<?=$magic['magicid']?>">丢弃</a>&nbsp;|&nbsp;
											<? if($magicmarket && $allowmagics > 1) { ?>
												<a href="magic.php?action=user&amp;operation=sell&amp;magicid=<?=$magic['magicid']?>">出售</a>&nbsp;
											<? } ?>
										</dd>
									</dl>
								</td><? } } ?><?=$magicendrows?>
						<? } else { ?>
							<td colspan="3">没有此类道具，您可以点<a href="magic.php?action=shop">这里</a>购买相应道具。</td></tr>
						<? } ?>
					</table>
			<? } elseif($operation == 'give' || $operation == 'use' || $operation == 'sell' || $operation == 'drop') { ?>
			<form method="post" action="magic.php?action=user">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
				<input type="hidden" name="operation" value="<?=$operation?>" />
				<input type="hidden" name="magicid" value="<?=$magicid?>" />
				<input type="hidden" name="<?=$operationsubmit?>" value="yes" />
				<div class="mainbox">
					<h1>
					<? if($operation == 'give') { ?>
						赠送
					<? } elseif($operation == 'drop') { ?>
						丢弃
					<? } elseif($operation == 'sell') { ?>
						出售
					<? } elseif($operation == 'use') { ?>
						使用
					<? } ?>
					</h1>
					<table summary="" cellspacing="0" cellpadding="0">
						<tr>
							<td class="attriblist">
								<dl>
									<dt><img src="images/magics/<?=$magic['pic']?>" alt="<?=$magic['name']?>"></dt>
									<dd><?=$magic['name']?></dd>
									<dd><?=$magic['description']?></dd>
									<dd>数量: <?=$magic['num']?> 总重量: <?=$magic['weight']?></dd>
									<dd>是否允许使用: <font color=red><? if($useperm) { ?> 允许 <? } else { ?> 不允许 <? } ?></font></dd>
									<? if($magic['type'] == 1) { ?>
										<dd>允许使用版块:
										<? if($forumperm) { ?><?=$forumperm?><? } else { ?> 所有版块 <? } ?></dd>
									<? } ?>
									<? if($magic['type'] == 2) { ?>
										<dd>允许被使用的用户组:
										<? if($targetgroupperm) { ?><?=$targetgroupperm?><? } else { ?> 所有用户组 <? } ?></dd>
									<? } ?>
								</dl>
							</td>
						</tr>
						<? if($operation != 'use') { ?>
							<tr ><td width="10%">
								数量:<input name="magicnum" type="text" size="5" value="1" />&nbsp;&nbsp;
							<? if($operation == 'sell') { ?>
								售价:<input name="price" type="text" size="5" />
							<? } ?>
							<? if($operation == 'give' && $allowmagics > 1 ) { ?>
								赠送对象用户名:<input name="tousername" type="text" size="5" />
							<? } ?>
							</td></tr>
						<? } ?>
						<tr class="btns"><td colspan="2">
						<? if($operation == 'use') { showmagic(); } ?>
							<? if($operation == 'give') { ?>
								<button class="submit" type="submit" name="operatesubmit" id="operatesubmit" value="true"  onclick="return confirm('确认该操作');">赠送</button>
							<? } elseif($operation == 'drop') { ?>
								<button class="submit" type="submit" name="operatesubmit" id="operatesubmit" value="true"  onclick="return confirm('确认该操作');">丢弃</button>
							<? } elseif($operation == 'sell') { ?>
								<button class="submit" type="submit" name="operatesubmit" id="operatesubmit" value="true"  onclick="return confirm('确认该操作');">出售</button>
							<? } elseif($operation == 'use') { ?>
								<button class="submit" type="submit" name="usesubmit" id="usesubmit" value="true">使用</button>
							<? } ?>
						</td></tr>
	</table></div>



	</form>
<? } ?>
		</div>
	</div>



<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } include template('footer'); ?>
