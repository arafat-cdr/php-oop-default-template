<?php if(isset($_SESSION['is_flush_msg'])) { ?>

<!-- logout or Fail login attempt start-->

<div style="margin-top: 0px;" class="<?php echo $_SESSION['grid_class']; ?> col-sm-12 col-xm-12  alert alert-<?php echo $_SESSION['alert_class']; ?> alert-dismissible fade in text-center" role="alert">
   <button type="button" class="close col-md-2 pull-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color: black;">X</span>
   </button>
   <strong><?php  echo $_SESSION['msg_1']; ?></strong><br/><?php  echo $_SESSION['msg_2']; ?>
</div>

<!-- logout or Fail login attempt end-->

<?php $utility->delete_flush(); } ?>