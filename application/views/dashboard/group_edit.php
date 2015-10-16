      <div class="row" id="form">
        <h4>Edit Group</h4>
        <?php if ($details) {
          foreach ($details as $rw) { ?>
            <form class="col s12 m6 l6" id="edit_group" action="<?php echo site_url('dashboard/update_group'); ?>" method="POST">
              <div class="row">
                <div class="input-field col s11">
                  <input id="icon_prefix" name="group_name" type="text" class="validate" value="<?php echo $rw['namagrup']; ?>">
                  <label for="icon_prefix">Group Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s11">
                  <select name="group_status">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1" <?php if ($rw['status_aktif'] == 1) echo 'selected'; ?> >Active</option>
                    <option value="0" <?php if ($rw['status_aktif'] == 0) echo 'selected'; ?>>Deactive</option>                
                  </select>
                  <label>Group Status</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input type="hidden" name="group_id" value="<?php echo $rw['idgrup']; ?>">
                  <a href="#" class="btn-large waves-effect waves-light tosca" onclick="confirm_update(); return false;">Save Changes</a>
                  <a href="<?php echo site_url('dashboard/groups'); ?>" class="btn-large waves-effect waves-light red">Cancel</a>
                </div>
              </div>

              
            </form>
            <div id="update_modal" class="modal">
                <div class="modal-content">
                  <h4>Confirm Update</h4>
                  <p>Are you sure updating this data?</p>
                </div>
                <div class="modal-footer">
                  <a href="#!" class="modal-close btn waves-effect waves-light red z-depth-0">Cancel</a>
                  <a href="#!" onclick="document.getElementById('edit_group').submit(); return false;" class="btn waves-effect waves-light tosca z-depth-0" id="confirm_delete_button">Yes</a>
                </div>
              </div>
            <div class="col s12 m6 l6">
              <h6>Current Group Information:</h6>
              <div class="card grey lighten-3">
                <div class="card-content">
                  <span class="card-title grey-text text-darken-4"><?php echo $rw['namagrup']; ?></span>
                  <p class="grey-text">                        
                    <?php 
                      echo '<strong>created:</strong> '.$rw['tanggal_buat'].'<br/>'; 
                      echo '<strong>modified:</strong> '.$rw['tanggal_modifikasi'].'<br/>';
                      if ($rw['status_aktif'] == 1) echo 'ACTIVATED'; 
                      else echo 'DEACTIVATED';
                    ?>
                  </p>
                </div>
              </div>
            </div>
        <?php }
        } ?>
        
      </div>

      <script>
        $(document).ready(function() {
          $('select').material_select();
        });

        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
        <?php } ?>
      </script>