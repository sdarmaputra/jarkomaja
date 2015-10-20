      <div class="row" id="table">
        <h4>Reports</h4>

        <table class="responsive-table highlight">
          <thead>
            <tr>
                <th data-field="number">#</th>
                <th data-field="phone">Date</th>
                <th data-field="name">Group ID</th>
                <th data-field="action">Recipient ID</th>
                <th data-field="action">Coupon</th>
                <th data-field="action">Message</th>
                <th data-field="action">Status</th>
            </tr>
          </thead>

          <tbody>
            <?php 
              if ($reports) {
                $i = 1;
                foreach ($reports as $rw) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rw['tanggal']; ?></td>
                    <td><?php echo $rw['idgrup']; ?></td>
                    <td><?php echo $rw['idnomor']; ?></td>
                    <td><?php echo $rw['coupon']; ?></td>
                    <td><?php echo $rw['pesan']; ?></td>
                    <td><?php if ($rw['sukses'] == 0) echo 'proses'; else if ($rw['sukses'] == 1) echo 'terkirim'; ?></td>
                  </tr>      
            <?php $i++; }
              }
             ?>
          </tbody>
        </table>
      </div>

      
