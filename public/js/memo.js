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
            '    <td class="RemovePcInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>\n' +
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
        $(this).parent().remove();
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
            ' <td class="RemoveRToInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>\n' +
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
        $(this).parent().remove();
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
            '        <select name="ExtraExpense[expense_type][]" class="form-control select2" style="width:15em;">\n'+
            '           <option value="">Select Expense</option>'+ExpenseTypeDataOptions+
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
            '        <select name="ExtraExpense[account_id][]" class="form-control" style="width: 8em">'+
            '             <option value="1">Cash</option>\n'+AccountsDataOption+
            '        </select>\n' +
            '   </td>\n' +
            '   <td>\n' +
            '    <select class="form-control" name="ExtraExpense[status][]" style="width: 8em">\n' +
            '        <option value="1">Paid</option>\n' +
            '        <option value="0">Not Paid</option>\n' +
            '    </select>\n' +
            '</td>\n' +
            '<td class="RemoveExtraExpenseInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>' +
            '</tr>';
        $('.ExtraExpenseTableData').append(ExtraExpenseInput);
        $('.select2').select2();
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
        $(this).parent().remove();
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
            '       <input type="text" class="form-control" name="PaalamToll[location][]" style="width:18em;">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <input type="number" min="0" class="form-control PaalamTollAmountValue" name="PaalamToll[amount][]" style="width:18em;">\n' +
            '   </td>\n' +
            '   <td>\n' +
            '        <select name="PaalamToll[account_id][]" class="form-control" style="width:18em;">'+
            '             <option value="1">Cash</option>'+AccountsDataOption+
            '        </select>\n' +
            '   </td>\n' +
            '<td class="RemovePaalamTollInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>' +
            '</tr>';
        $('.PaalamTollTableData').append(ExtraExpenseInput);
    });

    $('body').on('click','.RemovePaalamTollInput',function (e) {
        e.preventDefault();
        $(this).parent().remove();
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
        var VendorDatasOption = GetVendorOptionData();
        var DieselInputData ='<tr>\n' +
            '    <td>\n' +
            '        <input type="date" class="form-control DateValue" placeholder="Enter date" name="DieselData[date][]">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <select name="DieselData[vendor_id][]" class="form-control">\n'+
            '               <option value="">Select Vendor</option>'+VendorDatasOption +
            '        </select>\n' +
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
            '    <td class="RemoveDieselInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>\n' +
            '</tr>';
        $('.DieselTableData').append(DieselInputData);
        $('.DateChanges').trigger('change');
    });

    $('body').on('click','.RemoveDieselInput',function (e) {
        e.preventDefault();
        $(this).parent().remove();
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







    /*
    * ==============================================
    * ENTRY Module
    * ======================================================*/



    $('body').on('click', '.AddEntryInput', function (e) {
        var AccountsDataOption = GetAccountOptionData();
        var CustomersDataOption = GetCustomerOptionData();
        e.preventDefault();
        var EntryData ='<tr>\n' +
            '    <td>\n' +
            '        <input type="date" class="form-control DateValue" placeholder="Enter Date" name="EntryData[dateFrom][]" style="width:15em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <select name="EntryData[customerId][]" class="form-control select2" style="width:15em">\n' +
            '            <option value="">Select Customer</option>'+CustomersDataOption+
            '        </select>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control" placeholder="Enter Location" name="EntryData[locationFrom][]" style="width:15em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control" placeholder="Enter Location" name="EntryData[locationTo][]" style="width:15em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="text" class="form-control" placeholder="Enter Load type" name="EntryData[loadType][]" style="width:15em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" step="0.01" class="form-control" placeholder="Enter Ton" name="EntryData[ton][]" style="width:10em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <select name="EntryData[account_id][]" class="form-control" style="width:10em">\n' +
            '            <option value="1">Cash</option>'+AccountsDataOption+
            '        </select>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0"  class="form-control BillAmountValue" placeholder="Enter Bill Amount" name="EntryData[billAmount][]" style="width:10em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" class="form-control AdvanceAmountTotal" placeholder="Enter Advance" name="EntryData[advance][]" style="width:10em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" class="form-control ComissionValue" placeholder="Enter Comission" name="EntryData[comission][]" style="width:10em">\n' +
            '        <input type="radio" class="commission_status_class" name="EntryData[commission_status]['+EntryI+']" value="1" checked><label>Paid</label>\n' +
            '        <input type="radio" class="commission_status_class" name="EntryData[commission_status]['+EntryI+']" value="0"><label>Not Paid</label>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" max="100" step="0.01" class="form-control DriverPadiPercentage" placeholder="Enter driver paadi" name="EntryData[driverPadi][]" style="width:10em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" max="100" step="0.01" class="form-control CleanerPadiPercentage"  placeholder="Enter cleaner paadi" name="EntryData[cleanerPadi][]" style="width:10em">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" step="0.01"  class="form-control DriverPadiAmountValue" placeholder="Enter driver paadi amount" name="EntryData[driverPadiAmount][]" style="width:10em" readonly>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" step="0.01" class="form-control CleanerPadiAmountValue" placeholder="Enter cleaner paadi amount" name="EntryData[cleanerPadiAmount][]" style="width:10em" readonly>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" class="form-control loadingMamoolValue" placeholder="Enter Loading" name="EntryData[loadingMamool][]" style="width:10em">\n' +
            '        <input type="radio" class="loading_mamool_status_class" name="EntryData[loading_mamool_status]['+EntryI+']" value="1" checked><label>Paid</label>\n' +
            '        <input type="radio" class="loading_mamool_status_class" name="EntryData[loading_mamool_status]['+EntryI+']" value="0"><label>Not Paid</label>\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" class="form-control unLoadingMamoolValue" placeholder="Enter Unloading" name="EntryData[unLoadingMamool][]" style="width:10em">\n' +
            '        <input type="radio" class="unloading_mamool_status_class" name="EntryData[unloading_mamool_status]['+EntryI+']" value="1" checked><label>Paid</label>\n' +
            '        <input type="radio" class="unloading_mamool_status_class" name="EntryData[unloading_mamool_status]['+EntryI+']" value="0"><label>Not Paid</label>\n' +
            '    </td>\n' +
            '    <td class="RemoveEntryDataInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>\n' +
            '</tr>';

        $('.EntryTableData').append(EntryData);
        EntryI++;
        $('.DateChanges').trigger('change');
        $('.select2').select2();
    });


    $('body').on('click','.RemoveEntryDataInput',function (e) {
        e.preventDefault();
        $(this).parent().remove();
        CalculateEntryFullMasterFunctionCalculations();
    });



    $('body').on('keyup change','.unLoadingMamoolValue,.loadingMamoolValue,.ComissionValue,.BillAmountValue,.AdvanceAmountTotal,.DriverPadiPercentage,.CleanerPadiPercentage,.CleanerPadiAmountValue',function (e) {
        e.preventDefault();
        CalculateEntryFullMasterFunctionCalculations();
    });

    $('body').on('keyup change','.DriverPadiAmountValue',function (e) {
        e.preventDefault();
        // $($(this).parent().parent().find('.DriverPadiPercentage')).val('');
        CalculateDriverPadiAmountTotal();
    });

    $('body').on('keyup change','.CleanerPadiAmountValue',function (e) {
        e.preventDefault();
        // $($(this).parent().parent().find('.CleanerPadiPercentage')).val('');
        CalculateCleanerPadiAmountTotal();
    });



/*
* ============================
* Driver Advance Module
* ============================*/

    $('body').on('click', '.AddDriverAdvanceAmountInput', function (e) {
        var AccountsDataOption = GetAccountOptionData();
        e.preventDefault();
        var DriverAdvanceData ='<tr>\n' +
            '    <td>\n' +
            '        <input type="date" class="form-control DateValue" name="DriverAdvance[date][]" value="" style="width:18em;">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <input type="number" min="0" class="form-control DriverAdvanceAmountValue" name="DriverAdvance[amount][]" value="" style="width:18em;">\n' +
            '    </td>\n' +
            '    <td>\n' +
            '        <select name="DriverAdvance[account_id][]" class="form-control" style="width:18em;">\n' +
            '            <option value="1">Cash</option>' +AccountsDataOption+
            '        </select>\n' +
            '    </td>\n' +
            '    <td class="RemoveDriverAdvanceInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>\n' +
            '</tr>';

        $('.DriverAdvanceTableData').append(DriverAdvanceData);
        $('.DateChanges').trigger('change');
        $('.select2').select2();
    });

    $('body').on('click','.RemoveDriverAdvanceInput',function (e) {
        e.preventDefault();
        $(this).parent().remove();
        CalculateDriverAdvanceAmountTotal();
    });

    $('body').on('keyup change','.DriverAdvanceAmountValue',function (e) {
        e.preventDefault();
        CalculateDriverAdvanceAmountTotal();
    });
    /*
    * ==================================
    * Driver advance amount end
    * =====================================*/
});
CalculateTotalExpenseMasterFunction();


