<?php
//商品类型模型
class TypeModel extends Model{
	//获取所有的商品类型
	public function getTypes(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->db->getAll($sql);
	}

	//分页获取商品类型
	/*
	public function getPageTypes($offset,$limit){
		$sql = "SELECT * FROM {$this->table} LIMIT $offset,$limit";
		return $this->db->getAll($sql);
	}
	*/
	//改进版，统计属性并分页获取
	public function getPageTypes($offset,$limit){
		$sql = "select a.*,count(attr_name) as num from cz_goods_type as a
				left join cz_attribute as b
				on a.type_id = b.type_id group by a.type_id
				limit $offset,$limit";
		return $this->db->getAll($sql);
	}
}