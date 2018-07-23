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
class AddressAction extends BaseAction
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
		$User = M("address");
		$where['userid']=$this->_userid;
		$list_address=$User->where($where)->select();
		//dump($list);
		$this->assign('list_address',$list_address);
        $this->display();
    }
	
	public function edit()
    {
		//dump($_POST);exit;
		if(!$_POST['tel'] || !$_POST['name'] || !$_POST['xxdz'] || !$_POST['yb']) $this->error(L('请填写完整内容！'));
		$User = M("address");
		$data['userid']=$this->_userid;
		$data['tel']=$_POST['tel'];
		$data['name']=$_POST['name'];
		$data['createtime']=time();
		$data['dz']=$_POST['dz'];
		$data['xxdz']=$_POST['xxdz'];
		$data['yb']=$_POST['yb'];
		
		if($User->add($data))
		$this->success('添加地址成功！','/index.php?g=Home&m=Address&a=index');
        //$this->display();
    }
	
	public function del()
    {
		//dump($_POST);exit;
		$User = M("address");
		$where['userid']=$this->_userid;
		$where['id']=$_GET['id'];
		
		if($User->where($where)->delete())
		$this->success('删除地址成功！','/index.php?g=Home&m=Address&a=index');
        //$this->display();
    }
	
	public function def()
    {
		//dump($_POST);exit;
		$User = M("address");
		$where['userid']=$this->_userid;
		$data['def']=0;
		//echo '213213';
		$res=$User->where($where)->save($data);
		
			$where['id']=$_GET['id'];
			$data['def']=1;
			if($User->where($where)->save($data))
			$this->success('设置默认地址成功！','/index.php?g=Home&m=Address&a=index');
		
        //$this->display();
    }

}
?>