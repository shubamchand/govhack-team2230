<?php
$vehicle_id = isset($_GET['vid'])? $_GET['vid'] : '';
$user = isset($_GET['id'])? $_GET['id'] : '';

?>
<style>
.alert{
	border: 1px solid #f9000059;
	background-color: #f9000059
}
</style>



	<noscript>
		<style>
			table{
				border-collapse:collapse;
				width: 100%;
			}
			tr,td,th{
				border:1px solid black;
			}
			td,th{
				padding: 3px;
			}
			.text-center{
				text-align: center;
			}
			.text-right{
				text-align: right;
			}
			p{
				margin: unset;
			}
			.alert{
				border: 1px solid #f9000059;
				background-color: #f9000059
			}
		</style>
	</noscript>
	<script>
		function _Print(){
			start_loader();
			var ns = $('noscript').clone()
			var report = $('#report-tbl-holder').clone()
			var head = $('head').clone()

			var _html = report.prepend(ns.html())
				_html.prepend(head)
			var nw = window.open('','_blank',"height=900,width=1200");
			nw.document.write(_html.html())
			nw.document.close()
			nw.print()

			setTimeout(function(){
				nw.close()
				end_loader()
			})
		}
		$(document).ready(function(){
			$('.select2').select2();
			$('#filter-frm').submit(function(e){
				e.preventDefault()
				location.replace(_base_url_+'admin/?page=reports&vid='+$('#vehicle_id').val()+'&id='+$('#audience_id').val()+'&monthlyearly='+$('#monthlyearly').val())
			})
		})

		$(document).ready(function(){
		$('.new_attendance').click(function(){
			uni_modal("New Audience","./reports/manage.php")
		})
		$('.manage_audience').click(function(){
			uni_modal("Manage Attendance","./reports/manage.php?id="+$(this).attr('data-id')+"&vid="+$('#vehicle_id').val())
		})
		
		$('.view_data').click(function(){
			uni_modal("QR","./reports/view.php?id="+$(this).attr('data-id'))
		})
		
		$('.delete_audience').click(function(){
		_conf("Are you sure to delete this record?","delete_audience",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_audience($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_report',
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
</div>