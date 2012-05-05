<? if(!defined('IN_DISCUZ')) exit('Access Denied'); function tpl_hide_credits_hidden($creditsrequire) {
global $hideattach;
 ?><?
$return = <<<EOF
<div class="notice" style="width: 500px">本帖隐藏的内容需要积分高于 {$creditsrequire} 才可浏览</div>
EOF;
?><? return $return; }

function tpl_hide_credits($creditsrequire, $message) {
global $hideattach;
 ?><?
$return = <<<EOF
<div class="notice" style="width: 500px">以下内容需要积分高于 {$creditsrequire} 才可浏览</div>
{$message}<br /><br />
<br />
EOF;
?><? return $return; }

function tpl_codedisp($discuzcodes, $code) {
 ?><?
$return = <<<EOF
<div class="blockcode"><span class="headactions" onclick="copycode($('code{$discuzcodes['codecount']}'));">复制内容到剪贴板</span><h5>代码:</h5><code id="code{$discuzcodes['codecount']}">{$code}</code></div>
EOF;
?><? return $return; }

function tpl_quote() {
 ?><?
$return = <<<EOF
<div class="quote"><h5>引用:</h5><blockquote>\\1</blockquote></div>
EOF;
?><? return $return; }

function tpl_free() {
 ?><?
$return = <<<EOF
<div class="quote"><h5>免费内容:</h5><blockquote>\\1</blockquote></div>
EOF;
?><? return $return; }

function tpl_hide_reply() {
global $hideattach;
 ?><?
$return = <<<EOF
<div class="notice" style="width: 500px">以下内容需要回复才能看到</div>
\\1<br /><br />
<br />
EOF;
?><? return $return; }

function tpl_hide_reply_hidden() {
 ?><?
$return = <<<EOF
<div class="notice" style="width: 500px">本帖隐藏的内容需要回复才可以浏览</div>
EOF;
?><? return $return; }

