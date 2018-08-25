$(document).ready(function () {
    $('.edit-profile').on('click', function () {
        $('#edit-profile-modal').modal('show');
    });
    $('.edit-btn').on('click', function () {
        $('#edit-modal').modal('show');
    });
    $('.delete-btn').on('click', function () {
        $('#delete-modal').modal('show');
    });
    $('.select-batch').on('click', function () {
        $('#batch-code-modal').modal('hide');
        var $row = $(this).closest("tr"),
                $tds = $row.find("td");
        var array = [];
        $.each($tds, function () {
            array.push($(this).text());
        });
        $('#edit-batch_id').val(array[0]);
        $('#edit-course_name').val(array[1]);
        $('#edit-batch_code').val(array[2]);
        $('#edit-batch_start_date').val(array[3]);
        $('#edit-course_name').val(array[1]);
    });
    $('#edit-payment_amount').on('keyup', function () {
        var amount = parseInt($('#edit-payment_amount').val());
        var due_amount = parseInt($('#due_amount').val());
        var currentAmount = parseInt($("#currentAmount").val());
        if(amount === due_amount){
            $('#edit-next_due_date').val('NA');
            $("#edit-next_due_date").attr('required',false);
            $("#edit-next_due_date").attr('disabled',true);
            $("#edit-pay-fee-dis").attr('disabled',false);
        }else if(amount > (due_amount + currentAmount)){
            alert('Amount Exceeded.');
            $("#edit-pay-fee-dis").attr('disabled',true);
        }else{
            //$('#edit-next_due_date').val('');
            $("#edit-next_due_date").attr('required',true);
            $("#edit-next_due_date").attr('disabled',false);
            $("#edit-pay-fee-dis").attr('disabled',false);
        }
        var cgst = getCgst(amount);
        $('#edit-payment_tution_fee').val(getTuitionFee(amount));
        $('#edit-payment_cgst').val(getCgst(amount));
        $('#edit-payment_sgst').val(getSgst(amount));
    });
    $('#payment_amount').on('keyup', function () {

        
        var amount = parseInt($('#payment_amount').val());
        var due_amount = parseInt($('#due_amount').val());

        if(amount === due_amount){
            $('#next_due_date').val('NA');
            $("#next_due_date").attr('required',false);
            $("#next_due_date").attr('disabled',true);
            $("#pay-fee-dis").attr('disabled',false);
        }else if(amount > due_amount){
            alert('Amount Exceeded.');
            $("#pay-fee-dis").attr('disabled',true);
        }else{
            $('#next_due_date').val('');
            $("#next_due_date").attr('required',true);
            $("#next_due_date").attr('disabled',false);
            $("#pay-fee-dis").attr('disabled',false);
        }

        var cgst = getCgst(amount);
        $('#payment_tution_fee').val(getTuitionFee(amount));
        $('#payment_cgst').val(getCgst(amount));
        $('#payment_sgst').val(getSgst(amount));
    });
    $('#debit-payment_amount').on('keyup', function () {
        var amount = parseInt($('#debit-payment_amount').val())
        var cgst = getCgst(amount);
        $('#debit-payment_tution_fee').val(getTuitionFee(amount));
        $('#debit-payment_cgst').val(getCgst(amount));
        $('#debit-payment_sgst').val(getSgst(amount));
    });
    $('.edit-informations').on('click', function () {
        $('#edit-informations-modal').modal('show');
    });
    $('.search-batch-code-informations').on('click', function () {
        $('#batch-code-modal').modal('show');
    });
    $('.search-bank').on('click', function () {
        $('#bank-detail-modal').modal('show');
        loaderProcess();
        $.ajax({
            url: site_url + 'invoices/getBankDetail',
            type: "post",
            data: {search_ifsc: $('#payment_bank_ifsc').val()},
            cache: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.status.error === true) {
                    loaderFail(obj.status.message);
                    return false;
                }
                table = $('#table-2').DataTable();
                table.clear();
                for (var i = 0; i < obj.payload.bank_details.length; i++) {
                    var vals = "'" + obj.payload.bank_details[i].ifsc_code + "', '" + obj.payload.bank_details[i].bank_name + "', '" + obj.payload.bank_details[i].branch_name + "'";
                    table.row.add([
                        obj.payload.bank_details[i].ifsc_code,
                        obj.payload.bank_details[i].bank_name,
                        obj.payload.bank_details[i].branch_name,
                        '<button type="button" onClick="selectedBank(' + vals + ');" class="btn btn-info btn-sm select">Select</button>'
                    ]).node().id = 'ar' + obj.payload.bank_details[i].id;
                }
                table.draw(false);
                loaderSuccess();
            }
        });
    });
    $('.debit-search-bank').on('click', function () {
        $('#bank-detail-modal').modal('show');
        loaderProcess();
        $.ajax({
            url: site_url + 'invoices/getBankDetail',
            type: "post",
            data: {search_ifsc: $('#debit-payment_bank_ifsc').val()},
            cache: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.status.error === true) {
                    loaderFail(obj.status.message);
                    return false;
                }
                table = $('#table-2').DataTable();
                table.clear();
                for (var i = 0; i < obj.payload.bank_details.length; i++) {
                    var vals = "'" + obj.payload.bank_details[i].ifsc_code + "', '" + obj.payload.bank_details[i].bank_name + "', '" + obj.payload.bank_details[i].branch_name + "'";
                    table.row.add([
                        obj.payload.bank_details[i].ifsc_code,
                        obj.payload.bank_details[i].bank_name,
                        obj.payload.bank_details[i].branch_name,
                        '<button type="button" onClick="debitSelectedBank(' + vals + ');" class="btn btn-info btn-sm select">Select</button>'
                    ]).node().id = 'ar' + obj.payload.bank_details[i].id;
                }
                table.draw(false);
                loaderSuccess();
            }
        });
    });
    $('.edit-search-bank').on('click', function () {
        $('#edit-bank-detail-modal').modal('show');
        loaderProcess();
        $.ajax({
            url: site_url + 'invoices/getBankDetail',
            type: "post",
            data: {search_ifsc: $('#edit-payment_bank_ifsc').val()},
            cache: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.status.error === true) {
                    loaderFail(obj.status.message);
                    return false;
                }
                table = $('#table-0').DataTable();
                table.clear();
                for (var i = 0; i < obj.payload.bank_details.length; i++) {
                    var vals = "'" + obj.payload.bank_details[i].ifsc_code + "', '" + obj.payload.bank_details[i].bank_name + "', '" + obj.payload.bank_details[i].branch_name + "'";
                    table.row.add([
                        obj.payload.bank_details[i].ifsc_code,
                        obj.payload.bank_details[i].bank_name,
                        obj.payload.bank_details[i].branch_name,
                        '<button type="button" onClick="editSelectedBank(' + vals + ');" class="btn btn-info btn-sm select">Select</button>'
                    ]).node().id = 'ar' + obj.payload.bank_details[i].id;
                }
                table.draw(false);
                loaderSuccess();
            }
        });
    });
    $('#pay-fee').on('click', function () {
        $('#pay-fee-modal').modal('show');
    });
    $('#pay-mode-1').on('click', function () {
        $('#payment_bank_name').prop('required', false);
        $('#payment_bank_ref_number').prop('required', false);
        $('#check-frm').hide();
    });
    $('#pay-mode-2').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#check-frm').show();
    });
    $('#pay-mode-3').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#check-frm').show();
    });
    $('#pay-mode-4').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#check-frm').show();
    });
    $('#pay-mode-5').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#check-frm').show();
    });
    $('#pay-mode-6').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#check-frm').show();
    });
    $('#debit-pay-mode-1').on('click', function () {
        $('#debit-payment_bank_name').prop('required', false);
        $('#debit-payment_bank_ref_number').prop('required', false);
        $('#debit-check-frm').hide();
    });
    $('#debit-pay-mode-2').on('click', function () {
        $('#debit-payment_bank_name').prop('required', true);
        $('#debit-payment_bank_ref_number').prop('required', true);
        $('#debit-check-frm').show();
    });
    $('#debit-pay-mode-3').on('click', function () {
        $('#debit-payment_bank_name').prop('required', true);
        $('#debit-payment_bank_ref_number').prop('required', true);
        $('#debit-check-frm').show();
    });
    $('#debit-pay-mode-4').on('click', function () {
        $('#debit-payment_bank_name').prop('required', true);
        $('#debit-payment_bank_ref_number').prop('required', true);
        $('#debit-check-frm').show();
    });
    $('#debit-pay-mode-5').on('click', function () {
        $('#debit-payment_bank_name').prop('required', true);
        $('#debit-payment_bank_ref_number').prop('required', true);
        $('#debit-check-frm').show();
    });
    $('#debit-pay-mode-6').on('click', function () {
        $('#debit-payment_bank_name').prop('required', true);
        $('#debit-payment_bank_ref_number').prop('required', true);
        $('#debit-check-frm').show();
    });
    $('#edit-pay-mode-1').on('click', function () {
        $('#payment_bank_name').prop('required', false);
        $('#payment_bank_ref_number').prop('required', false);
        $('#edit-check-frm').hide();
    });
    $('#edit-pay-mode-2').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#edit-check-frm').show();
    });
    $('#edit-pay-mode-3').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#edit-check-frm').show();
    });
    $('#edit-pay-mode-4').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#edit-check-frm').show();
    });
    $('#edit-pay-mode-5').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#edit-check-frm').show();
    });
    $('#edit-pay-mode-6').on('click', function () {
        $('#payment_bank_name').prop('required', true);
        $('#payment_bank_ref_number').prop('required', true);
        $('#edit-check-frm').show();
    });
    $(function () {
        $("#student-filter-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'students/getSearchedStudents',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    table.clear();
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    for (var i = 0; i < obj.payload.students.length; i++) {
                        table.row.add([
                            obj.payload.students[i].fname,
                            obj.payload.students[i].fathers_name,
                            '<a href="' + site_url + 'students/profile/' + obj.payload.students[i].id + '">' + getRegNo(obj.payload.students[i]) + '</a>',
                            obj.payload.students[i].batch_code,
                            obj.payload.students[i].phone
                        ]).node().id = 'r' + obj.payload.students[i].id;
                    }
                    table.column('1:visible').order('desc').draw(false);
                    loaderSuccess();
                }
            });
        });
        $("#edit-batch-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'students/editBatch',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    // Chagne Batch
                    $('#batch_code_p').html($('#edit-batch_code').val());
                    $('#batch_start_date_p').html($('#edit-batch_start_date').val());
                    $('#batch_course_name_p').html($('#edit-course_name').val());
                    loaderSuccess();
                    $('#edit-profile-modal').modal('hide');
                }
            });
        });
        $("#edit-student-frm").on("submit", function (event) {
            event.preventDefault();
            var b = $('#edit-balance').val();
            if(b === 'undefined' || b.length === 0)
                b=0;            
            var balance = parseInt(b);
            var discount = parseInt($('#discount').val());
            //var feePending = parseInt($('.fee-pending-val').html());
            if (discount > balance) {
                loaderFail('Discount should not be greater than Balance');
                return false;
            }
            loaderProcess();
            $.ajax({
                url: site_url + 'students/editProfile',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    window.location.replace(site_url + 'students/profile/' + obj.payload.student.id);
                    return false;
                    $('#edit-informations-modal').modal('hide');
                    // view Info
                    $('.first-name-val').html(obj.payload.student.fname);
                    $('.last-name-val').html(obj.payload.student.lname);
                    $('.Law-school-val').html(obj.payload.student.law_school);
                    $('.yop-val').html(obj.payload.student.yop);
                    $('.referred-by-val').html(obj.payload.student.referred_by);
                    $('.course-name-val').html(obj.payload.student.course_name);
                    $('.father-name-val').html(obj.payload.student.fathers_name);
                    $('.occupation-val').html(obj.payload.student.fathers_occupation);
                    $('.father-phone-val').html(obj.payload.student.phone);
                    $('.student-email-val').html(obj.payload.student.email);
                    $('.student-mobile-val').html(obj.payload.student.mobile);
                    $('.temporary-add-val').html(obj.payload.student.local_address);
                    $('.permanent-add-val').html(obj.payload.student.permanant_address);
                    loaderSuccess();
                }
            });
        });
        $(".add-fee-frm").on("submit", function (event) {
            event.preventDefault();
            $("#pay-fee-dis").val("Please Wait...").attr('disabled', true);
            loaderProcess();
            $.ajax({
                url: site_url + 'invoices/payFee',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        $("#pay-fee-dis").val("Pay Fee").removeAttr('disabled', false);
                        return false;
                    }
                    window.location.replace(site_url + 'invoices/detail/' + obj.payload.invoice.id + '/' + obj.payload.invoice.student_created_at + '/' + obj.payload.invoice.created_at);
                }
            });
        });
        $(".add-debit-notes-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'debitnotes/save',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    loaderSuccess();
                    window.location.replace(site_url + 'debitnotes/detail/' + obj.payload.debitnote.id);
                }
            });
        });
        $(".edit-invoice").on("click", function (event) {
            event.preventDefault();
            $('#edit-pay-fee-modal').modal('show');
            var invoice_id = $(this).data("id");
            $('#edit-invoice-id').val(invoice_id);
            $.ajax({
                url: site_url + 'invoices/getInvoiceById',
                type: "post",
                data: {invoice_id: invoice_id},
                cache: false,
                success: function (data) {
                    var obj = $.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
                    loaderSuccess();
                    $('#edit-payment_type_id').val(obj.payload.invoice.payment_type_id);
                    $('#edit-payment_amount').val(obj.payload.invoice.payment_amount);
                    $('#edit-payment_tution_fee').val(getTuitionFee(obj.payload.invoice.payment_amount));
                    $('#edit-payment_cgst').val(getCgst(obj.payload.invoice.payment_amount));
                    $('#edit-payment_sgst').val(getSgst(obj.payload.invoice.payment_amount));
                    $('#edit-payment_bank_branch_name').val(obj.payload.invoice.payment_bank_branch_name);
                    $('#edit-payment_bank_ifsc').val(obj.payload.invoice.payment_bank_ifsc);
                    $('#edit-payment_bank_name').val(obj.payload.invoice.payment_bank_name);
                    $('#edit-payment_bank_ref_number').val(obj.payload.invoice.payment_bank_ref_number);
                    $('#edit-next_due_date').val(obj.payload.invoice.next_due_date);
                    $('#currentAmount').val(obj.payload.invoice.payment_amount);
                    $("#edit-pay-mode-" + obj.payload.invoice.payment_mode_id).attr('checked', true);
                    if (obj.payload.invoice.payment_mode_id != 1) {
                        $('#edit-check-frm').show();
                    }
                }
            });
        });
        $(".update-invoice").on("submit", function (event) {
            event.preventDefault();
            $('#edit-pay-fee-modal').modal('hide');
            loaderProcess();
            $.ajax({
                url: site_url + 'invoices/update',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var obj = $.parseJSON(data);
                    if (obj.status.error === true) {
                        loaderFail(obj.status.message);
                        return false;
                    }
//                    loaderSuccess();
//                    table.row($('#r' + obj.payload.invoice.id)).remove();
//                    table.row.add([
//                        '<a href="' + site_url + 'invoices/detail/' + obj.payload.invoice.id + '/' + obj.payload.invoice.student_created_at + '/' + obj.payload.invoice.created_at + '">' + obj.payload.invoice.id + '</a>',
//                        obj.payload.invoice.payment_amount,
//                        dateFormate(obj.payload.invoice.created_at),
//                        getPaymentMode(obj.payload.invoice.payment_mode_id),
//                        '<button type="button" data-id="' + obj.payload.invoice.id + '" class="btn btn-primary btn-sm edit-invoice">Edit</button>',
//                    ]).node().id = 'r' + obj.payload.invoice.id;
//                    table.draw(false);
                    //$('#edit-pay-fee-modal').modal('hide');
                    window.location.replace(site_url + 'invoices/detail/' + obj.payload.invoice.id + '/' + obj.payload.invoice.student_created_at + '/' + obj.payload.invoice.created_at);
                    //document.submit();
                }
            });
        });
    });
    $('refund-fee').on('click', function () {
        $('#refund-fee-modal').modal('show');
    });
});
function selectedBank(ifsc_code, bank_name, branch_name) {
    $('#bank-detail-modal').modal('hide');
    $('#payment_bank_ifsc').val(ifsc_code);
    $('#payment_bank_name').val(bank_name);
    $('#payment_bank_branch_name').val(branch_name);
}

function debitSelectedBank(ifsc_code, bank_name, branch_name) {
    $('#bank-detail-modal').modal('hide');
    $('#debit-payment_bank_ifsc').val(ifsc_code);
    $('#debit-payment_bank_name').val(bank_name);
    $('#debit-payment_bank_branch_name').val(branch_name);
}

function editSelectedBank(ifsc_code, bank_name, branch_name) {
    $('#edit-bank-detail-modal').modal('hide');
    $('#edit-payment_bank_ifsc').val(ifsc_code);
    $('#edit-payment_bank_name').val(bank_name);
    $('#edit-payment_bank_branch_name').val(branch_name);
}

