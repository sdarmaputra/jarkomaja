	
		<div class="row">
	      <div class="col s12 m7">
	        <div class="card-panel blue darken-2">
	          <span class="white-text">
	          	<h4>Welcome, <?php echo $this->session->userdata('username'); ?>!</h4>
	          	<strong>JARKOMAJA</strong> is an application which has purpose to help people broadcast their messages into community.
	          	You can make some groups and decide which recipient can be member of the group.
	          	Everything is based on your need and feel free to add groups and recipient as much as you need.
	          	<br/> <br/>
	          	Best regards,<br/>
	          	JARKOMAJA Teams.
	          </span>
	        </div>

	        <div class="card-panel blue darken-2">
	          <span class="white-text">
	          	<h4>We are still working :)</h4>
	          	<strong>JARKOMAJA</strong> is under development. Help us by giving feedback and support.
	          </span>
	        </div>

	      </div>

	      <div class="col s12 m5">
	        <div class="card-panel cyan darken-1">
	          <span class="white-text">
	          	<h4>Our Stuffs</h4>
	          	We are offering some great features, such as:
	          	<ul>
	          		<li>Broadcast Messages</li>
	          		<li>Adding New Groups</li>
	          		<li>Editing Group Detail</li>
	          		<li>Adding New Recipients</li>
	          		<li>Editing Recipient Details</li>
	          		<li>Assigning Recipient Into Group(s)</li>
	          		<li>Message Delivery Reports</li>
	          	</ul>
	          </span>
	        </div>
	      </div>

	    </div>

	    <hr></hr>

	    <div class="row" style="padding-top: 2em;">
	    	<h5 style="padding-left: 0.5em;">Your Statistics</h5>
	    	<div class="col s12 m5">
		        <div class="card-panel amber lighten-1">
		          <span class="white-text">
		          	<h3><?php echo $group_count; ?></h3>
		          	<h5>Managed Group</h5>
		          	<a class="white-text" href="<?php echo site_url('dashboard/groups'); ?>">Go to groups page<i class="material-icons left">launch</i></a>
		          </span>
		        </div>
		    </div>

		    <div class="col s12 m5">
		        <div class="card-panel amber lighten-1">
		          <span class="white-text">
		          	<h3><?php echo $report_count; ?></h3>
		          	<h5>Delivery Reports</h5>
		          	<a class="white-text" href="<?php echo site_url('dashboard/reports'); ?>">Go to reports page <i class="material-icons left">launch</i></a>
		          </span>
		        </div>
		    </div>

	    </div>
	