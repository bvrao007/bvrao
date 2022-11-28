<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {
	
	
function __construct(){
		parent::__construct();
		
	}

function getItems()	{
		$query="SELECT i._id,i.item,ip.item_id,ip.units,ip.price,GROUP_CONCAT('',io.link_itemId) as link_item,io2.item_id as has_offer FROM `items` as i join (SELECT item_id,GROUP_CONCAT('',units) as units,GROUP_CONCAT('',price) as price FROM `item_price` group by item_id)ip on i._id=ip.item_id left join item_offers as io on i._id=io.item_id left join item_offers as io2 on i._id=io2.link_itemId where ip.item_id>0 and i.is_active='1' GROUP by ip.item_id ";
		$products=$this->db->query($query)->result();
		return $products;
		
}
function get_linkitem_offers($id=0,$link_id=0){
		
		$query="SELECT * FROM item_offers where item_id=".$id." and link_itemId=".$link_id;
		$result=$this->db->query($query)->row();
		return $result;
		
	}
}
