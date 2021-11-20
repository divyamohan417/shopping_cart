<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Memento admin_model model
 *
 * This class handles admin_model management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model
 * @author		propertyjar
 * @link		#
 */

class Shopping_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($data=null)
	{
		return $this->db->insert('products',$data);
	}

	function get_all()
	{
		$this->db->select('*');
		return $this->db->get('products')->result();
	}

	function delete($product_id=null)
	{
		$this->db->where('product_id', $product_id);
		return $this->db->delete('products');
	}

	function update($data=null,$product_id=null)
	{
		$this->db->where('product_id', $product_id);
		return $this->db->update('products',$data);
	}

	function get_all_tax()
	{
		$this->db->select('*');
		$this->db->order_by('tax', 'ASC');
		return $this->db->get('tax')->result();
	}

	function save_tax($data=null)
	{
		return $this->db->insert('tax',$data);
	}

	function delete_tax($tax_id=null)
	{
		$this->db->where('tax_id', $tax_id);
		return $this->db->delete('tax');
	}

	function update_tax($data=null,$tax_id=null)
	{
		$this->db->where('tax_id', $tax_id);
		return $this->db->update('tax',$data);
	}

	function get_all_discount()
	{
		$this->db->select('*');
		$this->db->order_by('discount', 'ASC');
		return $this->db->get('discount')->result();
	}

	function save_discount($data=null)
	{
		return $this->db->insert('discount',$data);
	}

	function delete_discount($discount_id=null)
	{
		$this->db->where('discount_id', $discount_id);
		return $this->db->delete('discount');
	}

	function update_discount($data=null,$discount_id=null)
	{
		$this->db->where('discount_id', $discount_id);
		return $this->db->update('discount',$data);
	}

	function save_cart($data=null)
	{
		return $this->db->insert('cart',$data);
	}

	function cart_count()
	{
		$this->db->select('*');
		$this->db->where('order_id', 0);
		return $this->db->get('cart')->num_rows();
	}

	function cart_list($id=null)
	{
		$this->db->select('a.*');
		$this->db->where('a.order_id', 0);
		$this->db->where('a.product_id', $id);
		return $this->db->get('cart a')->row();
		// echo "<pre>"; print_r($this->db->last_query());
	}

	function remove_cart($cart_id=null)
	{
		$this->db->where('cart_id', $cart_id);
		return $this->db->delete('cart');
	}

	function get_all_cart($order_id=null)
	{
		$this->db->select('a.*, b.product, b.price');
		$this->db->join('products b', 'b.product_id = a.product_id');
		if ($order_id) {
			$this->db->where('a.order_id', $order_id);
		} else {
			$this->db->where('a.order_id', 0);
		}
		return $this->db->get('cart a')->result();
	}

	function save_order($data=null)
	{
		$this->db->insert('order_details',$data);
		return $this->db->insert_id();
	}

	function update_cart($order_id=null)
	{
		$this->db->set('order_id', $order_id);
		$this->db->where('order_id', 0);
		return $this->db->update('cart');
	}

	function order_details($order_id=null)
	{
		$this->db->where('id', $order_id);
		return $this->db->get('order_details')->row();
	}

	function get_invoice($temp=null)
	{
		$this->db->order_by('id', 'ASC');
		if ($temp) {
			return $this->db->get('order_details')->num_rows();
		} else {
			return $this->db->get('order_details')->result();
		}
	}

	function get_product($id=null)
	{
		$this->db->select('group_concat(b.product) as prod');
		$this->db->join('products b', 'b.product_id = a.product_id');
		$this->db->where('a.order_id', $id);
		return $this->db->get('cart a')->row();
	}
}