function CalculateTotalExpenseMasterFunction() {
    CalculatePcTotalAmount();
    CalculateRTOTotalAmount();
    CalculateExtraExpenseAmountTotal();
    CalculatePaalamTollAmountTotal();
    CalculateTotalDiselQuantityAmountValues();
    CalculateTotalExpenseCalculationAmount();
}


/*
* ======================================
* CALCULATION FOR PC
* =====================================
* */

    function CalculatePcTotalAmount() {
        var PcTotal = 0;
        $('.PCAmountValue').each(function(){
            if($(this).val() !='' && !isNaN($(this).val())){
                PcTotal += parseFloat($(this).val());
            }
        });
        CalculateTotalExpenseCalculationAmount();
        $('#PCTotalSpentAmount').html(PcTotal);
        $('#TotalPCCalculationAmount').html(PcTotal);
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

function CalculateRTOTotalAmount() {
    var RTOTotal = 0;
    $('.RTODataAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            RTOTotal += parseFloat($(this).val());
        }
    });
    $('#RTOTotalSpentAmount').html(RTOTotal);
    $('#TotalRTOCalculationAmount').html(RTOTotal);
}
/*
* ============================
* Calculation pc end
* ===========================*/

/*
* ====================================
* calculate extra expense
* ====================================*/


