$(document).ready(function() {
   $( window ).on("load", function() {
    $("#loading_value1").hide();
    $("#loading_value_text1").hide();
  })
    $("#catagories1").on('change', function(e) {
        e.preventDefault();
        var catagory = $(this).children(":selected").attr("value");
        if(catagory == "loading"){
          $("#loading_value1").show();
          $("#loading_value_text1").show();
          $("input[name='loading']").val('');
        }
        else{
          $("#loading_value1").hide();
          $("#loading_value_text1").hide();
          $("input[name='loading']").val('');
        }
    });

    // input_box = 0;
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
    // $('.add_halt_entry_class_div').append('<div><div class="form-group"><div class="col-md-4 col-sm-3 col-xs-4"><label>Date:</label><input type="date" class="form-control value_calculate" name="halt_date[]" required></div><div class="col-md-4 col-sm-3 col-xs-4"><label>Reason:</label><input type="text" class="form-control value_calculate" placeholder="Halt Reason" name="halt_reason[]" required></div><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-remove"></i></a></div></div>'); //add input field
    //     input_box++;
        var super_from_date = $("#super_from_date").val();
          var super_to_date = $("#super_to_date").val();
        $('.add_halt_entry_class_div').append('<div><div class="form-group"><div class="col-md-3 col-sm-3 col-xs-4"><label>Date From:</label><input type="date" min="'+super_from_date+'" max="'+super_to_date+'" class="form-control value_calculate" name="'+number+'[datefrom][]" required></div><div class="col-md-3 col-sm-3 col-xs-4"><label>DateTo :</label><input type="date" min="'+super_from_date+'" max="'+super_to_date+'" class="form-control value_calculate" name="'+number+'[dateto][]" required></div><div class="col-md-4 col-sm-3 col-xs-4"><label>Reason:</label><input type="text" class="form-control" placeholder="Halt Reason" name="halt_reason[]" required></div><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-remove"></i></a></div></div>');
        $(".value_calculate").trigger("change");
        number++;
    });  
    $('.add_halt_entry_class_div').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove();
        $( ".value_calculate" ).trigger("change");
    })
    $('#append_next').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove();
    });
    $('#append_div').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove();
    });
// calculate total working hour
$("body").on("change paste keyup",".value_calculate",function(){
    total_days=0;
        var starting_time = $("input[name='starting_time']").val();
        var ending_time = $("input[name='ending_time']").val();
        var total_time = ending_time-starting_time;
        total_time = total_time.toFixed(2);
        $("#working_time").val(total_time);

        // calculate number of halt days
        var total=0;
        for (var i = 0; i < number; i++) {
            var datefrom = new Date($("input[name='"+i+"[datefrom][]']").val());
            var dateto = new Date($("input[name='"+i+"[dateto][]']").val());
            var diffDays = Math.round(Math.abs((datefrom.getTime() - dateto.getTime())/(24*60*60*1000)));
            if (0<=diffDays) {
                total_days = parseInt(diffDays)+parseInt(1);
                total +=total_days;
            }else{
            }
        }

        // $.each($("input[name^='halt_date']"), function(index, val){
        //     console.log(index + " : " + val);
        // });
    // date calculate
        var date_from = new Date($("input[name='from_date']").val());
        var date_to = new Date($("input[name='to_date']").val());
        var diffDays = Math.round(Math.abs((date_from.getTime() - date_to.getTime())/(24*60*60*1000)));
        total_days = parseInt(diffDays)+parseInt(1)-parseInt(total);
        $("#total_working_days").val(total_days);

    // calculate balance
        var total_amount_per_day = $("input[name='total_amount_per_day']").val();
        var t1 = total_days*total_amount_per_day;
        var batta_amount = $("input[name='batta_amount']").val();
        var site_advance_amount = $("input[name='advance_payment']").val();
        var total_bill_amount = parseInt(t1)+parseInt(batta_amount);
        $("#total_bill_amount").val(total_bill_amount);
        var balance_amount = parseInt(total_bill_amount)-parseInt(site_advance_amount);
        $("#balance_amount").val(balance_amount);
    });



    // delete monthly running entry model
    $(".delete_monthly_running_entry_model").click(function(){
        var delete_monthly_running_entry_id = $(this).attr('id');
        $("#delete_monthly_running_entry").click(function(e){
            e.preventDefault();
                $.ajax({
                    type : 'POST',
                    data : {'id':delete_monthly_running_entry_id},
                    url  : '../controller/delete_monthly_running_entry_controller.php',
                    success:function(data){
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
        
    });
});




