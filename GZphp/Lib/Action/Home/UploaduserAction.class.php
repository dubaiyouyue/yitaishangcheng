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
class UploaduserAction extends BaseAction
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
        $this->assign('bcid',0);//顶级栏目
        $this->assign('ishome','home');
        //echo '2312121321';
        //exit;
        $this->display();
    }



    public function uploaduser()
    {
        //dump($_POST);exit;
        import("@.ORG.UploadFile");
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 500000 ;// 设置附件上传大小
        $upload->saveRule=$this->_userid;
        $upload->uploadReplace=true;//同名文件覆盖
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath =  './Public/Uploads/';// 设置附件上传目录
        if(!$upload->upload()) {// 上传错误提示错误信息
            //echo '2312222222222222321';exit;
           // $this->ajaxReturn(0,$upload->getErrorMsg(),0);
            $this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
            //echo '2312321';exit;

            $info =  $upload->getUploadFileInfo();

            $User = M("user"); // 实例化User对象
            $new_where['id']=$this->_userid;
            $data_new['pic']=$upload->savePath.$info['0']['savename'];

            $User->where($new_where)->save($data_new);

            $this->success('上传成功头像！','/index.php?g=Home&m=User&a=index');


        }

        //dump($info);
        //exit;

    }



}
?>