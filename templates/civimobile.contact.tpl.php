<?php 
require_once('civimobile.header.php');
require_once('initialise.php');


//Get the id from the URL
$path=$_SERVER['REQUEST_URI'];
$split = explode ( "/" , $path );
$id = end($split);
//api call to get contact
$params = array ('version' =>'3',
				'contact_id' => $id
				);
$results=civicrm_api("Contact","get",$params );
// print_r($results);
?>

<script>
var contactId = <?php echo $id; ?>;
var contact = <?php echo json_encode($results); ?>;
</script>

<div data-role="page">

	<div data-role="header">
		<h1>Contact details</h1>
		<a href="#" id="edit-contact-button" data-role="button" class="ui-btn-right jqm-edit">Edit</a>
		<a style="display:none" href="#" id="cancel-contact-button" data-role="button" data-icon="delete" class="ui-btn-left jqm-cancel">Cancel</a>
		<a style="display:none" href="#" id="save-contact-button" data-role="button" data-icon="check" class="ui-btn-right jqm-save">Save</a>
	</div><!-- /header -->
	
	<div data-role="content" id="contact-details-content">
		<div id="edit-contact">
		   	<div data-role="fieldcontain">
		        <input type="text" name="first_name" id="first_name" value="" placeholder="First Name" />
		    </div>
		    <div data-role="fieldcontain">
		        <input type="text" name="last_name" id="last_name" value="" placeholder="Last Name" />
		    </div>
		    <div data-role="fieldcontain">
		        <input type="email" name="email" id="email" value="" placeholder="Email" />
		    </div>    
		    <div data-role="fieldcontain">
		        <input type="tel" name="tel" id="tel" value="" placeholder="Phone" />
		    </div>
		    <div data-role="fieldcontain">
		    	<textarea cols="40" rows="8" name="note" id="note" placeholder="Note"></textarea>
		    </div>
		    <a style="display:none" href="#" id="save-contact" data-role="button" data-theme="b">Save Contact</a> 
	    </div>
	</div><!-- /content -->
	<?php require_once('civimobile.navbar.php') ?>
</div><!-- /page -->


<script>

$( function(){
	$('#edit-contact-button').click(function(){ editContact(); });
	$('#cancel-contact-button').click(function(){ cancelEditContact(); });
	
	//console.log(contact.values[contactId]);
	//console.log(contactId);
		//Set field values from JSON
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

</script>

<?php require_once('civimobile.footer.php')?>