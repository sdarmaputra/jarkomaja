<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $this->config->item('site_name'); ?></title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public'); ?>/css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('public'); ?>/css/style.css"  media="screen,projection"/>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('public'); ?>/js/materialize.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('public'); ?>/js/app.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body style="padding: 6em 0em;">
     <div class="row">
      <div class="col s1 l4">
        &nbsp;
      </div>
      <div class="col s10 l4">
          <div class="card grey lighten-4" data-position="top" data-delay="50">
              <div class="card-content">
                <div class="card-title grey-text text-darken-4">
                  <div class="center-align">JARKOMAJA | <strong>LOGIN</strong></div>
                </div>
                <form id="loginForm" action="<?php echo site_url('gate/auth'); ?>" method="POST">
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix">account_circle</i>
                      <input id="icon_prefix" name="username" type="text" class="validate">
                      <label for="icon_prefix">Username</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix">lock</i>
                      <input id="icon_telephone" name="password" type="password" class="validate">
                      <label for="icon_telephone">Password</label>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-action">
                <div class="row">
                  <a onclick="$('#loginForm').submit(); return false;" href="#" class="col s12 btn-large waves-effect waves-light btn blue darken-1 white-text">
                    <span class="center-align">Login</span>
                  </a>
                </div>
                <div class="row">
                  <a href="#" class="col s12 btn-large waves-effect waves-light btn cyan darken-1 white-text">
                    <span class="center-align">Register</span>
                  </a>
                </div>
              </div>
          </div>
          <h6 class="center-align grey-text text-lighten-1">&copy; 2015 Computer Architecture and Network Laboratory</h6>
          
      </div>
      <div class="col s1 l4">
        &nbsp;
      </div>
    </div>

    <script>
        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
        <?php } ?>
      </script>
  </body>
</html>