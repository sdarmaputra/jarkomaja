      <div class="row" id="table">
        <h4>Add Group Member to <?php echo $namagrup; ?></h4>
        <div class="chip">
          Showing 
          <?php 
            $end = $start + $limit;
            if ($end >= $recipientCount) $end = $recipientCount;
            echo ($start+1).'-'.($end).' from '.$recipientCount.' data'; 
          ?>
        </div>

        <table class="responsive-table highlight">
          <thead>
            <tr>
                <th data-field="check">#</th>
                <th data-field="number">#</th>
                <th data-field="phone">Phone Number</th>
                <th data-field="name">Recipient Name</th>
            </tr>
          </thead>

          <tbody>
            <form id="add_form" action="<?php echo site_url('dashboard/do_add_member'); ?>" method="POST">
            <?php 
              if ($recipient_list) {
                $i = $start+1;
                foreach ($recipient_list as $rw) { ?>
                  <tr>
                    <td>
                      <input type="checkbox" name="add_id[]" id="check<?php echo $rw['idnomorhp']; ?>" value="<?php echo $rw['idnomorhp']; ?>">
                      <label for="check<?php echo $rw['idnomorhp']; ?>"></label>
                    </td>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rw['nomorhp']; ?></td>
                    <td><?php echo $rw['nama']; ?></td>
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
        <a class="btn waves-effect waves-light red" href="<?php echo site_url('dashboard/group_member/'.$idgrup); ?>" >Cancel</a>
        <a class="btn waves-effect waves-light cyan darken-1 <?php if (!$recipient_list) echo 'disabled'; ?> " href="#" <?php if ($recipient_list){ ?>onclick="$('#add_form').submit(); return false;" <?php } ?> >Submit</a>
      </div>

      <script>
        <?php if ( null != $this->session->flashdata('after_process') && $this->session->flashdata('after_process') == true){ ?>
            Materialize.toast('<?php echo $this->session->flashdata("messages"); ?>', 5000);
            <?php  ?>
        <?php } ?>
      </script>
