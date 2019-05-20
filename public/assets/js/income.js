$(document).ready(function () {
	$('.view_entry_table').on('click','.delete_income_entry',function (e) {
		var delete_income_id = $(this).attr('id');
		$("#delete_income_entry_data").click(function(e){
			e.preventDefault();
			$.ajax({
				type : "POST",
				url:'../controller/delete_controller.php',
				data:{delete:"delete_income",income_id:delete_income_id},
				success:function(data){
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
	

// income detail on change show in entry page

	$(".income_customer").change(function () {
		var customer_id = $(this).children(":selected").attr("value");
		$.ajax({
			type:'POST',
			url:'../controller/get_income_customer_controller.php',
			data:{'customer_id':customer_id},
			success: function(data) { 
				$("#income_data_table").html(data);
			}
		})
	});
	 $("body").on("change paste keyup",".calculate_total_receving_amount",function(){
		var sum = 0;
		$('.calculate_total_receving_amount').each(function() {
			sum += Number($(this).val());
			$("#total_calculated_receving_amount").val(sum);
			$(".closing_balance_amount").trigger("change"); 
		});
	 });
	 $("body").on("change paste keyup",".total_calculated_discount_amount",function(){
		var discount_amount = 0;
		$('.total_calculated_discount_amount').each(function() {
			discount_amount += Number($(this).val());
			$("#total_calculated_discount_amount").val(discount_amount);
			$(".closing_balance_amount").trigger("change"); 
		});
	 });

 	 $("body").on("change paste keyup",".closing_balance_amount",function(){
 	 	var balance_total_amount = $( "#balance_total_amount" ).val();
 	 	var total_discount=0;
		$('.closing_balance_amount').each(function() {
			total_discount += Number($(this).val());
		});
		var closing_balance = parseFloat(balance_total_amount) - parseFloat(total_discount);
		$("#closing_bal_amount").val(closing_balance);
	 });

//  end income detail on change in entry page
});