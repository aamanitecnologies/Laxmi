$(document).ready(function () {
    $(function () {
        // Search Balance Report By Batch
        $("#balance-report-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'reports/getBalanceReportByBatchId',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    table.clear();
                    var obj = jQuery.parseJSON(data);
                    table.row().remove();
                    for (var i = 0; i < obj.payload.balanceReport.length; i++) {
                        table.row.add([
                            obj.payload.balanceReport[i].fname,
                            '<a href="' + site_url + 'students/profile/' + obj.payload.balanceReport[i].id + '">' + getRegNo(obj.payload.balanceReport[i]) + '</a>',
                            obj.payload.balanceReport[i].total_course_fee,
                            obj.payload.balanceReport[i].paid,
                            obj.payload.balanceReport[i].discount,
                            (obj.payload.balanceReport[i].balance),
                        ]).node().id = 'r' + obj.payload.balanceReport[i].id;
                    }
                    table.column('1:visible').order('asc').draw(false);
                    loaderSuccess();
                }
            });
        });

        // Search Admission Report By Date Range
        $("#admission-report-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            $.ajax({
                url: site_url + 'reports/getAdmissionReportByDateRange',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    table.clear();
                    var obj = jQuery.parseJSON(data);
                    table.row().remove();
                    for (var i = 0; i < obj.payload.admissionReport.length; i++) {
                        table.row.add([
                            dateFormate(obj.payload.admissionReport[i].created_at),
                            '<a href="' + site_url + 'students/profile/' + obj.payload.admissionReport[i].id + '">' + getRegNo(obj.payload.admissionReport[i]) + '</a>',
                            obj.payload.admissionReport[i].fname,
                            obj.payload.admissionReport[i].mobile,
                            obj.payload.admissionReport[i].batch_code + '<br>' + dateFormate(obj.payload.admissionReport[i].batch_start_date),
                            getPaymentMode(obj.payload.admissionReport[i].payment_mode_id),
                        ]).node().id = 'r' + obj.payload.admissionReport[i].id;
                    }
                    table.column('1:visible').order('asc').draw(false);
                    loaderSuccess();
                }
            });
        });

        // Search Admission Report By Date Range
        $("#payment-report-frm").on("submit", function (event) {
            event.preventDefault();
            loaderProcess();
            var total_cash_amount = 0;
            $.ajax({
                url: site_url + 'reports/getPaymentReportByDateRange',
                type: "post",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    table.clear();
                    var obj = jQuery.parseJSON(data);
                    table.row().remove();
                    for (var i = 0; i < obj.payload.paymentReport.length; i++) {
                        if(obj.payload.paymentReport[i].payment_mode_id == 1){
                            total_cash_amount = parseInt(total_cash_amount) + parseInt(obj.payload.paymentReport[i].payment_amount);
                        }
                        table.row.add([
                            '<a href="' + site_url + 'invoices/detail/' + obj.payload.paymentReport[i].id + '/' + obj.payload.paymentReport[i].student_created_at+ '/' + obj.payload.paymentReport[i].created_at + '">' + obj.payload.paymentReport[i].id + '</a>',
                            dateFormate(obj.payload.paymentReport[i].created_at),
                            '<a href="' + site_url + 'students/profile/' + obj.payload.paymentReport[i].student_id + '">' + getRegNo(obj.payload.paymentReport[i]) + '</a>',
                            obj.payload.paymentReport[i].fname,
                            obj.payload.paymentReport[i].batch_code + '<br>' + dateFormate(obj.payload.paymentReport[i].batch_start_date),
                            getPaymentMode(obj.payload.paymentReport[i].payment_mode_id),
                            obj.payload.paymentReport[i].payment_amount,
                        ]).node().id = 'r' + obj.payload.paymentReport[i].id;
                    }
                    table.column('1:visible').order('asc').draw(false);
                    $('#total_cash_amount').html(total_cash_amount);
                    loaderSuccess();
                }
            });
        });
    });
});

