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
class CustomerAction extends BaseAction
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
		//获取支付记录
			$User = M("zfjl");
			$where['uid']=$this->_userid;
			//$where['ddh']=$_GET['out_trade_no'];
			$where['ok']='1';
			$ok=$User->where($where)->order('createtime desc,id desc')->select();
			$this->assign('list_myok',$ok);
        $this->display();
    }

}
?>