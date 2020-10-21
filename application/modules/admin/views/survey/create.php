<style type="text/css">
.form-group .form-control{
	border: 1px solid #ededed;
  	padding: 0px 10px;
}
.panel-body {
    padding: 40px;
    border: 1px solid #afacac;
}
.radio, .checkbox {
    position: relative;
    display: block;
    margin-left: 15px !important;
    margin-bottom: 10px !important;
    margin-top: 0px !important;
}

textarea.form-control{
    border: 1px solid #ededed !important;
    padding: 10px 20px !important;
}

.sweet-alert{
  width: 300px !important;
}
$color1: #f4f4f4;
$color2: #3197EE;


.radio {
  margin: 0.5rem;
  input[type="radio"] {
    position: absolute;
    opacity: 0;
    + .radio-label {
      &:before {
        content: '';
        background: $color1;
        border-radius: 100%;
        border: 1px solid darken($color1, 25%);
        display: inline-block;
        width: 1.4em;
        height: 1.4em;
        position: relative;
        top: -0.2em;
        margin-right: 1em; 
        vertical-align: top;
        cursor: pointer;
        text-align: center;
        transition: all 250ms ease;
      }
    }
    &:checked {
      + .radio-label {
        &:before {
          background-color: $color2;
          box-shadow: inset 0 0 0 4px $color1;
        }
      }
    }
    &:focus {
      + .radio-label {
        &:before {
          outline: none;
          border-color: $color2;
        }
      }
    }
    &:disabled {
      + .radio-label {
        &:before {
          box-shadow: inset 0 0 0 4px $color1;
          border-color: darken($color1, 25%);
          background: darken($color1, 25%);
        }
      }
    }
    + .radio-label {
      &:empty {
        &:before {
          margin-right: 0;
        }
      }
    }
  }
}
.back-to-survey{
  padding: 12px 10px;
  margin: 0px 40px;
  background-color: black !important;
}
.form-group .form-control {
  border: 1px solid #afa5a5 !important;
}    
</style>
<div class="row">
   <div class="col-sm-12">
      <div class="panel lobidrag" id="create-survey-div">
         <form action="#" data-ha-url="<?php echo base_url('en/admin/survey/store');?>" class="form-vertical" method="post" id="create-survey" name="create-survey" enctype="multipart/form-data"  accept-charset="utf-8">
            <input type="hidden"  name="id" value="">
            <div class="panel-body">
  	          <div class="row">
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Survey Name<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <textarea class="form-control space" tabindex="1" name="survey_name" type="text" id="survey_name" placeholder="Please enter survey name"  required="" autocomplete="off"></textarea>
                      </div>
                   </div>
                </div>
              </div>
              <div class="row">  
  			        <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Rewards<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <textarea class="form-control space" tabindex="1" name="rewards" type="text" id="rewards" placeholder="Please enter rewards" required="" autocomplete="off"></textarea>
                      </div>
                   </div>
                </div>
             </div>

  			    <div class="row">
				      <div class="col-sm-6">
	              <div class="form-group row">
	                  <label for="product_name" class="col-sm-2 col-form-label">Survey Type<i class="text-danger">*</i></label>
	                  <div class="col-sm-10">
	                     <div class="radio">
						                <input id="radio-1" name="type" type="radio" value="reward" checked>
						                <label for="radio-1" class="radio-label">Reward</label>
						           </div>
                       <div class="radio">
						              <input id="radio-2" name="type"  value="normal" type="radio">
						              <label  for="radio-2" class="radio-label">Normal</label>
						           </div>
	                  </div>
	              </div> 
	            </div>       	
  			    </div>

      			<div class="row">
      		    <div class="col-sm-6">
                <div class="form-group row">
            	   <label for="product_name" class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                     <div id="ajaxMessageSurvey"></div>
      							 <input type="submit" value="Save" name="add-product-another" class="btn btn-large btn-warning" id="add-product-another"
      						 	tabindex="15" autocomplete="off" style="padding: 12px 50px;margin: 0px 0px;float: left;">
      						</div> 	
      				  </div>
      			  </div>		 
      			</div>
          </div>  	
        </form>  
      </div>	

      <div class="panel lobidrag" id="create-question-div"  style="display: none;">
         <form action="#" data-ha-url="<?php echo base_url('en/admin/survey/store_question');?>" class="form-vertical" method="post" id="create-survey-question" name="create-survey-question" enctype="multipart/form-data"  accept-charset="utf-8">
            <input type="hidden" id="survey_id" name="survey_id" value="">
            <input type="hidden" id="qcounts" value="1">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-12">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-1 col-form-label"> <span id="qcount">1</span>) Question <i class="text-danger">*</i></label>
                      <div class="col-sm-11">
                          <textarea class="form-control space" tabindex="1" placeholder="Please enter Question " name="question" type="text" id="question" rows="4" required=""></textarea>
                      </div>
                   </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Option 1<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <input class="form-control space" tabindex="1" name="option_1" type="text" id="option_1" placeholder="Please enter option 1" value="" required="" autocomplete="off">
                      </div>
                   </div>
                </div>

                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Option 2<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <input class="form-control space" tabindex="1" name="option_2" type="text" id="option_2" placeholder="Please enter option 2" value="" required="" autocomplete="off">
                      </div>
                   </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Option 3<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <input class="form-control space" tabindex="1" name="option_3" type="text" id="option_3" placeholder="Please enter option 3" value="" required="" autocomplete="off">
                      </div>
                   </div>
                </div>

                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Option 4<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <input class="form-control space" tabindex="1" name="option_4" type="text" id="option_4" placeholder="Please enter option 4" value="" required="" autocomplete="off">
                      </div>
                   </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Correct Option<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                        <div class="radio">
                            <input id="radio-1" name="answer" type="radio" value="1" checked>
                            <label for="radio-1" class="radio-label">Option 1</label>
                       </div>
                       <div class="radio">
                          <input id="radio-2" name="answer"  value="2" type="radio">
                          <label  for="radio-2" class="radio-label">Option 1</label>
                       </div>
                       <div class="radio">
                            <input id="radio-3" name="answer"  value="3"  type="radio">
                            <label for="radio-3" class="radio-label">Option 3</label>
                       </div>
                       <div class="radio">
                          <input id="radio-4" name="answer"  value="4" type="radio">
                          <label  for="radio-4" class="radio-label">Option 4</label>
                       </div>
                      </div>
                   </div>
                </div>
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Wait Time<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                        <select class="form-control" name="time">
                            <?php for($i=0;$i<=60;$i++){?>
                              <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }?>  
                        </select>
                      </div>  
                    </div>
                </div>      
              </div>  

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                   <label for="product_name" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                       <div id="ajaxMessageSurveyQuestion"></div>
                       <input type="submit" value="Save Question" name="add-product-another" class="btn btn-large btn-warning" id="add-product-another"
                      tabindex="15" autocomplete="off" style="padding: 12px 50px;margin: 0px 0px;float: left;">
                      <input type="button" class="btn btn-large btn-warning back-to-survey" value="Back to survey list" onclick="SurveyList()">
                    </div>  
                  </div>
                </div>     
              </div>
          
            </div>      
          </form>
       </div>   

     </div>
  </div>
