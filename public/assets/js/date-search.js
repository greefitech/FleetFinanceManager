//     $("#min").datepicker({
//       dateFormat: 'dd-mm-yy'
//     });
//     $("#max").datepicker({
//       dateFormat: 'dd-mm-yy'
//     });

// $(document).ready( function () {
//             $.fn.dataTable.ext.search.push(
//                 function( settings, data, dataIndex ) {
//                     var min = $('#min').val();
//                     var max = $('#max').val();
//                     var date =  data[0]; // use data for the age column
//                     var data_table_date = date.split("-");
//                     var table_date = data_table_date[0];
//                     var table_month = data_table_date[1];
//                     var table_year = data_table_date[2];
//                     var table_date_final  = table_year + '-' + table_month + '-' + table_date;
                    
//                     var minimum  = min.split("-");
//                     var min_date = minimum[0];
//                     var min_month = minimum[1];
//                     var min_year = minimum[2];
//                     var minimum_date = min_year + '-' + min_month + '-' + min_date;

//                     var maximum  = max.split("-");
//                     var max_date = maximum[0];
//                     var max_month = maximum[1];
//                     var max_year = maximum[2];
//                     var maximum_date = max_year + '-' + max_month + '-' + max_date;
//                     console.log(table_date_final);
                    
                   
//                     // if ( ( min == '' && max == '' ) ||
//                     // ( min == '' && date <= max ) ||
//                     // ( min <= date && '' == max ) ||
//                     // ( min <= date && date <= max ) )
//                     if((min == '' && max == '') ||
//                       (min == '' &&  table_date_final <= maximum_date )  ||
//                       (minimum_date <= table_date_final && '' == max) ||
//                       (minimum_date <= table_date_final && table_date_final <= maximum_date))
//                     {
//                     return true;
//                     }
//                     return false;
//                 }
//             );

//             var table = $('#customer_outstanding_amount').DataTable({
                
//             });
//             $('#test').click( function() {
//                 table.draw();
//             });

//          //Date Picker 
//             $("#min").datepicker({
//                 onSelect: function(currDate) {
//                     $("#status").html("Selected date: " + currDate);
//                 },
//                 dateFormat: 'dd-mm-yy'
//             });
//             $("#max").datepicker({
//                 onSelect: function(currDate) {
//                     $("#status").html("Selected date: " + currDate);
//                 },
//                 dateFormat: 'dd-mm-yy'
//             });

//            $('#sales_export').on('click', function(){
//             $('<table>').append(table.$('tr').clone()).table2excel({
//              exclude: ".excludeThisClass",
//              name: "Sales Details",
//              filename: "Sales Details" //do not include extension
//          });
//   });    
// } );
        






        

