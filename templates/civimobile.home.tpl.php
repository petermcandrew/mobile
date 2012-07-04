<?php 
require_once('civimobile.header.php');
require_once('initialise.php');

$activities=civicrm_api("Activity","get", array ('version' =>'3'));
//print_r($activities);exit;

?>
<div data-role="page">
  <div data-role="header">
    <h1>Home</h1>
  </div><!-- /header -->
  <div data-role="content" id="activity-content">
    <div class="content-primary">
        <ul data-role="listview" data-theme="g" data-inset="true" id="activity-list" data-dividertheme="a">
          <li data-role="list-divider">My Activities</li>
        </ul>
    </div><!-- /content-primary -->
  </div><!-- /content -->
  <?php require_once('civimobile.navbar.php') ?>
</div><!-- /page -->
  <?php require_once('civimobile.footer.php') ?>


<script>

$( function(){
  $.mobile.showPageLoadingMsg( 'Searching' );
  $().crmAPI ('Activity','get',{'version' :'3' }
  ,{
    ajaxURL: crmajaxURL,
    success:function (data){
      console.log(data);
      $.each(data.values, function(index, value) {
        $('#activity-list').append('<li role="option" tabindex="-1" data-theme="c" id="contact-'+value.id+'" >'+value.subject+'</li>');
      });
      $("#activity-list").listview('refresh');
      $.mobile.hidePageLoadingMsg();
    }
});
});

</script>