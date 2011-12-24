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
		    <input type="search" name="password" id="search" value="" />
		</div>
		
</div><!-- /page -->
<?php require('civimobile.navbar.php'); ?>


<?php require('civimobile.footer.php'); ?>
