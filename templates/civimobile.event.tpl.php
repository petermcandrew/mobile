<?php require_once('civimobile.header.php'); 

$path=$_SERVER['REQUEST_URI'];
$split = explode ( "/" , $path );
$id = end($split);

?>
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
  <?php require_once('civimobile.event.undobar.php') ?>
</div><!-- /page -->
  <?php require_once('civimobile.footer.php') ?>

<script>
$( function(){
	var event_id = "<?php echo $id; ?>"
	console.log(event_id);
	$().crmAPI ('Participant','get',{'version' :'3', 'event_id' : event_id, 'participant_status_id' : '1'||'5', 'rowCount' : '200' }
          ,{
            ajaxURL: crmajaxURL,
            success:function (data){
              if (data.count == 0) {
				$("#participants-list").append("no results found");
              }
              else {
				$.each(data.values, function(index, value) {
					$("#participants-list").append('<li id="row_'+value.participant_id+'"><div>'+value.display_name+'</div><a id="checkinBtn_'+value.participant_id+'" data-participant-id="'+value.participant_id+'" data-participant-name="'+value.display_name+'" data-participant-status-id="'+value.participant_status_id+'" class="ui-btn ui-btn-up-c ui-btn-corner-all ui-shadow ui-btn-right" data-theme="c" href="#">Check-in</a></li>');
					});		
				$("#participants-list").listview('refresh')
				$("[id^=checkinBtn_]").click(function(event){
					pid = $(this).attr('data-participant-id');
					$('#checkinBtn_'+pid).css("color","red");
					checkinParticipant($(this).attr('data-participant-id'),$(this).attr('data-participant-status-id'));
				});
				}
			}
		});

		function checkinParticipant(pid,psid){
		  $("#undo-checkin-button").hide();
		  console.log("removeCheckinBtn called");
			$().crmAPI ('Participant','update',{'version' :'3', 'event_id' : event_id, 'id' : pid, 'status_id' : '2' }
			,{
				ajaxURL: crmajaxURL,
				success:function (data){
				  //remove colour from button
					$('#checkinBtn_'+pid).css("color","");
					//hide item children
					$('#row_'+pid).attr('data-participant-id');
					$('#row_'+pid).children().hide();
					//need to figure out how to change button text before it get displayed.
          //$("#undo-checkin-button").attr('innerHTML', "Hey!!");
					$("#undo-checkin-button").show();
					$("#participants-list").listview('refresh');
					$("#undo-checkin-button").attr('data-participant-id', pid);
					$("#undo-checkin-button").attr('data-previous-participant-status-id', psid);
         
          //need to figure out how to cancel existing delays
         $("#undo-checkin-button").delay(10000).fadeOut("normal", function() {
            // need to remove row so that we don't end up with a weird thick line betwen ajacent rows this is link to above issue with cancelling existing delays
            // $('#row_'+pid).remove();
            $("#participants-list").listview('refresh');  
                                 });
					$("#undo-checkin-button").click(function(event){
						undoCheckinParticipant($(this).attr('data-participant-id'),$(this).attr('data-previous-participant-status-id'));
					});
				}
			});
		}

  function undoCheckinParticipant(pid,ppsid){
    $().crmAPI ('Participant','update',{'version' :'3', 'event_id' : event_id, 'id' : pid, 'status_id' : ppsid }
      ,{
        ajaxURL: crmajaxURL,
        success:function (data){
          //show checkin row
          $('#row_'+pid).children().show();
          $("#undo-checkin-button").hide();
          $("#participants-list").listview('refresh');
        }
    });
	}
});


</script>