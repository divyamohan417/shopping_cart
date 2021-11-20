<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./mpdf/mpdf.php');

class Shopping extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("shopping_model");
	}

	public function index()
	{
		$data['list'] = $this->shopping_model->get_all();
		$data['cart_cnt'] = $this->shopping_model->cart_count();
		$data['invoice'] = $this->shopping_model->get_invoice(1);
		
		$this->load->view('header.php');
		$this->load->view('products.php', $data);
		$this->load->view('footer.php');
	}

	function product()
	{
		$data['list'] = $this->shopping_model->get_all();
		// echo "<pre>"; print_r($data); exit;
		$this->load->view('header.php');
		$this->load->view('shopping_cart.php', $data);
		$this->load->view('footer.php');
	}

	function save_product()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('product', 'Product', 'required|alpha_numeric_spaces');
	        $this->form_validation->set_rules('price', 'Price','required|numeric');
	        $this->form_validation->set_rules('status', 'Status','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$data = array(
	        		'product' => $this->input->post('product'),
	        		'price' => $this->input->post('price'),
	        		// 'tax' => $this->input->post('tax'),
	        		'status' => $this->input->post('status')
	        	);
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->save($data);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function delete_product()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('id', 'Product ID', 'required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$product_id = $this->input->post('id');
	        	$this->db->trans_start();
	        		$this->shopping_model->delete($product_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '2'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function edit_product()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('product', 'Product', 'required|alpha_numeric_spaces');
	        $this->form_validation->set_rules('price', 'Price','required|numeric');
	        $this->form_validation->set_rules('status', 'Status','required|numeric');
	        $this->form_validation->set_rules('product_id', 'Product ID','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$product_id = $this->input->post('product_id');
	        	$data = array(
	        		'product' => $this->input->post('product'),
	        		'price' => $this->input->post('price'),
	        		'status' => $this->input->post('status')
	        	);
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->update($data,$product_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function tax()
	{
		$data['list'] = $this->shopping_model->get_all_tax();
		// echo "<pre>"; print_r($data); exit;
		$this->load->view('header.php');
		$this->load->view('tax.php', $data);
		$this->load->view('footer.php');
	}

	function save_tax()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('tax', 'Tax','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$data['tax'] = $this->input->post('tax');
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->save_tax($data);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function delete_tax()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('id', 'Tax ID', 'required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$tax_id = $this->input->post('id');
	        	$this->db->trans_start();
	        		$this->shopping_model->delete_tax($tax_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '2'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function edit_tax()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('tax', 'Tax', 'required|numeric');
	        $this->form_validation->set_rules('tax_id', 'Tax ID','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$tax_id = $this->input->post('tax_id');
	        	$data['tax'] = $this->input->post('tax');
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->update_tax($data,$tax_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function discount()
	{
		$data['list'] = $this->shopping_model->get_all_discount();
		// echo "<pre>"; print_r($data); exit;
		$this->load->view('header.php');
		$this->load->view('discount.php', $data);
		$this->load->view('footer.php');
	}

	function save_discount()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('discount', 'Discount','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$data['discount'] = $this->input->post('discount');
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->save_discount($data);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function delete_discount()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('id', 'Discount ID', 'required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$discount_id = $this->input->post('id');
	        	$this->db->trans_start();
	        		$this->shopping_model->delete_discount($discount_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '2'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function edit_discount()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('discount', 'Discount', 'required|numeric');
	        $this->form_validation->set_rules('discount_id', 'Discount ID','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$discount_id = $this->input->post('discount_id');
	        	$data['discount'] = $this->input->post('discount');
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->update_discount($data,$discount_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function add_to_cart()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('product_id', 'Product ID','required|numeric');
	        $this->form_validation->set_rules('quantity', 'Quantity','required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$data['product_id'] = $this->input->post('product_id');
	        	$data['quantity'] = $this->input->post('quantity');
	        	// echo "<pre>"; print_r($data); exit;
	        	$this->db->trans_start();
	        		$this->shopping_model->save_cart($data);
	        		$details = $this->shopping_model->cart_count();
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1', 'valid' => $details));
	        	} else {
	        		echo json_encode(array('value' => '3'));
	        	}
	        }
	    }
	}

	function remove_cart()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
	        $this->form_validation->set_rules('cartid', 'Cart ID', 'required|numeric');

	        if ($this->form_validation->run()==TRUE)
	        {
	        	$cart_id = $this->input->post('cartid');
	        	$this->db->trans_start();
	        		$this->shopping_model->remove_cart($cart_id);
	        	if ($this->db->trans_complete()) {
	        		echo json_encode(array('value' => '1'));
	        	} else {
	        		echo json_encode(array('value' => '2'));
	        	}
	        } else {
	        	echo json_encode(array('value' => '2', 'valid' => $this->form_validation->error_array()));
	        }
	    }
	}

	function view_cart()
	{
		$data['cart_products'] = $this->shopping_model->get_all_cart();
		$data['tax'] = $this->shopping_model->get_all_tax();
		$data['discount'] = $this->shopping_model->get_all_discount();
		// echo "<pre>"; print_r($data['cart_products']); exit;
		$this->load->view('header.php');
		$this->load->view('cart.php', $data);
		$this->load->view('footer.php');
	}

	function clear_cart()
	{
		$this->db->trans_start();
			$this->db->query("DELETE FROM cart WHERE order_id=0");
		if ($this->db->trans_complete()) {
			echo '1';
		} else {
			echo '2';
		}
	}

	function confirm_order()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
      	{
        	$data = array(
        		'without_tax' => $this->input->post('total'),
        		'tax' => $this->input->post('sub_taxx'),
        		'with_tax' => $this->input->post('wtax'),
        		'discount' => $this->input->post('sub_discount'),
        		'total' => $this->input->post('grant_total'),
        		'discount_per' => $this->input->post('discount'),
        		'tax_per' => $this->input->post('tax')
        	);
        	// echo "<pre>"; print_r($data); exit;
        	$this->db->trans_start();
        		$order_id = $this->shopping_model->save_order($data);
        		$this->shopping_model->update_cart($order_id);
        	if ($this->db->trans_complete()) {
        		echo json_encode(array('value' => '1', 'order_id' => $order_id));
        	} else {
        		echo json_encode(array('value' => '2'));
        	}
	    }
	}

	function order_details()
	{
		$data['order_id'] = $this->uri->segment(3);
		$data['cart_products'] = $this->shopping_model->get_all_cart($data['order_id']);
		$data['order_details'] = $this->shopping_model->order_details($data['order_id']);
		// echo "<pre>"; print_r($data); exit;
		$this->load->view('header.php');
		$this->load->view('order.php', $data);
		$this->load->view('footer.php');
	}

	function invoice()
	{
		$order_id = $this->uri->segment(3);
		$cart_products = $this->shopping_model->get_all_cart($order_id);
		$order_details = $this->shopping_model->order_details($order_id);

		$mpdf = new mPDF('',  
			'A4',
			10, 
			'Courier New', 
			15,   
			13,  
			3,    
			16,    
			9,    
			9,     
			'P'
		);

		ob_start(); ?>
			<div class="row">
				<div class="col-sm-12">
					<span><h1>Invoice</h1></span><hr>
				</div>
			</div>
		<?php $header = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML($header);

		ob_start(); ?>
			<div class="row">
				<span><b>{PAGENO} of {nbpg}</b></span>
			</div>
		<?php $footer = ob_get_contents();
		ob_end_clean();

		ob_start(); ?>

			<div class="row">
				<div class="col-sm-12">
					<h4 align="right">Date: <?= date('d-m-Y') ?></h4>
					<div class="card">
						<div class="card-body">
							<table border='1' cellpadding='7px' style="border-collapse: collapse;">
								<thead>
									<tr>
										<th width="10%">Sl No.</th>
										<th width="10%">Product</th>
										<th width="10%">Unit Price </th>
										<th width="10%">Quantity</th>
										<th width="10%">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 1;
									$sub_total = 0;
									foreach ($cart_products as $new) { ?>
										<tr>
											<td align="center"><?= $i; ?></td>
											<td align="center"><?= $new->product ?></td>
											<td align="center"><?= '$'.$new->price ?></td>
											<td align="center"><?= $new->quantity ?></td>
											<td align="center">
												<?php 
												$total = $new->price * $new->quantity;
												$sub_total = $sub_total + ($new->price * $new->quantity);
												echo '$'.$total;
												?>
											</td>
										</tr>
										<?php $i++;
									} ?>

									<tr>
										<th colspan="5"></th>
									</tr>
									<tr>
										<th colspan="4">Subtotal:</th>
										<td align="center">
											<span><?= '$'.$order_details->without_tax ?></span>    
										</td>
									</tr>

									<tr>
										<th colspan="4">Tax (<?= $order_details->tax_per ?>%):</th>
										<td align="center">
											<span><?= '$'.$order_details->tax ?></span>   
										</td>
									</tr>

									<tr>
										<th colspan="4">Subtotal With tax:</th>
										<td align="center">
											<span><?= '$'.$order_details->with_tax ?></span>   
										</td>
									</tr>

									<tr>
										<th colspan="4">Discount (<?= $order_details->discount_per ?>%):</th>
										<td align="center">
											<span><?= '$'.$order_details->discount ?></span>   
										</td>
									</tr>

									<tr>
										<th colspan="4">Grand Total:</th>
										<td align="center">
											<span style="color: red; font-weight: bold;font-size: 1.5em;"><?= '$'.$order_details->total ?></span>  
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		<?php $content = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML($content);
		$mpdf->SetFooter($footer);
		$mpdf->Output();
	}

	function invoice_list()
	{
		$data['invoice'] = $this->shopping_model->get_invoice();
		// echo "<pre>"; print_r($data); exit;
		$this->load->view('header.php');
		$this->load->view('invoice.php', $data);
		$this->load->view('footer.php');
	}
}