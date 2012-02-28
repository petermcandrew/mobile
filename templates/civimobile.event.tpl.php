<?php require_once('civimobile.header.php'); ?>

<div data-role="page">

	<div data-role="header">
		<h1>Event participants</h1>
		<a href="#" data-rel="back" class="ui-btn-left" data-icon="arrow-l">Back</a>
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
	$().crmAPI ('Participant','get',{'version' :'3', 'event_id' :'1'}
          ,{
            ajaxURL: crmajaxURL,
            success:function (data){
              if (data.count == 0) {
				$("#participants-list").append("no results found");
              }
              else {
			 $.each(data.values, function(index, value) {
				$("#participants-list").append('<li id="row_'+value.participant_id+'"><div>'+value.display_name+'</div><a id="checkinBtn_'+value.participant_id+'" class="ui-btn ui-btn-corner-all ui-shadow ui-btn-right" style="float:right;" href="#">Check-in</a></li>');
				$("#participants-list").listview('refresh');
			 			});		
				$("[id^=checkinBtn_]").click(function(event){ checkinParticipant(event.target.id); });
				}
			}
			});
			
});
function checkinParticipant(p){
	var elements = p.split('_')
	participant_id = elements[elements.length-1];
	console.log(participant_id);
	$().crmAPI ('Participant','update',{'version' :'3', 'event_id' :'1', 'id' : participant_id, status_id : '2' }
          ,{
            ajaxURL: crmajaxURL,
            success:function (data){
            console.log("success");
			$('#row_'+participant_id).slideUp(1000, function(){
				$("#participants-list").listview('refresh');
			});
			}
		});
	
	
	
}
</script>