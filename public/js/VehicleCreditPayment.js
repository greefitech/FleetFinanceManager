$( document ).ready(function() {
    $('.client_id').on('change',function () {
        var client_id = $('.client_id').val();

        $.ajax({
            type : "get",
            url:'/admin/Client/Details',
            data:{client_id:client_id},
            success:function(data){
                var total_amount = 0;
                var paid_amount = 0;
                var PaidAmount = 0;
                // console.log(data);
                $(data.VehicleCreditPayment).each(function(index,VehicleCreditPayment) {
                    PaidAmount += parseFloat(VehicleCreditPayment.PaidAmount);
                });
                $(data.VehicleCredits).each(function(index,VehicleCredits) {
                    total_amount += parseFloat(VehicleCredits.total_amount);
                    paid_amount += parseFloat(VehicleCredits.paid_amount);
                });
                $('.TotalVehicleCreditRemainingAmount').val((total_amount - paid_amount) - PaidAmount);
                $('.TotalVehicleCreditTotalAmount').html(total_amount);
                $('.TotalVehicleCreditPaidAmount').html(paid_amount + PaidAmount);
                $('.TotalVehicleCreditRemainingAmount').html((total_amount - paid_amount) - PaidAmount);
            }
        });

    });
});