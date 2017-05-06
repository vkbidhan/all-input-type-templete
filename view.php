<?php include 'inc/header.php'; ?>

	<div class="panel-heading">
		<h2 class="text-center">Student List</h2>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-bordered table-condensed">
		<thead>
			<tr>
				<th width="5%">Serial</th>
				<th width="15%">Name</th>
				<th width="15%">Email</th>
				<th width="10%">Country</th>
				<th width="10%">Gender</th>
				<th width="10%">Avatar</th>				
				<th width="20%">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>01</td>
				<td>Bidhan sutradhar</td>
				<td>Bidhanvk@gmail.com</td>
				<td>Bangladesh</td>
				<td>Male</td>
				<td><img src="img/capcha.png" width="70px" height="40px" /></td>
				<td>
					<a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">View</a>
					<a class="btn btn-default btn-lg" href="edit.php">Edit</a>
					<a class="btn btn-danger btn-lg" href="delete.php" onclick="return confirm('After deleting data will be store into recycle bin ?')">Remove</a>
				</td>
			</tr>
		</tbody>
		</table>

		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Sutdent Indivisual information</h4>
					</div>
					<div class="modal-body">
						<label class="pull-right"><img width="150px" height="80px" src="img/favicon.png"></label>
						<label> Name &nbsp;&nbsp;&nbsp; :</label><span> Bidhan Sutradhar </span><br/>
						<label> Email &nbsp;&nbsp;&nbsp; : </label><span> bidhanvk@gmail.com </span><br/>
						<label> Website : </label><span> http://www.imbidhan.com </span><br/>
						<label> Country : </label><span> Bangladesh </span><br/>
						<label> Subject : </label><span> Computer </span><br/>
						<label> Gender  : </label><span> Male </span><br/>
						<span class="text-center">Create Date : </span> <label>10/10/2010</label>
						<span  class="pull-right">
							<a href="pdf.php">Save as pdf </a> || <a href="xl.php">Save as Xl </a>
						</span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div> 
		<ul class="pagination">
		   <li><a href="#" aria-label="Previous"><span aria-hidden="true">First</span></a></li>
		   <li><a href="#">1</a></li>
		   <li><a href="#">2</a></li>
		   <li><a href="#">3</a></li>
		   <li><a href="#">4</a></li>
		   <li><a href="#">5</a></li>
		   <li><a href="#" aria-label="Previous"><span aria-hidden="true">Next</span></a></li>
		</ul>
	</div>
<?php include 'inc/footer.php'; ?>