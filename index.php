<?php
header('HTTP/1.1 301 Moved Permanently');//发出301头部
header('Location:http://www.yitaiwm.com'.$the_url);//跳转到带www的网址
$the_host = $_SERVER['HTTP_HOST'];//取得当前域名
if($the_host == 'yitaiwm.com') exit('Coming soon!');
if($the_host == 'www.yitaiwm.com') exit('Coming soon!');


//设置支付宝安全账号
			$_SESSION['selef_aaa_zaanff']='whatevermean@qq.com';
			//$sss_src='EvotVKVcyA*nx&Lt';
			//$_SESSION['selef_aaa_zaanff_md5']=md5('whatevermean@qq.com'.$sss_src);
			//$_SESSION['selef_aaa_zaanff_md5_src']=$sss_src;
/**
 *
 * index(入口文件)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <wei2l99@qq.com>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!is_file('./Cache/config.php'))header("location: ./Install");
header("Content-type: text/html;charset=utf-8");
ini_set('memory_limit','32M');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('GZPHP', 'GzPHP');
define('UPLOAD_PATH', './Uploads/');
define('VERSION','v3.7 Released');
define('UPDATETIME','20140525');
define('APP_NAME', 'GZphp');
define('APP_PATH', './GZphp/');
define('APP_LANG',true);
define('APP_DEBUG',false);
define('THINK_PATH','./Core/');
require(THINK_PATH.'/Core.php');
?>
