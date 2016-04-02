<?php
//核心启动类
class Framework {
	//主方法
	public static function run(){
		//echo "hello,world!";
		self::init();
		self::autoload();
		self::dispatch();
	}
	//初始化方法，路径常量
	private static function init(){
		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT", getcwd() . DS); //根目录
		define('APP_PATH', ROOT . 'application' . DS);
		define('FRAMEWORK_PATH',  ROOT . 'framework' .DS);
		define('PUBLIC_PATH',  ROOT . 'public' .DS);
		define("CORE_PATH", FRAMEWORK_PATH. 'core' .DS);
		define('DB_PATH', FRAMEWORK_PATH .'databases' .DS);
		define('LIB_PATH',  FRAMEWORK_PATH .'libraries' .DS);
		define('HELPER_PATH', FRAMEWORK_PATH . 'helpers' .DS);
		define('CONFIG_PATH', APP_PATH . 'config' .DS) ;
		define('CONTROLLER_PATH', APP_PATH .'controllers' .DS);
		define("MODEL_PATH", APP_PATH . 'models' .DS);
		define("VIEW_PATH", APP_PATH . 'views' .DS);
		define("UPLOAD_PATH", PUBLIC_PATH . "uploads" .DS);
		//获取p、c和a,index.php?p=admin&c=goods&a=insert,GoodsController
		define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : 'admin' );
		define('CONTROLLER', isset($_GET['c']) ? ucfirst($_GET['c']) : 'Index' );
		define('ACTION', isset($_GET['a']) ? $_GET['a'] : 'index' );
		//继续定义当前控制器和视图路径
		define('CUR_CONTROLLER_PATH', CONTROLLER_PATH . PLATFORM .DS);
		define('CUR_VIEW_PATH', VIEW_PATH . PLATFORM .DS);

		//手动加载核心类
		include CORE_PATH . "Controller.class.php";
		include CORE_PATH . "Model.class.php";
		include DB_PATH . "Mysql.class.php";

		
		//载入配置文件
		$GLOBALS['config'] = include CONFIG_PATH . "config.php";

		//开启session
		session_start();
	}
	//实现自动加载
	private static function autoload(){
		spl_autoload_register('self::load');
		//spl_autoload_register(array(__CLASS__,'load'));
	}

	//加载指定的类,只加载application中的controller和model
	//如GoodsController、GoodsModel
	private static function load($classname){
		if (substr($classname, -10) == 'Controller') {
			//控制器
			include CUR_CONTROLLER_PATH . "{$classname}.class.php";
		} elseif (substr($classname, -5) == "Model") {
			//模型
			include MODEL_PATH . "{$classname}.class.php";
		} else {
			//暂空
		}
	}

	//路由分发，说白了，就是实例化对象并调用方法
	//index.php?p=admin&c=goods&a=insert, 实例化GoodsController对象，调用insertAction
	private static function dispatch(){
		//获取类名和方法名
		$controller_name = CONTROLLER . "Controller"; 
		$action_name = ACTION . "Action";
		//实例化对象并调用方法
		$controller = new $controller_name();
		$controller->$action_name();
	}
}