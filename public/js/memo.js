/*!
 * Cloudstar Mohan
 * ===================
 * should be included in on memo entry pages. It controls some Calculations on memo sheet
 * https://cloudstarmohan.wordpress.com
 */


$(document).ready(function() {
/*
* =======================================
* PC START
* =======================================
* */
    /* add pc input button */
    $('body').on('click', '.AddPCInput', function (e) {
        e.preventDefault();
        var PCData =
            '<tr>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control" placeholder="Enter Location" name="PCData[location][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" class="form-control PCAmountValue" placeholder="Enter Amount" name="PCData[amount][]">\n' +
            '    </td>\n' +
            '    <td><i style="color: red;" class="fa fa-close RemovePcInput"></i></td>\n' +
            '</tr>';

        $('.PCTableData').append(PCData);
    });

    /* Calculate pc data total */
    $('body').on('keyup change','.PCAmountValue',function (e) {
        e.preventDefault();
        CalculatePcTotalAmount();
    });

    /* Expense remove pc datas */
    $('body').on('click','.RemovePcInput',function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        CalculatePcTotalAmount();
    });
/*
* ======================================
* PC END
* ======================================
* */



    /*
    * =======================================
    * RTO START
    * =======================================
    * */
    /* add RTO input button */
    $('body').on('click', '.AddRTOInput', function (e) {
        e.preventDefault();
        var RTOData =
            '<tr>\n' +
            ' <td>\n' +
            '     <input type="text" class="form-control" placeholder="Enter Location" name="RTOData[location][]">\n' +
            ' </td>\n' +
            ' <td>\n' +
            '     <input type="text" class="form-control RTODataAmountValue" placeholder="Enter Amount" name="RTOData[amount][]">\n' +
            ' </td>\n' +
            ' <td><i style="color: red;"  class="fa fa-close RemoveRToInput"></i></td>\n' +
            '</tr>';

        $('.RTOTableData').append(RTOData);
    });

    /* Calculate RTO data total */
    $('body').on('keyup change','.RTODataAmountValue',function (e) {
        e.preventDefault();
        CalculateRTOTotalAmount();
    });

    /* Expense remove RTO datas */
    $('body').on('click','.RemoveRToInput',function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        CalculateRTOTotalAmount();
    });
    /*
    * ======================================
    * PC END
    * ======================================
    * */



});


/*
* ======================================
* CALCULATION FOR PC
* */
    CalculatePcTotalAmount();
    function CalculatePcTotalAmount() {
        var PcTotal = 0;
        $('.PCAmountValue').each(function(){
            if($(this).val() !='' && !isNaN($(this).val())){
                PcTotal += parseFloat($(this).val());
            }
        });
        $('#PCTotalSpentAmount').html(PcTotal);
    }
/*
* ============================
* Calculation pc end
* */


/*
* ======================================
* CALCULATION FOR PC
* */
CalculateRTOTotalAmount();
function CalculateRTOTotalAmount() {
    var RTOTotal = 0;
    $('.RTODataAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            RTOTotal += parseFloat($(this).val());
        }
    });
    $('#RTOTotalSpentAmount').html(RTOTotal);
}
/*
* ============================
* Calculation pc end
* */