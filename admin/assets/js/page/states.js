$(document).ready(function () {
    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "states/save",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    table.row.add([
                        obj.payload.state.id,
                        obj.payload.state.state,
                        obj.payload.state.language,
                        '<button type="button" onClick="editRow(' + obj.payload.state.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                 <button type="button" onClick="deleteRow(' + obj.payload.state.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>'
                    ]).node().id = 'r' + obj.payload.state.id;
                    table.draw(false);
                    $('.btn-default').click();
                    loaderSuccess();
                }
            });
        });
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "states/update",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    table.row($('#r' + obj.payload.state.id)).remove();
                    table.row.add([
                        obj.payload.state.id,
                        obj.payload.state.state,
                        obj.payload.state.language,
                        '<button type="button" onClick="editRow(' + obj.payload.state.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                 <button type="button" onClick="deleteRow(' + obj.payload.state.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>'
                    ]).node().id = 'r' + obj.payload.state.id;
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
        url: site_url + "states/getRow",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            $('#id').val(obj.payload.state.id);
            $('#state_code').val(obj.payload.state.state_code);
            $('#state').val(obj.payload.state.state);
            $('#language').val(obj.payload.state.language);
            loaderSuccess();
        }
    });
}
function deleteRow(id) {
    $('#delete-modal').modal('show');
    $('#delete').on('click', function () {
        loaderProcess();
        $.ajax({
            type: "POST",
            url: site_url + "states/delete",
            data: {id: id},
            success: function () {
                table.row($('#r' + id)).remove().draw();
                loaderSuccess();
                $('#delete-modal').modal('hide');
            }
        });
    });
}