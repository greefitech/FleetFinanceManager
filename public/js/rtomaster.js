$('body').on('click','.AddRTOMasterInput',function () {
    var RTOData = '<tr>\n' +
        '    <td>\n' +
        '        <input type="text" class="form-control" name="RTOData[location][]" value="">\n' +
        '    </td>\n' +
        '    <td>\n' +
        '        <input type="text" id="number-only" min="0" class="form-control" name="RTOData[amount][]" value="">\n' +
        '    </td>\n' +
        '    <td class="RemoveRTOMasterInput" style="font-size: 18px;"><i style="color: red;" class="fa fa-close fa-10x"></i></td>\n' +
        '</tr>';
    $('.RTOMasterTableData').append(RTOData);
});

$('body').on('click','.RemoveRTOMasterInput',function (e) {
    e.preventDefault();
    $(this).parent().remove();
});