<!-- <nav class="navbar">
  <a href="" class="logo"><b><?php echo $site_name; ?></b></a>
  <div class="navbar-header" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="hidden-xs"><?php echo $user->first_name; ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <p><?php echo $user->first_name; ?></p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="panel/account" class="btn btn-default btn-flat">Account</a>
              </div>
              <div class="pull-right">
                <a href="panel/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
brand-logo      </ul>
    </div>
  </div>
</nav> -->


<!-- <div class="loading">
  <div>
    <div class="spinner-layer pl-light-green">
        <div class="circle-clipper left">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
  </div>
  <p class="loader-text">Please wait...</p>
</div> -->

<div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>


    <script type="text/javascript">
         
  $(window).on('load', function() {
    setTimeout(function() {
      $('body').addClass('loaded');
    }, 90);
  });
   </script>

    


<!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="click_menu_btn">
                <i class="material-icons menu_clas">menu</i>
                <i class="material-icons close_clas">close</i>
            </div>
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
              <!-- <img src="<?php echo base_url(); ?>assets/admin/images/intel.png" height="50" width="155" > -->
                <a class="navbar-brand " href="">
                  <?php echo $site_name; ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    
                    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">

            <img class="img_admin_icon" src="<?php echo base_url(); ?>assets/admin/images/user_1.png">
            <span class="user_name_text hidden-xs"><?php echo $user->first_name ; ?></span>
          </a>
          <ul class="dropdown-menu menu_admin_right">
            <li class="header">
              <p><?php echo $user->first_name ; ?></p>
            </li>
            <li class="footer">
              <div class="pull-left leftaln">
                <a href="panel/account" class="btn btn-info waves-effect t">Account</a>
              </div>
              <div class="pull-right rightaln">
                <a href="panel/logout" class="btn btn-danger waves-effect t">Sign out</a>
              </div>
            </li>
          </ul>
        </li>

        <li class="dropdown">
                      <a href="javascript:void(0);" onclick="toggleFullScreen(document.body)" class="ful_screen_optn dropdown-toggle" data-toggle="dropdown">
                        <i class="material-icons">settings_overscan</i>
                      </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->


<style type="text/css">
   .loading {
  width: 100%;
  height: 100%;
  opacity: 0.85;
  position: fixed;
  z-index: 2000;
}

.loading > div {
  width: 60px;
  height: 60px;
  position: absolute;
  left: 50%;
  margin-left: -30px;
  top: 50%;
  margin-top: -130px;
}
.loader-text{
  font-size: 14px;
font-weight: bold;
color: #444;
  width: 100px;
  height: 60px;
  position: absolute;
  left: 50%;
  margin-left: -38px;
  top: 50%;
  margin-top: -53px;

}
a.navbar-brand{
      font-size: 30px;
    margin: 10px;
    float: right;
    margin-left: 0px !important;
    margin-bottom: 0px;
    margin-right: 0px;
    font-weight: bold;
    margin-top: 0px;
}
</style>


<script type="text/javascript">
    $(".click_menu_btn").click(function(){
    //alert("The paragraph was clicked.");
});

$(".click_menu_btn").click(function(){
    $(".sidebar_left").toggleClass("slider_menu_hide");
});

$(".click_menu_btn").click(function(){
    $(".page_inner_wrapper").toggleClass("page_inner_wrapper_full");
});

$(".click_menu_btn").click(function(){
    $(".click_menu_btn").toggleClass("click_menu_btn_close");
});


</script>