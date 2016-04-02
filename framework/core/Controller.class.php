<?php
//核心控制器 
class Controller {
	//跳转方法
	public function jump($url,$message,$wait = 3){
		if ($wait == 0) {
			//立即跳转
			header("Location:$url");
		} else {
			//直接载入message.html
			include CUR_VIEW_PATH . "message.php";
		}
		//一定要退出
		exit();
	}

	//加载工具类
	public function library($lib) {
		include LIB_PATH . "{$lib}.class.php";
	}

	//加载辅助函数
	public function helper($helper){
		include HELPER_PATH . "{$helper}.php";
	}
}