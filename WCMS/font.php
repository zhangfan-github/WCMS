<?php
header("Content-type: image/gif");
$im = imagecreatetruecolor(50, 20);
$black = imagecolorallocate($im, 0, 0, 0);
$white = imagecolorallocate($im, 255, 255, 255);
imagefilledrectangle($im, 0, 0, 49, 19, $white);
$font = imageloadfont("font.ttf");
//print($font."<br />");
imagestring($im, $font, 10, 10, "Hello", $black);
imagegif($im);
?>