function attachlist($attach) {
global $attachrefcheck, $extcredits, $creditstrans, $ftp, $thumbstatus;
 ?><?
$return = <<<EOF

	<dl class="t_attachlist">
	
EOF;
 if($attach['attachimg']) { 
$return .= <<<EOF

		<dt>
			{$attach['attachicon']}
			<a href="attachment.php?aid={$attach['aid']}&amp;nothumb=yes" class="bold" target="_blank">{$attach['filename']}</a>
			<em>({$attach['attachsize']})</em>
		</dt>
		<dd>
			<p>
				{$attach['dateline']}
				
EOF;
 if($attach['readperm']) { 
$return .= <<<EOF
, 阅读权限: <strong>{$attach['readperm']}</strong>
EOF;
 } 
$return .= <<<EOF

				
EOF;
 if($attach['price']) { 
$return .= <<<EOF
, 售价: <strong>{$extcredits[$creditstrans]['title']} {$attach['price']} {$extcredits[$creditstrans]['unit']}</strong> &nbsp;[<a href="misc.php?action=viewattachpayments&amp;aid={$attach['aid']}" target="_blank">记录</a>]
					
EOF;
 if(!$attach['payed']) { 
$return .= <<<EOF

						&nbsp;[<a href="misc.php?action=attachpay&amp;aid={$attach['aid']}" target="_blank">购买</a>]
					
EOF;
 } 
$return .= <<<EOF

				
EOF;
 } 
$return .= <<<EOF

			</p>
			
EOF;
 if($attach['description']) { 
$return .= <<<EOF
<p>{$attach['description']}</p>
EOF;
 } 
$return .= <<<EOF

			
EOF;
 if(!$attach['price'] || $attach['payed']) { 
$return .= <<<EOF

				<p>
				
EOF;
 if($thumbstatus && $attach['thumb']) { 
$return .= <<<EOF

					
EOF;
 if(($attachrefcheck || $attach['remote']) && !($attach['remote'] && substr($ftp['attachurl'], 0, 3) != 'ftp' && !$ftp['hideurl'])) { 
$return .= <<<EOF

						<a href="#zoom"><img onclick="zoom(this, 'attachment.php?aid={$attach['aid']}&amp;noupdate=yes&amp;nothumb=yes')" src="attachment.php?aid={$attach['aid']}" alt="{$attach['filename']}" /></a>
					
EOF;
 } else { 
$return .= <<<EOF

						<a href="#zoom"><img onclick="zoom(this, '{$attach['url']}/{$attach['attachment']}')" src="{$attach['url']}/{$attach['attachment']}.thumb.jpg" alt="{$attach['filename']}" /></a>
					
EOF;
 } 
$return .= <<<EOF

				
EOF;
 } else { 
$return .= <<<EOF

					
EOF;
 if(($attachrefcheck || $attach['remote']) && !($attach['remote'] && substr($ftp['attachurl'], 0, 3) != 'ftp' && !$ftp['hideurl'])) { 
$return .= <<<EOF

						<img src="attachment.php?aid={$attach['aid']}&amp;noupdate=yes" border="0" onload="attachimg(this, 'load')" onmouseover="attachimg(this, 'mouseover')" onclick="zoom(this, 'attachment.php?aid={$attach['aid']}')" alt="{$attach['filename']}" />
					
EOF;
 } else { 
$return .= <<<EOF

						<img src="{$attach['url']}/{$attach['attachment']}" onload="attachimg(this, 'load')" onmouseover="attachimg(this, 'mouseover')" onclick="zoom(this, '{$attach['url']}/{$attach['attachment']}')" alt="{$attach['filename']}" />
					
EOF;
 } 
$return .= <<<EOF

				
EOF;
 } 
$return .= <<<EOF

				</p>
			
EOF;
 } 
$return .= <<<EOF

		</dd>
	
EOF;
 } else { 
$return .= <<<EOF

		<dt>
			{$attach['attachicon']}
			<a href="attachment.php?aid={$attach['aid']}" target="_blank">{$attach['filename']}</a>
			<em>({$attach['attachsize']})</em>
		</dt>
		<dd>
			<p>
				{$attach['dateline']}, 下载次数: {$attach['downloads']}
				
EOF;
 if($attach['readperm']) { 
$return .= <<<EOF
, 阅读权限: <strong>{$attach['readperm']}</strong>
EOF;
 } 
$return .= <<<EOF

				
EOF;
 if($attach['price']) { 
$return .= <<<EOF

					, 售价: <strong>{$extcredits[$creditstrans]['title']} {$attach['price']} {$extcredits[$creditstrans]['unit']}</strong> &nbsp;[<a href="misc.php?action=viewattachpayments&amp;aid={$attach['aid']}" target="_blank">记录</a>]
					
EOF;
 if(!$attach['payed']) { 
$return .= <<<EOF

						&nbsp;[<a href="misc.php?action=attachpay&amp;aid={$attach['aid']}" target="_blank">购买</a>]
					
EOF;
 } 
$return .= <<<EOF

				
EOF;
 } 
$return .= <<<EOF

			</p>
			
EOF;
 if($attach['description']) { 
$return .= <<<EOF
<p>{$attach['description']}</p>
EOF;
 } 
$return .= <<<EOF

		</dd>
	
EOF;
 } 
$return .= <<<EOF

	</dl>

EOF;
?><? return $return; }

