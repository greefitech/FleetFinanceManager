$(document).ready(function(){

	$('#income_list_table').on('click','.edit_expense_type',function (e) {
		e.preventDefault();
		var expense_type_id = $(this).attr('id');
		console.log(expense_type_id);
		get_expense_type(expense_type_id);
		function get_expense_type(id){
			$.ajax({
				type:"POST",
				url:"../controller/get_expense_type.php",
				data:{'id':id},
				success:function(data){
					var data = JSON.parse(data);
					if (data['status']=='success') {
						$("#expense_id_edit").val(data['id']);
						$("#expense_name_edit").val(data['expense']);
						$("#expense_type_edit").val(data['type']);
					}
					else{
						$("#edit_expense_type").hide();
					}
				}
			})
		}

	});

	$("#update_expense_type").click(function(e){
		e.preventDefault();
			$.ajax({
				type:"POST",
				url:"../controller/update_expense_type.php",		
				data: $('form').serialize(),
				success:function(data){
					var data = JSON.parse(data);
					if (data['status']=='success') {
						$("#edit_expense_type").hide();
					setTimeout(function(){
						location.reload();
						}, 300); }else{
						$("#edit_expense_type").hide();
					}
				}
			});
	});

	
	$(".delete_expense_type_model").click(function(e){
		var expense_type_id = $(this).attr('id');
		$(".delete_expense_type").click(function(e){
			e.preventDefault();
			$.ajax({
				type:"POST",
				url:"../controller/delete_expense_type_controller.php",
				data:{'id':expense_type_id},
				success:function(data){
					var data = JSON.parse(data);
					if(data['status']=='success'){
						$("#delete_expense_type_model").hide();
						setTimeout(function(){
							location.reload();
						}, 300); 
					}else{
						$("#delete_expense_type_model").hide();
					}	
				}
			})
		})
	});












	
	$(".calculate_diesel_price").on('change paste keyup',function(e){
		e.preventDefault();
		no_of_litters = $("#no_of_litters").val();
		litter_price = $("#litter_price").val();
		total = no_of_litters * litter_price;
		$("#total_price").val(total);
	});
	$(".calculate_diesel_prices").on('change paste keyup',function(e){
		e.preventDefault();
		number_of_litters = $("#number_of_litters").val();
		litter_prices = $("#litter_prices").val();
		total = number_of_litters * litter_prices;
		$("#total_prices").val(total);
	});
	$("#add_diesal_button").click(function(e){
		e.preventDefault();
		$.ajax({
		type : "POST",
		url	 :"../controller/add_diesel_controller.php",
		data:$('#add_new_diesel').serialize(),
		success:function(data){
			var data = JSON.parse(data);
			if(data['status']=='success'){
				$("#add_diesal").hide();
				setTimeout(function(){
					location.reload();
					}, 300); 
			}else{
				$("#add_diesal").hide();
			}
			
		  }
		})
	});
	$("#delete_diesel").click(function(e){
		e.preventDefault();
		var id = $(".delete_diesel").attr("id");
		$.ajax({
		type : "POST",
		url	 :"../controller/delete_diesel_controller.php",
		data:{id:id},
			success:function(data){
				var data = JSON.parse(data);
				if(data['status'] =='succes'){
					setTimeout(function(){
						location.reload();
						}, 300); 

				}else{
					console.log("data Error");
				}

			}
		});

	});
		$(".edit_diesel").click(function(){
		var vehicle_diesel_id = $(this).attr('id');
		get_vehicle_diesel_details(vehicle_diesel_id);
	});

		$("#update_diesel_button").click(function(e){
			e.preventDefault();
			$.ajax({
				type : "POST",
				url	 :"../controller/update_diesel_controller.php",
				data:$('#update_diesel').serialize(),
				success:function(data){
					var data = JSON.parse(data);
					if(data['status']=='success'){
						$("#add_diesal").hide();
						setTimeout(function(){
							location.reload();
							}, 300); 
					}else{
						$("#add_diesal").hide();
					}
					
				}
			})
		});

		$(".staff_salary_catagory").change(function(e){
			e.preventDefault();
			var catagory = $(this).children(":selected").attr("value");
			$.ajax({
				type:"POST",
				url:'../controller/staff_catagory_list_controller.php',
				data:{'staff_catagory':catagory},
					success:function(data){
						$("#staff_list").html(data);
					}
			})
		});

		$("#add_staff_salary").click(function(e){
		e.preventDefault();
		$.ajax({
		type : "POST",
		url	 :"../controller/add_staff_salary_controller.php",
		data:$('#add_salary_form').serialize(),
		success:function(data){
			var data = JSON.parse(data);
			if(data['status']=='success'){
				$("#add_staff_salary_model").hide();
				setTimeout(function(){
					location.reload();
					}, 300); 
			}else{
				$("#add_staff_salary_model").hide();
			}
			
		  }
		})
	});
});

function get_vehicle_diesel_details(vehicle_diesel_id){
	$.ajax({
		type : "POST",
		url  :'../controller/get_vehicle_diesel_details.php',
		data :{'id':vehicle_diesel_id},
		success:function(data){
			var data = JSON.parse(data);
			if(data['status']=='success') {
			$("#id").val(data['id']);
			$("#vehicle_id").val(data['vehicle_id']);
			$("#number_of_litters").val(data['no_of_litters']);
			$("#litter_prices").val(data['litter_price']);
			$("#date").val(data['date']);
			$("#total_prices").val(data['no_of_litters']*data['litter_price']);
			}
			else{
				$("#myModal").hide();
			}	
		}
	});
}