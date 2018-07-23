<?php
/**
 *
 * PostAction.class.php (前台内容管理)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <wei2l99@qq.com>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");

class UserAction extends BaseAction
{
    protected $dao, $fields;
    public function new_registered()
    {
        $c = A('Admin/Content');
        //dump($_POST);exit;
        $_POST['reg_ip'] = get_client_ip();



        //$list = $this->dao->field($field)->where($where)->order('createtime desc,id desc')->limit($page->firstRow . ',' . $page->listRows)->select();



        $User = M("user"); // 实例化User对象
        $new_where['username']=$_POST['username'];
        $new_count = $User->where($new_where)->count();
        $new_where_m['mobile']=$_POST['mobile'];
        $new_count_m = $User->where($new_where_m)->count();
        if($new_count) {
            $this->error(L('用户名已经被注册!'));
            exit;
        }
        if($new_count_m) {
            $this->error(L('手机号已经被注册!'));
            exit;
        }
		
		if($_POST['c_mobile']!=$_SESSION['ssccddoo']) {
            $this->error(L('手机验证码不正确！'));
            exit;
        }
		
        $_POST['password']=sysmd5($_POST['password']);











        if(empty($_POST['username']) || empty($_POST['mobile']) || empty($_POST['password'])) {
            $this->error(L('信息填写不完整!'));
            exit;
        }
        if(md5($_POST['verify'])!=$_SESSION['verify']) {
            $this->error(L('验证码填写错误!'));
            exit;
        }


        //$_POST['status']='1';
        $_POST['groupid']='3';
        //dump($c);exit;
       // $this->fields['username']=$_POST['username'];



        cookie('auth', $gzphp_auth, $cookietime);
        cookie('username', $authInfo['username'], $cookietime);
        cookie('groupid', $authInfo['groupid'], $cookietime);
        cookie('userid', $authInfo['id'], $cookietime);
        cookie('email', $authInfo['email'], $cookietime);

        //保存登录信息
        $dao = M('User');
        $data = array();
        $data['id'] = $authInfo['id'];
        $data['last_logintime'] = time();
        $data['last_ip'] = get_client_ip();
        $data['login_count'] = array('exp', 'login_count+1');
        $dao->save($data);



        $c->insert('user', $this->fields,'0',$_POST['username'],'3','reg');
        //$this->success(L('注册成功！'));
    }
}