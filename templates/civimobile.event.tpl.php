<?php require_once('civimobile.header.php'); ?>

<div data-role="page">

	<div data-role="header">
		<h1>Event participants</h1>
	</div><!-- /header -->
	
	<div data-role="content" id="event-content">
		<div class="content-primary">
		
			<ul data-role="listview" data-theme="c" id="event-list">
		    </ul>
		
		</div><!-- /content-primary -->
	</div><!-- /content -->

<?php require_once('civimobile.navbar.php') ?>

</div><!-- /page -->

<?php require_once('civimobile.footer.php') ?>


<script>
//console.log(page_path);
$( function(){
	$().crmAPI ('Event','get',{'version' :'3'}
          ,{
            ajaxURL: crmajaxURL,
            success:function (data){
			console.log(data.values);
			//alert("Sorry I couldn't find any events to display");
			
              if (data.count == 0) {
				alert("Sorry I couldn't find any events to display");
              }
              else {
			 $.each(data.values, function(index, value) {
				$("#event-list").append('<li><a href="'+page_path+'/'+value.id+'">'+value.title+'<br />('+value.start_date+')</a></li>');
				$("#event-list").listview('refresh');
			 			});		
				}
			}
			});
});
</script>