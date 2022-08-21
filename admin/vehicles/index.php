<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_vehicle" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Vehicle Type</th>
						<th>Registration ID</th>
						<th>Vehicle details</th>
						<th>VIN</th>
						<th>QR Code</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM vehicle_registration order by id asc  ");
					while($row= $qry->fetch_assoc()):
						$typeId = $row['regType'];
						$typeqry = $conn->query("SELECT id, type FROM vehicle_type where `id` = '$typeId'");
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php while($rowType = $typeqry->fetch_assoc()): echo ucwords($rowType['type']); endwhile; ?></b></td>
						<td><b><?php echo $row['registrationId'] ?></b></td>
						<td>
							<small><b>Make:</b> <?php echo $row['make'] ?></small><br>
							<small><b>Model:</b> <?php echo $row['model'] ?></small><br>
							<small><b>Transmission:</b> <?php echo $row['transmission'] ?></small>
							<small><b>Body:</b> <?php echo $row['body'] ?></small>
							<small><b>Color:</b> <?php echo $row['color'] ?></small>
							<small><b>Year:</b> <?php echo $row['year'] ?></small>
						</td>
						<td><b><?php echo $row['vin'] ?></b></td>
						<td><span><a href="javascript:void(0)" class="view_data" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span></td>

						<!-- <td class="text-center">
							<?php 
							//if(strtotime($row['datetime_start']) > time()): ?>
								<span class="badge badge-light">Not available</span>
							<?php //elseif(strtotime($row['datetime_end']) <= time()): ?>
								<span class="badge badge-success">Good condition</span>
							<?php //elseif((strtotime($row['datetime_start']) < time()) && (strtotime($row['datetime_end']) > time())): ?>
								<span class="badge badge-primary">Faulty</span>
							<?php //endif; ?>
						</td> -->
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_vehicle">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_vehicle" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.new_vehicle').click(function(){
			uni_modal("New vehicle","./vehicles/manage.php")
		})
		$('.manage_vehicle').click(function(){
			uni_modal("Manage vehicle","./vehicles/manage.php?id="+$(this).attr('data-id'))
		})
		
		$('.view_data').click(function(){
			//uni_modal("QR","./vehicles/view.php?id="+$(this).attr('data-id'))
          var id = $(this).attr('data-id');
          window.open('https://govhack.x10.mx/admin/vehicles/qrgen.php?vehicleid=' + id, 'newwin', 'height=500px,width=500px');
		})
		
		$('.delete_vehicle').click(function(){
		_conf("Are you sure to delete this vehicle?","delete_vehicle",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_vehicle($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_vehicle',
			method:'POST',
			data:{id:$id},
			dataType:"json",
			error:err=>{
				alert_toast("An error occured");
				end_loader()
			},
			success:function(resp){
				if(resp.status=="success"){
					location.reload()
				}else{
					alert_toast("Deleting Data Failed");
				}
				end_loader()
			}
		})
	}
</script>