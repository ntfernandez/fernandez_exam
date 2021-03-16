<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class routes_model extends CI_Model {

	function get_all_article(){
		$sql = "SELECT * FROM tbl_article";
		
		$result = $this->db->query($sql );
		return $result->result_array();
	}
	
	function get_an_article($uri){
		$sql = "SELECT  * FROM tbl_article 
			WHERE art_url = '".$uri."'  ;";
		
		$result = $this->db->query($sql );
		return $result->row_array();
	}
	
	function mod_article($id=0){
		$sql = "SELECT  * FROM tbl_article 
			WHERE art_id = '".$id."'  ;";
		
		$result = $this->db->query($sql );
		return $result->row_array();
	}
	
	function save_article($arr){
		$this->db->trans_begin();
		$this->db->insert('tbl_article',$arr);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			return $this->db->insert_id();
		}
	}
	
	function upd_article($id, $arr){
		$this->db->trans_begin();
		$this->db->where($id);
		$this->db->update('tbl_article',$arr);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			return true;
		}
	}
	
	function del_article($id){
		$this->db->trans_begin();
		$this->db->where($id);
		$this->db->delete('tbl_article');
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			return true;
		}
	}

}


?>