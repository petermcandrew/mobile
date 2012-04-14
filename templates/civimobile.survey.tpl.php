<?php 
require_once('civimobile.header.php');
require_once('initialise.php');
//Get the id from the URL
$path=$_SERVER['REQUEST_URI'];
$split = trim ( $path, "/" );
$split = explode ( "/" , $path );
$activityId = array_pop($split);
$contactId = array_pop($split);
$resultId = array_pop($split);
$surveyId = array_pop($split);
?>

<div data-role="page">
  <div data-role="header">
    <h1>The Survey</h1>
    <a href="#" id="back-contact-button"data-rel="back" class="ui-btn-left" data-icon="arrow-l">Back</a>
    <a href="#" id="save-survey-button" data-role="button" data-icon="check" class="ui-btn-right jqm-save">Save</a>
  </div><!-- /header -->
  <div data-role="content" id="survey-content">
    <ul data-role="listview" data-theme="g" id="question-list">
    </ul>
  </div><!-- /content -->
</div><!-- /page -->

<script>
var respondentId =  '28';
var surveyId = <?php echo $surveyId; ?>;
var resultId = <?php echo $resultId; ?>;
var activityId = <?php echo $activityId; ?>;

$( function(){
  console.log("r"+respondentId);
  console.log("a"+activityId);
  console.log("s"+surveyId);
  $().crmAPI ('OptionValue','get',{'version' :'3', 'option_group_id' : resultId}
  ,{ success:function (data){
    console.log(data);
    $('#question-list').append('<div data-role="fieldcontain" class="ui-field-contain ui-body ui-br"><label for="select-choice-0" class="select"></label> <select name="select-choice-0" id="select-choice-1">  </select></div>');
    $.each(data.values, function(index, value) {
      $('#select-choice-1').append('<option value="'+value.value+'">'+value.label+'</option>');
    });
    $('#select-choice-1').selectmenu();
  }
  });	
  $('#save-survey-button').click(function(){ saveSurvey(); });
});

function saveSurvey(){
  selectValue= $('#select-choice-1').val()
  console.log(selectValue);
  console.log(activityId);
  $().crmAPI ('Activity','update', {'version' :'3', 'id' : activityId, 'result': selectValue, 'status_id': '2' }
  ,{ success:function (data){
    console.log(data)
    window.location.href = "/civimobile/survey/"+surveyId+"/"+resultId+"/";
  }			
  });
}
</script>

<?php require_once('civimobile.footer.php')?>