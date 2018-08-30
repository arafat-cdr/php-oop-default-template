<?php
require_once(__DIR__."/includes/common_requires.php");
/*$obj->dbSelect();
$obj->dbInsert();
$obj->dbUpdate();
$obj->dbDelete();*/
#$utility->dd($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile</title>
    <?php include_once(__DIR__."/includes/all_css.php"); ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        
        <?php include_once(__DIR__."/includes/left_top_menu.php");?>

            <!--  flush Messages start -->
             <?php include_once(__DIR__."/includes/flush_messages.php"); ?>
            <!--  flush Messages end -->

       <?php include_once(__DIR__."/includes/footer.php"); ?>
      </div>
    </div>
    <?php include_once(__DIR__."/includes/all_js.php"); ?>
  </body>
</html>