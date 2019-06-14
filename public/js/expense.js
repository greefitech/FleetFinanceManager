$(document).ready(function () {
	$('.expense_vehicle_div').hide();
	$('.expense_quantity_div').hide();
	$('.expense_staff_div').hide();


    var expense_type =$('.expense-type').val();
    if(expense_type=='1'){ //SALARY
        $('.expense_vehicle_div').show();
        $('.expense_quantity_div').hide();
        $('.expense_staff_div').show();
        // $("#expense-vehicle").val("").change();
        $("#expense-quantity").val("");
    }else if(expense_type=='2'){ //DIESEL
        $('.expense_staff_div').hide();
        $('.expense_vehicle_div').show();
        $('.expense_quantity_div').show();
        $("#expense-staff").val("").change();
    }else if(expense_type !=''){
        $('.expense_staff_div').hide();
        $('.expense_vehicle_div').show();
        $('.expense_quantity_div').hide();
    }

	// $(".expense-type").on("change paste keyup", function(e) {
	// 	e.preventDefault();
	// 	var expense_type =$('.expense-type').val();
	// 	// console.log(expense_type);
	// 	if(expense_type=='salary'){ //SALARY
	// 		$('.expense_vehicle_div').hide();
	// 		$('.expense_quantity_div').hide();
	// 		$('.expense_staff_div').show();
	// 	}else if(expense_type=='diesel'){ //DIESEL
	// 		$('.expense_staff_div').hide();
	// 		$('.expense_vehicle_div').show();
	// 		$('.expense_quantity_div').show();
	// 	}else{ //OTHERS
	// 		$('.expense_staff_div').hide();
	// 		$('.expense_vehicle_div').show();
	// 		$('.expense_quantity_div').show();
	// 	}

	// 	if(expense_type==''){
	// 		$('.expense_vehicle_div').hide();
	// 		$('.expense_quantity_div').hide();
	// 		$('.expense_staff_div').hide();
	// 	}
	// });


	$(".expense-type").on("change paste keyup", function(e) {
		e.preventDefault();
		var expense_type =$('.expense-type').val();
		// console.log(expense_type);
		if(expense_type=='1'){ //SALARY
			$('.expense_vehicle_div').show();
			$('.expense_quantity_div').hide();
			$('.expense_staff_div').show();
			// $("#expense-vehicle").val("").change();
			$("#expense-quantity").val("");
		}else if(expense_type=='2'){ //DIESEL
			$('.expense_staff_div').hide();
			$('.expense_vehicle_div').show();
			$('.expense_quantity_div').show();
			$("#expense-staff").val("").change();
		}else{
			$('.expense_staff_div').hide();
			$('.expense_vehicle_div').show();
			$('.expense_quantity_div').hide();
		}

		if(expense_type==''){
			$('.expense_vehicle_div').hide();
			$('.expense_quantity_div').hide();
			$('.expense_staff_div').hide();
		}
	});



    $("#expense-trip").on("change paste keyup", function(e) {
        e.preventDefault();
        var tripId = $('#expense-trip option:selected').attr('value');
        $.ajax({
            type:"get",
            url :'/entry/getTripDatas',
            data: {tripId : tripId},
            success:function(data){
                $("#expense-vehicle option[value="+data.vehicleId+"]").attr('selected','selected');

            }
        });

    });


    $(".LastExpense").on("change", function(e) {
        e.preventDefault();
        var ExpenseType = $('.expense-type option:selected').attr('value');
        var vehicleID = $('.expense-vehicle option:selected').attr('value');
        $('#expense-LastData').val('');
        if(ExpenseType != '' && vehicleID!= ''){
            $('#expense-LastData').val('No Record Found!!');
            $.ajax({
                type:"get",
                url :'/client/expense/GetLastExpenseTypeDetail',
                data: {vehicleID:vehicleID,ExpenseType:ExpenseType},
                success:function(data){
                    if(data != ''){
                        $('#expense-LastData').val(data);
                    }
                }
            });
        }
    });
});