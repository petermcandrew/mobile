<?php 
require_once('civimobile.header.php');
require_once('initialise.php');
$new_individual_profile_id=4;
$profile_title=civicrm_api("UFGroup","get", array ('version' =>'3', 'id' =>$new_individual_profile_id));
$profile_title=$profile_title['values'][$new_individual_profile_id]['title'];
?>
<div data-role="page">
	<div data-role="header">
		<h1 id='contact-header'>Contacts</h1>
		<a href="#" id="add-contact-button" data-role="button" data-icon="plus" class="ui-btn-right jqm-home">Add</a>
		<a style="display:none" href="#" id="back-contact-button" data-role="button" data-icon="delete" class="ui-btn-left jqm-back">Cancel</a>
		<a href="/civimobile" id="contact-home-button" data-ajax="false" data-direction="reverse" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-left jqm-home">Home</a>
	</div><!-- /header -->
	<div data-role="content" id="contact-content">
		<div class="content-primary">
		
		<div id="contact-search-list">
    		<div class="ui-listview-filter ui-bar-c">
		        <input type="search" name="search" placeholder="Search for contacts" id="search" value="" />
		    </div>
			<ul data-role="listview" data-theme="g" id="contact-list">
		    </ul>
		</div>
		<div style="display:none" id="add-contact">
	    </div>
	</div><!-- /content-primary -->
	</div><!-- /content -->
<?php require('civimobile.navbar.php'); ?>
	
</div><!-- /page -->

<script>

var profileTitle = "<?php echo $profile_title; ?>";
var newIndividualProfileId = "<?php echo $new_individual_profile_id; ?>";
var params = {};

$(function(){
	$().crmAPI ('UFField','get',{'version' :'3', 'uf_group_id' : newIndividualProfileId}
		,{ success:function (data){
			$.each(data.values, function(index, value) {
			$('#add-contact').append('<div data-role="fieldcontain"> <input type="text" name="'+value.field_name+'" id="contact-field-'+value.field_name+'" value="" placeholder="'+value.label+'" /> </div>');
			$('#contact-field-'+value.field_name).textinput();
			});
			$('#add-contact').append('<a href="#" id="save-contact" data-role="button" data-theme="b">Save</a>');
			$('#save-contact').button();
		}
	});
	$('#add-contact-button').click(function(){ addContact(); });
	$('#back-contact-button').click(function(){ hideAddContact(); });
	$('#search').change (function () {
		value = $("#search").val();
		if (value){
			contactSearch(value);
		}
		else{
			$("#contact-list").empty();
		}
	});
});

function contactSearch(q) {
	$('input#search').blur();
	$.mobile.showPageLoadingMsg( 'Searching' );
	$().crmAPI ('Contact','get',{'version' :'3', 'sort_name': q, 'return' : 'display_name' }
		,{
		ajaxURL: crmajaxURL,
		success:function (data){
			if (data.count == 0) {
				$("#contact-list").empty();
				$("#contact-list").append('<li data-theme="c">No results found</li>');
				$("#contact-list").listview('refresh');
				$.mobile.hidePageLoadingMsg( );
			}
			else {
				var page_path = '<?php echo $_SERVER['REQUEST_URI']; ?>'
				$("#contact-list").empty();
				console.log(page_path);
				$.each(data.values, function(index, value) {
				$('#contact-list').append('<li role="option" tabindex="-1" data-theme="c" id="contact-'+value.contact_id+'" ><a href="'+value.contact_id+'" data-ajax="false">'+value.display_name+' </a></li>');
				});
			}
			$("#contact-list").listview('refresh');
			$.mobile.hidePageLoadingMsg();
		}
	});
}

function addContact() {
	$('#contact-header').text(profileTitle);
	$('#contact-search-list').hide();
	$('#add-contact-button').hide();
	$('#contact-home-button').hide();
	$('#add-contact').show();
	$('#back-contact-button').show();
	$('#save-contact').click(function(){ createContact(); });
}

function hideAddContact() {
	$('#add-contact').hide();
	$('#back-contact-button').hide();
	$('#contact-search-list').show();
	$('#add-contact-button').show();
	$("#contact-list").listview('refresh');
}

function createContact() {
	$("[id^=contact-field-]").each(function(index, value) {
		name = value.name;
		value = $('#contact-field-'+value.name).val();
		params[name] = value;
	});
	params.version = "3";
	params.contact_type = "Individual";
	$().crmAPI ('Contact','create', params
		,{ success:function (data){
			console.log("this is the returned contact id: " + data.id )
			window.location.href = "/civimobile/contact/"+data.id;
		}
	});
}
</script>
<?php require('civimobile.footer.php'); ?>