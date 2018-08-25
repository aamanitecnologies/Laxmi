$(document).ready(function () {
    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "batchcodes/save",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    table.row.add([
                        obj.payload.batch_code.id,
                        obj.payload.batch_code.batch_code,
                        obj.payload.batch_code.batch_code_display,
                        obj.payload.batch_code.batch_code_timing,
                        '<button type="button" onClick="editRow(' + obj.payload.batch_code.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                                                             <button type="button" onClick="deleteRow(' + obj.payload.batch_code.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>'
                    ]).node().id = 'r' + obj.payload.batch_code.id;
                    table.draw(false);
                    loaderSuccess();
                    $('.btn-default').click();
                }
            });
        });
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "batchcodes/update",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    table.row($('#r' + obj.payload.batch_code.id)).remove().draw();
                    table.row.add([
                        obj.payload.batch_code.id,
                        obj.payload.batch_code.batch_code,
                        obj.payload.batch_code.batch_code_display,
                        obj.payload.batch_code.batch_code_timing,
                        '<button type="button" onClick="editRow(' + obj.payload.batch_code.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                                                             <button type="button" onClick="deleteRow(' + obj.payload.batch_code.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>'
                    ]).node().id = 'r' + obj.payload.batch_code.id;
                    table.draw(false);
                    loaderSuccess();
                    $('.btn-default').click();
                }
            });
        });
    });
});
function editRow(id) {
    $('#edit-modal').modal('show');
    loaderProcess();
    $.ajax({
        type: "POST",
        url: site_url + "batchcodes/getRow",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            $('#id').val(obj.payload.batch_code.id);
            $('#batch_code').val(obj.payload.batch_code.batch_code);
            $('#batch_code_display').val(obj.payload.batch_code.batch_code_display);
            $('#batch_code_timing').val(obj.payload.batch_code.batch_code_timing);
            loaderSuccess();
        }
    });
}
function deleteRow(id) {
    $('#delId').val(id);
    $('#delete-modal').modal('show');
}
function deleteCon() {
    loaderProcess();
    var id = $('#delId').val();
    $.ajax({
        type: "POST",
        url: site_url + "batchcodes/delete",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            table.row($('#r' + id)).remove().draw();
            loaderSuccess();
            $('#delete-modal').modal('hide');
        }
    });
}
