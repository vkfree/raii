<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| Custom Constants (added by CI Bootstrap)
|--------------------------------------------------------------------------
| Constants to be used in both Frontend and other modules
|
*/
if (!(PHP_SAPI === 'cli' OR defined('STDIN')))
{
	// Base URL with directory support
	$protocol = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'])!== 'off') ? 'https' : 'http';
	$base_url = $protocol.'://'.$_SERVER['HTTP_HOST'];
	$base_url.= dirname($_SERVER['SCRIPT_NAME']);
	define('BASE_URL', $base_url);
	
	// For API prefix in Swagger annotation (/application/modules/api/swagger/info.php)
	define('API_PROTOCOL', $protocol);
	define('API_HOST', $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
}

define('CI_BOOTSTRAP_REPO',			'#');
define('CI_BOOTSTRAP_VERSION',		'Build 2017');	// will follow semantic version (e.g. v1.x.x) after first stable launch

// Upload paths
define('ASSETS_PATH', $_SERVER['DOCUMENT_ROOT'].'/assets/' );

define('UPLOAD_BLOG_POST',		'/assets/admin/usersdata/');

define("CI_CURRENCY_SYMBOL", "KD");
define("CI_CURRENCY_CODE", "KD");
define("STORE_TYPE", "KWT");
define("BRANCH_ID", "8");

function get_store_type(){
// 	return array( "store_type" => STORE_TYPE );
return array( );
}

function store_push($a){
// return array_merge($a,get_store_type());
return $a;

}
function get_percentage($sale_price,$price){
	if($price  > $sale_price ){
		return round( ( ( $price - $sale_price ) / $price ) * 100 );
	}else{
		return 0;
	}
	
}

function ordernotification($title,$shipping,$orderitems,$orderfooter){
	$template = '<table cellspacing="15" cellpadding="0" width="100%" style="font:15px/20px Arial,sans-serif;color:#000000;border-collapse:separate;">
            <tr>
                <td>'.$title.'</td>
            </tr>
            <tr>
                <td>
                <h3>Address</h3>
                <p class="text">'.$shipping.'</p>
                </td>
            </tr>
            <tr>
                <td>
                <h2 >Order Details</h2>
                <table class="td" cellspacing="0" cellpadding="6" style="width:  100%;border: 1px solid; text-align:  left;">
                	<thead>
                		<tr style="    background:  #cdcdcd;    border:  1px solid black;">
                			<th>Product Name</th>
                			<th>Quantity</th>
                			<th>Price</th>
                		</tr>
                	</thead>
                	<tbody>
                		'.$orderitems.'
                	</tbody>
                	<tfoot>
                		'.$orderfooter.'
                	</tfoot>
                </table>
                </td>
            </tr>
        </table>';
	return $template;
}

function send_email($emails,$subject,$message,$includes = true){
	if(!empty($message)){
		if($includes){
			$header = email_header();
			$footer = email_footer();
			$message = $header.$message.$footer;
		}
		
		$headers = "From: admin@appristine.in\r\n";
        $headers .= "Reply-To: admin@appristine.in\r\n";
        $headers .= "CC: admin@appristine.in\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
		
		return @mail($emails, $subject, $message, $headers);
	}
}

function email_header(){

	$template = '<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">
               <div style="max-width: 800px;float: none;margin: 0px auto;border: 1px solid #eee;display:block;font-family: Montserrat, sans-serif;">
               <div class="medsdel" style="background-color: #f16608;padding: 27px;text-align: center;">
                  <img src="'.base_url().'/assets/frontend/img/logo/new_logo.png" class="logo" style="max-width: 300px;width: 100%;margin: 0px auto;">
               </div>
                <div class="" style="padding: 30px 15px;max-width: 650px;margin: 0px auto;">';

	return $template;
}

function email_footer(){

	$template = '</div>

            <div class="sfoot1" style="background-color: rgb(85,86,120);overflow: hidden;padding: 10px 30px;margin-top: -5px;">
               <div class="" style="width: 33%;float: left;box-sizing: border-box;overflow: hidden;margin-top: 10px;">
                  <h4 style="color:#fff;font-size:19px;font-size:1.2vw;text-align: left;margin: 0px;padding: 0px;">Call Us</h4>    
                  <a href="tel:1234567890" style="color: #fff;"><h4 style="color: #f16608;font-size:19px;font-size:1.2vw;text-align: left;margin: 0px;">1234567890</h4></a>
               </div>   

               <div class="" style="width: 33%;float: left;box-sizing: border-box;overflow: hidden;margin-top: 10px;">
                  <h4 style="color:#f16608;font-weight: bold;text-align: center;font-size:19px;font-size:1.9vw;margin: 17px;padding: 0px;">Team Khedmah</h4>
               </div>

                  <div class="" style="width: 33%;float: left; box-sizing: border-box;overflow: hidden;">
                   <div class="" style="clear: both;">
                     <a href="" target="_blank"><img src="'.base_url().'/assets/frontend/img/android.png" style="width: 12%;margin-left: 10%;float: right;"></a>
                     <a href="" target="_blank"><img src="'.base_url().'/assets/frontend/img/ios.png" style="width: 12%;float: right;"></a>
               </div>

               <div class="" style="width: 100%;float: right;overflow: hidden;">
                   <h5 style="font-weight: 500;color: #fff;text-align: right;font-size:13px;font-size:0.8vw;padding: 0px;margin: 10px 0px 0px;">Copyright@2018 Khedma.com</h5>
                     <h5 style="font-weight: 500;color: #fff;text-align: right;font-size:13px;font-size:0.8vw;padding: 0px;margin: 5px 0px 0px;"><a href="'.base_url('/home/services').'" target="_blank" style="color:#fff;text-decoration:none;">Services</a> | <a href="'.base_url('/home/contact').'" target="_blank" style="color:#fff;text-decoration:none;"> Contact Us</a></h5>
               </div>
               </div>
            </div>

         </div>';

	return $template;
}

function forgetpass_content($name,$link)
{
	/*$message = "<p style='font-size: 12px;'>Hi $name,</p>
				            <p style='font-size: 12px; color:#696969; margin-top: -15px;'><br/>

				We've received a request to reset your password. If you didn't make the request,
				just ignore this email. Otherwise, you can reset your password using this link.<br/>

				<input type='button' name='button' onclick=\"location.href='$link'\" value='Reset Password' style='margin-left: 104px; margin-top: 20px; width: 100%;padding: 10px 0;background: #9bc03c;border: none;color: #fff;font-size: 14px;text-transform: uppercase;border-radius: 3px;margin: 15px 0 15px 0; cursor: pointer;'>";*/

	$message = "<p style='font-size: 12px;'>Hi $name,</p>
				<br/><p style='font-size: 12px; color:#696969; margin-top: -15px;'>
				We've received a request to reset your password. If you didn't make the request,
				just ignore this email. Otherwise, you can reset your password using this link.</p><br/>
				
			<a href='".$link."' style='margin-left: 104px; margin-top: 20px; width: 100% !important;padding: 10px 0px;background: #3c4043;border: none;color: #fff;font-size: 14px;text-transform: uppercase;text-decoration: none;border-radius: 3px;margin: 15px 0 15px 0; cursor: pointer;clear: both; overflow: hidden;margin: auto;display: inline-block;font-weight: 500;text-align: center;'>Reset Password</a>";
	return $message;
}

/**
 * Encrypt and decrypt
 * @param string $string string to be encrypted/decrypted
 * @param string $action what to do with this? e for encrypt, d for decrypt
 */
function en_de_crypt( $string, $action = 'e' ) {
    $secret_key = 'a1s3er1n5n7m3f3e45o5p9w3k2x3q32x';
    $secret_iv = 'a1snsd5nm3fssddsdgrkjlpdf9llkw22x';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
}

function getLocationInfoByIp(){

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];
    $result  = array('country'=>'', 'city'=>'');
    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
    if($ip_data && $ip_data->geoplugin_countryName != null){
        $result['country'] = $ip_data->geoplugin_countryName;
        $result['country_code'] = $ip_data->geoplugin_countryCode;
        $result['city'] = $ip_data->geoplugin_city;
    }
    return $result;
}

function decnum($number){
	$number = round($number,2);
	return number_format((float)$number, 2, '.', '');
}