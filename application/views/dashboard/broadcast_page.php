      <div class="row" id="form">
        <h4>Broadcast Message</h4>
            <form id="send_form" class="col s12 m12 l12" action="<?php echo site_url('dashboard/broadcast/send'); ?>" method="POST">
              <div class="row">                
                <div class="row">
                  <div class="input-field col s12">
                    <textarea id="icon_prefix2" class="materialize-textarea" name="smstext"></textarea>
                    <label for="icon_prefix2">Message Content</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s8">
                  <select name="idgrup">
                    <option value="" disabled selected>Choose your option</option>
                    <?php if ($group_list) {
                      foreach ($group_list as $rw) { ?>
                          <option value="<?php echo $rw['idgrup'] ;?>" ><?php echo $rw['namagrup'] ;?></option>
                    <?php }
                    } ?>
                  </select>
                  <label>Target Group</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <a href="#" class="btn-large waves-effect waves-light tosca" onclick="confirm_send(); return false;">Sent Message</a>
                </div>
              </div>
            </form>
            <div id="send_modal" class="modal">
              <div class="modal-content">
                <h4>Confirmation</h4>
                <p>Are you sure sending this message?</p>
              </div>
              <div class="modal-footer">
                <a href="#!" class="modal-close btn waves-effect waves-light red z-depth-0">Cancel</a>
                <a href="#!" onclick="document.getElementById('send_form').submit(); return false;" class="btn waves-effect waves-light tosca z-depth-0" >Yes</a>
              </div>
            </div>
      </div>

      <script>
        $(document).ready(function() {
          $('select').material_select();
        });

        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
        <?php } ?>
      </script>