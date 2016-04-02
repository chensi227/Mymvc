<?php
//批量实体转义
/*
array('php','mysql','linux','apache');
 */
function deepspecialchars($data){
	if (empty($data)) {
		return $data;
	}
	//初级程序员的写法
	/*
	if (is_array($data)) {
		//数组
		foreach ($data as $k => $v) {
			$data[$k] = deepspecialchars($v);
		}
		return $data;
	} else {
		//单值
		return htmlspecialchars($data);
	}
	*/
	//中高级程序员的写法
	return is_array($data) ? array_map('deepspecialchars', $data) : htmlspecialchars($data);
}

//批量单引号转义
function deepslashes($data){
	if (empty($data)) {
		return $data;
	}
	return is_array($data) ? array_map('deepslashes', $data) : addslashes($data);
}