function CalculateExtraExpenseAmountTotal() {
    var ExtraExpenseTotal = 0;
    $('.ExtraExpenseAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            ExtraExpenseTotal += parseFloat($(this).val());
        }
    });
    CalculateTotalExpenseCalculationAmount();
    $('#ExtraExpenseTotalSpentAmount').html(ExtraExpenseTotal);
    $('#TotalExpenseCalculationAmount').html(ExtraExpenseTotal);
}

/*
* ===============================
* calculate extra expense end
* ===============================*/


/*
* ==============================
* Calculate Total Palam Amount
* ==============================*/


function CalculatePaalamTollAmountTotal() {
    var PaalamTollTotal = 0;
    $('.PaalamTollAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            PaalamTollTotal += parseFloat($(this).val());
        }
    });
    CalculateTotalExpenseCalculationAmount();
    $('#PaalamTollTotalSpentAmount').html(PaalamTollTotal);
    $('#TotalPaalamCalculationAmount').html(PaalamTollTotal);
}

/*=================================
* Calculate total paalam toll amount end
* =================================*/



/*
* ===============================
* Calculate disel total amount start
* ================================*/



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
    CalculateTotalExpenseCalculationAmount();

    $('#DieselCostTotalSpentAmount').html(DiselAmountTotal);
    $('#DieselLitreTotalSpentAmount').html(DiselQuantityTotal);
    $('#TotalDieselCalculationAmount').html(DiselAmountTotal);
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

var VendorDatas;
GetVendorOptionData();
function GetVendorOptionData(){
    $.ajax({
        type: "get",
        url: '/client/entry/memo/vendors',
        success: function(data) {
            VendorDatas = data;
        }
    });
    return VendorDatas;
}

/*
* ============================
* get ajax data end
* ============================*/


















/*
* ===================================
* Entry Calculation Total Functions
* ===================================*/





CalculateEntryFullMasterFunctionCalculations();
function CalculateEntryFullMasterFunctionCalculations(){
    CalculateUnloadingAmountTotal();
    CalculateloadingAmountTotal();
    CalculateComissionAmountTotal();
    CalculateBillAmountTotal();
    CalculateAdvanceAmountTotal();

    CalculateCleanerPadiPercentageTotal();
    CalculateDriverPadiPercentageTotal();

    CalculateDriverPadiAmountTotal();
    CalculateCleanerPadiAmountTotal();

    CalculateTotalExpenseCalculationAmount();
}


function CalculateCleanerPadiPercentageTotal() {
    $('.CleanerPadiPercentage').each(function(){
        if($(this).parent().parent().find('.BillAmountValue').val() !='' && !isNaN($(this).parent().parent().find('.BillAmountValue').val()) && $(this).val() >0 && $(this).val()<=100) {
            $($(this).parent().parent().find('.CleanerPadiAmountValue')).val(Math.round((parseFloat($(this).parent().parent().find('.BillAmountValue').val()) * parseFloat($(this).val()) / 100)));
        }
    });
}


