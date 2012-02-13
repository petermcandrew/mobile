<?php require_once('civimobile.header.php'); ?>

<div data-role="page">

	<div data-role="header">
		<h1>CiviMobile</h1>
	</div><!-- /header -->

	<div data-role="content" id="contact-list">
		<!--
		//-->
		<ul data-role="listview">
		<?php
		civicrm_initialize();
		$results=civicrm_api("Contact","get", array ('version' =>'3'));
		$results=$results['values'];
		$num = 0;
		// foreach ($results as $contact)
		// 		    echo "<li><a href='/contact/".$contact['contact_id']."'>".$contact['display_name']."</a></li>";
		?>
		</ul>
		<div data-role="fieldcontain">
		    <input type="search" name="search" placeholder="Search for contacts" id="search" value="" />
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
function contactSearch (q){
    $.mobile.showPageLoadingMsg( 'Searching' );
    $().crmAPI ('Contact','get',{'version' :'3', 'sort_name': q, 'return' : 'display_name,phone' }
          ,{ 
            ajaxURL: crmajaxURL,
            success:function (data){
			console.log(data.values);
              if (data.count == 0) {
				alert("no results");                            
              }
              else {
          alert("some results");
			// $.each(data, function(index, value) {
			// 		            $('#months').append('<li>' + value + '</li>');
			// 		        });
			//               }
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
