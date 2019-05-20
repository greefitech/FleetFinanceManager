$(document).ready(function () {

    //GET VEHICLE DATA
    $(".TripVehicles").on("change", function(e) {
        e.preventDefault();
        $('.startkm').val('');
        var vehicleId = $('.TripVehicles option:selected').val();
        if (vehicleId != '') {
            $.ajax({
                type : "get",
                url:'/vehicle/getLastEntryKm',
                data:{vehicleId:vehicleId},
                success:function(data){
                    if (data != ''){
                        $('.startkm').val(data.vehicleLastKm);
                    }
                }
            });
        }
    });

});