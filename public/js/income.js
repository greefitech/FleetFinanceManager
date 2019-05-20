$(document).ready(function () {

	// CLIENT TOTAL RECEVING AMOUNT
	$(".recevingAmountValues").on("change paste keyup", function(e) {
		e.preventDefault();
		var totalRecevingAmount=0;
		$('.recevingAmountValues').each(function() {
			totalRecevingAmount += Number($(this).val());
			$("#recevingTotal").val(totalRecevingAmount);
		});
	});

	// CLIENT TOTAL DISCOUNT AMOUNT
	$(".discountAmountValues").on("change paste keyup", function(e) {
		e.preventDefault();
		var totalDiscountAmount=0;
		$('.discountAmountValues').each(function() {
			totalDiscountAmount += Number($(this).val());
			$("#discountTotal").val(totalDiscountAmount);
		});
	});
});