<?php
#---------- common for all pages Start --------------
require_once(__DIR__."/all_files_requires.php");

$utility->is_logout();

if(isset($_GET['logout'])) {

  if($_GET['logout'] == 1) {
    $utility->logout();
  }
  
}

$current_url = BASEURL.$_SERVER['PHP_SELF'];

$var = explode("/", BASEURL);
#$utility->pr($var);

$current_url = $var[0]."//".$var[2].$_SERVER['PHP_SELF'];

$fixed_url = $var[0]."//".$var[2]."/".$var[3]."/employee_profile_pending.php";

#This is for Preventing Too Many redirect Fatal Error ....
if($utility->auth_user_data("is_active") != 1 && $current_url != $fixed_url) {

	$utility->redirect("employee_profile_pending.php");	
}

#---------- common for all pages end --------------