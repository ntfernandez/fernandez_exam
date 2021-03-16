<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	private $server = 'http://localhost/fernandez_api/route/';
	 
	function __construct()
    {
        // Construct our parent class
        parent::__construct();

    }
	
	public function index(){
		$url = "article_list";
		$type = "GET";
		$params =array();
		$return_data = (array)$this->send_request($url, $type, $params);
		
		if(isset($return_data[0])){
			$art_arr = json_decode($return_data[0]);
			$art_data = $art_arr->data;
			$art_data = (array)$art_data;
		}
		else{
			$art_arr = array();
		}
		
		$page = array("page_view"=> "list_view", "art_data"=>$art_data);
		$this->load->view('main_view',$page);
	}
	
	public function view_article($uri=""){
		$url = "view_article";
		$type = "POST";
		$params =array("art_url" => $uri);
		$return_data = (array)$this->send_request($url, $type, $params);
		
		if(isset($return_data[0])){
			$art_arr = json_decode($return_data[0]);
			$art_data = $art_arr->data;
			$art_data = (array)$art_data;
		}
		else{
			$art_arr = array();
		}
		
		$page = array("page_view"=> "article_view", "art_data"=>$art_data);
		$this->load->view('main_view',$page);
	}
	
	public function modify_article($id=""){
		$url = "mod_article";
		$type = "POST";
		$params =array("art_id" => $this->input->post('id'));
		$return_data = (array)$this->send_request($url, $type, $params);
		
		if(isset($return_data[0])){
			$art_arr = json_decode($return_data[0]);
			$art_data = $art_arr->msg;
			$art_data = (array)$art_data;
		}
		else{
			$art_arr = array('status' => 0, 'msg'=> 'Error on API');
		}
		
		echo json_encode($art_arr);
	}
	
	public function save_article(){
		$url = "save_article";
		$type = "POST";
		$params =$_POST;
		$return_data = $this->send_request($url, $type, $params);
		
		echo $return_data;
	}
	
	public function publish_article(){
		$url = "publish_article";
		$type = "POST";
		$params =$_POST;
		$return_data = $this->send_request($url, $type, $params);
		
		echo $return_data;
	}
	
	public function upd_article(){
		$url = "upd_article";
		$type = "POST";
		$params =$_POST;
		$return_data = $this->send_request($url, $type, $params);
		
		echo $return_data;
	}
	
	public function del_article(){
		$url = "del_article";
		$type = "POST";
		$params =$_POST;
		$return_data = $this->send_request($url, $type, $params);
		
		echo $return_data;
	}
	
	
	private function send_request($url, $type, $params){
		$conf = array(
			CURLOPT_URL => $this->server .$url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 400,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $type,  
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
			)
		);
		

		$curl = curl_init();
		
		curl_setopt_array($curl, $conf);
		
		$result = curl_exec($curl);
		$this->error = curl_error($curl);
		curl_close($curl);

		if ($this->error) {
			$obj = new stdClass;
			$obj->error = $this->error;
			return $obj;
			
		} else {
			
			$result = (array) json_decode($result);	
			$result = (array)$result['response'];
			
			if (isset($result['status'])){
				return json_encode($result);
			}
			else{ 
				return json_encode($result);
			}
		}
	}
}
