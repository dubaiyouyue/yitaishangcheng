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
class CartAction extends BaseAction
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
        if($_GET['cm'] && $_GET['ys'] && $_GET['sid'])
        {
            $cm=$_GET['cm'];
            $ys=$_GET['ys'];
            $sid=$_GET['sid']+0;
            $User = M("mygw"); // 实例化User对象
            $new_where['cm']=$cm;
            $new_where['ys']=$ys;
			$new_where['ok']=0;
			//$new_where['kkcc']=array('like',$ys.'lizhenqiu'.$cm.'%');
            $new_where['sid']=$sid;

            $new_where['uid']=$this->_userid;
            //dump($new_where);exit;
           $new_count = $User->where($new_where)->count();
		   //echo $new_count;exit;
            //$data['num']='112';
            $data['utime']=time();
           // exit;
            if($new_count){
                //添加更新购物
                //echo '23132132';exit;
                if($_GET['addd']=='ok') $data['num']=array('exp','num+1');
                //dump($data);exit;
                $User->where($new_where)->save($data);
            }
            else{
                //新增加订单
                $new_where['num']=1;
                $new_where['ctime']=time();
                //echo '23132132';exit;
                $User->add($new_where);
            }
        }


        //删除订单
        if($_GET['del']=='ok'){
            $User = M("mygw"); // 实例化User对象
            $del_www['id']=$_GET['id'];
			$del_www['ok']=0;
            $del_www['uid']=$this->_userid;
            $User->where($del_www)->delete();
        }

        //增加订单数量
        if($_GET['cm']=='cc'){
            $User = M("mygw"); // 实例化User对象
            $c_did=$_GET['id']+0;
            $c_num=$_GET['dm']+0;

            $c_where['id']=$c_did;
            $c_where['uid']=$this->_userid;
            $c_data['num']=$c_num;
            $c_data['utime']=time();
            if($c_did && $c_num){
                $User->where($c_where)->save($c_data);
            }
            /*
            if($c_did && !$c_num){
                $User->where($c_where)->delete();
            }
            */
        }

        //清空购物车
        if($_GET['delall']=='ok'){
            $User = M("mygw"); // 实例化User对象
            $c_where['uid']=$this->_userid;
			$c_where['ok']=0;
            $User->where($c_where)->delete();
        }


        //我的订单
        $User = M("mygw"); // 实例化User对象
        $where_my['uid']=$this->_userid;
		if(ACTION_NAME!='my') $where_my['ok']=0;
        $list_my=$User->where($where_my)->order('id desc')->select();
        //$list_my_id=0;
        foreach($list_my as $k=>$v){
            $list_my_id.=','.$v['sid'];
        }
        $list_my_id=substr($list_my_id,1);
        //echo $list_my_id;exit;





        //获取商品信息
        $where_sp['id']=array('in',$list_my_id);
        $My_rrrpp=M("product");
        $list_my_sspp=$My_rrrpp->where($where_sp)->select();
		//dump();
		$xl_new_url_gerrr=explode('/',$list_my_sspp[0]['url']);
		$xl_new_url_gerrr='/'.$xl_new_url_gerrr[1].'/'.$xl_new_url_gerrr[2].'/'.$xl_new_url_gerrr[3].'/';
		$this->assign('nsfdsfdsfsss',$xl_new_url_gerrr);
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
                    //订单号
					$v1['ddh']=$v['ddh'];
                    //$v1['ddh']=md5($v['id'].$v['ctime']);
                    $dd_spp=$dd_spp+$v['num'];
                    $dd_spp_jg=$dd_spp_jg+($v1['price']*$v['num']);
                    $v1['ctime']=$v['ctime'];
                    $v1['utime']=$v['utime'];
					$v1['ok']=$v['ok'];
					$v1['ypj']=$v['ypj'];
                    $list_my[$k]=$v1;
                }
            }
        }



        //多少件商品
        //$dd_spp=count($list_my);
        $this->assign('dd_spp',$dd_spp);
        $this->assign('dd_spp_jg',$dd_spp_jg);


        $this->assign('list_my_sspp',$list_my_sspp);
        $this->assign('list_my',$list_my);

        $this->assign('list_my_new',$list_my_new);

        //dump($list_my);
       // exit;
        //echo '2312121321';
        //exit;
        $this->display();
    }

    public function my()
    {
        $this->assign('list_my',$this->index());
		//dump($list_my);
        //dump($this->index());
        //$this->display();
    }
	
	public function myjeall(){
		//我的订单
        $User = M("mygw"); // 实例化User对象
        $where_my['uid']=$this->_userid;
        $list_my=$User->where($where_my)->select();
        //$list_my_id=0;
        foreach($list_my as $k=>$v){
            $list_my_id.=','.$v['sid'];
        }
        $list_my_id=substr($list_my_id,1);
        //echo $list_my_id;exit;





        //获取商品信息
        $where_sp['id']=array('in',$list_my_id);
        $My_rrrpp=M("product");
        $list_my_sspp=$My_rrrpp->where($where_sp)->select();

       // $list_my_sspp[]=$list_my;


        foreach($list_my as $k=>$v){
            foreach($list_my_sspp as $k1=>$v1) {
                if($v['sid']==$v1['id']){
                    $v1['did']=$v['id'];
                    $v1['cm']=$v['cm'];
                    $v1['ys']=$v['ys'];
                    $v1['num']=$v['num'];
                    //订单号
                    $v1['ddh']=$v['ddh'];
					//md5($v['id'].$v['ctime']);
                    $dd_spp=$dd_spp+$v['num'];
                    $dd_spp_jg=$dd_spp_jg+($v1['price']*$v['num']);
                    $v1['ctime']=$v['ctime'];
                    $v1['utime']=$v['utime'];
                    $list_my[$k]=$v1;
                }
            }
        }
		echo $dd_spp_jg;
	}
}
?>