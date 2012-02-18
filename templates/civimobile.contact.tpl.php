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



<div data-role="page">

	<div data-role="header">
		<h1>Contact details</h1>
		<a href="#" id="edit-contact-button" data-role="button" class="ui-btn-right jqm-home">Edit</a>
		<a style="display:none" href="#" id="done-contact-button" data-role="button" data-icon="delete" class="ui-btn-left jqm-back">Cancel</a>
	</div><!-- /header -->
	
	<div data-role="content" id="contact-details-content">
		<div  id="edit_contact">
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
	    <a href="#" id="save-contact" data-role="button" data-theme="b">Save Contact</a> 
	    </div>
	</div><!-- /content -->
</div><!-- /page -->

<?php require_once('civimobile.navbar.php')?>

<script>

$( function(){
	
});

</script>

<?php require_once('civimobile.footer.php')?>
