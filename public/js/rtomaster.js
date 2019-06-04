$('body').on('click','.AddRTOMasterInput',function () {
    var RTOData = '<tr>\n' +
        '    <td>\n' +
        '        <input type="text" class="form-control" name="RTOData[location][]" value="">\n' +
        '    </td>\n' +
        '    <td>\n' +
        '        <input type="number" min="0" class="form-control" name="RTOData[amount][]" value="">\n' +
        '    </td>\n' +
        '    <td><i style="color: red;" class="fa fa-close RemoveRTOMasterInput"></i></td>\n' +
        '</tr>';
    $('.RTOMasterTableData').append(RTOData);
});

$('body').on('click','.RemoveRTOMasterInput',function (e) {
    e.preventDefault();
    $(this).parent().parent().remove();
});