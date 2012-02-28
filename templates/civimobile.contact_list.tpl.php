<?php require_once('civimobile.header.php'); ?>

<div data-role="page">

	<div data-role="header">
		<h1>Contacts</h1>
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
		<div style="display:none" id="add_contact">
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
	</div><!-- /content-primary -->
	</div><!-- /content -->
<?php require('civimobile.navbar.php'); ?>
	
</div><!-- /page -->

<script>

$( function(){
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
			console.log(data.values);
              if (data.count == 0) {
				$("#contact-list").empty();
				$("#contact-list").append("<li>no results found</li>");
				$("#contact-list").listview('refresh');
				 $.mobile.hidePageLoadingMsg( );
              }
              else {
          //alert("some results");
			var page_path = '<?php echo $_SERVER['REQUEST_URI'];  ?>'
			$("#contact-list").empty();
			console.log(page_path);
			$.each(data.values, function(index, value) {
				$('#contact-list').append('<li role="option" tabindex="-1" data-theme="c" id="contact-'+value.contact_id+'" ><a href="http://mobile.local/civimobile/contact/'+value.contact_id+'" data-ajax="false">'+value.display_name+' </a></li>');
				//<a href="#contact/'+value.contact_id+'" data-role="contact-'+value.contact_id+'">'+value.display_name+'</a>
			});		}
			$("#contact-list").listview('refresh');
           $.mobile.hidePageLoadingMsg( );
			}
	});
}

function addContact() {
	//$('#contact-content').append($('#add_contact')); ******* is this line necessary?
	$('#contact-search-list').hide();
	$('#add-contact-button').hide();
	$('#contact-home-button').hide();
	$('#add_contact').show();
	$('#back-contact-button').show();
	$('#save-contact').click(function(){ createContact(); });
}
function hideAddContact() {
	$('#add_contact').hide();
	$('#back-contact-button').hide();
	$('#contact-search-list').show();
	$('#add-contact-button').show();
}
function createContact() {
      first_name = $('#first_name').val(); 
      last_name = $('#last_name').val(); 
      phone = $('#tel').val(); 
      email = $('#email').val(); 
      note = $('#note').val(); 
   
        $().crmAPI ('Contact','create',{
            'version' :'3', 
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
<?php require('civimobile.footer.php'); ?>