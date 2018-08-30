<?php
require_once(__DIR__."/super_admin.php");
require_once(__DIR__."/utility.php");

$obj     = new super_admin;
$utility = new utility;

#when call for a ajax request
if(isset($_POST)) {
  #Read the QR Code this is come form QR Data
    $data = array();
    $data                  = $utility->auto_validate($_POST);
    $qr_encrypted_data     = @$data["result"]; #this is come form QR Data
    
   /* echo "qr Data is : ";
    $utility->pr($qr_encrypted_data);*/

    $qr_decrypt_data = $utility->encrypt_decrypt("decrypt", $qr_encrypted_data);


    $qr_data = explode(":", $qr_decrypt_data);
    //$qr_data = explode(":", "Hello World");

    $search_id = (int)$qr_data[0];
    $name      = '';
    if(is_array($qr_data)) {
      if(count($qr_data) == 2) {
        $name = $qr_data[1];
      }
    }

    #fetch the data from table using the search_id and match the id and token.
    $token = $obj->dbSelect("identities", "token", "WHERE user_id='$search_id'");

    if($token) {
      $token = $token[0]->token;
    }else{
     $token = NULL;
    }


    $match_token = md5($qr_encrypted_data);
    

    if($match_token == $token) {
      #is match token then check if pregent already given or not form database
      $res_data_info = $obj->dbSelect("attendees", "*", "WHERE user_id='$search_id' ORDER BY id DESC LIMIT 1");
      $present_at = date("Y-m-d h:i:m");
      $present_info = array();

      if($res_data_info) {
          $data_info  = $res_data_info[0]->data_info;
          $tbl_row_date = date("d", strtotime($data_info));

          $present_date = date("d", strtotime($present_at));

          if($tbl_row_date == $present_date) {
              echo 'you already Entry your present';
              die();
          }else{
            #insert the attendence data...
            $present_info['user_id']   = $search_id;
            $present_info['data_info'] = $present_at;
        }
      }else{
          #insert the attendence data...
          $present_info['user_id']   = $search_id;
          $present_info['data_info'] = $present_at;
      }

      #run the query and check it is success...
      $is_success = $obj->dbInsert("attendees", $present_info);

      if($is_success) {
        echo "Attendence Entry SuccessFull";
      }else {
        echo "Attendence Entry Fails";
      }

    }
    #end of match token if condition....

    else {
      echo "Invalid Id card..";
    }

}
