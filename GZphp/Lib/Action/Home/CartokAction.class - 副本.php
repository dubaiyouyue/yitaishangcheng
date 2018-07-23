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
class CartokAction extends BaseAction
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
        //获取收货地址
		$User = M("address");
		$where['userid']=$this->_userid;
		$list_address=$User->where($where)->select();
		//dump($list);
		$this->assign('list_address',$list_address);
		//商品清单
		//我的订单
        $User = M("mygw"); // 实例化User对象
        $where_my['uid']=$this->_userid;
		$where_my['ok']=0;
        $list_my=$User->where($where_my)->select();
        //$list_my_id=0;
        foreach($list_my as $k=>$v){
            $list_my_id.=','.$v['sid'];
			$list_my_idd.=','.$v['id'];
        }
        $list_my_id=substr($list_my_id,1);
		$list_my_idd=substr($list_my_idd,1);
		
		//购买成功评价状态
		$_SESSION['list_my_id']=$list_my_idd;
        //echo $list_my_id;exit;





        //获取商品信息
        $where_sp['id']=array('in',$list_my_id);
        $My_rrrpp=M("product");
        $list_my_sspp=$My_rrrpp->where($where_sp)->select();

       // $list_my_sspp[]=$list_my;


        foreach($list_my as $k=>$v){
            foreach($list_my_sspp as $k1=>$v1) {
                if($v['sid']==$v1['id']){
					$v1['price']=explode($v['ys'].'lizhenqiu'.$v['cm'],$v1['kkcc']);
					$v1['price']=explode('lizhenqiu',$v1['price'][1]);
					//dump($v1['price']);exit;
					$v1['price']=$v1['price'][1];
					//exit;
                    $v1['did']=$v['id'];
                    $v1['cm']=$v['cm'];
                    $v1['ys']=$v['ys'];
                    $v1['num']=$v['num'];
					
					
				
					//新库存
					
					//$xin_new_kkcc=$v1['ys'].'lizhenqiu'.$v1['cm'].'lizhenqiu'.$v1['price'].'lizhenqiu';
					
					$new_kkcc_nss=str_ireplace('moweilin','lizhenqiu',$v1['kkcc']);
					//旧库存
					//$old_kkcc_arr=explode('moweilin',$v1['kkcc']);
					//dump($old_kkcc_arr);exit;
					$new_kkcc=explode('lizhenqiu',$new_kkcc_nss);
					//dump($new_kkcc);
					foreach($new_kkcc as $k2=>$v2){
						$ys_id=array_search($v['ys'],$new_kkcc)+1;
						$cm_id=array_search($v['cm'],$new_kkcc);
						$new_kkcc_id=$cm_id+2;
						if($ys_id==$cm_id) $v1['new_kkcc_id']=$new_kkcc[$new_kkcc_id];
						if($v1['num']>$v1['new_kkcc_id'] && $v1['new_kkcc_id']){
							//echo $v1['title'].$v1['ys'].$v1['cm'];
							//echo $v1['new_kkcc_id'];
							$this->error('<style>.showMsg .guery{max-width:452px!important}</style>'.$v1['title'].'/'.$v1['ys'].'/'.$v1['cm'].' 剩余库存'.$v1['new_kkcc_id'].'不足以购买！','/index.php?g=Home&m=Cart&a=index',10);
							exit;
						}
						//新库存
						$v1['xin_num_kkcc']=$v1['new_kkcc_id']-$v1['num'];
					}
					//echo $new_kkcc_id;
					//dump($new_kkcc);
					//exit;
					//$new_kkcc=explode('moweilin',$new_kkcc);
					//echo $new_kkcc[1];
					//echo $v['ys'].'lizhenqiu'.$v['cm'].'lizhenqiu'.$v['price'].'lizhenqiu<br>';
					//header('Content-Type:text/html;charset=utf-8');
					//echo $str_kkcc=$v1['kkcc'];
					//$t1 = mb_strpos($str_kkcc,$v['ys'].'lizhenqiu'.$v['cm'].'lizhenqiu'.$v['price'].'lizhenqiu');
					//$t2 = mb_strpos($str_kkcc,'moweilin');
					//echo $s = mb_substr($str_kkcc,$t1,$t2-$t1).'<br>';
					
					
                    //订单号
                    $v1['ddh']=md5($v['id'].$v['ctime']);
                    $dd_spp=$dd_spp+$v['num'];
                    $dd_spp_jg=$dd_spp_jg+($v1['price']*$v['num']);
                    $v1['ctime']=$v['ctime'];
                    $v1['utime']=$v['utime'];
					
					
					$qdall_id_kkcc.=$v1['id'].'lizhenqiu'.$v1['ys'].'lizhenqiu'.$v1['cm'].'lizhenqiu'.$v1['price'].'lizhenqiu'.$v1['xin_num_kkcc'].'moweilin';
					$qdall_id.=$v1['id'].'lizhenqiu'.$v1['ys'].'lizhenqiu'.$v1['cm'].'lizhenqiu'.$v1['price'].'lizhenqiu'.$v1['num'].'moweilin';
					
					$qdall.='<p>'.$v1['title'].'/'.$v1['ys'].'/'.$v1['cm'].'/'.$v1['num'].'</p>';
                    $list_my[$k]=$v1;
                }
            }
			
		}
		
		$this->assign('list_my',$list_my);
		$this->assign('dd_spp_jg',$dd_spp_jg);
		$this->assign('dd_spp',$dd_spp);
		$new_guanting_c=$this->Config;
		$new_guanting=$new_guanting_c['guanting'];
		$new_zhifubaozhanghu=$new_guanting_c['zhifubaozhanghu'];
		if(!$new_zhifubaozhanghu || ($new_zhifubaozhanghu!=$_SESSION['selef_aaa_zaanff']) || !$_SESSION['selef_aaa_zaanff']) $this->error('支付异常！','/');
		if(!$new_guanting){
			$this->error('网站维护中，请稍后继续支付！','/');
			exit;
		}
		//echo $new_guanting;exit;
		//dump($this->Config);exit;
		$_SESSION['WIDtotal_fee']=$dd_spp_jg;
		$newwwwyffff=$this->Config;
		$wwyyyffff=$this->Config;
		$wwyyyffff=$wwyyyffff['buyyf'];
		$newwwwyffff=$newwwwyffff['buyon'];
		if($_SESSION['WIDtotal_fee']<$newwwwyffff) $_SESSION['WIDtotal_fee']=$_SESSION['WIDtotal_fee']+$wwyyyffff;
		//$_SESSION['WIDtotal_fee']='0.01';
		$_SESSION['qdall']=$qdall;
		//$qdall_id=explode(',',$qdall_id);
			//$arr = array(…………) ;//假设有一万个元素的数组，里面有重复的元素。 
			//$qdall_id = array_flip(array_flip($qdall_id)); //这样便可以删除重复元素。 
		//foreach($qdall_id as $k=>$v){
			//if($new_qdall_id) $new_qdall_id.=','.$v;
			// $new_qdall_id.=$v;
		//}
		$_SESSION['qdall_id']=$qdall_id;
		$_SESSION['qdall_id_kkcc']=$qdall_id_kkcc;
		//echo $qdall_id_kkcc;exit;


        $this->display();
		
	}
	public function ok(){
		//echo $buyon;exit;
		//dump();exit;
		$dz=$_POST['radio'];
		//$dz=preg_replace(" ","",$dz); 
		if(!$_POST['radio']){
			
			if(!$_POST['dz'] || !$_POST['xxdz'] || !$_POST['yb'] || !$_POST['name'] || !$_POST['tel']){
			$this->error('请正确选择或填写新地址！','/index.php?g=Home&m=Cartok&a=index');
			}
			
			else{
				//添加新地址
				$User = M("address");
				$data['userid']=$this->_userid;
				$data['tel']=$_POST['tel'];
				$data['name']=$_POST['name'];
				$data['createtime']=time();
				$data['dz']=$_POST['dz'];
				$data['xxdz']=$_POST['xxdz'];
				$data['yb']=$_POST['yb'];
				
				if($User->add($data)) $newadd='ok';
				
				$dz=$data['name'].$data['tel'].$data['dz'].$data['xxdz'].$data['yb'];
			}
			
			
		}
		//$_POST['radio2']=1;
		if(!$_POST['radio2']){
			$this->error('请选择送货时间！','/index.php?g=Home&m=Cartok&a=index');
			}
			
			
		//保存订单
			if($_POST['kaipmc']) $dz=$dz.'<p>需要发票：'.$_POST['kaipmc'].'</p>';
			$sdata['dz']=$dz;
			
			$sdata['shsj']=$_POST['radio2'];
			$sdata['gmly']=$_POST['gmly'];
			$sdata['spqd']=$_SESSION['qdall'];
			$sdata['qdall_id']=$_SESSION['qdall_id'];
			$sdata['uid']=$this->_userid;
			$User = M("ddgl");
			$ddglok=$User->add($sdata);
			
			$_SESSION['uid']=$this->_userid;
			$_SESSION['mmod']='buy';
			$_SESSION['ddglid']=$ddglok;
			//dump($_POST);
		$this->success('确认订单成功！请付款','/zfb/alipayapi.php');
		
		//$_SESSION['WIDtotal_fee']=$_POST['WIDtotal_fee'];
	}
}
?>