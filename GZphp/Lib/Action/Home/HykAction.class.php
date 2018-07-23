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
class HykAction extends BaseAction
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
	if(!$_POST['aplication'] || !$_POST['name'] || !$_POST['sex'] || !$_POST['ssffzz'] || !$_POST['zy'] || !$_POST['yss']) $this->error(L('请填写完整内容！'));
		$User = M("user"); // 实例化User对象
                $new_where['id']=$this->_userid;
                $new_count_arr = $User->where($new_where)->select();
                $new_count=$new_count_arr['0'];
				
		//dump($_POST);exit;
		$User = M("hyk");
		$data['userid']=$this->_userid;
		$data['aplication']=$_POST['aplication'];
		$data['name']=$_POST['name'];
		$data['createtime']=time();
		$data['sex']=$_POST['sex'];
		$data['ssffzz']=$_POST['ssffzz'];
		$data['email']=$new_count['email'];
		$data['tel']=$new_count['mobile'];
		$data['sr']=$_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
		//$data['status']=1;
		$data['lang']=1;
		$data['zy']=$_POST['zy'];
		$data['yss']=$_POST['yss'];
	
		
		if($User->add($data))
		$this->success('申请会员卡成功！','/index.php?g=Home&m=Hyk&a=index');
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
		if($res=$User->where($where)->save($data)){
			$where['id']=$_GET['id'];
			$data['def']=1;
			if($User->where($where)->save($data))
			$this->success('设置默认地址成功！','/index.php?g=Home&m=Address&a=index');
		}
        //$this->display();
    }

}
?>