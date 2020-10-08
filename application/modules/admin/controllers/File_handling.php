<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_handling extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('form_builder');
		$this->load->model('custom_model');
	}

	/*file upload code*/
	public function uploadFiless()
	{   
		// echo "a.png";die();

		if(isset($_FILES["file"]["type"]))
		{
			$details = $this->input->post();
			$path = $details['path'];
			// print_r($path);die;
			$FILES = $_FILES["file"];
			// $url =  dirname(__FILE__);
			$upload_dir =  ASSETS_PATH.$path;
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			// echo $upload_dir;
// print_r($_SERVER);die;
			$newFileName = md5(time());
			$target_file = $upload_dir . basename($FILES["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$newFileName = $newFileName.".".$imageFileType;
			$target_file = $upload_dir.$newFileName;
// echo $target_file;
			
			list($width, $height, $type, $attr)= getimagesize($FILES["tmp_name"]);
			$type1 = $FILES['type'];  

			if ( ( ($type1 == "image/gif") || ($type1 == "image/jpeg") || ($type1 == "image/jpg") || ($type1 == "image/png") ) /*&& ($FILES["size"] < 50939 ) && ($width < 200) && ($height < 200 ) && ($width > 40) && ($height > 40 )*/  )
			{ 

				if (move_uploaded_file($FILES["tmp_name"], $target_file)) 
				{
					$post_data = array('name' => $newFileName,
										'path' => $path,
										'note' => 'admin',
										'user_id' => $this->mUser->id);

					$img_id = $this->custom_model->my_insert($post_data,'image_master');
					$this->makeThumbnails($upload_dir.'thumbnails/',$newFileName,$upload_dir.$newFileName);
					// sub category 
					// $this->makeThumbnails($upload_dir.'thumbnails205/',$newFileName,$upload_dir.$newFileName,205,205);
					if (isset($details['vendor']) && $details['vendor'] == 'true')
					{
						$this->makeThumbnails($upload_dir.'large/',$newFileName,$upload_dir.$newFileName,1273,244);
						$this->makeThumbnails($upload_dir.'medium/',$newFileName,$upload_dir.$newFileName,408,267);
						$this->makeThumbnails($upload_dir.'small/',$newFileName,$upload_dir.$newFileName,180,96);
					}
					
					// sub sub category
					$this->makeThumbnails($upload_dir.'thumbnails205/',$newFileName,$upload_dir.$newFileName,205,205);
					// Product 
					/*$this->makeThumbnails($upload_dir.'thumbnails205/',$newFileName,$upload_dir.$newFileName,205,205);*/
					echo $newFileName;
				}
				else
				{
					echo 'false';
				}
			}
			else
			{ 
				echo 'false';
			}
		}
	}

	public function makeThumbnails($updir,$img,$img_url,$thumbnail_width=50,$thumbnail_height=50)
	{
		if (!file_exists($updir)) {
			@mkdir($updir, 0777, true);
		}
		$myFile = $updir."index.php";
		if (!file_exists($myFile)) {
			$fh = fopen($myFile, 'a');
			fwrite($fh, '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p><hr></body></html>'."\n");
			fclose($fh);
		}
		$arr_image_details = @getimagesize($img_url);
		$original_width = $arr_image_details[0];
		$original_height = $arr_image_details[1];
		if ($original_width > $original_height) {
			$new_width = $thumbnail_width;
			$new_height = intval($original_height * $new_width / $original_width);
		} else {
			$new_height = $thumbnail_height;
			$new_width = @intval($original_width * $new_height / $original_height);
		}
		$dest_x = intval(($thumbnail_width - $new_width) / 2);
		$dest_y = intval(($thumbnail_height - $new_height) / 2);
		if ($arr_image_details[2] == 1) {
		    $imgt = "ImageGIF";
		    $imgcreatefrom = "ImageCreateFromGIF";
		}
		if ($arr_image_details[2] == 2) {
		    $imgt = "ImageJPEG";
		    $imgcreatefrom = "ImageCreateFromJPEG";
		}
		if ($arr_image_details[2] == 3) {
		    $imgcreatefrom = "ImageCreateFromPNG";
		}
		    $imgt = "ImagePNG";
		if ( isset($imgt) ){
		    $old_image = $imgcreatefrom($img_url);
		    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		    //default background is black
		    $bg = imagecolorallocate ( $new_image, 255, 255, 255 );
		    imagefill ( $new_image, 0, 0, $bg );
		    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
		    $imgt($new_image, "$updir"."$img");
		}
	}
}