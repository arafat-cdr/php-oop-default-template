<?php
require_once(__DIR__."/super_admin.php");
require_once(__DIR__."/utility.php");

$obj     = new super_admin;
$utility = new utility;

#when call for a ajax request
if(isset($_POST)) {
	
	$isUpdate =  $utility->validation(@$_POST['isUpdate']);
	$email    =  $utility->validation(@$_POST['email']);
	$id       = $utility->auth_user_data("id");

	if($isUpdate == 1) {
		//this is update data

		$res = $obj->dbSelect("users","email","WHERE email='$email' AND id!='$id'");
		if($res) {
			echo 1;
		}else{
			echo 0;
		}

	}else if($isUpdate == 0){
		//this is create User  data
		$res = $obj->dbSelect("users","email","WHERE email='$email'");
		if($res) {
			echo 1;
		}else{
			echo 0;
		}
	}
}