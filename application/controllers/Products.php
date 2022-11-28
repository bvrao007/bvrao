<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	
	function __construct(){
		parent::__construct();
		$this->load->model('products_model');
		
	}
	public function index()
	{
		$products=$this->products_model->getItems();
		
		$this->load->view('products/product',array("products"=>$products));
	}

	public function get_linkitem_offers(){
		$id=$_POST['id'];
		$link_id=$_POST['item_id'];
		$data=$this->products_model->get_linkitem_offers($id,$link_id);
		
		echo json_encode(array("result" => "success", "msg" => "Success", "base_units"=>$data->base_units,"item_units" => $data->units,"link_units"=>$data->link_itemUnits,"item_price"=>$data->item_price));
	  exit();
		//var_dump($data);
	}
}
