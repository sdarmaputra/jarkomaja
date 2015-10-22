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

  <body>
    <div class="navbar-fixed">
      <ul id="dropdown_user" class="dropdown-content">
        <li><a href="#!"><i class="left material-icons">settings</i>Profile Settings</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo site_url('gate/logout'); ?>"><i class="left material-icons">power_settings_new</i>Log Out</a></li>
      </ul>
      <nav>
        <div class="nav-wrapper cyan accent-4">
          <a href="#!" class="brand-logo" style="padding: 0.2em 0.5em;"><i class="left material-icons">perm_phone_msg</i><?php echo $this->config->item('site_name'); ?></a>
          <ul class="right hide-on-med-and-down">
            <li style="width:350px; text-align:right;"><a class="dropdown-button" href="#!" data-activates="dropdown_user">What's up! <?php echo $this->session->userdata('username'); ?><i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
      </nav>
    </div>

    <div class="row" style="margin:0px;">

      <div id="sidebar" class="col s12 m3 l2 grey lighten-2 z-depth-1" style="padding:0; height: 700px;"> 
        <div class="collection" style="padding:0; margin:0;">
          <a href="<?php echo site_url('dashboard'); ?>" class="collection-item"><i class="left material-icons">web</i>Dashboard</a>
          <a href="<?php echo site_url('dashboard/broadcast'); ?>" class="collection-item"><i class="left material-icons">message</i>Broadcast Messages</a>
          <a href="<?php echo site_url('dashboard/groups'); ?>" class="collection-item"><i class="left material-icons">perm_contact_calendar</i>Group Management</a>
          <a href="<?php echo site_url('dashboard/recipients'); ?>" class="collection-item"><i class="left material-icons">perm_contact_calendar</i>Recipient Management</a>
          <a href="<?php echo site_url('dashboard/reports'); ?>" class="collection-item"><i class="left material-icons">view_list</i>Reports</a>
        </div>
      </div>

      <div class="col s12 m9 l10" id="content">
          <div class="container" style="padding: 3em 0em;">
            <?php echo $body; ?>
          </div>
      </div>
    </div>
    <footer class="page-footer cyan accent-4" style="margin:0px; padding:0px;">
      <div class="footer-copyright cyan accent-4">
        <div class="container cyan accent-4">
        &copy; 2015 Computer Architecture and Network Laboratory
        </div>
      </div>
    </footer>
    <script>
      window.onload = function() {
        var height;
        var win = $(window).height();
        var content = $('#content').height();
        if ( win > 600 || content > 600) {
          if (win > content) height = win + 'px';
          else height = content + 'px';
        } 
        document.getElementById('sidebar').style.height = height;  
      }
    </script>
  </body>
</html>