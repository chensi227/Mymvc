<?php
//管理员模型
class AdminModel extends Model{
	//检查用户名和密码
	public function checkUser($username,$password){
		$password = md5($password);
		$sql = "select * from cz_admin 
		        where admin_name = '$username' and password = '$password'
		        limit 1";
		// echo $sql;
		// exit;
		return $this->db->getRow($sql); // 返回一条记录，一维数组
	}

	//获取所有的管理员
	public function getAdmins(){
		$sql = "SELECT * FROM cz_admin";
		return $this->db->getAll($sql);
	}
}