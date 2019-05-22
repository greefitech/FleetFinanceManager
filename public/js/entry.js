$(document).ready(function () {

    $('.Entry-Customer-div').hide();

	$("#entry-customer").on("change paste keyup", function(e) {
		var customerId = $('#entry-customer option:selected').val();
		console.log(customerId);
		if(customerId == ''){
			$('.Entry-Customer-div').show();
		}else{
			$('.Entry-Customer-div').hide();
			$('#entry-customerName').val('');
			$('#entry-customerMobile').val('');
			$('#entry-CustomerType option:selected').val('');
		}
	});



	$(".DateChange").on("change paste keyup", function(e) {
		e.preventDefault();
		var dateFrom=$('#entry-dateFrom').val();
		var dateTo=$('#entry-dateTo').val();
		if(dateFrom!=''){
			$("#entry-dateTo").prop('min',dateFrom);
		}
		if(dateTo!=''){
			$("#entry-dateFrom").removeAttr("max")
			$("#entry-dateFrom").prop('max',dateTo);
		}
	});

	$(".CalculateKm").on("change paste keyup", function(e) {
		e.preventDefault();
		var startkm=$('#entry-startkm').val();
		var endkm=$('#entry-endkm').val();
		var totalkm= parseInt(endkm)-parseInt(startkm);
		$('#entry-totalkm').val(totalkm);
		if(totalkm <= 0){
			$('#ErrorTotal').html('<p style="color:red">Check KM Value Entered</p>');
		}else{
			$('#ErrorTotal').html('');
		}
	});

    $(".CalculateComission").on("change paste keyup", function(e) {
        e.preventDefault();
        var comissionPercentage=$('#entry-comission-percentage').val();
        var billAmount=$('#entry-billAmount').val();
		var comissionAmount = (billAmount*comissionPercentage)/100;
        $('#entry-comission').val(Math.round(comissionAmount));

    });

	$(".calculateEntryValue").on("change paste keyup", function(e) {
		e.preventDefault();
		var billAmount=$('#entry-billAmount').val();
		var advance=$('#entry-advance').val();
		var comission=$('#entry-comission').val();
		var loadingMamool=$('#entry-loadingMamool').val();
		var unLoadingMamool=$('#entry-unLoadingMamool').val();
		if(loadingMamool==''){ loadingMamool=0;  }	
		if(unLoadingMamool==''){  unLoadingMamool=0;  }
		if(comission==''){  comission=0;  }
		if(advance==''){  advance=0;  }
		var balance = parseFloat(billAmount) - parseFloat(advance);
		$('#entry_balance').val(Math.round(balance));
	});




    $("#entry-trip").on("change paste keyup", function(e) {
        e.preventDefault();
        var tripId = $('#entry-trip option:selected').attr('value');
        $.ajax({
            type:"get",
            url :'/entry/getTripDatas',
            data: {tripId : tripId},
            success:function(data){
                $('#entry-dateFrom').attr("min", data.dateFrom);
                $('#entry-dateFrom').attr("max", data.dateTo);
                $('#entry-dateFrom').val(data.dateFrom);
                $("#entry-vehicle option[value="+data.vehicleId+"]").attr('selected','selected');
                $('#entry-startkm').val(data.startKm);
                $("#entry-staff1 option[value="+data.staff1+"]").attr('selected','selected');
                $("#entry-staff2 option[value="+data.staff2+"]").attr('selected','selected');
                $("#entry-staff3 option[value="+data.staff3+"]").attr('selected','selected');
            }
        });
    });

})