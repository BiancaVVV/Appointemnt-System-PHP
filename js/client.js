$(document).ready(function(){
	var clientRecords = $('#clientListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		'serverMethod': 'post',
		"order":[],
		"ajax":{
			url:"client_action.php",
			type:"POST",
			data:{action:'listclient'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 8, 9, 10],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

	$('#addclient').click(function(){
		$('#clientModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#clientForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add client");
		$('#action').val('addclient');
		$('#save').val('Save');
	});

	$("#clientListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getclient';
		$.ajax({
			url:'client_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
				$("#clientModal").on("shown.bs.modal", function () {
					$('#id').val(data.id);
					$('#name').val(data.name);
					$('#gender').val(data.gender);
					$('#age').val(data.age);
					$('#email').val(data.email);
					$('#mobile').val(data.mobile);
					$('#address').val(data.address);
					$('#history').val(data.medical_history);
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit client");
					$('#action').val('updateclient');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#clientModal").on('submit','#clientForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"client_action.php",
			method:"POST",
			data:formData,
			success:function(data){
				$('#clientForm')[0].reset();
				$('#clientModal').modal('hide');
				$('#save').attr('disabled', false);
				clientRecords.ajax.reload();
			}
		})
	});

	$("#clientListing").on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getclient';
		$.ajax({
			url:'client_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){
				$("#clientDetails").on("shown.bs.modal", function () {
					$('#p_name').html(data.name);
					$('#p_gender').html(data.gender);
					$('#p_age').html(data.age);
					$('#p_email').html(data.email);
					$('#p_mobile').html(data.mobile);
					$('#p_address').html(data.address);
					$('#p_history').html(data.medical_history);
				}).modal();
			}
		});
	});

	$("#clientListing").on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = "deleteclient";
		if(confirm("Are you sure you want to delete this client?")) {
			$.ajax({
				url:"client_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {
					clientRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

});
