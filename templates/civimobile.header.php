<?php  // $Id: page.tpl.php,v 1.0 kylejaster Exp $ 
if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php //print $civimobile_page_settings['language'] ?>" lang="<?php //print $civimobile_page_settings['language'] ?>" >
  <head>
    <title><?php //print $civimobile_page_settings['title'] ?></title>
    <?php //print $civimobile_page_settings['head'] ?>
    <?php //print $civimobile_page_settings['favicon'] ?>
    <?php $new_individual_profile_id = 1; ?>
     
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" >
    <link rel="stylesheet" href="/sites/all/modules/civimobile/libraries/jquery.mobile-1.0.1/jquery.mobile-1.0.1.css" />
    <script src="/sites/all/modules/civimobile/libraries/jquery.mobile-1.0.1/jquery-1.7.1.min.js"></script>
    <script src="/sites/all/modules/civimobile/libraries/jquery.mobile-1.0.1/jquery.mobile-1.0.1.min.js"></script>
    <script src="/sites/all/modules/civicrm/js/rest.js"></script>
    <script>
         var crmajaxURL = '<?php print base_path(); ?>civicrm/ajax/rest';
         var base_url =  '<?php print base_path(); ?>';
         var newIndividualProfileId = 1;
         
    </script>
  </head>
<body> 
<?php endif; 

global $base_url;

function navbar ($back = false) {
if ($back) { 
  $ajax="true";
} else {
  $ajax="false";
}  

}
?>
