<?php
if(!defined('ZH')){
    exit('');
}
		for($i=0;$i<2;$i++){
		 $rand.=dechex(rand(1,15));
		}
		$im=imagecreatetruecolor(266,26);
	$te = imagecolorallocate($im,255,255,255);
	for($i=0;$i<29;$i++){
		$te2 = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
		imageline($im,rand(0,266),rand(0,26),rand(0,266),rand(0,26),$te2);
	}
 	for($i=0;$i<49;$i++){
  		imagesetpixel($im,rand()%266,rand()%26,$te2);
  	}
  	imagettftext($im,14,9,rand(10,230),20,$te,__DIR__.'/minion_pro.ttf',$str);
		header("Content-type: image/jpeg");
		imagejpeg($im);