function CalculateDriverPadiPercentageTotal() {
    $('.DriverPadiPercentage').each(function(){
        if($(this).parent().parent().find('.BillAmountValue').val() !='' && !isNaN($(this).parent().parent().find('.BillAmountValue').val()) && $(this).val() >0 && $(this).val()<=100) {
            $($(this).parent().parent().find('.DriverPadiAmountValue')).val(Math.round((parseFloat($(this).parent().parent().find('.BillAmountValue').val()) * parseFloat($(this).val()) / 100)));
        }
    });
}




function CalculateCleanerPadiAmountTotal() {
    var CleanerPadiTotalAmount = 0;
    $('.CleanerPadiAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            CleanerPadiTotalAmount += parseFloat($(this).val());
        }
    });
    $('#CleanerPadiTotalAmount').html(CleanerPadiTotalAmount);
    $('#TotalCleanerPadiCalculationAmount').html(CleanerPadiTotalAmount);
}

function CalculateDriverPadiAmountTotal() {
    var DriverPadiTotalAmount = 0;
    $('.DriverPadiAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            DriverPadiTotalAmount += parseFloat($(this).val());
        }
    });
    $('#DriverPadiTotalAmount').html(DriverPadiTotalAmount);
    $('#TotalDriverPadiCalculationAmount').html(DriverPadiTotalAmount);
}


function CalculateBillAmountTotal() {
    var BillAmountTotalAmount = 0;
    $('.BillAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            BillAmountTotalAmount += parseFloat($(this).val());
        }
    });
    $('#BillAmountTotalAmount').html(BillAmountTotalAmount);
    $('#TotalTotalIncomeCalculationAmount').html(BillAmountTotalAmount);

}

function CalculateAdvanceAmountTotal() {
    var AdvanceAmountTotalAmount = 0;
    $('.AdvanceAmountTotal').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            AdvanceAmountTotalAmount += parseFloat($(this).val());
        }
    });
    $('#AdvanceAmountTotalAmount').html(AdvanceAmountTotalAmount);
}

function CalculateUnloadingAmountTotal() {
    var UnloadingTotalAmount = 0;
    $('.unLoadingMamoolValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            UnloadingTotalAmount += parseFloat($(this).val());
        }
    });
    $('#UnloadingTotalAmount').html(UnloadingTotalAmount);
    $('#TotalImportCalculationAmount').html(UnloadingTotalAmount);
}

function CalculateloadingAmountTotal() {
    var loadingTotalAmount = 0;
    $('.loadingMamoolValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            loadingTotalAmount += parseFloat($(this).val());
        }
    });
    $('#loadingTotalAmount').html(loadingTotalAmount);
    $('#TotalExportCalculationAmount').html(loadingTotalAmount);
}

function CalculateComissionAmountTotal() {
    var ComissionTotalAmount = 0;
    $('.ComissionValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            ComissionTotalAmount += parseFloat($(this).val());
        }
    });
    $('#ComissionTotalAmount').html(ComissionTotalAmount);
    $('#TotalComissionCalculationAmount').html(ComissionTotalAmount);
}


var CustomerData;
GetCustomerOptionData();
function GetCustomerOptionData(){
    $.ajax({
        type: "get",
        url: '/client/entry/memo/customers',
        success: function(data) {
            CustomerData = data;
        }
    });
    return CustomerData;
}




function CalculateTotalExpenseCalculationAmount() {
    var TOTALEXPENSE = 0;
    $('.CalculeteTotalExpenseAmount').each(function(){
        if($(this).text() !='' && !isNaN($(this).text())){
            TOTALEXPENSE += parseFloat($(this).text());
        }
    });
    $('#TotalTotalSpentCalculationAmount').html(TOTALEXPENSE);
    $('#TotalBalanceCalculationAmount').html(parseFloat($('#TotalTotalIncomeCalculationAmount').text()) - parseFloat(TOTALEXPENSE));
}


CalculateDriverAdvanceAmountTotal();
function CalculateDriverAdvanceAmountTotal() {
    var DriverAdvanceTotalAmount = 0;
    $('.DriverAdvanceAmountValue').each(function(){
        if($(this).val() !='' && !isNaN($(this).val())){
            DriverAdvanceTotalAmount += parseFloat($(this).val());
        }
    });
    $('#DriverAdvanceTotalAmount').html(DriverAdvanceTotalAmount);
}