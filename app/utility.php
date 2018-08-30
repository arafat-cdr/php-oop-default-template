<?php
require_once(__DIR__.'/config.php');

class utility {

	public $base_url = BASEURL;

	public function validation($data) {

  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);

  		return $data;
	}

	public function auto_validate($data) {

		$res = array();

		foreach ($data as $k => $v) {

		  $res[$k] = $this->validation($v);
		}

		return $res;
	}

	public function show_404() {

		$this->redirect("page_404.php");
	}

	public function is_login() {

		if(!empty($_SESSION['login_user_data'])) {

		  if(is_object($_SESSION['login_user_data']) && isset($_SESSION['login_user_data']->id)) {

		  	$user_role = $this->auth_user_data("user_role");

		  	if($user_role == 5) {
		  		if($this->auth_user_data("is_active") != 1) {

		  			$this->redirect("employee_profile_pending.php");
		  		}
		  	}

			$this->redirect("profile.php");

		  }
		}
	}

	public function auth_user_data($data = NULL) {

		if(isset($_SESSION['login_user_data'])) {
		  if(is_object($_SESSION['login_user_data'])) {

		    $data = $_SESSION['login_user_data']->$data;

		    return $data;
		  }
		}

		return NULL;
	}

	public function update_auth_user_data($key = NULL, $value = NULL) {

		if(isset($_SESSION['login_user_data'])) {
		  if(is_object($_SESSION['login_user_data'])) {
		    try {

		        $_SESSION['login_user_data']->$key = $value;
		        return TRUE;
		    } catch (Exception $e) {
		        echo 'Caught exception: ',  $e->getMessage(), "\n";
		    }
		  }
		}

		return FALSE;
	}

	public function is_logout() {

		if(empty($_SESSION['login_user_data'])) {

			$this->redirect("index.php");
		}
	}

	public function logout() {

		session_destroy();
		session_start();

		$this->set_flush(TRUE, "col-md-12", "info", "See you Soon !", "Logout is Successfull.");

		$this->redirect("self");
	}

	public function pr($data = NULL) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

	public function dd($data = NULL) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}

	public function set_flush($is_flush_msg = 0, $grid_class = NUll, $alert_class = NULL, $msg_1 = NULL, $msg_2 = NULL) {

		$_SESSION['is_flush_msg'] =  $is_flush_msg;
		$_SESSION['grid_class']   =  $grid_class;
		$_SESSION['alert_class']  =  $alert_class;
		$_SESSION['msg_1']        =  $msg_1;
		$_SESSION['msg_2']        =  $msg_2;
	}

	public function delete_flush() {

		$_SESSION['is_flush_msg'] =  NULL;
		$_SESSION['grid_class']   =  NULL;
		$_SESSION['alert_class']  =  NULL;
		$_SESSION['msg_1']        =  NULL;
		$_SESSION['msg_2']        =  NULL;
	}

	public function redirect($url = NULL) {

		if($url == "self") {
			#reload the Current Page
			header('Location: '.$_SERVER['REQUEST_URI']);
			ob_end_flush();
			exit();

		}else {
			#redirect to Given Page
			header("location:".$this->base_url.$url);
			ob_end_flush();
			exit();
		}
	}

	public function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
   }

   #-------------------------------------------------------------
   #
   # the input field name for file upload should be file
   # pass the $FILE Global Variable here....
   #
   #-------------------------------------------------------------

   public function image_thubnil_create($FILE) {
   	
   	$filetmp = $FILE["file"]["tmp_name"];

   	#$filename = $FILE["file"]["name"];

   	#below two are for chanig the name of that image...
   	$temp     = explode(".", $FILE["file"]["name"]);
   	$filename = round(microtime(true)) . '.' . end($temp);

   	$filetype = $FILE["file"]["type"];
   	$filesize = $FILE["file"]["size"];
   	$fileinfo = getimagesize($FILE["file"]["tmp_name"]);
   	$filewidth = $fileinfo[0];
   	$fileheight = $fileinfo[1];
   	$filepath = "assests/photos/".$filename;
   	$filepath_thumb = "assests/photos/thumbs/".$filename;

   	if($filetmp == "")
   	{
   	   #echo "please select a photo";
   	   $this->set_flush(TRUE, "col-md-offset-3 col-md-4", "info", "please select a photo");
   	   $this->redirect("change_profile_picture.php");
   	}
   	else
   	{

   	   if($filesize > 10097152)
   	   {
   	      #echo "photo > 10mb";
   	      $this->set_flush(TRUE, "col-md-offset-3 col-md-4", "info", "photo > 10mb");
   	      $this->redirect("change_profile_picture.php");
   	   }
   	   else
   	   {

   	      if($filetype != "image/jpeg" && $filetype != "image/png" && $filetype != "image/gif")
   	      {
   	        #echo "Please upload jpg / png / gif";
   	        $this->set_flush(TRUE, "col-md-offset-3 col-md-4", "info", "Please upload jpg / png / gif");
   	        $this->redirect("change_profile_picture.php");

   	      }
   	      else
   	      {

   	         move_uploaded_file($filetmp,$filepath);

   	         if($filetype == "image/jpeg")
   	         {
   	           $imagecreate = "imagecreatefromjpeg";
   	           $imageformat = "imagejpeg";
   	         }
   	         if($filetype == "image/png")
   	         {
   	           $imagecreate = "imagecreatefrompng";
   	           $imageformat = "imagepng";
   	         }
   	         if($filetype == "image/gif")
   	         {
   	           $imagecreate= "imagecreatefromgif";
   	           $imageformat = "imagegif";
   	         }

   	         $new_width = "200";
   	         $new_height = "200";

   	         $image_p = imagecreatetruecolor($new_width, $new_height);
   	         $image = $imagecreate($filepath); //photo folder

   	         imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $filewidth, $fileheight);
   	         $imageformat($image_p, $filepath_thumb);//thumb folder

   	        /* echo "<br/>";
   	         echo $filename;
   	         echo "<br/>";
   	         echo $filepath;
   	         echo "<br/>";
   	         echo $filetype;*/
   	        
   	        $img_path = "assests/photos/thumbs/".$filename;

   	        #delete the original file...

   	        unlink($filepath);

   	        //echo "<img src='".$img_path."'>";

   	        return $img_path;
   	      }

   	   }
   	}

   }

   public function ms_office_or_pdf_or_text_file_upload($FILE) {

    $support_formate = array('doc','dot','docx','dotx','docm','dotm','xls','xlt','xla','xlsx','xltx','xlsm','xltm','xlam','xlsb','ppt','pot','pps','ppa','pptx','potx','ppsx','ppam','pptm','potm','ppsm','txt','pdf');

    $filetmp = $FILE["file"]["tmp_name"];

    #below two are for chanig the name of that image...
    $temp     = explode(".", $FILE["file"]["name"]);
    $filename = round(microtime(true)) . '.' . end($temp);
    $filetype = $FILE["file"]["name"];
    $filetype = @explode(".", $filetype);
    $filetype = @strtolower($filetype[1]);

    #file save path
    $filepath = "assests/files/".$filename;

    #checking if empty file ...

    if($filetmp == "") {
      
       #echo "please select a photo";
       $this->set_flush(TRUE, "col-md-offset-3 col-md-4", "info", "please select a File");
       
       $this->redirect("project_create.php");

    } else {

      if(!in_array($filetype, $support_formate)) {

        $this->set_flush(TRUE, "col-md-offset-3 col-md-4", "info", "Please upload a Valid File !");

        $this->redirect("project_create.php");

      } else {

        //file is a valid file ....

        move_uploaded_file($filetmp,$filepath);

        return $filepath;

      }

    }

   }

}
