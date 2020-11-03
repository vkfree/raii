<style type="text/css">
.form-group .form-control{
	border: 1px solid #b5b0b0 !important;
  	padding: 0px 10px;
}
.panel-body {
    padding: 40px;
    border: 1px solid #ededed;
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
</style>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<div class="row">
   <div class="col-sm-12">
      <div class="panel lobidrag" id="create-survey-div">
         <form action="#" data-ha-url="<?php echo base_url('en/admin/rewards/store');?>" class="form-vertical" method="post" id="create-store" name="create-store" enctype="multipart/form-data"  accept-charset="utf-8">
            <input type="hidden"  name="id" value="<?php echo @$store_data[0]['id'];?>">
            <div class="panel-body">
  	          <div class="row">
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Name<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <textarea class="form-control space" tabindex="1" name="name" type="text" id="name" placeholder="Please enter coupoun name"  required="" autocomplete="off"><?php echo @$store_data[0]['name'];?></textarea>
                      </div>
                   </div>
                </div>
              
  			        <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Price<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <textarea class="form-control space" tabindex="1" name="coupoun" type="text" id="coupoun" placeholder="Please enter coupoun value"  required="" autocomplete="off"><?php echo @$store_data[0]['price'];?></textarea>
                      </div>
                   </div>
                </div>
             </div>

             <div class="row">  
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">Start Date<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <input  class="form-control" type = "text" name="start_date" id = "datepicker-13" value="<?php echo @$store_data[0]['start_date'];?>" required>
                      </div>
                   </div>
                </div>
              
                <div class="col-sm-6">
                   <div class="form-group row">
                      <label for="product_name" class="col-sm-2 col-form-label">End Date<i class="text-danger">*</i></label>
                      <div class="col-sm-10">
                          <input class="form-control" type = "text" name="end_date" id = "datepicker-23" value="<?php echo @$store_data[0]['start_date'];?>" required>
                      </div>
                   </div>
                </div>
             </div>

  			    <div class="row">
				      <div class="col-sm-6">
	              <div class="form-group row">
	                  <label for="product_name" class="col-sm-2 col-form-label">Upload Image<i class="text-danger">*</i></label>
	                  <div class="col-sm-10">
                       <input type="hidden" name="past" value="<?php echo @$store_data[0]['image'];?>">
	                     <input type="file" id="file1" name="upload_image" <?php if(empty(@$store_data[0]['image'])){?> required="" <?php }?> />
	                  </div>
	              </div> 
	            </div>       	
  			    </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group row">
                    <label for="product_name" class="col-sm-2 col-form-label">Status<i class="text-danger">*</i></label>
                    <div class="col-sm-10">
                       <div class="radio">
                            <input id="radio-1" name="status" type="radio" value="active" checked="">
                            <label for="radio-1" class="radio-label">Active</label>
                       </div>
                       <div class="radio">
                          <input id="radio-2" name="status" value="in-active" type="radio">
                          <label for="radio-2" class="radio-label">In-active</label>
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

   </div>
</div>      	

<script>
   $(function() {
      $( "#datepicker-13" ).datepicker({
        appendText:"Select Start date",
        dateFormat:"yy-mm-dd",
      });
      $( "#datepicker-13" ).datepicker("show");

      $( "#datepicker-23" ).datepicker({
        appendText:"Select Start date",
        dateFormat:"yy-mm-dd",
      });
      $( "#datepicker-23" ).datepicker("show");
   });
</script>

<script type="text/javascript">
  function showLoader(){
      document.body.classList.remove("loaded");
      document.body.classList.add("loading");
  }

  function hideLoader(){
    document.body.classList.remove("loading");
    document.body.classList.add("loaded");
  }

  $("form#create-store").submit(function(e){
    showLoader();
    $this = $(this);
    var submit = $this.find('.submit');
    submit.button('loading');
    $this.find("#ajaxMessage").html("");
    var formData = new FormData(this);
    e.preventDefault();
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
                setTimeout(function() {
                      swal({
                          title: "Success",
                          text: data['msg'],
                          type: "success"
                      }, function() {
                          window.location = "<?php echo base_url('admin/rewards/list');?>";
                      });
                  }, 1000);
              }
              else
              {
                swal(data['msg'],"Please try again","error");
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
</script>