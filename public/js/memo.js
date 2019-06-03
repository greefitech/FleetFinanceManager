/*======================================================================================
 * Cloudstar Mohan
 * ===================
 * should be included in on memo entry pages. It controls some Calculations on memo sheet
 * https://cloudstarmohan.wordpress.com
 * =====================================================================================
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
            '        <input type="text" class="form-control" style="width: 15em" placeholder="Enter Location" name="PCData[location][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" style="width: 15em" class="form-control PCAmountValue" placeholder="Enter Amount" name="PCData[amount][]">\n' +
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
            '     <input type="text" class="form-control" style="width: 15em" placeholder="Enter Location" name="RTOData[location][]">\n' +
            ' </td>\n' +
            ' <td>\n' +
            '     <input type="text" class="form-control RTODataAmountValue" style="width: 15em" placeholder="Enter Amount" name="RTOData[amount][]">\n' +
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


    /*
    * ===================================
    * Extra Expense start
    * ==================================
    * */

    $('body').on('click', '.AddExtraExpenseInput', function (e) {
        e.preventDefault();
        var ExpenseTypeDataOptions = GetExpenseTypesDatas();
        var AccountsDataOption = GetAccountOptionData();
        var ExtraExpenseInput ='<tr>\n' +
            '    <td>\n' +
            '        <select name="ExtraExpense[expense_type][]" class="form-control">'+ExpenseTypeDataOptions+
            '        </select>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '       <input type="number" min="0" class="form-control" name="ExtraExpense[quantity][]">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <input type="text" class="form-control" name="ExtraExpense[location][]">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <input type="number" min="0" class="form-control ExtraExpenseAmountValue" name="ExtraExpense[amount][]">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <input type="text" class="form-control" name="ExtraExpense[discription][]">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '        <select name="ExtraExpense[account_id][]" class="form-control">'+
            '             <option value="1">Cash</option>'+AccountsDataOption+
            '        </select>\n' +
            '   </td>\n' +
            '   <td>\n' +
            '    <select class="form-control" name="ExtraExpense[status][]">\n' +
            '        <option value="1">Paid</option>\n' +
            '        <option value="0">Not Paid</option>\n' +
            '    </select>\n' +
            '</td>\n' +
            '<td><i style="color: red;" class="fa fa-close RemoveExtraExpenseInput"></i></td>' +
            '</tr>';
        $('.ExtraExpenseTableData').append(ExtraExpenseInput);
    });

    /*
    * Calculate extra expense */
    $('body').on('keyup change','.ExtraExpenseAmountValue',function (e) {
        e.preventDefault();
        CalculateExtraExpenseAmountTotal();
    });

    /*
    * remove extra expense module*/
    $('body').on('click','.RemoveExtraExpenseInput',function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        CalculateExtraExpenseAmountTotal();
    });
    /*
    * =====================================
    * Extra expense end
    * =====================================*/


    /*
    * =====================================
    * Paalam Toll start
    * =====================================*/

    $('body').on('click', '.AddPalamTollInput', function (e) {
        e.preventDefault();
        var AccountsDataOption = GetAccountOptionData();
        var ExtraExpenseInput ='<tr>\n' +
            '   <td>\n' +
            '       <input type="text" class="form-control" name="PaalamToll[location][]">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <input type="number" min="0" class="form-control PaalamTollAmountValue" name="PaalamToll[amount][]">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '        <select name="PaalamToll[account_id][]" class="form-control">'+
            '             <option value="1">Cash</option>'+AccountsDataOption+
            '        </select>\n' +
            '   </td>\n' +
            '<td><i style="color: red;" class="fa fa-close RemovePaalamTollInput"></i></td>' +
            '</tr>';
        $('.PaalamTollTableData').append(ExtraExpenseInput);
    });

    $('body').on('click','.RemovePaalamTollInput',function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        CalculatePaalamTollAmountTotal();
    });

    $('body').on('keyup change','.PaalamTollAmountValue',function (e) {
        e.preventDefault();
        CalculatePaalamTollAmountTotal();
    });


    /*=================================
    * Paalam Toll End
    * =================================*/



    /*
    * ==================================
    * Diesel start
    * =================================*/

    $('body').on('click', '.AddDiseleInput', function (e) {
        e.preventDefault();
        var AccountsDataOption = GetAccountOptionData();
        var DieselInputData ='<tr>\n' +
            '    <td>\n' +
            '        <input type="date" class="form-control" placeholder="Enter date" name="DieselData[date][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control" placeholder="Enter Location" name="DieselData[location][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control" placeholder="Enter Description" name="DieselData[discription][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" step="0.01" class="form-control DieselDataQuantityValue" placeholder="Enter Quantity" name="DieselData[quantity][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control DieselDataAmountValue" placeholder="Enter Amount" name="DieselData[amount][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <select name="DieselData[account_id][]" class="form-control">\n' +
            '            <option value="1">Cash</option>'+AccountsDataOption +
            '            \n' +
            '        </select>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <select class="form-control" name="DieselData[status][]">\n' +
            '            <option value="1">Paid</option>\n' +
            '            <option value="0">Not Paid</option>\n' +
            '        </select>\n' +
            '    </td>\n' +
            '    <td><i style="color: red;" class="fa fa-close RemoveDieselInput"></i></td>\n' +
            '</tr>';
        $('.DieselTableData').append(DieselInputData);
    });

    $('body').on('click','.RemoveDieselInput',function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        CalculateTotalDiselQuantityAmountValues();
    });


    $('body').on('keyup change','.DieselDataAmountValue,.DieselDataQuantityValue',function (e) {
        e.preventDefault();
        CalculateTotalDiselQuantityAmountValues();
    });

    /*
    ====================================
    * Diesel end
    ========================================*/



});


