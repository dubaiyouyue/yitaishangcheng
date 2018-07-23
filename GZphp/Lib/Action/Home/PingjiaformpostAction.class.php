<?php
/**
 *
 * IndexAction.class.php (前台首页)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class PingjiaformpostAction extends BaseAction
{
    function _initialize()
    {
        parent::_initialize();
		
        if(!$this->_userid){
            $this->error(L('请登录！'),'/index.php/login/');
            exit;
        }
		
    }

    public function index()
    {
		
        if(!$this->_userid){
            $this->error(L('请登录！'),'/index.php/login/');
        }
		
		if(!$_POST['ttid'] || !$_POST['name'] || !$_POST['city'] || !$_POST['did']) exit;
		
		$User = M("pingjia");
		
		$data['tid']=$_POST['ttid']+0;
		$data['uid']=$this->_userid;
		$data['uname']=$this->_username;
		$data['content']=$_POST['name'];
		$data['my']=$_POST['city'];
		$data['createtime']=time();
		
		$likeadd=$User->add($data);
		
		//更新已评价
		$User = M("mygw");
		$wdata['id']=$_POST['did']+0;
		$ddata['ypj']=1;
		$gsspj=$User->where($wdata)->save($ddata);
		
		//dump($_POST);
		
    }
	

}
?>