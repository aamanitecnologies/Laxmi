$(document).ready(function () {
    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'parts/save',
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
                        obj.payload.part.id,
                        obj.payload.part.part_name,
                        obj.payload.part.qty,
                        '<button type="button" onClick="editRec(' + obj.payload.part.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                                 <button type="button" onClick="deleteRec(' + obj.payload.part.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>']).node().id = 'r' + obj.payload.part.id;
                    table.draw(false);
                    $('#add-new-part').modal('hide');
                    loaderSuccess();
                }
            });
        });
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'parts/update',
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
                    table.row($('#r' + obj.payload.part.id)).remove();
                    table.row.add([
                        obj.payload.part.id,
                        obj.payload.part.part_name,
                        obj.payload.part.qty,
                        '<button type="button" onClick="editRec(' + obj.payload.part.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                                 <button type="button" onClick="deleteRec(' + obj.payload.part.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>']).node().id = 'r' + obj.payload.part.id;
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
        url: site_url + 'parts/getPartById',
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            $('#part_id').val(obj.payload.part.id);
            $('#edit-part_name').val(obj.payload.part.part_name);
            $('#edit-qty').val(obj.payload.part.qty);
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
        url: site_url + 'parts/delete',
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

     