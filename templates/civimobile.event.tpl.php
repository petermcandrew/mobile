<?php require_once('civimobile.header.php'); ?>

<div data-role="page">

	<div data-role="header">
		<h1>Event participants</h1>
	</div><!-- /header -->
	
	<div data-role="content" id="participants-content">
		<div class="content-primary">
		
			<ul data-role="listview" data-theme="c" id="participants-list">

		    </ul>
		
		</div><!-- /content-primary -->
	</div><!-- /content -->

<?php require_once('civimobile.navbar.php') ?>

</div><!-- /page -->

<?php require_once('civimobile.footer.php') ?>


<script>
$( function(){
	console.log("h")
	$().crmAPI ('Participant','get',{'version' :'3', 'event_id' :'1'}
          ,{
            ajaxURL: crmajaxURL,
            success:function (data){
			console.log(data.values);
              if (data.count == 0) {
				$("#participants-list").append("no results found");
              }
              else {
			 $.each(data.values, function(index, value) {
				$("#participants-list").append('<li><div>'+value.display_name+'</div><a id="checkin_'+value.id+'" class="ui-btn ui-btn-corner-all ui-shadow ui-btn-right" style="float:right;" href="#">Check in</a></li>');
				$("#participants-list").listview('refresh');
			 			});		
				}
			}
			});
			
			$("#contact_74").click('pageinit',function(){ console.log("hello"); });
});
</script>