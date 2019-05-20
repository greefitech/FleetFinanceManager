$(document).ready(function () {




// data data-toggle reload cannot be changed
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#myTab a[href="' + activeTab + '"]').tab('show');
	}

     $(".phone_no").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        	$("#errmsg").html("Digits Only").show().fadeOut("slow");
        	return false;
       }
	});
     $( window ).on("load", function() {
		$("#loading_value").hide();
		$("#loading_value_text").hide();
        $("#halt_entry").hide();
        $("#view_running_entry").show();
        $("#view_halt_entry").hide();
        $('#working_hour').attr('readonly', true);
        i_know_working_hour = "yes";
        loading_data = "no";
	});

	$("#list_entry").change(function () {
		if ($(this).val() == "running_entry") {
            $("#running_entry").show();
            $("#halt_entry").hide();
        } 
        else if ($(this).val() == "monthly_running_entry_tab") {
             window.location = "../view/monthly_running_entry.php";
        } 
        else {
            $("#halt_entry").show();
            $("#running_entry").hide();
        }
    });
       

    $("#list_entry_view").change(function () {
        if ($(this).val() == "view_running_entry") {
            $("#view_running_entry").show();
            $("#view_halt_entry").hide();
        } else {
            $("#view_halt_entry").show();
            $("#view_running_entry").hide();
        }
    });


	$( window).on("load", function() {
	 	var catagories_value = $("#catagories option:selected").val();
	 	if(catagories_value == "loading"){
	    	$("#loading_value").show();
	      	$("#loading_value_text").show();
	      	loading_data = "yes";
	    }

		selected_value = $("input[name='working_time_known']:checked").val();
        if (selected_value=="y") {
        	i_know_working_hour = "yes";
        	$('#working_hour').attr('readonly', true);
        	$('#starting_time').attr('readonly', false);
        	$('#ending_time').attr('readonly', false);
        }
        else {
        	i_know_working_hour = "no";	
        	$('#starting_time').attr('readonly', true);
        	$('#ending_time').attr('readonly', true);
        	$('#working_hour').attr('readonly', false);
        }
	});


	$('.view_entry_table').on('click','.edit_customer_detail',function (e) {
			e.preventDefault();
		var customer_id = $(this).attr('id');
		get_customer_details(customer_id);
	});

	$('#staff_detail_table').on('click','.edit_staff_detail',function (e) {
		var staff_id = $(this).attr('id');
		get_staff_detail(staff_id);
	});

	$('.view_entry_table').on('click','.delete_customer_detail',function (e) {
		var delete_customer_id = $(this).attr('id');
		$("#delete_customer").click(function(e){
			e.preventDefault();
			$.ajax({
				type : "POST",
				url:'../controller/delete_customer_controller.php',
				data:{customer_id:delete_customer_id},
				success:function(data){
					var data = JSON.parse(data);
					if(data['status']=='success'){
						$("#delete_model").hide();
						setTimeout(function(){
						location.reload();
						}, 300); 
					}else{
						$("#delete_model").hide();
					}
				}
			});
		});
	});


	$("#submit").click(function(e){
		e.preventDefault();
		$.ajax({
			type : "POST",
			url:'../controller/update_customer_details.php',
			data: $('form').serialize(),
			success: function(data) {
				var data = JSON.parse(data);
				if(data['status'] =='success'){
					setTimeout(function(){
					location.reload();
					}, 300); 
				}
				else{
					$("#myModal").hide();
				}
			}
		});
	});


	$(".edit_vehicle").click(function(e){
		e.preventDefault();
		var vechile_id = $(this).attr('id');
	});


});


function get_customer_details(id){
	$.ajax({
		type: "POST",
		url: "../controller/get_customer_details.php",
		data:{customer_id:id},
		success: function(data) { 
			var data = JSON.parse(data);
			// console.log(data);
			if(data['status'] =='success'){
				$("#myModal").show();
				$("#customer_id").val(data['id']);
				$("#name").val(data['customer_name']);
				$("#phone_no").val(data['phone_no']);
				$("#customer_address").val(data['address']);
			}else{
				$("#myModal").hide();
			}
		}
	});
}


