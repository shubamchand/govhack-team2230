<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_vehicleType" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>vehicle Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$users = $conn->query("SELECT id,concat(firstname,' ',lastname) as name FROM users where `type` =2  ");
					$assignees = array();
					while($urow = $users->fetch_assoc()){
						$assignees[$urow['id']] = ucwords($urow['name']);
					}
					$qry = $conn->query("SELECT * FROM vehicle_type order by id asc  ");
					while($row= $qry->fetch_assoc()):
						// $assignee = isset($assignees[$row['user_id']]) ? $assignees[$row['user_id']] : "N/A";
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['type']) ?></b></td>

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
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_vehicleType">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_vehicleType" data-id="<?php echo $row['id'] ?>">
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
		$('.new_vehicleType').click(function(){
			uni_modal("New vehicleType","./vehicle_types/manage.php")
		})
		$('.manage_vehicleType').click(function(){
			uni_modal("Manage vehicleType","./vehicle_types/manage.php?id="+$(this).attr('data-id'))
		})
		
		$('.delete_vehicleType').click(function(){
		_conf("Are you sure to delete this vehicleType?","delete_vehicleType",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_vehicleType($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_vehicletype',
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