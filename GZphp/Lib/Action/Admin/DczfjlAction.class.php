<?php
/**
 * 
 * User(会员管理文件)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class DczfjlAction extends AdminbaseAction {

    public $dao,$usergroup;
	function _initialize()
	{
		parent::_initialize();
		$this->dao = D('Zfjl');
		$this->usergroup=F('Role');
		$this->assign('usergroup',$this->usergroup);
	}


	function index(){
	//echo '21321321';exit;
		import ( '@.ORG.Page' );

		$keyword=$_GET['keyword'];
		$searchtype=$_GET['searchtype'];
		$groupid =intval($_GET['groupid']);

		$this->assign($_GET);
		
		if(!empty($keyword) && !empty($searchtype)){
			$where[$searchtype]=array('like','%'.$keyword.'%');
		}
		if($groupid)$where['groupid']=$groupid;

		$user=$this->dao;
		//$count=$user->where($where)->count();
		//$page=new Page($count,20);
		//$show=$page->show();
		//$this->assign("page",$show);
		$list=$user->field('id,uid,lb,je,ddh,ok')->order('id')->select();
		//dump($list);
		//$this->assign('ulist',$list);
		//$this->display();
		foreach($list as $k=>$v){
			$list[$k]['lb']='充值';
			if($v['lb']==buy) $list[$k]['ok']='购买';
			if($v['ok']==1) $list[$k]['ok']='已付款';
		}
		//unset($v);
		$this->exportexcel($list,array('ID','UID','类别','金额','订单号','交易状态'),'支付记录');
	}


function exportexcel($data=array(),$title=array(),$filename='report'){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");  
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);
            
        }
        echo implode("\n",$data);
    }
}
	function insert(){
		$user=$this->dao;
		$_POST['password'] = sysmd5($_POST['pwd']);
		if($data=$user->create()){
			if(false!==$user->add()){
				$uid=$user->getLastInsID();
				$ru['role_id']=$_POST['groupid'];
				$ru['user_id']=$uid;
				$roleuser=M('RoleUser');
				$roleuser->add($ru);			
				$this->success(L('add_ok'));
			}else{
				$this->error(L('add_error'));
			}
		}else{
			$this->error($user->getError());
		}
	}

	function update(){
		$user=$this->dao;
		$_POST['password'] = $_POST['pwd'] ? sysmd5($_POST['pwd']) : $_POST['opwd'];
		if(!empty($_POST['id'])){
				if(false!==$user->save($_POST)){
					$ru['user_id']=$_POST['id'];
					$ru['role_id']=$_POST['groupid'];
					$roleuser=M('RoleUser');
					$roleuser->where('user_id='.$_POST['id'])->delete();
					$roleuser->where('user_id='.$_POST['id'])->add($ru);
					$this->success(L('edit_ok'));
				}else{
					$this->error(L('edit_error').$user->getDbError());
				}
		}else{
				$this->error(L('do_error'));
		}
		 
	}
 

	function _before_add(){
		$this->assign('rlist',$this->usergroup);	
	}

	function _before_edit(){
		$this->assign('rlist',$this->usergroup);	
	}


	function delete(){
		$id=$_GET['id'];
		$user=$this->dao;
		if(false!==$user->delete($id)){
			$roleuser=M('RoleUser');
			$roleuser->where('user_id ='.$id)->delete();
			delattach(array('moduleid'=>0,'catid'=>0,'id'=>0,'userid'=>$id));
			$this->success(L('delete_ok'));
		}else{
			$this->error(L('delete_error').$user->getDbError());
		}
	}

	function deleteall(){		
		$ids=$_POST['ids'];
		if(!empty($ids) && is_array($ids)){
			$user=$this->dao;
			$id=implode(',',$ids);
			if(false!==$user->delete($id)){
				$roleuser=M('RoleUser');
				$roleuser->where('user_id in('.$id.')')->delete();
				delattach("moduleid=0 and catid=0 and id=0 and userid in($id)");
				$this->success(L('delete_ok'));
			}else{
				$this->error(L('delete_error'));
			}
		}else{
			$this->error(L('do_empty'));
		}
	}
}
?>