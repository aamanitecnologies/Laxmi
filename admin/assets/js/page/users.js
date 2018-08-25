$(document).ready(function () {
    $('.loader').val('');
    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            if ($('#pass').val() !== $('#conpass').val()) {
                loaderFail('Password Mismatch');
                return false;
            }
            $.ajax({
                url: site_url + "users/save",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    } else {
                        table.row.add([
                            obj.payload.staff_user.id,
                            obj.payload.staff_user.fname,
                            obj.payload.staff_user.lname,
                            obj.payload.staff_user.email,
                            obj.payload.staff_user.phone,
                            '<span class="text-danger">Disable</span>',
                            '<button type="button" onclick="editRec(' + obj.payload.staff_user.id + ');" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit">Edit</button>\n\
                                     <button type="button" onclick="deleteRec(' + obj.payload.staff_user.id + ');" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">Delete</button>\n\
                                     <button type="button" onclick="resetPassword(' + obj.payload.staff_user.id + ');" class="btn btn-success btn-sm" data-toggle="modal" data-target="#reset-password">Reset password</button>'
                        ]).node().id = 'r' + obj.payload.staff_user.id;
                        table.draw(false);
                        $('#add-modal').modal('hide');
                        loaderSuccess();
                    }
                }
            });
        });
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "users/update",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }

                    table.row($('#r' + obj.payload.staff_user.id)).remove().draw();
                    table.row.add([
                        obj.payload.staff_user.id,
                        obj.payload.staff_user.fname,
                        obj.payload.staff_user.lname,
                        obj.payload.staff_user.email,
                        obj.payload.staff_user.phone,
                        ((obj.payload.staff_user.status === '0') ? '<span class="text-success">Enable</span>' : '<span class="text-danger">Disable</span>'),
                        '<button type="button" onclick="editRec(' + obj.payload.staff_user.id + ');" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit">Edit</button>\n\
                                     <button type="button" onclick="deleteRec(' + obj.payload.staff_user.id + ');" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">Delete</button>\n\
                                     <button type="button" onclick="resetPassword(' + obj.payload.staff_user.id + ');" class="btn btn-success btn-sm" data-toggle="modal" data-target="#reset-password">Reset password</button>'
                    ]).node().id = 'r' + obj.payload.staff_user.id;
                    table.draw(false);
                    $('#edit').modal('hide');
                    loaderSuccess();
                }
            });
        });
        $("#frmPass").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            if ($('#repassword').val() !== $('#reconfirm_password').val()) {
                loaderFail('Password Mismatch');
                return false;
            }
            $.ajax({
                url: site_url + "users/resetPassword",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    $('.btn-default').click();
                    loaderSuccess();
                }
            });
        });
    });
    $('#add-button').on('click', function () {
        $('#add-modal').modal('show');
    });
});
function editRec(id) {
    loaderProcess();
    $.ajax({
        type: "POST",
        url: site_url + "users/getRow",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            $('#id').val(obj.payload.staff_user.id);
            $('#fname').val(obj.payload.staff_user.fname);
            $('#lname').val(obj.payload.staff_user.lname);
            $('#email').val(obj.payload.staff_user.email);
            $('#phone').val(obj.payload.staff_user.phone);
            loaderSuccess();
        }
    });
}
function resetPassword(id) {
    $('input:password').val('');
    loaderProcess();
    $.ajax({
        type: "POST",
        url: site_url + "users/getRow",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            $('#user_id').val(obj.payload.staff_user.id);
            $('#staff_user_id').val(obj.payload.staff_user.id);
            $('#remail').val(obj.payload.staff_user.email);
            loaderSuccess();
        }
    });
}
function deleteRec(id) {
    $('#delId').val(id);
}
function deleteCon() {
    loaderProcess();
    var id = $('#delId').val();
    $.ajax({
        type: "POST",
        url: site_url + "users/delete",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            table.row($('#r' + id)).remove().draw();
            $('#delete').modal('hide');
            loaderSuccess();
        }
    });
}