$( document ).ready(function() {
    $('.client_id').on('change',function () {
        var client_id = $('.client_id').val();
        $.ajax({
            type : "get",
            url:'/admin/Client/client-payment-balance-details',
            data:{client_id:client_id},
            success:function(data){
                $('.TotalBalanceAmount').val('');
                if(data != 'error'){
                    $('.TotalVehicleCreditTotalAmount').html(data.TotalAmount);
                    $('.TotalVehicleCreditPaidAmount').html(data.TotalPaidAmount);
                    $('.TotalVehicleCreditBalanceAmount').html(data.BalanceAmount);
                    $('.TotalBalanceAmount').val(data.BalanceAmount);
                    if(data.BalanceAmount>0){
                        $('.AddVehicleCreditPaymentButton').attr('disabled',false)
                    }else{
                        $('.AddVehicleCreditPaymentButton').attr('disabled',true);
                    }
                }
            }
        });
    });
});