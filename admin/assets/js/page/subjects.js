$(document).ready(function () {
    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "subjects/save",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    table.row.add([
                        obj.payload.subject.id,
                        $("#add_course_id option:selected").text(),
                        obj.payload.subject.name,
                        obj.payload.subject.description,
                        '<button type="button" onClick="editRow(' + obj.payload.subject.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                 <button type="button" onClick="deleteRow(' + obj.payload.subject.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>'
                    ]).node().id = 'r' + obj.payload.subject.id;
                    table.draw(false);
                    $('#add-new-course').modal('hide');
                    loaderFail();
                }
            });
        });
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "subjects/update",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    table.row($('#r' + obj.payload.subject.id)).remove().draw();
                    table.row.add([
                        obj.payload.subject.id,
                        $("#course_id option:selected").text(),
                        obj.payload.subject.name,
                        obj.payload.subject.description,
                        '<button type="button" onClick="editRow(' + obj.payload.subject.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>\n\
                                 <button type="button" onClick="deleteRow(' + obj.payload.subject.id + ');" class="btn btn-danger btn-sm delete-btn">Delete</button>'
                    ]).node().id = 'r' + obj.payload.subject.id;
                    table.draw(false);
                    $('#edit-modal').modal('hide');
                    loaderSuccess();
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
        url: site_url + "subjects/getRow",
        data: {id: id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            $('#id').val(obj.payload.subject.id);
            $('#course_id').val(obj.payload.subject.course_id);
            $('#name').val(obj.payload.subject.name);
            $('#description').val(obj.payload.subject.description);
            loaderSuccess();
        }
    });
    $.ajax({
        type: "POST",
        url: site_url + "courses/getAllCourses",
        success: function (data) {
            var sel = '';
            var obj = jQuery.parseJSON(data);
            var lan = obj.payload.courses.length;
            for (i = 0; i < lan; i++) {
                if (parseInt(selectedId) === parseInt(obj.payload.courses[i].id)) {
                    $('#course_id').append($("<option selected='selected'></option>").attr("value", obj.payload.courses[i].id).text(obj.payload.courses[i].name));
                } else {
                    $('#course_id').append($("<option></option>").attr("value", obj.payload.courses[i].id).text(obj.payload.courses[i].name));
                }
            }
        }
    });
}
function deleteRow(id) {
    loaderProcess();
    $('#delete-modal').modal('show');
    $('#delete').on('click', function () {
        $.ajax({
            type: "POST",
            url: site_url + "subjects/delete",
            data: {id: id},
            success: function () {
                table.row($('#r' + id)).remove().draw();
                $('#delete-modal').modal('hide');
                loaderSuccess();
            }
        });
    });
}