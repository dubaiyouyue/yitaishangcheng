<?php
/**
 * RegisterAction.class.php (前台会员注册模块)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class RegisterAction extends BaseAction
{
	
	function _initialize()
    {
		parent::_initialize();
		$this->dao = M('User');
		//if(empty($this->member_config['member_register'])) $this->error(L('close_reg'));
    }
    public function index()
    {
		if( cookie('auth')){
			$this->assign('forward','');
			$this->assign('jumpUrl','/');
			$this->success(L('login_ok'));
		}
		$this->assign('bcid',0);
        $this->display();
    }

	public function doreg()
	{
		
		$_POST['mobile']=$_SESSION['mobile'];
		$username = get_safe_replace($_POST['username']);
        $password = get_safe_replace($_POST['password']);
		$mobile = get_safe_replace($_POST['mobile']);
        $verifyCode =$_POST['verifyCode'];

        if(strlen($mobile)!=11)  {
            //$this->error(L('手机号格式错误!'),'/index.php/Registered/?mmm=iframe" target="_parent');
            exit('1');
        }

        $User = M("user"); // 实例化User对象
        $new_where['username']=$_POST['username'];
        $new_count = $User->where($new_where)->count();
        $new_where_m['mobile']=$_POST['mobile'];
        $new_count_m = $User->where($new_where_m)->count();
        if($new_count) {
            //$this->error(L('用户名已经被注册!'),'/index.php/Registered/');
            exit('2');
        }
        if($new_count_m) {
            //$this->error(L('手机号已经被注册!'),'/index.php/Registered/');
            exit('3');
        }
		//echo $_POST['cmobile'];exit;
		if($_POST['cmobile']!=$_SESSION['ssccddoo'] || !$_SESSION['ssccddoo']) {
            //$this->error(L('手机验证码不正确！'));
            exit('4');
        }
		
        if(empty($username) || empty($password) || empty($mobile)){
           //$this->error(L('信息填写不完整！'));
		   exit('5');
        }
		if($this->member_config['member_login_verify'] && md5($verifyCode) != $_SESSION['verify']){
           //$this->error(L('error_verify'));
		   exit('6');
        }
		$status = $this->member_config['member_registecheck'] ? 0 : 1;
		if($this->member_config['member_emailcheck']){ $status = 1; $groupid=5 ;}
		$groupid = $groupid ? $groupid : 3;
		$data=array();
		$data['username']= $username;
		$data['mobile']=$mobile;
		$data['groupid']=3;
		$data['login_count']=1;
		$data['createtime']=time();
		$data['updatetime']=time();
		$data['last_logintime']=time();
		$data['reg_ip']=get_client_ip();
		$data['status']=1;
		$authInfo['password'] = $data['password'] = sysmd5($password);
		 
		if($r=$this->dao->create($data)){
			if(false!==$this->dao->add()){
				$authInfo['id'] = $uid=$this->dao->getLastInsID();
				$authInfo['groupid'] = $ru['role_id']=$data['groupid'];
				$ru['user_id']=$uid;
				$roleuser=M('RoleUser');
				$roleuser->add($ru);
                /*
				if($this->member_config['member_emailcheck']){
					$gzphp_auth = authcode($uid."-".$username."-".$email, 'ENCODE',$this->sysConfig['ADMIN_ACCESS'],3600*24*3);//3天有效期
					$url = 'http://'.$_SERVER['HTTP_HOST'].U('User-Login/regcheckemail?code='.$gzphp_auth);
					$click = "<a href=\"$url\" target=\"_blank\">".L('CLICK_THIS')."</a>";
					$message = str_replace(array('{click}','{url}','{sitename}'),array($click,$url,$this->Config['site_name']),$this->member_config['member_emailchecktpl']);
					$r = sendmail($email,L('USER_REGISTER_CHECKEMAIL').'-'.$this->Config['site_name'],$message,$this->Config);
					$this->assign('send_ok',1);
					$this->assign('username',$username);
					$this->assign('email',$email);
					$this->display('Login:emailcheck');
					exit;
				}
                */
				
				$gzphp_auth_key = sysmd5($this->sysConfig['ADMIN_ACCESS'].$_SERVER['HTTP_USER_AGENT']);
				$gzphp_auth = authcode($authInfo['id']."-".$authInfo['groupid']."-".$authInfo['password'], 'ENCODE', $gzphp_auth_key);
				

				$authInfo['username'] = $data['username'];
				//$authInfo['email'] = $data['email'];
				cookie('auth',$gzphp_auth,$cookietime);
				cookie('username',$authInfo['username'],$cookietime);
				cookie('groupid',$authInfo['groupid'],$cookietime);
				cookie('userid',$authInfo['id'],$cookietime);
				//cookie('email',$authInfo['email'],$cookietime);

				$this->assign('jumpUrl',$this->forward);
				//$this->success(L('reg_ok'),'/index.php?g=Home&m=User&a=index');
				
				$_SESSION['mobile']='';
				$_SESSION['ssccddoo']='';
				$_SESSION['verify']='';
				
				exit('7');
			}else{
				$this->error(L('reg_error'));
			}
		}else{
			$this->error($this->dao->getError());
		}
 
	}


	function checkEmail(){
        $email=$_GET['email'];
		$userid=intval($_GET['userid']);
		if(empty($userid)){
			if($this->dao->getByEmail($email)){
				 echo 'false';
			}else{
				echo 'true';
			}
		}else{
			//判断邮箱是否已经使用
			if($this->dao->where("id!={$userid} and email='{$email}'")->find()){
				 echo 'false';
			}else{
				echo 'true';
			}
		}
        exit;
	}

	function checkusername(){
		$username=$_GET['username'];
		if($this->dao->getByUsername($username)){
				 echo 'false';
			}else{
				echo 'true';
		}
		exit;
	}
}
?>