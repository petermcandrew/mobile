<?php require_once('civimobile.header.php'); ?>

<div data-role="page">

	<div data-role="header">
		<h1>CiviMobile</h1>
	</div><!-- /header -->
	
	<div data-role="content" id="contact-content"> 
    <div class="ui-listview-filter ui-bar-c">
        <input type="search" name="search" placeholder="Search for contacts" id="search" value="" />
    </div>
	<div id="contact-list">
    </div>
	</div>
</div><!-- /page -->
<?php require('civimobile.navbar.php'); ?>

<script>

$( function(){

	$('#search').change (function () {
		value = $("#search").val();		
    contactSearch(value);
	});
});
function contactSearch(q) {
    $.mobile.showPageLoadingMsg( 'Searching' );
    $().crmAPI ('Contact','get',{'version' :'3', 'sort_name': q, 'return' : 'display_name,phone' }
          ,{ 
            ajaxURL: crmajaxURL,
            success:function (data){
			console.log(data.values);
              if (data.count == 0) {
				$("#contact-list").empty();
				$("#contact-list").append("no results found");
              }
              else {
          //alert("some results");
			$("#contact-list").empty();
			$.each(data.values, function(index, value) {
				$('#contact-list').append("<li class='ui-li ui-li-static ui-body-c'>" + value.display_name + "</li>");
			});
			              
			}
           $.mobile.hidePageLoadingMsg( );
          			
			}
	});
}
// $.each(data.values, function(key, value) {
//     $('#contacts').append('<li role="option" tabindex="-1" data-ajax="false" data-theme="c" id="event-'+value.contact_id+'" ><a href="#contact/'+value.contact_id+'" data-role="contact-'+value.contact_id+'">'+value.display_name+'</a></li>');
//   });
// $.mobile.hidePageLoadingMsg( );
// $('#contacts').listview(cmd);
// }

</script>
<?php require('civimobile.footer.php'); ?>
