var C_GST = 9;
var S_GST = 9;
var table = $('#table-1').DataTable();
var loader = 'fa fa-spinner fa-spin fa-fw';
var text_color = 'text-danger';

function loaderProcess() {
    $('.loader').html('');
    $('.loader').removeClass(text_color);
    $('.loader').addClass(loader);
}
function loaderSuccess() {
    $('.loader').html('');
    $('.loader').removeClass(text_color);
    $('.loader').removeClass(loader);
}

function loaderFail(msg) {
    $('.loader').removeClass(loader);
    $('.loader').addClass(text_color);
    $('.loader').html(msg);
}

function getCgst(amount = 0) {
    return getGst(amount) / 2;
}
function getSgst(amount = 0) {
    return getGst(amount) / 2;
}
function getGst(amount = 0) {
    amount = parseInt(amount);
    return (amount - getTuitionFee(amount));
}
function getTuitionFee(amount = 0) {
    amount = parseInt(amount);
    var tuition_fee = (amount / 118) * 100;
    return Math.round(tuition_fee);
}
function getPaymentMode(payment_mode_id = 0) {
    payment_mode_id = parseInt(payment_mode_id);
    var payment_mode = '';
    switch (payment_mode_id) {
        case 1:
            payment_mode = 'Cash';
            break;
        case 2:
            payment_mode = 'Cheque';
            break;
        case 3:
            payment_mode = 'Demand Draft';
            break;
        case 4:
            payment_mode = 'NEFT';
            break;
        case 5:
            payment_mode = 'IMPS';
            break;
        case 6:
            payment_mode = 'Online Payment Gatway';
            break;
        default:
            payment_mode = 'Unknown';
            break;
    }
    return payment_mode;
}

function dateFormate(created_at) {
    var Xmas = new Date(created_at);
    var date = Xmas.getDate();
    var year = Xmas.getFullYear();
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var selectedMonthName = months[Xmas.getMonth()];
    return date + ' ' + selectedMonthName + ' ' + year;
}

function getPaymentType(payment_type_id = 0) {
    payment_mode_id = parseInt(payment_mode_id);
    var payment_type = '';
    switch (payment_type_id) {
        case 1:
            payment_type = 'Admission Fee';
            break;
        case 2:
            payment_type = 'Installment Fee';
            break;
        default:
            payment_mode = 'Unknown';
            break;
    }
    return payment_type;
}

function getRegNo(obj) {
    if (obj.student_id > 0) {
        obj.id = obj.student_id;
    }
    if (obj.registration_no > 0) {
        obj.id = obj.registration_no;
    }
    var preval = 'RIAS';
    var Xmas = new Date(obj.created_at);
    var year = Xmas.getFullYear();
    var course_code = 'JS';
    var student_id = obj.id;
    l = (obj.id).length;
    var p = '';
    if (l === 1) {
        p = '000';
    }
    if (l === 2) {
        p = '00';
    }
    if (l === 3) {
        p = '0';
    }
    var regNo = preval + '/' + year + '/' + course_code + '/' + p + student_id;
    return regNo;
}

function getInvoiceId(obj){
    var pre = 'RIAS';
    var Xmas = new Date(obj.created_at);
    var year = Xmas.getFullYear();
    var invoice_id = obj.id;
    var invoiceId = pre+'/'+year+'/'+invoice_id;
    return invoiceId;
}


