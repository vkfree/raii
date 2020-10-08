<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Library to search from website or app
*/
class Pdf_create {

	public function __construct()
	{
	// Assign the CodeIgniter super-object
	$this->CI =& get_instance();
	$this->CI->load->model('admin/Custom_model','custom_model');
	date_default_timezone_set('Asia/Kuwait');
	$this->order_datetime = date('Y-m-d H:i:s');
	}

	public function get_print_pdf_list($order_id)
	{
			ob_start();

			$booking = $this->CI->custom_model->my_where('confirm_booking','*',array('id' => $order_id));

			$driver_id = $booking[0]['driver_id'];
			$customer_id = $booking[0]['user_id'];

			$driver_detail = $this->CI->custom_model->my_where('admin_users','*',array('id' => $driver_id));

			$customer_details = $this->CI->custom_model->my_where('admin_users','*',array('id' => $customer_id));

			function getaddress($lat,$lng)
			{
				$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
				$json = @file_get_contents($url);
				$data=json_decode($json);
				$status = $data->status;
				if($status=="OK")
				// return $data->results[0]->formatted_address;
				return $data->results;
				else
				return false;
			}

			if (!empty($customer_details[0]['lat']) && !empty($customer_details[0]['lng'])) 
			  {
			    $lat= $customer_details[0]['lat']; //latitude
			    $lng= $customer_details[0]['lng']; //longitude
			  }
			  else{
			    $lat= 18.5590; //latitude
			    $lng= 73.7868; //longitude
			  }

			  $address= getaddress($lat,$lng);

			// $data = $this->CI->custom_model->my_where('order_master','*',array('order_master_id' => $order_id));
			//print_r($data);
			 
			?>	

			<!DOCTYPE html>
			<html lang="en">

			<head>KHEDMA</head>

			<body>
			<div class="container">
				<table>
					<caption style="font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;">
						Order invoice
					</caption>
					
					<thead>
						<tr>
							<th style="text-align: left;" colspan="3">Name:&nbsp; Girish Bhumkar</th>
							<th>Invoice id:#<?php echo $booking[0]['id']; ?></th>
						</tr>
						<tr>
							<td style="background-color: #f0f0f0; font-weight: bold;" colspan="1">
								<p>Address:</p>
								<p>Mobile no:</p>
								<p>Email:</p>
								<p>Country:</p>
							</td>
							<td colspan="3">
								<p><?php print_r($address[0]->formatted_address) ; ?></p>
					            <p><?php echo $customer_details[0]['phone']; ?></p>
					            <p><?php echo $customer_details[0]['email']; ?></p>
					            <p><?php echo $address[5]->formatted_address; ?></p>
							</td>
						</tr>
					</thead>

					<tbody>

						<tr>
							<th>Pick Up time</th>
							<th>Distance</th>
							<th>Vehicle Type</th>
							<th>Vehicle Rate</th>
						</tr>
						
			                                              
						<tr>
							<td><?php $date = date('F j, Y, g:i a', strtotime($booking[0]['user_booking_time'])); ?>
					          <?php echo $date; ?>
					          </td>
							<td><?php echo $booking[0]['actual_distance']; ?> KM</td>
							<td><?php echo $booking[0]['vehicle']; ?></td>
							<td><?php echo $booking[0]['rate']; ?> SAR / KM</td>
						</tr>
						
						<tr>
							<th colspan="4">Address</th>
							<!-- <td>110.00</td> -->
						</tr>
						<tr> 
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="1">Pick Up Address</th>
							<td colspan="3"><?php echo $booking[0]['pick_address']; ?></td>	
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="1">Drop Up Address</th>
							<td colspan="3"><?php echo $booking[0]['drop_address']; ?></td>
						</tr>

							
						<tr>
							<th colspan="4">Billing Details</th>
							<!-- <td>110.00</td> -->
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">Payment Mode</th>
							<td colspan="2">
								<?php if (!empty( $booking[0]['payment_mode'])): ?>
									<?php echo $booking[0]['payment_mode']; ?>
								<?php endif ?>
								<?php if (empty( $booking[0]['payment_mode'])): ?>
									COD
								<?php endif ?>
							</td>	
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">Payment Status</th>
							<td colspan="2">
								<?php if (!empty( $booking[0]['payment_status'])): ?>
									<?php echo $booking[0]['payment_status']; ?>
								<?php endif ?>
								<?php if (empty( $booking[0]['payment_status'])): ?>
									COMPLETE
								<?php endif ?>
							</td>	
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">Wallet Amount</th>
							<td colspan="2"><?php echo $booking[0]['wallet_amount']; ?></td>
						</tr>
						<!-- <tr>
							<th colspan="4"> Order Invoice <p style="font-size: 15px;">(Tax is included in product price)</p></th>
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">vendor Net</th>
							<td colspan="2">456</td>	
						</tr> -->
					</tbody>

					<tfoot>
						<tr>
							<th colspan="4"> Order Invoice <p style="font-size: 15px;">(Tax is included )</p></th>
						</tr>

						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">Subtotal</th>
							<td colspan="2"><?php echo $booking[0]['price']; ?> SAR</td>	
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">Wallet Amount:</th>
							<td colspan="2"><?php echo $booking[0]['wallet_amount']; ?> SAR</td>	
						</tr>
						<tr>
							<th style="text-align: left;font-family: 'Open Sans', sans-serif;line-height: 1;color: #5b5b5b;" colspan="2">Grand Total(Incl.Tax):</th>
							<td colspan="2"><?php echo $booking[0]['final_price']; ?> SAR</td>	
						</tr>
					</tfoot>
				</table>
			</div>
			</body>

			<style type="text/css">
				body{
					background-color:#333;
					font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
					color:#333;
					text-align:left;
					font-size:18px;
					margin:0;
				}
				.container{
					margin:0 auto;
					margin-top:35px;
					padding:40px;
					width:750px;
					height:auto;
					background-color:#fff;
				}
				caption{
					font-size:28px;
					margin-bottom:15px;
				}
				table{
					border:1px solid #333;
					border-collapse:collapse;
					margin:0 auto;
					width:740px;
				}
				td, tr, th{
					padding:12px;
					border:1px solid #333;
					width:185px;
				}
				th{
					background-color: #f0f0f0;
				}
				h4, p{
					margin:0px;
				}
			</style>

			</html>

			<?php
			$html = ob_get_clean();
			?>
				
			<?php
			    $file_name .= "invoice_".$order_id.".pdf";
		        require_once('vendor/autoload.php');
			  	$mpdf = new \Mpdf\Mpdf();
		        $mpdf->WriteHTML($html);
    		    $mpdf->Output($file_name, 'D');
        }
}			

