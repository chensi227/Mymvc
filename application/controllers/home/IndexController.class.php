<?php
//前台首页控制器 
class IndexController extends Controller {
	//载入首页面方法
	public function indexAction(){
		echo '欢迎!';
	}
	
	public function aboutAction(){
	    echo '一个简单的mvc框架!';
	}
}