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
class LikeAction extends BaseAction
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
		
		
		//我的喜欢
        $User = M("like"); // 实例化User对象
        $where_my['uid']=$this->_userid;
        $list_mya=$User->where($where_my)->select();
        //$list_my_id=0;
        foreach($list_mya as $k=>$v){
            $list_my_id.=','.$v['tid'];
        }
        $list_my_id=substr($list_my_id,1);
		
		//我的订单
        $User = M("product"); // 实例化User对象
        //$where_my['uid']=$this->_userid;
		$where_my['id']=array('in',$list_my_id);
        $list_my=$User->where($where_my)->select();
        //$list_my_id=0;
        //dump($list_my);
		$this->assign('list_my',$list_my);
		
		$this->display();
    }
	
	public function del()
    {
        if(!$this->_userid){
            $this->error(L('请登录！'),'/index.php/login/');
        }
		$User = M("like"); // 实例化User对象
		$del_www['tid']=$_GET['id'];
		$del_www['uid']=$this->_userid;
		$User->where($del_www)->delete();
	}
	
	public function add()
    {
        if(!$this->_userid){
            $this->error(L('请登录！'),'/index.php/login/');
        }
		
		$User = M("like"); // 实例化User对象
		
        $where_my['uid']=$this->_userid;
		$where_my['tid']=$_GET['id'];
        $list_mya=$User->where($where_my)->count();
		if($list_mya) 
			{
			echo '1';
			exit();
			
			}
		
		
		$del_www['tid']=$_GET['id'];
		$del_www['uid']=$this->_userid;
		//$del_www['uid']=$this->_userid;
		if(!$list_mya) $likeadd=$User->add($del_www);
		if($likeadd){
			$User = M("product");
			$where['id']=$_GET['id'];
			$data['likenum']=array('exp','likenum+1');
			$likeup=$User->where($where)->save($data);
			if($likeup) {
			echo '2';
			exit();
			}
		}
	}

}
?>