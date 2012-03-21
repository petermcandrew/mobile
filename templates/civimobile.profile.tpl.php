<?php 
require_once('civimobile.header.php');
require_once('initialise.php');


//Get the id from the URL
$path=$_SERVER['REQUEST_URI'];
$split = explode ( "/" , $path );
$id = end($split);
//api call to get fields from profile
$params=array('version' =>'3','uf_group_id' => $id);
$results=civicrm_api("UFField","get", $params);
$results=$results['values'];

foreach($results as $result){
	print_r($result['field_name']."\n");
}
print_r($results);exit;

?>
<div data-role="page">

	<div data-role="header">
		<h1>Profile <?php print_r($id); ?></h1>
	</div><!-- /header -->
	<div data-role="content" id="profile-<?php print_r($id); ?>">
		<div id="profile-<?php print_r($id); ?>-fields">
			<?php foreach($results as $result){
				print_r('<div data-role="fieldcontain">
			        		<input type="text" name="'.$result['field_name'].'" id="'.$result['field_name'].'-'.$id.'" value="" placeholder="'.$result['field_name'].'" />
			    		</div>');
			}?>
	    </div>
	</div><!-- /content -->
	<?php require_once('civimobile.navbar.php') ?>
</div><!-- /page -->


<script>
var contactId = <?php echo $id; ?>;
var contact = <?php echo json_encode($results); ?>;

$( function(){
	$('#edit-contact-button').click(function(){ editContact(); });
	$('#cancel-contact-button').click(function(){ cancelEditContact(); });
	$('#save-contact-button').click(function(){ updateContact(); });
	$('#first_name').val(contact.values[contactId].first_name);
	$('#last_name').val(contact.values[contactId].last_name);
	$('#email').val(contact.values[contactId].email);
	$('#tel').val(contact.values[contactId].phone);
	$("#edit-contact :input").attr("disabled", "disabled");
	hideEmptyFields();
	
});
function editContact(){
	$("#edit-contact :input").removeAttr("disabled");
	$('#edit-contact-button').hide();
	$('#cancel-contact-button').show();
	$('#save-contact-button').show();
}

function cancelEditContact(){
	$("#edit-contact :input").attr("disabled", "disabled");
	$('#cancel-contact-button').hide();
	$('#save-contact-button').hide();
	$('#edit-contact-button').show();
	hideEmptyFields();
}

function hideEmptyFields(){
	$("#edit-contact :input").each(function (i) {
		if (!this.value){
			$(this).hide();	
		}
	  });
}
function updateContact() {
      first_name = $('#first_name').val(); 
      last_name = $('#last_name').val(); 
      phone = $('#tel').val(); 
      email = $('#email').val(); 
      note = $('#note').val(); 
   
        $().crmAPI ('Contact','update',{
            'version' :'3',
 			'id' : contactId,
            'contact_type' :'Individual', // only individuals for now
            'first_name' :first_name, 
            'last_name' : last_name, 
            'phone' : phone, 
            'email' : email 			}
          ,{ success:function (data){    
			console.log("this is the returned contact id: " + data.id )
              // create the note if one exists
				if (note){
				$().crmAPI ('Note','create',{
					'version' :'3',
					'entity_id' : data.id,
					'note' : note
					}
				  ,{ success:function (data){    
			      console.log("note created");
				    }
				});}
				else{
					console.log("there was no note");
				} 
				window.location.href = "/civimobile/contact/"+data.id;
            }
        });
}	


</script>

<?php require_once('civimobile.footer.php')?>
