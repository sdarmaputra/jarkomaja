      <div class="row" id="table">
        <h4>Group Member Management | <?php echo $namagrup; ?></h4>
        <div class="chip">
          Showing 
          <?php 
            $end = $start + $limit;
            if ($end >= $recipientCount) $end = $recipientCount;
            echo ($start+1).'-'.($end).' from '.$recipientCount.' data'; 
          ?>
        </div>

        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
          <a href="<?php echo site_url('dashboard/groups'); ?>" class="btn-large waves-effect waves-light red">
            <i class="large material-icons left">chevron_left</i> Back
          </a>
          <a href="<?php echo site_url('dashboard/add_member/'.$idgrup); ?>" class="btn-large waves-effect waves-light cyan darken-1">
            <i class="large material-icons left">playlist_add</i> Add New Member
          </a>
        </div>

        <table class="responsive-table highlight">
          <thead>
            <tr>
                <th data-field="number">#</th>
                <th data-field="number">#</th>
                <th data-field="phone">Phone Number</th>
                <th data-field="name">Recipient Name</th>
                <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <form id="delete_form" action="<?php echo site_url('dashboard/delete_checked_from_group'); ?>" method="POST">
            <?php 
              if ($recipient_list) {
                $i = $start+1;
                foreach ($recipient_list as $rw) { ?>
                  <tr>
                    <td>
                      <input type="checkbox" name="delete_id[]" id="check<?php echo $rw['idnomorhp']; ?>" value="<?php echo $rw['idnomorhp']; ?>">
                      <label for="check<?php echo $rw['idnomorhp']; ?>"></label>
                    </td>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rw['nomorhp']; ?></td>
                    <td><?php echo $rw['nama']; ?></td>
                    <td>
                      <a href="#" class="red-text tooltipped" data-position="right" data-delay="50" data-tooltip="Remove from group" onclick="confirm_delete('<?php echo $rw['idnomorhp']; ?>'); return false;"><i class="material-icons">delete</i></a>
                    </td>
                  </tr>      
            <?php $i++; }
              }
             ?>
             <input type="hidden" name="idgrup" value="<?php echo $idgrup; ?>">
           </form>
          </tbody>
        </table>

        <?php echo $pagination; ?>
      </div>
      <div class="row">
        <a class="btn waves-effect waves-light red <?php if (!$recipient_list) echo 'disabled'; ?> " href="#" <?php if ($recipient_list){ ?>onclick="confirm_multiple_delete(); return false;" <?php } ?> >Delete selected</a>
      </div>

      <form action="<?php echo site_url('dashboard/delete_from_group'); ?>" method="POST" id="delete_form">
        <input type="hidden" name="idgrup" value="<?php echo $idgrup; ?>">
        <input type="hidden" name="delete_id" id="delete_id">
      </form>

      <div id="delete_modal" class="modal">
        <div class="modal-content">
          <h4>Confirm Deletion</h4>
          <p>Are you sure deleting this data from group?</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="btn waves-effect waves-light cyan darken-1 z-depth-0" id="confirm_delete_button">Yes</a>
          <a href="#!" class="modal-close btn waves-effect waves-light red z-depth-0">Cancel</a>
        </div>
      </div>

      <script>
        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
            <?php  ?>
        <?php } ?>
      </script>