</div>         



<script type="text/javascript">
  function showLoader(){
      document.body.classList.remove("loaded");
      document.body.classList.add("loading");
  }

  function hideLoader(){
    document.body.classList.remove("loading");
    document.body.classList.add("loaded");
  }

  function SurveyList()
    {
        localStorage.setItem('survey_id','');
        setTimeout(function() {
        swal({
            title: "Survey data saved successfully",
            text: "Go to suvey list",
            type: "success"
        }, function() {
            window.location = "<?php echo base_url('admin/survey');?>";
        });
    }, 1000);
    }

  $("form#create-survey").submit(function(e){
    showLoader();
    $this = $(this);
    var submit = $this.find('.submit');
    submit.button('loading');
    $this.find("#ajaxMessage").html("");
    var formData = new FormData(this);
    e.preventDefault();
    showLoader();
    $.ajax({
              url: $(this).attr('data-ha-url'),
              type: 'POST',
              data: formData,
              async: true,
              xhr: function(){
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function(evt){
              if (evt.lengthComputable){
                  var percentComplete = parseInt(evt.loaded / evt.total*100);
                  $this.find("#ajaxMessageSurvey").html('<div class="progress"><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'+percentComplete+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%;">'+percentComplete+'%</div></div>');
                  if(percentComplete==100){
                      console.log('Completed');
                      submit.button('reset');
                      $this.find("#ajaxMessageSurvey").html('');
                    }
                  }
              }, false);
              return xhr;
            },
            success: function (returndata){
              hideLoader();
              var data = JSON.parse(returndata);
              if(data['status'] == 'success'){
                  localStorage.setItem('survey_id',data['survey_id']);
                  $('#create-survey-div').hide();
                  $('#create-question-div').show();
                  $('#survey_id').val(data['survey_id']);
                  $("#create-survey").find('input:text, input:password, input:file, select, textarea').val('');
                  $("#create-survey").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
                  swal("Survey created successfully","Add Survey Questions Now","success");
              }
              else
              {
                swal("Survey create failed","Please try again","error");
              } 
           },
          error : function(xhr, status, error) {
            hideLoader();
            console.log(xhr.responseText);
              console.log(status);
              console.log(error);
              if(status == "error"){
                  $this.find("#ajaxMessageSurvey").html('<div class="alert alert-danger">* Something went wrong please try again later</div>');
              }
              $("#submitmeeting").attr("value",'Save Changes');
              $("#submitmeeting").prop( "disabled", false );
              submit.button('reset');
          },
          cache: false,
          contentType: false,
          processData: false
        });
        return false; 
  });  


  $("form#create-survey-question").submit(function(e){
    showLoader();
    $this = $(this);
    var submit = $this.find('.submit');
    submit.button('loading');
    $this.find("#ajaxMessage").html("");
    var formData = new FormData(this);
    e.preventDefault();
    showLoader();
    var qcounts = parseInt($('#qcounts').val());
    $.ajax({
              url: $(this).attr('data-ha-url'),
              type: 'POST',
              data: formData,
              async: true,
              xhr: function(){
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function(evt){
              if (evt.lengthComputable){
                  var percentComplete = parseInt(evt.loaded / evt.total*100);
                  $this.find("#ajaxMessageSurvey").html('<div class="progress"><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'+percentComplete+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%;">'+percentComplete+'%</div></div>');
                  if(percentComplete==100){
                      console.log('Completed');
                      submit.button('reset');
                      $this.find("#ajaxMessageSurveyQuestion").html('');
                    }
                  }
              }, false);
              return xhr;
            },
            success: function (returndata){
              hideLoader();
              var data = JSON.parse(returndata);
              if(data['status'] == 'success'){
                  qcounts = qcounts +1;
                  $('#qcounts').val(qcounts);
                  $('#qcount').html(qcounts);
                  localStorage.setItem('insert_id',data['id']);
                  swal("Survey question added successfully","Add More Questions","success");
                  $("#create-survey-question").find('input:text, input:password, input:file, textarea').val('');
                  $('#survey_id').val(localStorage.getItem('survey_id'));

              }
              else
              {
                swal("Survey question add failed","Pleas try again","error");
              } 
           },
          error : function(xhr, status, error) {
            hideLoader();
            console.log(xhr.responseText);
              console.log(status);
              console.log(error);
              if(status == "error"){
                  $this.find("#ajaxMessageSurveyQuestion").html('<div class="alert alert-danger">* Something went wrong please try again later</div>');
              }
              submit.button('reset');
          },
          cache: false,
          contentType: false,
          processData: false
        });
        return false; 
  });  
</script>