/*
* ======================================
* CALCULATION FOR PC
* =====================================
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
* ===========================
* */


/*
* ======================================
* CALCULATION FOR PC
* ======================================
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
* ===========================*/

/*
* ====================================
* calculate extra expense
* ====================================*/

CalculateExtraExpenseAmountTotal();
function CalculateExtraExpenseAmountTotal() {
    var ExtraExpenseTotal = 0;
    $('.ExtraExpenseAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            ExtraExpenseTotal += parseFloat($(this).val());
        }
    });
    $('#ExtraExpenseTotalSpentAmount').html(ExtraExpenseTotal);
}

/*
* ===============================
* calculate extra expense end
* ===============================*/


/*
* ==============================
* Calculate Total Palam Amount
* ==============================*/

CalculatePaalamTollAmountTotal();
function CalculatePaalamTollAmountTotal() {
    var PaalamTollTotal = 0;
    $('.PaalamTollAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            PaalamTollTotal += parseFloat($(this).val());
        }
    });
    $('#PaalamTollTotalSpentAmount').html(PaalamTollTotal);
}

/*=================================
* Calculate total paalam toll amount end
* =================================*/



/*
* ===============================
* Calculate disel total amount start
* ================================*/


CalculateTotalDiselQuantityAmountValues();
function CalculateTotalDiselQuantityAmountValues() {
    var DiselAmountTotal = 0;
    var DiselQuantityTotal = 0;
    $('.DieselDataAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            DiselAmountTotal += parseFloat($(this).val());
        }
    });

    $('.DieselDataQuantityValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            DiselQuantityTotal += parseFloat($(this).val());
        }
    });

    $('#DieselCostTotalSpentAmount').html(DiselAmountTotal);
    $('#DieselLitreTotalSpentAmount').html(DiselQuantityTotal);
}


/*
* =============================
* calculate diesel amount end
* =============================*/




/*===================================
* GET ajax data for expense account client
* ===================================*/

var ExpenseTypeDatas;
GetExpenseTypesDatas();
function GetExpenseTypesDatas(){
    $.ajax({
        type: "get",
        url: '/client/entry/memo/expense-type',
        success: function(data) {
            ExpenseTypeDatas = data;
        }
    });
    return ExpenseTypeDatas;
}

/*
* ===Get account ajax data========*/
var AccountDatas;
GetAccountOptionData();
function GetAccountOptionData(){
    $.ajax({
        type: "get",
        url: '/client/entry/memo/accounts',
        success: function(data) {
            AccountDatas = data;
        }
    });
    return AccountDatas;
}

/*
* ============================
* get ajax data end
* ============================*/