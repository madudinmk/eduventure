<?php 

date_default_timezone_set("Asia/Kuala_Lumpur");
//echo date('d/m/Y H:i:s');
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eduventure: Admin Panel</title>
<link rel="stylesheet" href="css/admin_panel_bootstrap.css"> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Below CSS link take precedence	as it loaded the last CSS-->
<link rel="stylesheet" href="css/admin_panel_bootstrap.css">
<!-- Above CSS link take precedence	as it loaded the last CSS-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
<script type="text/javascript" src="jquery.js"></script>
</head>
<body>
  <div class="container">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-4">
						<h2>Booking <b>Lists</b></h2>
					</div>
					<div class="col-sm-8">						
						<a id="refresher" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh List</span></a>
					</div>
        </div>
      </div>
			<div class="table-filter">
				<div class="row">
          <div class="col-sm-3">
						<div class="show-entries">
							<span>Show</span>
							<select id="dropdown-norows" class="form-control"></select>
							<span>entries</span>
						</div>
					</div>
          <div class="col-sm-9">
						<button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
						<div class="filter-group">
							<input type="text" class="form-control" placeholder="Reservation ID, Dates, Names">
						</div>
						<div class="filter-group">
							<label>Status</label>
							<select id="dropdown-status" class="form-control"></select>
						</div>
						<span class="filter-icon"><i class="fa fa-filter"></i></span>
          </div>
        </div>
			</div>

			<div id="tbl-listing">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Reservation ID</th>
						<th>Customer Name</th>
						<th>Check-in Date</th>						
            <th>Check-out Date</th>						
						<th>Status</th>
						<th>Action</th>
          </tr>
        </thead>
        <tbody id="tbody-content"></tbody>
      </table>
			</div> <!-- #tbl-listing -->

			<!-- refresh loader -->
			<div id="refresh-loader" style="display: none; text-align: center;">
        <img src="ajax-loader.gif">
      </div> 

			<div class="clearfix">
        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
          <ul class="pagination">
            <li class="page-item disabled"><a href="#">Previous</a></li>
            <li class="page-item"><a href="#" class="page-link">1</a></li>
            <li class="page-item"><a href="#" class="page-link">2</a></li>
            <li class="page-item"><a href="#" class="page-link">Next</a></li>
        </ul>
      </div>
    </div> <!-- Table Wrapper -->
  </div> <!-- Container -->



<!-- Modal HTML -->
	<div id="editEmployeeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">						
						<h4 class="modal-title">Booking Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<!-- ajax loader -->
						<div id="modal-loader" style="display: none; text-align: center;">
           		<img src="ajax-loader.gif">
           	</div>
				<!-- mysql data will be load here -->                     
            <div id="dynamic-content">
            	<div class="row"> 
                <div class="col-md-12">     
                  <div class="table-responsive">        
                    <table class="table table-striped table-bordered">
                    	<tr>
		                    <th>Reservation ID</th>
		                    <td id="txt_id"></td>
	                    </tr>
	                    <tr>
		                    <th>Name</th>
		                    <td id="txt_name"></td>
	                    </tr>           
	                    <tr>
		                    <th>Email</th>
		                    <td id="txt_email"></td>
	                    </tr>                   
	                    <tr>
		                    <th>Phone</th>
		                    <td id="txt_phone"></td>
	                    </tr>
	                    <tr>
		                    <th>No of Guests</th>
		                    <td id="txt_guests"></td>
	                    </tr>
	                    <tr>
		                    <th>Booking Timestamp</th>
		                    <td id="txt_timestamp"></td>
	                    </tr>
	                    <tr>
		                    <th>Status</th>
		                    <td>
		                    	<span id="bull_status" class="status">&bull;</span><span id="txt_status"></span><span id="btn-status" style="margin-left:5vw"></span>
		                    </td>
	                    </tr>         
                    </table>       
                  </div>                
                </div> 
              </div>
            </div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
						<a id="delete_data" class="btn btn-danger">Delete</a>
					</div>
			</div>
		</div>
	</div> <!-- Modal -->
<script type="text/javascript" src="js/ajax.js"></script>
</body>
</html>                                		                            