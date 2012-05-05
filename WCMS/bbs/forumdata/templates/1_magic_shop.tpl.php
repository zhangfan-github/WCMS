<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 道具商店</div>
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
					<h1>道具商店</h1>
					<ul class="tabs">
						<li<? if(empty($typeid)) { ?> class="current"<? } ?>><a href="magic.php?action=shop">全部</a></li>
						<li<? if($typeid==1) { ?> class="current"<? } ?>><a href="magic.php?action=shop&amp;typeid=1">帖子类</a></li>
						<li<? if($typeid==2) { ?> class="current"<? } ?>><a href="magic.php?action=shop&amp;typeid=2">会员类</a></li>
						<li<? if($typeid==3) { ?> class="current"<? } ?>><a href="magic.php?action=shop&amp;typeid=3">其他类</a></li>
					</ul>
					<table summary="道具商店" cellspacing="0" cellpadding="0">
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
									<dd>售价: <b><?=$magic['price']?></b> <?=$extcredits[$creditstrans]['title']?> 重量: <b><?=$magic['weight']?></b> 库存: <b><?=$magic['num']?></b> 销量:<b><?=$magic['salevolume']?></b></dd>
									<dd><a href="magic.php?action=shop&amp;operation=buy&amp;magicid=<?=$magic['magicid']?>">购买</a></dd>
								</dl>
							</td><? } } ?><?=$magicendrows?>
					<? } else { ?>
						<td colspan="3">没有此类道具，您可以点<a href="magic.php?action=shop">这里</a>购买相应道具。</td></tr>
					<? } ?>
			<? } elseif($operation == 'buy') { ?>
				<form method="post" action="magic.php?action=shop">
				<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
				<input type="hidden" name="operation" value="buy" />
				<input type="hidden" name="magicid" value="<?=$magicid?>" />
				<input type="hidden" name="operatesubmit" value="yes" />
				<div class="mainbox">
				<h1>道具商店</h1>
				<table cellspacing="0" cellpadding="0" width="100%" align="0">
				<tr><td rowspan="6"align="center" width="20%"><img src="images/magics/<?=$magic['pic']?>"><br /></td>
				<td width="80%"><b><?=$magic['name']?></b></td></tr>
				<tr><td><?=$magic['description']?></td></tr>
				<tr><td>售价: <?=$magic['price']?> <?=$extcredits[$creditstrans]['title']?> 库存: <?=$magic['num']?> 销量: <?=$magic['salevolume']?> 重量: <?=$magic['weight']?></td></tr>
				<tr><td>是否允许使用: <font color=red><? if($useperm) { ?> 允许 <? } else { ?> 不允许 <? } ?></font>
				<? if($magic['type'] == 1) { ?>
						<br />允许使用版块: <? if($forumperm) { ?><?=$forumperm?><? } else { ?> 所有版块 <? } ?>
				<? } ?>
				<? if($magic['type'] == 2) { ?>
						<br />允许被使用的用户组: <? if($targetgroupperm) { ?><?=$targetgroupperm?><? } else { ?> 所有用户组 <? } ?>
				<? } ?>
				</td></tr>
				<tr><td width="10%">
					购买数量: <input name="magicnum" type="text" size="5" value="1" />&nbsp;
					<? if($allowmagics > 1 ) { ?>
						<input type="checkbox" name="checkgive" value="0" onclick="$('showgive').style.display = $('showgive').style.display == 'none' ? '' : 'none'; this.value = this.value == 0 ? 1 : 0; this.checked = this.value == 0 ? false : true" /> 赠送其他用户
						<div id="showgive" style="display:none">
							赠送对象用户名: <input name="tousername" type="text" size="5" />
						</div>
					<? } ?>
				</td></tr>
				<tr><td>
					<button class="submit" type="submit" name="operatesubmit" id="operatesubmit" value="true" tabindex="101">购买</button>
				</td></tr>
				</table></div>
				</form>
			<? } ?>
			</tr></table></div>
			<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } ?>
		</div>
	</div>
<? include template('footer'); ?>
