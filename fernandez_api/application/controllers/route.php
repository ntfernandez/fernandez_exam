<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Route extends REST_Controller
{
	
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
		$this->load->model('routes_model', 'rm');
    }

	public function article_list_get(){
		$articles = $this->rm->get_all_article();
		$response = array("response"=>array('status' => 1, 'data'=> $articles));	
		$this->response($response, 200); 
	}
	
	public function view_article_post(){
		$uri = $this->request->body;
		$article = $this->rm->get_an_article($uri['art_url']);
		$response = array("response"=>array('status' => 1, 'data'=> $article));
		$this->response($response, 200); 
	}
	
	public function mod_article_post(){
		$data = $this->request->body;
		$article = $this->rm->mod_article($data['art_id']);
		
		$response = array("response"=>array('status' => 1, 'msg'=> 'Data does not exist anymore.'));
		if(is_array($article) AND COUNT($article) > 0){
			$html_eval = "
				$('#art_id').val('".$article['art_id']."');
				$('#art_content').val('".$article['art_content']."');
				$('#art_title').val('".$article['art_title']."');
			";
			$response = array("response"=>array('status' => 0, 'msg'=> 'Data does exist.', 'eval'=> $html_eval));
		}
		
		$this->response($response, 200); 
	}
	
	private function slug_form($str = ""){
		$str = strtolower(strtoupper($str));
		$str = str_replace(" ","-",$str);
		
		return trim($str);
	}
	
	public function save_article_post(){
		$ins = $this->request->body;
		
		$data = array(
			"art_title" => ucwords(trim(strtolower(strtoupper($ins['art_title'])))),
			"art_content" => $ins['art_content'],
			"is_publish" => 1,
			"date_created" => date('Y-m-d H:i:s'),
			"date_updated" => date('Y-m-d H:i:s'),
			
		);
		
		$result = $this->rm->save_article($data);
		if($result !== false){
			$id_arr = array("art_id" => $result);
			$upd_arr = array ("art_url" => $result.'-'.$this->slug_form($ins['art_title']) );
			$this->rm->upd_article($id_arr, $upd_arr);
			$ret_arr = array('status'=> 0, 'msg' => 'Article Saved');
		}
		else{
			$ret_arr = array('status'=> 1, 'msg' => 'Article not saved');
		}

		$response = array("response"=>$ret_arr);
		$this->response($response, 200); 
	}
	
	public function upd_article_post(){
		$upd = $this->request->body;
		$article = $this->rm->mod_article($upd['art_id']);

		if(is_array($article) AND COUNT($article) > 0){
			$id_arr = array("art_id" => $article['art_id']);
			$data = array(
				"art_title" => ucwords(trim(strtolower(strtoupper($upd['art_title'])))),
				"art_content" => $upd['art_content'],
				"date_updated" => date('Y-m-d H:i:s'),
				"art_url" => $article['art_id'].'-'.$this->slug_form($upd['art_title']) 
			);
			$result = $this->rm->upd_article($id_arr, $data);
			if($result !== false){
				$ret_arr = array('status'=> 0, 'msg' => 'Article updated');
			}
			else{
				$ret_arr = array('status'=> 1, 'msg' => 'Article not updated');
			}
		}
		else{
			$ret_arr = array('status'=> 1, 'msg' => 'Article not updated');
		}

		$response = array("response"=>$ret_arr);
		$this->response($response, 200); 
	}
	
	public function publish_article_post(){
		$upd = $this->request->body;
		$article = $this->rm->mod_article($upd['art_id']);

		if(is_array($article) AND COUNT($article) > 0){
			$id_arr = array("art_id" => $article['art_id']);
			$data = array(
				"is_publish" => 0,
				"date_updated" => date('Y-m-d H:i:s'),
			);
			$result = $this->rm->upd_article($id_arr, $data);
			if($result !== false){
				$ret_arr = array('status'=> 0, 'msg' => 'Article published');
			}
			else{
				$ret_arr = array('status'=> 1, 'msg' => 'Article not published');
			}
		}
		else{
			$ret_arr = array('status'=> 1, 'msg' => 'Article not published');
		}

		$response = array("response"=>$ret_arr);
		$this->response($response, 200); 
	}
	
	public function del_article_post(){
		$del = $this->request->body;
		$article = $this->rm->mod_article($del['art_id']);

		if(is_array($article) AND COUNT($article) > 0){
			$id_arr = array("art_id" => $article['art_id']);
			$result = $this->rm->del_article($id_arr);
			if($result !== false){
				$ret_arr = array('status'=> 0, 'msg' => 'Article deleted');
			}
			else{
				$ret_arr = array('status'=> 1, 'msg' => 'Article not deleted');
			}
		}
		else{
			$ret_arr = array('status'=> 1, 'msg' => 'Article not deleted');
		}

		$response = array("response"=>$ret_arr);
		$this->response($response, 200); 
	}
	
}