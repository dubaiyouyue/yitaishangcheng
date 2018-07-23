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
class UserAction extends BaseAction
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

        $this->display();
    }
    public function edit()
    {

        $this->display();
    }
	public function medit()
    {

        $this->display();
    }
    public function upload_newmm()
    {
        /*
        $_SESSION['dxzym']=1;
        dump($_SESSION);exit;
        */

        
		/*
		if($_POST['dxzym']!=$_SESSION['ssccddoo'] || !$_SESSION['ssccddoo']) {
            $this->error('短信验证码填写错误！修改失败！');
            exit;
        }
		*/

        $User = M("user"); // 实例化User对象

        $up_where['id']=$this->_userid;

        $up_data['realname']=$_POST['realname'];
        $up_data['email']=$_POST['email'];
        $up_data['sex']=$_POST['sex'];
        $up_data['month']=$_POST['month'];
        $up_data['year']=$_POST['year'];
        $up_data['day']=$_POST['day'];
        $up_data['address']=$_POST['address'];
        //$up_data['realname']=$_POST['realname'];
        $User->where($up_where)->limit(1)->save($up_data);
        $this->success('修改资料成功！','/index.php?g=Home&m=User&a=index');


    }
	public function upload_newmmm()
    {
        /*
        $_SESSION['dxzym']=1;
        dump($_SESSION);exit;
        */

        
		
		if($_POST['dxzym']!=$_SESSION['ssccddoo'] || !$_SESSION['ssccddoo']) {
            $this->error('短信验证码填写错误！修改失败！','/index.php?g=Home&m=User&a=medit');
            exit;
        }
		

        $User = M("user"); // 实例化User对象

        $up_where['id']=$this->_userid;

        $up_data['mobile']=$_POST['mobile'];
        
        //$up_data['realname']=$_POST['realname'];
        $User->where($up_where)->limit(1)->save($up_data);
        $this->success('手机号修改成功！请添加新手机号收货地址！','/index.php?g=Home&m=User&a=index',12);


    }

}
?>