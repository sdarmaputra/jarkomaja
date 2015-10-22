      <div class="row" id="table">
        <h4>Recipient Management</h4>

        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
          <a class="btn-large waves-effect waves-light teal" onclick="switchElement('form', 'table'); return false;">
            <i class="large material-icons left">playlist_add</i> Add New Recipient
          </a>
        </div>

        <table class="responsive-table highlight">
          <thead>
            <tr>
                <th data-field="number">#</th>
                <th data-field="phone">Phone Number</th>
                <th data-field="name">Recipient Name</th>
                <th data-field="action">Actions</th>
            </tr>
          </thead>

          <tbody>
            <?php 
              if ($recipient_list) {
                $i = 1;
                foreach ($recipient_list as $rw) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rw['nomorhp']; ?></td>
                    <td><?php echo $rw['nama']; ?></td>
                    <td>
                      <a class="teal-text" href="<?php echo site_url('dashboard/recipients/edit/'.$rw['idnomorhp']); ?>"><i class="material-icons">settings</i></a>
                      <a class="red-text" href="#" onclick="confirm_delete('<?php echo $rw['idnomorhp']; ?>'); return false;"><i class="material-icons">delete</i></a>
                    </td>
                  </tr>      
            <?php $i++; }
              }
             ?>
          </tbody>
        </table>
      </div>

      <div class="row" id="form" style="display:none;">
        <h4>New Recipient</h4>
        <form class="col s12" id="new_recipient" action="<?php echo site_url('dashboard/add_recipient'); ?>" method="POST">
          <div class="row">
            <div class="input-field col s6">
              <i class="material-icons prefix">account_circle</i>
              <input id="icon_prefix" type="text" name="nama" class="validate">
              <label for="icon_prefix">Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <i class="material-icons prefix">phone</i>
              <input id="icon_telephone" type="tel" name="nomor_hp" class="validate">
              <label for="icon_telephone">Phone Number</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <a href="#" onclick="switchElement('table', 'form'); return false;" class="btn-large waves-effect waves-light red">Cancel</a>
              <a href="#" onclick="document.getElementById('new_recipient').submit(); return false;" class="btn-large waves-effect waves-light teal">Submit</a>
            </div>
          </div>
        </form>
      </div>

      <form action="<?php echo site_url('dashboard/delete_recipient'); ?>" method="POST" id="delete_form">
        <input type="hidden" name="delete_id" id="delete_id">
      </form>

      <div id="delete_modal" class="modal">
        <div class="modal-content">
          <h4>Confirm Deletion</h4>
          <p>Are you sure deleting this data?</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="btn waves-effect waves-light teal z-depth-0" id="confirm_delete_button">Yes</a>
          <a href="#!" class="modal-close btn waves-effect waves-light red z-depth-0">Cancel</a>
        </div>
      </div>

      <script>
        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
            <?php  ?>
        <?php } ?>
      </script>