$(document).ready(function(){
	$("#add-vehicle").click(function(){
		$("#add_vehicle").show();
	});

	$(".edit_vehicle").click(function(){
		var vehicle_id = $(this).attr('id');
		get_vehicle_details(vehicle_id);
	});

	$("#add_new_expense_type").click(function(e){
		e.preventDefault();
		var expense = $('#expense_name').val();
		var type = $('#expense_type option:selected').attr('value');
		// console.log(type);
		$.ajax({
			type:"POST",
			url :'../controller/add_expense_type.php',
			data: {expense : expense, type : type},
			success:function(data){
				$( ".close" ).trigger( "click" );
					setTimeout(function(){
						location.reload();
					}, 100); 
			}
		});
	});

	$('#quantity').show();
	$('#salary_div').hide();
	$('select[name="expense_type"]').on('change', function(){
		if ($('option:selected', this).attr('value') == 'salary') {
			$('#quantity').hide();
			$('#salary_div').show();
			document.getElementById("staff_salary_expense").required = true;  
			document.getElementById("quantity_value_values").required = false;  
		}
		else{
			$('#quantity').show();
			$('#salary_div').hide();
			$('#quantity_type').val($('option:selected', this).attr('qt_ty'));
			document.getElementById("quantity_value_values").required = true; 
			document.getElementById("staff_salary_expense").required = false;   
		}
	});
	
	$("#add_new_customer").click(function(e){
		e.preventDefault();
		$.ajax({
			type:"POST",
			url :'../controller/add_new_customer.php',
			data: $('#new_customer_form').serialize(),
			success:function(data){
				var data = JSON.parse(data);
				if(data['status'] =='success'){
					setTimeout(function(){
					location.reload();
					}, 100); 
				// console.log(data);
				}
				else{
					$("#myModal").hide();
				}
			}
		});
	});


	$("#add_new_vehicle").click(function(e){
		e.preventDefault();
		$.ajax({
			type:"POST",
			url :'../controller/add_new_vehicle_controller.php',
			data: $('#new_vehicle_form').serialize(),
			success:function(data){
				var data = JSON.parse(data);
				if(data['status'] =='success'){
					setTimeout(function(){
					location.reload();
					}, 100); 
				// console.log(data);
				}
				else{
					$("#myModal").hide();
				}
			}
		});
	});


	$("#update_vehicle").click(function(e){
		e.preventDefault();
		$.ajax({
			type:"POST",
			url :'../controller/update_vehicle_controller.php',
			data: $('form').serialize(),
			success:function(data){
				var data = JSON.parse(data);
				if(data['status'] =='success'){
					setTimeout(function(){
					location.reload();
					}, 100); 
				// console.log(data);
				}
				else{
					$("#myModal").hide();
				}
			}
		});
	});


	$(".delete_vehicle_detail").click(function(){
		var delete_vehicle_id = $(this).attr('id');
		$(".delete_vehicle").click(function(e){
			e.preventDefault();
			$.ajax({
				type : "POST",
				url  : '../controller/delete_vehicle_controller.php',
				data:{'vehicle_id':delete_vehicle_id},
				success:function(data){
					// console.log(data);
				var data = JSON.parse(data);
					if(data['status']=='success'){
						$("#delete_model").hide();
						setTimeout(function(){
						location.reload();
						}, 200); 
					}else{
						$("#delete_model").hide();
					}
				}
			});
		});
	});

});
function get_vehicle_details(vehicle_id){
	$.ajax({
		type : "POST",
		url  :'../controller/get_vehicle_details.php',
		data :{vehicle_id:vehicle_id},
		success:function(data){
			var data = JSON.parse(data);
				// console.log(data);
			if(data['status']=='success') {
			$("#vehicle_id").val(data['id']);
			$("#vehicle_number").val(data['vehicle_number']);
			$("#model_number").val(data['model_number']);
			$("#insurance").val(data['insurance']);
			$("#fc_renewal").val(data['fc_renewal']);
			$("#tax_date").val(data['tax_date']);
			}
			else{
				$("#myModal").hide();
			}	
		}
	});
}


function get_staff_detail(staff_id){
	$.ajax({
		type : "POST",
		url : '../controller/get_staff_detail_controller.php',
		data : {'staff_id':staff_id},
		success:function(data){
			var data = JSON.parse(data);
			if (data['status']=='success') {
				$("#staff_id").val(data['id']);
				$("#staff_name").val(data['staff_name']);
				$("#phone_no").val(data['phone_no']);
				$("#salary").val(data['salary']);
				$("#catagory").val(data['catagory']);
				$("#joining_date").val(data['joining_date']);
			// console.log(data);
			}
			else{
				$("#staff_detail").hide();
			}	
		}
	});
}


