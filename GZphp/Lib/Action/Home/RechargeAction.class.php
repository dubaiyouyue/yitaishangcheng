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
class RechargeAction extends BaseAction
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
	
		$_SESSION['uid']=$this->_userid;
		$_SESSION['mmod']='zz';
		//$key='408A606EB328A5733071CDD728E972A1';
		//$_SESSION['ukey']=md5($key.md5($this->_userid));
	
		$User = M("page");
		$where['id']=49;
		$list_address=$User->where($where)->limit(1)->select();
		//dump($list);
		$this->assign('list_address',$list_address);
        $this->display();
    }
	
}
?>