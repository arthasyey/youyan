<?php $this->load->view('include/header'); ?>


<div id="main_content">

<?php 
if(!is_array($main_content))
  $this->load->view($main_content); 
else
  foreach($main_content as $element){
    $this->load->view($element);
  }
?>
</div>

<?php $this->load->view('include/footer'); ?>

