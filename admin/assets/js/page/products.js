$(document).ready(function () {
    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'products/save',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = $.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    table.row.add([
                        obj.payload.machine.id,
                        obj.payload.machine.product_name,
                        obj.payload.machine.model_no,
                        '<button type="button" onClick="editRec(' + obj.payload.machine.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                                 <button type="button" onClick="deleteRec(' + obj.payload.machine.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>']).node().id = 'r' + obj.payload.machine.id;
                    table.draw(false);
                    $('#add-new-product').modal('hide');
                    loaderSuccess();
                }
            });
        });
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'courses/update',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    table.row($('#r' + obj.payload.course.id)).remove();
                    table.row.add([
                        obj.payload.course.id,
                        obj.payload.course.name,
                        obj.payload.course.course_code,
                        obj.payload.course.duration + ' ' + obj.payload.course.duration_code,
                        obj.payload.course.course_fee,
                        '<button type="button" onClick="editRec(' + obj.payload.course.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                                 <button type="button" onClick="deleteRec(' + obj.payload.course.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>']).node().id = 'r' + obj.payload.course.id;
                    table.draw(false);
                    loaderSuccess();
                    $('#edit-modal').modal('hide');
                }
            });
        });
    });
});

function editRec(id) {
    loaderProcess();
    $('#edit-modal').modal('show');
    $.ajax({
        type: "POST",
        url: site_url + 'products/getProductById',
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            $('#id').val(obj.payload.machine.id);
            $('#edit-product_name').val(obj.payload.machine.product_name);
            $('#edit-model_no').val(obj.payload.machine.model_no);
            loaderSuccess();
        }
    });
}
function deleteRec(id) {
    $('#delId').val(id);
    $('#delete-modal').modal('show');
}

function deleteCon() {
    loaderProcess();
    var id = $('#delId').val();
    $.ajax({
        type: "POST",
        url: site_url + 'products/delete',
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            table.row($('#r' + id)).remove().draw();
            $('.btn-default').click();
            $('#delete-modal').modal('hide');
            loaderSuccess();
        }
    });
}

     