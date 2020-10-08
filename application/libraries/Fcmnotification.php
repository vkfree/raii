<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Fcmnotification
{
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->model('admin/Custom_model','custom_model');
        date_default_timezone_set('Asia/Kuwait');
    }

	function send_fcm_message_api($user_id,$msg,$title='',$to_id='',$fname='',$click_action='')
	{
	    // $check = User::where('id', $user_id)->get();
        // get user id
        $check = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$user_id));

	    if(isset($check[0]['id']) && !empty($check[0]['fcm_no']))
	    {
	    	$fcmno = $check[0]['fcm_no'];
			$firebase = new Firebase();
		    $push = new Push();
		    $push->setTitle($title);
		    $push->setMessage($msg);
		    $push->setoid($to_id);
		    $push->setfname($fname);
		    $push->setUser($user_id);
		    $json = $push->getPush();
		    
		    $push->setClick_action($click_action);
		    
		    $notification = $push->getPush1();
		    // $query = mysqli_query($conn,"SELECT iosToken FROM user_notify WHERE fcm_no = '$fcmno' AND iosToken !='' ");
		    if($check[0]['source'] == 'IOS')
		    {
		    	$response = $firebase->sendToios($fcmno, $json);
		    	return $response;
			}
			else{
				//$json = json_encode($json);   
			    $response = $firebase->send($fcmno, $json,$notification);
				return $response;
			}
		    
		}
		else{
			return $check;
		}
	} 
    
    
    function send_fcm_message_api_driver($user_id,$msg,$title='',$to_id='',$fname='',$click_action = '')
   {
	    // $check = User::where('id', $user_id)->get();
        // get user id
        $check = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$user_id));

	    if(isset($check[0]['id']) && !empty($check[0]['fcm_no']))
	    {
	    	$fcmno = $check[0]['fcm_no'];
			$firebase = new Firebase1();
		    $push = new Push();
		    $push->setTitle($title);
		    $push->setMessage($msg);
		    $push->setoid($to_id);
		    $push->setfname($fname);
		    $push->setUser($user_id);
		    $json = $push->getPush();
		    
		    $push->setClick_action($click_action);
		    
		    $notification = $push->getPush1();
		    
		    // $query = mysqli_query($conn,"SELECT iosToken FROM user_notify WHERE fcm_no = '$fcmno' AND iosToken !='' ");
		    if($check[0]['source'] == 'IOS')
		    {
		    	$response = $firebase->sendToios($fcmno, $json);
		    	return $response;
			}
			else{
				//$json = json_encode($json);   
			    $response = $firebase->send($fcmno, $json,$notification);
				return $response;
			}
		    
		}
		else{
			return $check;
		}
	} 
    
    
    public function send_noti_driver_for_booking($user_id,$curr,$confirm_booking_id='') 
    {
         if (!empty($user_id))
        {
            $user_nm = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$user_id));
            $user_name = $user_nm[0]['first_name'];
        
            //echo "<pre>";
            //print_r($curr);
            //print_r($user_name); 
    
            foreach ($curr as $key => $value) 
            {
                $driver_id = $value ->id;
                $this->CI->custom_model->my_update(array("requested_driver" =>$driver_id ),array("id" => $confirm_booking_id),"confirm_booking" );
                //echo "<pre>";
                //print_r($driver_id); 
                
                $booking_details = $this->CI->custom_model->my_where('confirm_booking','*',array('id'=>$confirm_booking_id));
                $booking_details[0]['pick_lat'];
                $booking_details[0]['pick_lng'];
                
                $value = $booking_details[0]['pick_address'];
                $bad_symbols = array(",", ".");
                $value = str_replace($bad_symbols, " ", $value);
                
                // $booking_details[0]['pick_address'];
                
                if (!empty($driver_id))
                {
                    // $fname = $booking_details[0]['pick_lat'].",".$booking_details[0]['pick_lng'];
                    
                    $fname = $booking_details[0]['pick_lat'].",".$booking_details[0]['pick_lng'].",".$value;
                    
                    $to_id = $confirm_booking_id.",".$user_name;
                    $user_id = $driver_id;
                    $click_action = 'MY_ACTION';
                    $message = "Pick up Location - ".$value;
                    $title = "Booking Request";
                    // echo "<pre>"; 
                    // print_r($title);
                    $this->send_fcm_message_api($user_id, $message, $title,$to_id,$fname,$click_action);
                }
            }
            // die;          
        }
    }
    

    public function send_notif_user($user_id,$otp,$booking_id)
    {
         if (!empty($user_id))
        {
            $user_name = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$user_id));
            $user_name1 = $user_name[0]['first_name'];
            
            $booking_details = $this->CI->custom_model->my_where('confirm_booking','*',array('id'=>$booking_id));
            $driver_details = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$booking_details[0]['driver_id']));
            // echo "<pre>";
            // print_r($booking_details);
            // die;
            if (!empty($user_id))
            {
                $user_id = $user_id;
                $message = "Your booking request accepted, you are riding with ".$driver_details[0]['first_name'];
                $title   = "Booking accept";
                $fname   =  $booking_details[0]['id'];
                $to_id   =  $booking_details[0]['driver_id'];
                // print_r($user_id); die;
                $click_action = 'HOME_ACTIVITY_ACTION';
                $this->send_fcm_message_api_driver($user_id, $message, $title,$to_id,$fname,$click_action);
                
            }
        }
    }



    public function send_notif_user_order_cancel($user_id,$booking_id)
    {
        if (!empty($user_id))
        {
            $user_name = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$user_id));
            $user_name1 = $user_name[0]['first_name'];
            $booking_details = $this->CI->custom_model->my_where('confirm_booking','*',array('id'=>$booking_id));

            // echo "<pre>";
            // print_r($user_id);
            // die;            
            if (!empty($user_id))
            {
               $user_id = $user_id;
               $message = "Your booking canceled by ".$user_name1;
               $title  = "Ride cancel";
               $fname =  $booking_id;
               $to_id =  $booking_details[0]['driver_id'];
                // print_r($user_id); die;
               $click_action = 'HOME_ACTIVITY_ACTION';
               $this->send_fcm_message_api_driver($user_id, $message, $title,$to_id,$fname,$click_action);
            }
        }
    }
    

    public function otp_acept_user_send_notify($customer_id,$booking_details)
    {
        if (!empty($customer_id))
        {
            $booking_id = $booking_details[0]['id'];
            // echo "<pre>";
            // print_r($booking_id);
            // die;
            if (!empty($customer_id))
            {
                $user_id = $customer_id;
                $message = "Your ride started";
                $title  = "Ride Started";
                $to_id =  $booking_id;
                // $fname =  $booking_details[0]['id'];
                // $to_id =  $booking_details[0]['driver_id'];
                // print_r($user_id); die;
                $click_action = 'HOME_ACTIVITY_ACTION';
                $this->send_fcm_message_api_driver($user_id, $message, $title,$to_id,$click_action);
                
            }
        }
    }

    
    
    
    public function total_order_bill_send_user($total_bill,$booking_user,$booking_id)
    {
        // echo "<br>";
        // print_r($total_bill);
        // echo "<br>";
        // print_r($booking_user);echo "<br>";

        if (!empty($total_bill) && !empty($total_bill))
        {
            $booking_user_list = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$booking_user));
            $fname = $booking_user_list[0]['first_name']; 

            $user_id = $booking_user;
            $message = "Hello ".$fname." your fare ".$total_bill." for booking ".$booking_id ; 
            $title  = "Invoice";
            $to_id =  $booking_id;
            // print_r($message);
            $click_action = 'HOME_ACTIVITY_ACTION';
            
            if (!empty($user_id))
            {
                $this->send_fcm_message_api_driver($user_id, $message, $title,$to_id,$fname,$click_action);
                
            }
        }
    }
    
    public function send_noti_driver_for_booking_cancel($booking_id)
    {
        if (!empty($booking_id))
        {            
            $booking_details = $this->CI->custom_model->my_where('confirm_booking','*',array('id'=>$booking_id));

            $driver_details = $this->CI->custom_model->my_where('admin_users','*',array('id'=>$booking_details[0]['driver_id']));
            $driver_id = $driver_details[0]['id'];
            // echo "<pre>";
            // print_r($booking_details);
            // die;
            if (!empty($driver_id))
            {
                $user_id = $driver_id;
                $message = "Your order ".$booking_id." is canceled by user" ;
                $to_id  = $booking_id;
                $title  = "Booking Cancel by User";
                // print_r($user_id); die;
                $click_action = 'BOOKING_CANCEL_ACTION';
                
               $this->send_fcm_message_api($user_id, $message, $title ,$to_id,$click_action);
                
            }
        }
    }
    
    
    
     public function send_notif_from_backend_to_user($type , $message ,$title)
    {
        if (!empty($type) && !empty($message) && !empty($title))
        {
            // print_r($type); die;
            $users = $this->CI->custom_model->my_where('admin_users','*',array('type' => 'user'));
            if (!empty($users))
            {
                foreach ($users as $key => $value)
                {
                    $user_id = $value['id'];
                    $message    = $message;
                    $title      = $title;
                    $this->send_fcm_message_api_driver($user_id, $message, $title);
                }
            }
        }
    }

    public function send_notif_from_backend_to_driver($type , $message ,$title)
    {
        if (!empty($type) && !empty($message) && !empty($title))
        {
            // print_r($type); die;
            $users = $this->CI->custom_model->my_where('admin_users','*',array('type' => 'driver'));
            if (!empty($users))
            {
                foreach ($users as $key => $value)
                {
                    $user_id    = $value['id'];
                    $message    = $message;
                    $title      = $title;
                    $this->send_fcm_message_api($user_id, $message, $title);
                }
            }
        }
    }
    
    
    public function send_notif_from_backend_to_first_time_order_user($type , $message ,$title)
    {
        if (!empty($type) && !empty($message) && !empty($title))
        {
            // print_r($type); die;
           $response = $this->CI->custom_model->get_data_array("SELECT COUNT(a.id) as order_count, a.id,a.first_name,a.phone,a.email,a.logo,a.type FROM `admin_users` as a left join confirm_booking as b on a.id = b.user_id  where a.type = 'user'  AND b.status='complete' group by a.id HAVING COUNT(order_count) < 2 order by order_count DESC");
           
            
            if (!empty($response))
            {
                foreach ($response as $key => $value)
                {
                    $user_id    = $value['id'];
                    $message    = $message;
                    $title      = $title;
                    $this->send_fcm_message_api_driver($user_id, $message, $title);
                }
            }
        }
    }

    public function send_notif_from_backend_to_first_time_order_driver($type , $message ,$title)
    {
        if (!empty($type) && !empty($message) && !empty($title))
        {
            // print_r($type); die;
           $response =$this->CI->custom_model->get_data_array("SELECT COUNT(a.id) as order_count, a.id,a.first_name,a.phone,a.email,a.logo,a.type FROM `admin_users` as a left join confirm_booking as b on a.id = b.driver_id  where a.type = 'driver'  AND b.status='complete' group by a.id HAVING COUNT(order_count) < 2 order by order_count DESC");
           
            // print_r($response); die;

            if (!empty($response))
            {
                foreach ($response as $key => $value)
                {
                    $user_id    = $value['id'];
                    // print_r($user_id); 
                    $message    = $message;
                    $title      = $title;
                    $this->send_fcm_message_api($user_id, $message, $title);
                }
                // die;
            }
        }
    }


    public function send_notif_from_backend_to_no_order_user($type , $message ,$title)
    {
        if (!empty($type) && !empty($message) && !empty($title))
        {
            // print_r($type); die;
            $response = $this->CI->custom_model->get_data_array("SELECT admin_users.type,admin_users.id,admin_users.first_name,admin_users.logo ,admin_users.phone ,admin_users.email , admin_users.vehicle FROM admin_users  LEFT JOIN confirm_booking  ON admin_users.id = confirm_booking.user_id  WHERE  admin_users.type = 'user' AND confirm_booking.id is null");
           
            
            if (!empty($response))
            {
                foreach ($response as $key => $value)
                {
                    $user_id    = $value['id'];
                    $message    = $message;
                    $title      = $title;
                    $this->send_fcm_message_api_driver($user_id, $message, $title);
                }
            }
        }
    }

    public function send_notif_from_backend_to_no_order_driver($type , $message ,$title)
    {
        if (!empty($type) && !empty($message) && !empty($title))
        {
            // print_r($type); die;
           $response = $this->CI->custom_model->get_data_array("SELECT admin_users.type,admin_users.id,admin_users.first_name,admin_users.logo ,admin_users.phone ,admin_users.email , admin_users.vehicle FROM admin_users  LEFT JOIN confirm_booking  ON admin_users.id = confirm_booking.user_id  WHERE  admin_users.type = 'driver' AND confirm_booking.id is null");
           
            // print_r($response); die;

            if (!empty($response))
            {
                foreach ($response as $key => $value)
                {
                    $user_id    = $value['id'];
                    // print_r($user_id); 
                    $message    = $message;
                    $title      = $title;
                    $this->send_fcm_message_api($user_id, $message, $title);
                }
                // die;
            }
        }
    }
    
}