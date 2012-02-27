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
console.log(page_path);
$( function(){
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
				$("#participants-list").append('<li>'+value.display_name+'</li>');
				$("#participants-list").listview('refresh');
			 			});		
				}
			}
			});
});
</script>