$(document).ready(function(){
	$("#update_staff").click(function(e){
		e.preventDefault();
		$.ajax({
			type :"POST",
			url :'../controller/update_staff_controller.php',
			data : $('form').serialize(),
			success: function(data){
				var data = JSON.parse(data);
				if(data['status'] =='success'){
					setTimeout(function(){
					location.reload();
					}, 300);
				}
				else{
					$("#staff_detail").hide();
				}
			}
		});

	});
	$('#staff_detail_table').on('click','.delete_staff_detail',function (e) {
		var delete_staff_id = $(this).attr('id');
		$("#delete_staff").click(function(e){
			e.preventDefault();
			$.ajax({
				type :'POST',
				url  : '../controller/delete_staff_controller.php',
				data : {'staff_id':delete_staff_id},
				success:function(data){
					var data = JSON.parse(data);
						// console.log(data);
					if(data['status']=='success'){
						$("#delete_model").hide();
						setTimeout(function(){
							location.reload();
						}, 300); 
					}else{
						$("#delete_model").hide();
					}				
				}
			});

		});
	});

	$(".radio_button").on("change",function () {
		selected_value = $("input[name='working_time_known']:checked").val();
        if (selected_value=="y") {
        	i_know_working_hour = "yes";
        	$(".calculate_value").trigger("change"); 
        	$('#working_hour').attr('readonly', true);
        	$('#starting_time').attr('readonly', false);
        	$('#ending_time').attr('readonly', false);
        }
        else {
        	i_know_working_hour = "no";	
        	$(".calculate_value").trigger("change"); 
        	$("input[name='starting_time']").val('');
        	$("input[name='ending_time']").val('');
        	$("input[name='working_hour']").val('');
        	$('#starting_time').attr('readonly', true);
        	$('#ending_time').attr('readonly', true);
        	$('#working_hour').attr('readonly', false);

        }
    });


	 $(".calculate_value").on("change paste keyup", function() {
	 	 var starting_time = $("input[name='starting_time']").val();
	 	 var ending_time = $("input[name='ending_time']").val();
	 	 var working_hour = $("input[name='working_hour']").val();
	 	 var rate = $("input[name='rate']").val();
	 	 var batta = $("input[name='batta']").val();
	 	 var Shift_rent = $("input[name='Shift_rent']").val();
	 	 var advance_payment = $("input[name='advance_payment']").val();
	 	 var bill_amount = $("input[name='bill_amount']").val();
	 	 var balance_amount = $("input[name='balance_amount']").val();
	 	 var loading = $("input[name='loading']").val();



	 	 if(i_know_working_hour == "yes"){
	 	 	var total_time = ending_time-starting_time;
 	 		total_time = total_time.toFixed(2);
	 	 }
	 	 else{
	 	 	 var total_time = $("input[name='working_hour']").val();
	 	 }
 	 		$("#working_hour").val(total_time);
	 	 // if working hour above 0 show submit
 	// 	if(0<total_time){
		// 	$("#submit").prop("disabled",false);
		// }else{
		// 	$("#submit").prop("disabled",true);
		// }

	 	 if(loading_data == "yes"){
	 	 	 var loading = $("input[name='loading']").val();
	 	 	var t1 = (loading*rate);
	 	 	var total_bill_amount = parseFloat(batta) + parseFloat(Shift_rent) + parseFloat(t1);
	 	 }
	 	 else{
	 	 	var t1 = (total_time*rate);
	 	 	var total_bill_amount = parseFloat(batta) + parseFloat(Shift_rent) + parseFloat(t1);
	 	 }

	 	total_bill_amount = total_bill_amount.toFixed(2);
		$("#bill_amount").val(total_bill_amount);

	 	 var total_balance_amount = parseFloat(total_bill_amount-advance_payment);
	 	 $("#balance_amount").val(total_balance_amount);
	 });


	$("#catagories").on('change', function(e) {
		e.preventDefault();
		var customer_id = $(this).children(":selected").attr("value");
		if(customer_id == "loading"){
	      $("#loading_value").show();
	      $("#loading_value_text").show();
	      $("input[name='loading']").val('');
	      document.getElementById("loading_value").required = true;  
	      loading_data = "yes";
	       $(".calculate_value").trigger("change"); 
	    }
	    else{
	      $("#loading_value").hide();
	      $("#loading_value_text").hide();
	      $("input[name='loading']").val('1');
	        loading_data = "no";
		  document.getElementById("loading_value").required = false;
		  $(".calculate_value").trigger("change"); 
	    }
	});

$('.view_entry_table').on('click','.delete_halt_entry_model',function () {
		var delete_halt_entry_id = $(this).attr('id');
		$("#delete_halt_entry").click(function(e){
			e.preventDefault();
			$.ajax({
				type : "POST",
				url:'../controller/delete_halt_entry_controller.php',
				data:{halt_entry_id:delete_halt_entry_id},
				success:function(data){
					var data = JSON.parse(data);
					if(data['status']=='success'){
						$("#delete_halt_entry_model").hide();
						setTimeout(function(){
						location.reload();
						}, 300); 
					}else{
						$("#delete_halt_entry_model").hide();
					}
				}
			});
		});
	});


	// $(".delete_running_entry_model").click(function(){
	// 	var delete_running_entry_id = $(this).attr('id');
	// 	$("#delete_running_entry").click(function(e){
	// 		console.log(delete_running_entry_id);
	// 		e.preventDefault();
	// 		$.ajax({
	// 			type : "POST",
	// 			url : '../controller/delete_running_entry_controller.php',
	// 			data:{'running_entry_id':delete_running_entry_id},
	// 			success:function(data){
	// 				var data = JSON.parse(data);
	// 				if(data['status']=='success'){
	// 					$("#delete_running_entry_model").hide();
	// 					setTimeout(function(){
	// 					location.reload();
	// 					}, 300); 
	// 				}else{
	// 					$("#delete_running_entry_model").hide();
	// 				}
	// 			}
	// 		});
	// 	});
	// });

	$('.view_entry_table').on('click','.delete_running_entry_model',function () {
				var delete_running_entry_id = $(this).attr('id');
				// console.log(delete_running_entry_id);
			$("#delete_running_entry").click(function(e){
				// console.log(delete_running_entry_id);
				e.preventDefault();
				$.ajax({
					type : "POST",
					url : '../controller/delete_running_entry_controller.php',
					data:{'running_entry_id':delete_running_entry_id},
					success:function(data){
						var data = JSON.parse(data);
						if(data['status']=='success'){
							$("#delete_running_entry_model").hide();
							setTimeout(function(){
							location.reload();
							}, 300); 
						}else{
							$("#delete_running_entry_model").hide();
						}
					}
				});
			});
	});
	// $(".running_entry_customer").on('change', function(e) {
	// 	var customer_id = $(this).children(":selected").attr("value");
	// 	if (customer_id!='') {
	// 		get_customer_details(customer_id);
	// 	}
	// 	else{
	// 		$("#rem_bal").html('');
	// 	}
	// 	function get_customer_details(id){
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "../controller/get_customer_details.php",
	// 			data:{customer_id:id},
	// 			success: function(data) { 
	// 				var data = JSON.parse(data);
	// 				// console.log(data);
	// 				if(data['status'] =='success'){
	// 					var balance_amount=data['balance_amount'];
	// 					$("#rem_bal").html(balance_amount);
	// 				}
	// 			}
	// 		});
	// 	}
	// });

	$(".running_entry_customer").on('change', function(e) {
		var customer_id = $(this).children(":selected").attr("value");
		if (customer_id!='') {
			get_customer_details(customer_id);
		}
		else{
			$("#rem_bal").html('');
		}
		function get_customer_details(id){
			$.ajax({
				type: "POST",
				url: "../controller/get_customer_details.php",
				data:{calculate_outstanging_amount:"calculate_outstanging_amount",customer_id:id},
				success: function(data) { 
					var data = JSON.parse(data);
					if(data['status'] =='success'){
						var balance_amount=data['balance_amount'];
						$("#rem_bal").html(balance_amount);
					}
				}
			});
		}
	});



	$("#vehicles").on('change', function(e) {
		var vehicle_id = $(this).children(":selected").attr("value");
		var date = $("input[name='date']").val();
		$.ajax({
			type: "POST",
			url: "../controller/get_entry_details.php",
			data:{vehicle_id:vehicle_id,date:date},
			success: function(data) { 
				var data = JSON.parse(data);
				if(data['status'] =='success'){
					var ending_time=data['ending_time'];
					 $("#starting_time").val(ending_time);
				}
			}
		});
	});

	$("#entry_date").on('change', function(e) {
		  $("#vehicles").trigger("change");
	})

});


