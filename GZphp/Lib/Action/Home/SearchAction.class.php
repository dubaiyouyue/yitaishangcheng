<?php
/**
 * 
 * SearchAction.class.php (前台搜索功能)
 *
 * @package      	GZPHP
 * @author          wen QQ:52009619 <admin@resonance.com.cn>
 * @copyright     	Copyright (c) 2008-2011  (http://www.resonance.com.cn)
 * @license         http://www.resonance.com.cn/license.txt
 * @version        	GzPHP企业网站管理系统 v2.1 2011-03-01 resonance.com.cn $
 */
if(!defined("GZPHP")) exit("Access Denied");
class SearchAction extends BaseAction
{

	function _initialize()
    {	
		parent::_initialize();
    }

    public function index()
    {
		$keyword=$_GET['keyword'];
		//$field =  $this->module[$cat['moduleid']]['listfields'];
		$field='id,catid,url,title,createtime';
		$p=$_GET['p']+0;
		$p=($p>0)?$p:1;
		$pm=120;//每页多少
		$pl=($p-1)*$pm;
		$ps=$p*$pm;
		$limit=$pl.','.$pm;
		if($keyword){
			//文章
			$User = M("article"); // 实例化User对象
			$where=' keywords like \'%'.$keyword.'%\' ';
			$where.='or title like \'%'.$keyword.'%\' ';
			$list_a=$User->field($field)->where($where)->select();
			//$list_my_id=0;
			//dump($list);exit;
			//产品
			$User = M("product"); // 实例化User对象
			$list_p=$User->field($field)->where($where)->select();
			if(!empty($list_a) && !empty($list_p)) $list=array_merge($list_a,$list_p);
			else{
				$list=empty($list_a)?$list_p:$list_a;
				$list=empty($list_p)?$list_a:$list_p;
			}
			//dump($list_a);
			$ddfdccc=count($list);
			if($pm<$ddfdccc){
			foreach($list as $k=>$v){
				if($k>=$pl && $k<$ps){
					$newlist[]=$v;
				}
			}}
			else $newlist=$list;
		}
		if($pm>$ddfdccc) $totalPage=1;
		else $totalPage=ceil($ddfdccc%$pm);
		$this->assign('totalPage',$totalPage);
		$this->assign('list',$newlist);
		$this->display();
    } 
}
?>