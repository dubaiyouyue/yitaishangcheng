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

class PayokzhhyeAction extends BaseAction
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
		
		//账户余额购买商品
		//dump($_SESSION);exit;
		if($_SESSION['mmod']=='buy'){
			$User = M("zfjl");
			$where['uid']=$this->_userid;
			$where['ddh']=$_SESSION['out_trade_no'];//$_GET['out_trade_no'];
			//echo $_GET['out_trade_no'];
			$where['ok']='0';
			$ok=$User->where($where)->limit(1)->select();
			//dump($ok);
			//echo $ok[0]['je'];
			if($ok[0]['je']){
				//支付成功
				//更新订单管理
				$User = M("ddgl");
				$ddglwhere['id']=$_SESSION['ddglid'];
				$ddgldata['ddh']=$ok[0]['ddh'];
				$ddgldata['je']=$ok[0]['je'];
				$ddgldata['ok']=1;
				$User->where($ddglwhere)->limit(1)->save($ddgldata);
				
				//获取购买商品id
				$User = M("product");
				$nnnssdfsdfds=explode('moweilin',$_SESSION['qdall_id']);
				
				//获取购买商品最新库存
				$nnnssdfsdfds_kkcc=explode('moweilin',$_SESSION['qdall_id_kkcc']);
				
				foreach($nnnssdfsdfds_kkcc as $k5=>$v5){
				$nwwwww=explode('lizhenqiu',$v5);
				$new_kkcc_nss=str_ireplace($nwwwww[0].'lizhenqiu','',$v5);
				
				$where_sp_up_kkcc['id']=$nwwwww[0];
				$data_sp_up_kkcc['kkcc']=$new_kkcc_nss;
				$User->where($where_sp_up_kkcc)->save($data_sp_up_kkcc);
				}
				
				
				foreach($nnnssdfsdfds as $k4=>$v4){
					$nwwwww=explode('lizhenqiu',$v4);
					if($nwwwww_id) $nwwwww_id.=','.$nwwwww[0];
					else $nwwwww_id.=$nwwwww[0];
				}
				
				$where_sp_up['id']=array('in',$nwwwww_id);
				$data_sp_up['buynum']=array('exp','buynum+1');
				$User->where($where_sp_up)->save($data_sp_up);
				
				//更新支付记录
				$User = M("zfjl");
				$fwhere['id']=$ok[0]['id'];
				$fdata['ok']=1;
				$User->where($fwhere)->limit(1)->save($fdata);
				
				//更新我的购物车
				$User = M("mygw");
				$where_sp['id']=array('in',$_SESSION['list_my_id']);
				$data_sp['ok']=1;
				$data_sp['ddh']=$_SESSION['WIDtotal_fee_dddhhhh'];
				$User->where($where_sp)->save($data_sp);
					$_SESSION['WIDtotal_fee_dddhhhh']='';
					$_SESSION['WIDtotal_fee']='';
					$_SESSION['out_trade_no']='';
					$_SESSION['subject']='';
				$this->success('购买成功！','/index.php?g=Home&m=Cart&a=my');
			}
		}
        //$this->display();
    }
	
}
?>