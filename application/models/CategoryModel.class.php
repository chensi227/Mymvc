<?php
//商品分类模型
class CategoryModel extends Model{
	//获取所有的分类
	public function getCats(){
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		return $this->tree($cats);
	}

	//docblockr插件 先写函数，然后在函数的前面写/**，按tab

	/**
	 * [对数组进行重新排序]
	 * @param  array  $arr [要排序的数组 ]
	 * @param  integer $pid [指定的条件，默认0，从顶级开始]
	 * @param  integer $leve [表示层级，默认0，顶级]
	 * @return array       [排序之后的结果]
	 */
	/*
	public function tree($arr,$pid = 0,$level = 0){
		static $res = array();
		foreach ($arr as $v) {
			if ($v['parent_id'] == $pid) {
				//保存当前分类的level
				$v['level'] = $level;
				//说明找到，先保存，然后递归
				$res[] = $v;
				$this->tree($arr,$v['cat_id'],$level+1);
			}
		}
		return $res;
	}*/

	//完美版本
	public function tree($arr,$pid = 0,$level = 0){
		$res = array();
		foreach ($arr as $v) {
			if ($v['parent_id'] == $pid) {
				//保存当前分类的level
				$v['level'] = $level;
				//说明找到，先保存，然后递归
				$res[] = $v;
				$res = array_merge($res,$this->tree($arr,$v['cat_id'],$level+1));
			}
		}
		return $res;
	}

	/**
	 * 获取指定分类的后代的id
	 * @param  integer $cat_id [指定分类id]
	 * @return array         [返回结果,一维数组]
	 */
	public function getSubIds($cat_id){
		$ids = array();
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		$cats = $this->tree($cats,$cat_id) ; //注意，一定要传$cat_id

		foreach ($cats as $v) {
			$ids[] = $v['cat_id'];
		}
		//将自己追加到数组中
		$ids[] = $cat_id;
		return $ids;
	}

	/**
	 * 重组多维嵌套
	 * @param  array  $arr [要处理的数组]
	 * @param  integer $pid [从哪儿开始，默认0，表示所有的]
	 * @return array       [处理的结果]
	 */
	public function child($arr,$pid = 0) {
		$res = array();
		foreach ($arr as $v){
			if ($v['parent_id'] == $pid) {
				//找到了，继续找,就是递归
				$current = $this->child($arr,$v['cat_id']);
				//再保存，作为当前分类的一个元素来保存，元素下标为child
				$v['child'] = $current;
				$res[] = $v;
			}
		}
		return $res;
	}

	//前台获取分类并重组
	public function frontCats(){
		$sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		return $this->child($cats);
	}
}