function attachinpost($attach) {
global $attachrefcheck, $extcredits, $creditstrans, $ftp, $thumbstatus;
 ?><?
$__IMGDIR = IMGDIR;$return = <<<EOF

	
EOF;
 if(!isset($attach['unpayed'])) { 
$return .= <<<EOF

		
EOF;
 if($attach['attachimg']) { 
$return .= <<<EOF

			<span style="position: absolute; display: none" id="attach_{$attach['aid']}" onmouseover="showMenu(this.id, 0, 1)"><img src="{$__IMGDIR}/attachimg.gif" border="0"></span>
			
EOF;
 if($thumbstatus && $attach['thumb']) { 
$return .= <<<EOF

				
EOF;
 if($attachrefcheck) { 
$return .= <<<EOF

					<a href="###zoom"><img onclick="zoom(this, 'attachment.php?aid={$attach['aid']}&amp;noupdate=yes&amp;nothumb=yes')" src="attachment.php?aid={$attach['aid']}" border="0" onmouseover="attachimginfo(this, 'attach_{$attach['aid']}', 1)" onmouseout="attachimginfo(this, 'attach_{$attach['aid']}', 0, event)" /></a>
				
EOF;
 } else { 
$return .= <<<EOF

					<a href="###zoom"><img onclick="zoom(this, '{$attach['url']}/{$attach['attachment']}')" src="{$attach['url']}/{$attach['attachment']}.thumb.jpg" border="0" onmouseover="attachimginfo(this, 'attach_{$attach['aid']}', 1)" onmouseout="attachimginfo(this, 'attach_{$attach['aid']}', 0, event)" /></a>
				
EOF;
 } 
$return .= <<<EOF

			
EOF;
 } else { 
$return .= <<<EOF

				
EOF;
 if($attachrefcheck) { 
$return .= <<<EOF

					<img src="attachment.php?aid={$attach['aid']}&amp;noupdate=yes" border="0" onload="attachimg(this, 'load')" onmouseover="attachimginfo(this, 'attach_{$attach['aid']}', 1);attachimg(this, 'mouseover')" onclick="zoom(this, 'attachment.php?aid={$attach['aid']}')" onmouseout="attachimginfo(this, 'attach_{$attach['aid']}', 0, event)" alt="" />
				
EOF;
 } else { 
$return .= <<<EOF

					<img src="{$attach['url']}/{$attach['attachment']}" border="0" onload="attachimg(this, 'load')" onmouseover="attachimginfo(this, 'attach_{$attach['aid']}', 1);attachimg(this, 'mouseover')" onclick="zoom(this, '{$attach['url']}/{$attach['attachment']}')" onmouseout="attachimginfo(this, 'attach_{$attach['aid']}', 0, event)" alt="" />
				
EOF;
 } 
$return .= <<<EOF

			
EOF;
 } 
$return .= <<<EOF

			<div class="t_attach" id="attach_{$attach['aid']}_menu" style="position: absolute; display: none">
			{$attach['attachicon']} <a href="attachment.php?aid={$attach['aid']}&amp;nothumb=yes" target="_blank"><strong>{$attach['filename']}</strong></a> ({$attach['attachsize']})<br />
			
EOF;
 if($attach['description']) { 
$return .= <<<EOF
{$attach['description']}<br />
EOF;
 } 
$return .= <<<EOF

		
EOF;
 } else { 
$return .= <<<EOF

			{$attach['attachicon']} <span style="white-space: nowrap" id="attach_{$attach['aid']}" onmouseover="showMenu(this.id)"><a href="attachment.php?aid={$attach['aid']}" target="_blank"><strong>{$attach['filename']}</strong></a> ({$attach['attachsize']})</span>
			<div class="t_attach" id="attach_{$attach['aid']}_menu" style="position: absolute; display: none">{$attach['attachicon']} <a href="attachment.php?aid={$attach['aid']}" target="_blank"><strong>{$attach['filename']}</strong></a> ({$attach['attachsize']})<br />
			
EOF;
 if($attach['description']) { 
$return .= <<<EOF
{$attach['description']}<br />
EOF;
 } 
$return .= <<<EOF

			下载次数: {$attach['downloads']}<br />
			
EOF;
 if($attach['readperm']) { 
$return .= <<<EOF
阅读权限: {$attach['readperm']}<br />
EOF;
 } 
$return .= <<<EOF

		
EOF;
 } 
$return .= <<<EOF

		
EOF;
 if($attach['price']) { 
$return .= <<<EOF

			售价: {$extcredits[$creditstrans]['title']} {$attach['price']} {$extcredits[$creditstrans]['unit']} &nbsp;<a href="misc.php?action=viewattachpayments&amp;aid={$attach['aid']}" target="_blank">[记录]</a>
			
EOF;
 if(!$attach['payed']) { 
$return .= <<<EOF

				&nbsp;<a href="misc.php?action=attachpay&amp;aid={$attach['aid']}" target="_blank">[购买]</a>
			
EOF;
 } 
$return .= <<<EOF

		
EOF;
 } 
$return .= <<<EOF

		<div class="t_smallfont">{$attach['dateline']}</div></div>
	
EOF;
 } else { 
$return .= <<<EOF

		{$attach['attachicon']} <strong>收费附件: {$attach['filename']}</strong>
	
EOF;
 } 
$return .= <<<EOF


EOF;
?><? return $return; }

 ?>