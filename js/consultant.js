$(document).ready(function(){	
	var consultantRecords = $('#consultantListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		'serverMethod': 'post',
		"order":[],
		"ajax":{
			url:"consultant_action.php",
			type:"POST",
			data:{action:'listconsultants'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7, 8],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

	$('#addconsultant').click(function(){
		$('#consultantModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#consultantForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add consultant");
		$('#action').val('addconsultant');
		$('#save').val('Save');
	});

	$("#consultantListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getconsultant';
		$.ajax({
			url:'consultant_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
				$("#consultantModal").on("shown.bs.modal", function () {
					$('#id').val(data.id);
					$('#name').val(data.name);
					$('#fee').val(data.fee);
					$('#specialization').val(data.specialization_id);
					$('#mobile').val(data.mobile);
					$('#address').val(data.address);
					$('#email').val(data.email);
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit consultant");
					$('#action').val('updateconsultant');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#consultantModal").on('submit','#consultantForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"consultant_action.php",
			method:"POST",
			data:formData,
			success:function(data){
				$('#consultantForm')[0].reset();
				$('#consultantModal').modal('hide');
				$('#save').attr('disabled', false);
				consultantRecords.ajax.reload();
			}
		})
	});

	$("#consultantListing").on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getconsultant';
		$.ajax({
			url:'consultant_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
				$("#consultantDetails").on("shown.bs.modal", function () {
					$('#d_name').html(data.name);
					$('#d_specialization').html(data.specialization);
					$('#d_fee').html(data.fee);
					$('#d_email').html(data.email);
					$('#d_mobile').html(data.mobile);
					$('#d_address').html(data.address);
				}).modal();
			}
		});
	});

	$("#consultantListing").on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = "deleteconsultant";
		if(confirm("Are you sure you want to delete this consultant?")) {
			$.ajax({
				url:"consultant_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {
					consultantRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

});
