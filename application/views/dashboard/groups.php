      <div class="row" id="table">
        <h4>Group Management </h4>

        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
          <a class="btn-large waves-effect waves-light tosca" onclick="switchElement('form', 'table'); return false;">
            <i class="large material-icons left">playlist_add</i> Add New Group
          </a>
        </div>

        <div class="row">
          <?php
            if ($group_list) {
              foreach ($group_list as $rw) { ?>
                <div class="col s6 m5 l4">
                  <div class="card red accent-2 tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $rw['namagrup']; ?>">
                    <div class="card-content">
                      <span class="card-title truncate"><?php echo $rw['namagrup']; ?></span>
                      <p class="red-text text-lighten-4">                        
                        <?php 
                          echo '<strong>created:</strong> '.$rw['tanggal_buat'].'<br/>'; 
                          echo '<strong>modified:</strong> '.$rw['tanggal_modifikasi'].'<br/>';
                          if ($rw['status_aktif'] == 1) echo 'ACTIVATED'; 
                          else echo 'DEACTIVATED';
                        ?>
                      </p>
                    </div>
                    <div class="card-action">
                      <a href="<?php echo site_url('dashboard/groups/edit/'.$rw['idgrup']); ?>"><i class="material-icons">settings</i></a>
                      <a href="#" onclick="confirm_delete('<?php echo $rw['idgrup']; ?>'); return false;"><i class="material-icons">delete</i></a>
                    </div>
                  </div>
                </div>
        <?php }
            }
          ?>
        </div>
      </div>

      <div class="row" id="form" style="display:none;">
        <h4>New Group</h4>
        <form class="col s12" id="new_group" action="<?php echo site_url('dashboard/add_group'); ?>" method="POST">
          <div class="row">
            <div class="input-field col s6">
              <i class="material-icons prefix">perm_contact_calendar</i>
              <input id="icon_prefix" name="group_name" type="text" class="validate">
              <label for="icon_prefix">Group Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <a href="#" onclick="document.getElementById('new_group').submit(); return false;" class="btn-large waves-effect waves-light tosca">Submit</a>
              <a href="#" onclick="switchElement('table', 'form'); return false;" class="btn-large waves-effect waves-light red">Cancel</a>
            </div>
          </div>
        </form>
      </div>

      <form action="<?php echo site_url('dashboard/delete_group'); ?>" method="POST" id="delete_form">
        <input type="hidden" name="delete_id" id="delete_id">
      </form>

      <div id="delete_modal" class="modal">
        <div class="modal-content">
          <h4>Confirm Deletion</h4>
          <p>Are you sure deleting this data?</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close btn waves-effect waves-light red z-depth-0">Cancel</a>
          <a href="#!" class="btn waves-effect waves-light tosca z-depth-0" id="confirm_delete_button">Yes</a>
        </div>
      </div>

      <script>
        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
        <?php } ?>
      </script>