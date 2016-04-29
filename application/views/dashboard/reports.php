      <div class="row" id="table">
        <h4>Reports</h4>
        <div class="chip">
          Showing 
          <?php 
            $end = $start + $limit;
            if ($end >= $reportsCount) $end = $reportsCount;
            echo ($start+1).'-'.($end).' from '.$reportsCount.' data'; 
          ?>
        </div>
        <table class="responsive-table highlight">
          <thead>
            <tr>
                <th data-field="number">#</th>
                <th data-field="phone">Date</th>
                <th data-field="name">Group ID</th>
                <th data-field="action">Recipient ID</th>
                <th data-field="action">Message</th>
                <th data-field="action">Length</th>
                <th data-field="action">Status</th>
            </tr>
          </thead>

          <tbody>
            <?php 
              if ($reports) {
                $i = $start+1;
                foreach ($reports as $rw) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($rw['tanggal'])); ?></td>
                    <td><?php echo $rw['namagrup']; ?></td>
                    <td class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $rw['nomorhp']; ?>"><?php echo substr($rw['nama'],0,15); if (strlen($rw['nama']) > 15 ) echo '...'; ?></td>
                    <td class="tooltipped" data-position="bottom" data-delay="50" data-tooltip=<?php echo $rw['pesan']; ?>><?php echo substr($rw['pesan'],0,30); if (strlen($rw['pesan']) > 30 ) echo '...'; ?></td>
                    <td><?php echo $rw['biaya']; ?></td>
                    <td><?php if ($rw['sukses'] == 0) echo 'proses'; else if ($rw['sukses'] == 1) echo 'terkirim'; ?></td>
                  </tr>      
            <?php $i++; }
              }
             ?>
          </tbody>
        </table>
        
        <?php echo $pagination; ?>
        
      </div>

      