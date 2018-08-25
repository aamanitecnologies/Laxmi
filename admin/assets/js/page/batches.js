$(document).ready(function () {

    $('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    $('.edit-profile').on('click', function () {
        $('#edit-profile-modal').modal('show');
    });

    $('#send-sms').on('click', function () {
        $('#sms-modal').modal('show');
    });
    
    $('#send-email').on('click', function () {
        $('#email-modal').modal('show');
    });

    $('#admission_status').hide();
    $('#online_admission_status').hide();

    $(function () {
        $("#addFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "batches/save",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    loaderSuccess();
                    window.location.replace(site_url + 'batches/detail/' + obj.payload.batch.id);
                }
            });
        });
        
        $("#send-sms-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $('#msg').html('');
            $.ajax({
                url: site_url + "batches/sendSms",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    $('#msg').show();
                    $('#msg').html('Message Successfully Send');
                    loaderSuccess();
                }
            });
        });
        
        $("#send-email-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $('#email-msg').html('');
            $("#send-email").val("Please Wait...").attr('disabled', true);
            $.ajax({
                url: site_url + "batches/sendEmails",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    $('#email-msg').show();
                    $('#email-msg').html(data);
                    loaderSuccess();
                    $("#send-email").val("Please Wait...").attr('disabled', false);
                }
            });
        });
        
        $("#editFrm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + "batches/update",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    loaderSuccess();
                    window.location.replace(site_url+"batches/detail/" + obj.payload.batch.id);
                }
            });
        });
        $("#filter").on("submit", function (event) {
            loaderProcess();
            event.preventDefault();
            $.ajax({
                url: site_url + "batches/filter",
                type: "post",
                data: $(this).serialize(),
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    table.clear();
                    for (var i = 0; i < obj.payload.batches.length; i++) {
                        table.row.add([
                            '<a href="' + site_url + 'batches/detail/' + obj.payload.batches[i].id + '">' + obj.payload.batches[i].id + '</a>',
                            obj.payload.batches[i].course,
                            obj.payload.batches[i].batch_code,
                            obj.payload.batches[i].batch_start_date
                        ]).node().id = 'r' + obj.payload.batches[i].id;
                    }
                    table.draw(false);
                    loaderSuccess();
                }
            });
        });
    });

    $('.enable-admission').on('click', function () {
        $('#admission-model').modal('show');
        var status = parseInt($('#admission_status').html());
        if (status === 1) {
            $('#conf').html('Are you sure want to admissions close');
        } else {
            $('#conf').html('Are you sure want to admissions open');
        }
    });
    $('.enable-online-admission').on('click', function () {
        $('#online-admission-model').modal('show');
        var status = parseInt($('#online_admission_status').html());
        if (status === 1) {
            $('#online_conf').html('Are you sure want to online close admissions');
        } else {
            $('#online_conf').html('Are you sure want to online admissions open');
        }
    });

});
function changeAdminssionStatus(batch_id) {
    loaderProcess();
    var status = parseInt($('#admission_status').html());
    if (status) {
        var s = 0;
    } else {
        var s = 1;
    }
    $.ajax({
        type: "POST",
        url: site_url + "batches/admissionStatus",
        data: {id: batch_id, status: s},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            if (status === 1) {
                $('#admission_status').html('0');
                $("#admission_text").html('Admission Closed');
                $("#admission").removeClass("btn-success");
                $("#admission_i").removeClass("ti-check");
                $("#admission").addClass("btn-danger");
                $("#admission_i").addClass("ti-close");
            } else {
                $('#admission_status').html('1');
                $("#admission_text").html('Admission Opend');
                $("#admission").removeClass("btn-danger");
                $("#admission_i").removeClass("ti-close");
                $("#admission").addClass("btn-success");
                $("#admission_i").addClass("ti-check");
            }
            loaderSuccess();
            $('#admission-model').modal('hide');
        }
    });
}
function changeOnlineAdminssionStatus(batch_id) {
    loaderProcess();
    var status = parseInt($('#online_admission_status').html());
    if (status) {
        var s = 0;
    } else {
        var s = 1;
    }
    $.ajax({
        type: "POST",
        url: site_url + "batches/onlineAdmissionStatus",
        data: {id: batch_id, status: s},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status.error) {
                loaderFail(obj.status.message);
                return false;
            }
            if (status === 1) {
                $('#online_admission_status').html('0');
                $("#online_admission_text").html('Online Admission Closed');
                $("#online_admission").removeClass("btn-success");
                $("#online_admission_i").removeClass("ti-check");
                $("#online_admission").addClass("btn-danger");
                $("#online_admission_i").addClass("ti-close");
            } else {
                $('#online_admission_status').html('1');
                $("#online_admission_text").html('Online Admission Opend');
                $("#online_admission").removeClass("btn-danger");
                $("#online_admission_i").removeClass("ti-close");
                $("#online_admission").addClass("btn-success");
                $("#online_admission_i").addClass("ti-check");
            }
            loaderSuccess();
            $('#online-admission-model').modal('hide');
        }
    });
}
