<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view'); ?>
            <div class="site-content">
                <!-- Content -->
                <div class="content-area pb-1">
                    <div class="profile-header mb-1">
                        <div class="profile-header-counters clearfix">
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="card profile-card">
                                    <div class="profile-avatar">
                                        <div>
                                            <form method="post" id="photo-frm" enctype="multipart/form-data">
                                                <div class="card-block groupinfo">
                                                    <span class="loader pull-left"></span>
                                                    <a href="#" id="upload-photo">Edit Photo</a>
                                                    <input type="file" name="student_photo" id="fileupload" style="display:none;">
                                                </div> 
                                                <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                                                <input type="hidden" name="id_proof_id" value="<?php echo $student->payload->student->id_proof_id; ?>">
                                            </form>
                                        </div>
                                        <img height="200" id="photo-img" src="<?php echo $student->payload->student->photo_url; ?>" alt="">
                                    </div>
                                    <div class="profile-avatar">
                                        <div>
                                            <form method="post" id="documents-frm" enctype="multipart/form-data">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                <div class="card-block">
                                                    <span class="loader pull-left"></span>
                                                    <a href="#" id="document-a">Edit Id Proof</a>
                                                    <input type="file" name="id_proof" id="id-proof" style="display:none;">
                                                </div> 
                                                <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                                                <input type="hidden" name="photo_id" value="<?php echo $student->payload->student->photo_id; ?>">
                                            </form>
                                        </div>
                                        <img height="200" id="document-img" src="<?php echo $student->payload->student->id_proof_url; ?>" alt="">
                                    </div>
                                    <div class="card-block">
                                        <h4><?php echo $student->payload->student->fname; ?> <span title="edit" class="edit-profile" style="cursor: pointer; float: right; font-size: 14px; color:#aaa; padding:4px 0 0 0;"><i class="ti-pencil"></i></span></h4>
                                        <h5 class="mb-0-25"><span class="batch-name-head" title="batch name" id="batch_code_p"><?php echo $student->payload->student->batch_code; ?></span> | <span class="batch-code-head" title="batch code" id="batch_start_date_p"><?php echo $student->payload->student->batch_start_date; ?></span></h5>
                                        <div id="batch_course_name_p" ><b><?php echo $student->payload->student->course_name; ?></b></div>
                                        <div><b><?php echo getRegNo($student->payload->student); ?></b></div>
                                        <label id="admission" class="btn <?php echo($student->payload->student->seat_confirmed == 1) ? 'btn-success' : 'btn-danger'; ?> btn-sm label-left b-a-0 waves-effect waves-light mb-0-5" style="cursor: default;">
                                            <span class="btn-label"><i id="admission_i" class="ti-<?php echo($student->payload->student->seat_confirmed == 1) ? 'check' : 'close'; ?>"></i></span>
                                            <span id="admission_text"><?php
                                                if ($student->payload->student->seat_confirmed == 1) {
                                                    echo 'Seat Confirmed';
                                                } elseif ($student->payload->student->seat_confirmed == 2) {
                                                    echo 'Seat Refunded';
                                                } else {
                                                    echo 'Seat Unconfirmed';
                                                }
                                                ?></span>
                                        </label>
                                    </div> 
                                </div>
                                <div class="card">
                                    <div class="card-header text-uppercase"><b>Fee Summary</b></div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p class="fee-payable"><strong>Fee Payable</strong></p>
                                                <p class="fee-paid"><strong>Fee Paid</strong></p>
                                                <p class="fee-pending"><strong>Fee Pending</strong></p>
                                                <?php if ($student->payload->student->discount) { ?><p class="fee-discount"><strong>Discount</strong></p><?php } ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="fee-payable-val"><?php echo $fee_summary->fee_payable; ?></p>
                                                <p class="fee-paid-val"><?php echo $fee_summary->fee_paid; ?></p>
                                                <p class="fee-pending-val"><?php echo $fee_summary->fee_pending; ?></p>
                                                <?php if ($student->payload->student->discount) { ?><p class="fee-discount-val"><?php echo $student->payload->student->discount; ?></p><?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-uppercase"><b>Action</b></div>
                                    <div class="card-block">
                                        <div style="margin-bottom: 8px;">
                                            <?php if ($student->payload->student->seat_confirmed != 2) { ?>
                                                <div>
                                                    <a href="#" id="pay-fee" class="enable-admission">Pay Fee</a>
                                                </div>
                                            <?php } ?>

                                            <div>
                                                <a href="#" id="add-refund" class="enable-admission">Refund</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="box bg-white">
                                    <div class="card-header text-uppercase"><b>Student informations</b></div>
                                    <div class="card-block">
                                        <table width="100%"cellpadding='5' >
                                            <tr>
                                                <th width='20%'>Student Name</th>
                                                <td width='30%'><?php echo $student->payload->student->fname; ?></td>
                                                <th width='20%'>Father's Name</th>
                                                <td><?php echo $student->payload->student->fathers_name; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td><?php echo dateFromat($student->payload->student->dob); ?></td>
                                                <th>Father's Occupation</th>
                                                <td><?php echo $student->payload->student->fathers_occupation; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Law Faculty from where did/doing LLB</th>
                                                <td><?php echo $student->payload->student->law_school; ?></td>
                                                <th>Phone</th>
                                                <td><?php echo $student->payload->student->phone; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Year of Passing</th>
                                                <td><?php echo $student->payload->student->yop; ?></td>
                                                <th>Student Email</th>
                                                <td><?php echo $student->payload->student->email; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Referred By</th>
                                                <td><?php echo $student->payload->student->referred_by; ?></td>
                                                <th>Student Mobile</th>
                                                <td><?php echo $student->payload->student->mobile; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Leave Entitlement</th>
                                                <td><?php
                                                    echo ($student->payload->student->leave_from) ? $student->payload->student->leave_from : 'NA';
                                                    echo' - ';
                                                    echo ($student->payload->student->leave_to) ? $student->payload->student->leave_to : 'NA';
                                                    ?></td>
                                                <th>Temporary Address</th>
                                                <td><?php echo $student->payload->student->local_address; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Course Name</th>
                                                <td><?php echo $student->payload->student->course_name; ?></td>
                                                <th>Permanent Address</th>
                                                <td><?php echo $student->payload->student->permanant_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><button type="button" class="btn btn-primary pull-right edit-informations">Edit</button></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="box bg-white">
                                    <div class="card-header text-uppercase"><b>Fee Details</b></div>
                                    <br/>
                                    <div class="table-responsive pa-0-75">
                                        <table class="table table-striped table-bordered dataTable" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>Invoice No.</th>
                                                    <th>Amount Paid</th>
                                                    <th>Date of Payment</th>
                                                    <th>Mode of Payment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!$invoices->payload->invoices->status->error) {
                                                    foreach ($invoices->payload->invoices as $val) {
                                                        ?>
                                                        <tr id="r<?php echo $val->id; ?>">
                                                            <td><a href="<?php echo site_url('invoices/detail/' . $val->id . '/' . $val->student_created_at . '/' . $val->created_at); ?>"><?php echo $val->id; ?></a></td>
                                                            <!--td><a href="javascript:void(0);" onClick="getInvoice('<?php echo $val->id; ?>', '<?php echo $val->created_at; ?>');" ><?php echo $val->id; ?></a></td-->
                                                            <td><?php echo $val->payment_amount; ?></td>
                                                            <td><?php echo dateFromat($val->created_at); ?></td>
                                                            <td><?php echo getPaymentMode($val->payment_mode_id); ?></td>
                                                            <td>
                                                                <button type="button" data-id="<?php echo $val->id; ?>" class="btn btn-primary btn-sm edit-invoice">Edit</button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Debit Notes Modal-->
                <div class="modal fade" id="add-debit-notes-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Refund Fee</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <form method="post" id="frm" class="add-debit-notes-frm">
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-4"><div class="form-group">
                                                <label>Registration No.</label>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo getRegNo($student->payload->student); ?>">
                                                <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Payment Type</label>
                                                <div class="form-group">
                                                    <input type="text" disabled="disabled" value="Refund Fee" class="form-control">
                                                    <input type="hidden" name="payment_type_id" id="payment_type_id" value="3">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Payment Mode</label>

                                                <ul style="list-style-type: none;">
                                                    <li><label class="custom-control custom-radio">
                                                            <input id="debit-pay-mode-1" checked="checked" value="1" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cash</span>
                                                        </label></li>

                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="debit-pay-mode-2" value="2" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cheque</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="debit-pay-mode-3" name="payment_mode_id" value="3" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">DD</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="debit-pay-mode-4" name="payment_mode_id" value="4" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">NEFT</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="debit-pay-mode-5" name="payment_mode_id" value="5" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">IMPS</span>
                                                        </label>
                                                    </li>

                                                </ul>                                           
                                            </div>

                                        </div>
                                        <div class="col-sm-4">

                                            <div id="debit-check-frm" style="display: none;">
                                                <div class="form-group">
                                                    <label>Refrence No</label>
                                                    <input type="text" name="payment_bank_ref_number" id="debit-payment_bank_ref_number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>IFSC</label>
                                                    <div class="input-group">
                                                        <input type="text" name="payment_bank_ifsc" id="debit-payment_bank_ifsc" class="form-control">
                                                        <div class="input-group-addon debit-search-bank" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="payment_bank_name" id="debit-payment_bank_name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Branch Name</label>
                                                    <input type="text" name="payment_bank_branch_name" id="debit-payment_bank_branch_name" class="form-control">
                                                </div>
                                            </div></div>
                                        <div class="col-sm-4"><div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" required="" name="payment_amount" id="debit-payment_amount" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tution Fee</label>
                                                <input type="text" disabled="disabled" name="payment_tution_fee" id="debit-payment_tution_fee" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>CGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_cgst" id="debit-payment_cgst" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>SGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_sgst" id="debit-payment_sgst" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Remarks</label>
                                                <textarea name="remarks" id="remarks" placeholder="Remarks" class="form-control"></textarea>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <span class="pull-left loader"></span>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="sumit" class="btn btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="due_amount" id="edit-due_amount" value="<?php echo $fee_summary->fee_pending; ?>">
                            </form>
                        </div>
                    </div> 
                </div>        
                <!-- Pay Fee Modal-->
                <div class="modal fade" id="pay-fee-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Pay Fee</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <form method="post" id="frm" class="add-fee-frm">
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-sm-4"><div class="form-group">
                                                <label>Registration no.</label>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo getRegNo($student->payload->student); ?>">
                                                <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" disabled="disabled" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                                <input type="hidden" name="name" id="edit-student_name" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Payment Type</label>
                                                <select required="required" name="payment_type_id" id="payment_type_id" class="form-control">
                                                    <option value="">Please Select Payment Type</option>
                                                    <?php
                                                    if ($student->payload->student->seat_confirmed == 0) {
                                                        echo '<option value="1">Admission Fee</option>';
                                                    } else {
                                                        ?>
                                                        <option value="2">Installment Fee</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Payment Mode</label>

                                                <ul style="list-style-type: none;">
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="pay-mode-1" checked="checked" value="1" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cash</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="pay-mode-2" value="2" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cheque</span>
                                                        </label>
                                                    </li>

                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="pay-mode-3" name="payment_mode_id" value="3" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">DD</span>
                                                        </label>
                                                    </li>

                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="pay-mode-4" name="payment_mode_id" value="4" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">NEFT</span>
                                                        </label> 
                                                    </li>

                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="pay-mode-5" name="payment_mode_id" value="5" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">IMPS</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="pay-mode-6" name="payment_mode_id" value="6" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Online Payment Gateway</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                            <div id="check-frm" style="display: none;">
                                                <div class="form-group">
                                                    <label>Refrence No</label>
                                                    <input type="text" name="payment_bank_ref_number" id="payment_bank_ref_number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>IFSC</label>
                                                    <div class="input-group">
                                                        <input type="text" name="payment_bank_ifsc" id="payment_bank_ifsc" class="form-control">
                                                        <div class="input-group-addon search-bank" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="payment_bank_name" id="payment_bank_name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Branch Name</label>
                                                    <input type="text" name="payment_bank_branch_name" id="payment_bank_branch_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Amount Due : Rs. <?php echo $fee_summary->fee_pending; ?></label>
                                            </div>
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" required="" name="payment_amount" id="payment_amount" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tution Fee</label>
                                                <input type="text" disabled="disabled" name="payment_tution_fee" id="payment_tution_fee" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>CGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_cgst" id="payment_cgst" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>SGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_sgst" id="payment_sgst" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Next Due Date (mm/dd/yyyy)</label>
                                                <input type="text" required="required" class="form-control"  name="next_due_date" id="next_due_date"  placeholder="mm/dd/yyyy">
                                            </div></div>

                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <span class="pull-left loader"></span>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <input type="submit" id="pay-fee-dis" class="btn btn-primary" value="Fee Submit">
                                    </div>
                                </div>
                                <input type="hidden" name="due_amount" id="due_amount" value="<?php echo $fee_summary->fee_pending; ?>">
                            </form>
                        </div>
                    </div> 
                </div>
                <!-- Edit Pay Fee Modal-->
                <div class="modal fade" id="edit-pay-fee-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Edit Pay Fee</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <form method="post" id="frm" onsubmit="return false;" class="update-invoice">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Registration no.</label>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo getRegNo($student->payload->student); ?>">
                                                <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" disabled="disabled" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                                <input type="hidden" name="name" id="edit-student_name" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Payment Type</label>
                                                <select required="required" name="payment_type_id" id="edit-payment_type_id" class="form-control">
                                                    <option value="">Please Select Payment Type</option>
                                                    <option value="1">Admission Fee</option>
                                                    <option value="2">Installment Fee</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Payment Mode</label>
                                                <ul style="list-style-type: none;">
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-1" checked="checked" value="1" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cash</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-2" value="2" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cheque</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-3" name="payment_mode_id" value="3" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">DD</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-4" name="payment_mode_id" value="4" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">NEFT</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-5" name="payment_mode_id" value="5" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">IMPS</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-6" name="payment_mode_id" value="6" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Online Payment Gateway</span>
                                                        </label>
                                                    </li>
                                                </ul>             
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="edit-check-frm" style="display: none;">
                                                <div class="form-group">
                                                    <label>Refrence No</label>
                                                    <input type="text" name="payment_bank_ref_number" id="edit-payment_bank_ref_number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>IFSC</label>
                                                    <div class="input-group">
                                                        <input type="text" name="payment_bank_ifsc" id="edit-payment_bank_ifsc" class="form-control">
                                                        <div class="input-group-addon edit-search-bank" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="payment_bank_name" id="edit-payment_bank_name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Branch Name</label>
                                                    <input type="text" name="payment_bank_branch_name" id="edit-payment_bank_branch_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Amount Due : Rs. <?php echo $fee_summary->fee_pending; ?></label>
                                            </div>
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" required="" name="payment_amount" id="edit-payment_amount" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tution Fee</label>
                                                <input type="text" disabled="disabled" name="payment_tution_fee" id="edit-payment_tution_fee" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>CGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_cgst" id="edit-payment_cgst" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>SGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_sgst" id="edit-payment_sgst" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Next Due Date (mm/dd/yyyy)</label>
                                                <input type="text" class="form-control" name="next_due_date" id="edit-next_due_date"  placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <span class="pull-left loader"></span>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" id="edit-pay-fee-dis" class="btn btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="invoice_id" id="edit-invoice-id">
                                <input type="hidden" name="edit-due_amount" id="edit-due_amount" value="<?php echo $fee_summary->fee_pending; ?>">
                                <input type="hidden" name="currentAmount" id="currentAmount">
                            </form>
                        </div>
                    </div> 
                </div>
                <!-- Edit Batch -->
                <div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" id="edit-batch-frm">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="card-header text-uppercase"><b>Edit Batch</b></div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Registration no.</label>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->id; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Batch Start Date</label>
                                                <input type="text" id="edit-batch_start_date" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->batch_start_date; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->fname; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Batch code</label>
                                                <div class="input-group">
                                                    <input type="text" id="edit-batch_code" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->batch_code; ?>">
                                                    <div class="input-group-addon search-batch-code-informations" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Course Name</label>
                                                <input type="text" id="edit-copurse_name" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->course_name; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                            <input type="hidden" name="batch_id" id="edit-batch_id" value="<?php echo $student->payload->student->batch_id; ?>">
                        </form>
                    </div>
                </div>
                <!-- Edit informations -->
                <div class="modal fade" id="edit-informations-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" id="edit-student-frm">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="card-header text-uppercase"><b>Edit Information</b></div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Student Name</label>
                                                <input type="text" name="fname" id="edit-fname" required="required" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="text" required="required" class="form-control" value="<?php echo date('m/d/Y', strtotime($student->payload->student->dob)); ?>" name="dob" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                            </div>

                                            <div class="form-group">
                                                <label>Law Faculty from where did/doing LLB</label>
                                                <input type="text" name="law_school" id="law_school" required="required" value="<?php echo $student->payload->student->law_school; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Leave Entitlement</label>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label class="custom-control custom-radio">
                                                            <input id="leave-entitlement-1" <?php echo($this->session->userdata('admission')['leave-entitlement'] == 1) ? 'checked="checked"' : ''; ?> name="leave-entitlement" value="1" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Yes</span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input id="leave-entitlement-2" <?php echo($this->session->userdata('admission')['leave-entitlement'] == 0) ? 'checked="checked"' : ''; ?> name="leave-entitlement" value="0" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">No</span>
                                                        </label>
                                                    </div>
                                                    <div class="custom-control custom-radio" id="leaverange" <?php echo($this->session->userdata('admission')['leave-entitlement'] == 0) ? 'style="display:none;"' : ''; ?>>
                                                        <input type="text" style="width:100px;" name="leave_from" value="<?php echo(isset($this->session->userdata('admission')['leave_from'])) ? $this->session->userdata('admission')['leave_from'] : ''; ?>"  placeholder="Leave From"> To
                                                        <input type="text" style="width:100px;" name="leave_to" value="<?php echo(isset($this->session->userdata('admission')['leave_to'])) ? $this->session->userdata('admission')['leave_to'] : ''; ?>" placeholder="Leave To">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Year of Passing</label>
                                                <input type="text" name="yop" id="yop" value="<?php echo $student->payload->student->yop; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Referred By</label>
                                                <input type="text" name="referred_by" id="referred_by" value="<?php echo $student->payload->student->referred_by; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Discount</label>
                                                <input type="text" name="discount" id="discount" value="<?php echo $student->payload->student->discount; ?>" class="form-control">
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Father's Name</label>
                                                <input type="text" name="fathers_name" id="edit-fathers_name" required="required" value="<?php echo $student->payload->student->fathers_name; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Father's Occupation</label>
                                                <input type="text" name="fathers_occupation" id="edit-fathers_occupation" required="required" value="<?php echo $student->payload->student->fathers_occupation; ?>"  class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Student E-mail</label>
                                                <input type="email" name="email" id="edit-email" required="required" value="<?php echo $student->payload->student->email; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" maxlength="10" minlength="10" name="phone" name="phone" id="edit-phone" required="required" value="<?php echo $student->payload->student->phone; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Student Mobile</label>
                                                <input type="text" maxlength="10" minlength="10" name="mobile" id="edit-mobile" required="required" value="<?php echo $student->payload->student->mobile; ?>" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Temporary Address</label>
                                                <textarea class="form-control" name="local_address" id="edit-local_address" rows="3"> <?php echo $student->payload->student->permanant_address; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Permanent Address</label>
                                                <textarea class="form-control" name="permanant_address" id="edit-permanant_address" required="required" rows="3"><?php echo $student->payload->student->permanant_address; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <span class="pull-left loader"></span>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="edit-student_id" value="<?php echo $student->payload->student->id; ?>">
                            <input type="hidden" name="total_course_fee" id="edit-total_course_fee" value="<?php echo $student->payload->student->total_course_fee; ?>">
                            <input type="hidden" name="total_fee_paid" id="edit-total_fee_paid" value="<?php echo (int) $student->payload->student->total_fee_paid; ?>">
                            <input type="hidden" name="blance" id="edit-balance" value="<?php echo ((int) $student->payload->student->total_course_fee - (int) $student->payload->student->total_fee_paid); ?>">
                        </form>
                    </div>
                </div>
                <!-- Select Batch -->
                <div class="modal fade" id="batch-code-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Select batches</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <table class="table table-striped table-bordered dataTable" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Batch Id</th>
                                            <th>Course</th>
                                            <th>Batch Code</th>
                                            <th>Batch start date</th>
                                            <th>Fee</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($batches->payload->batches)) {
                                            foreach ($batches->payload->batches as $val) {
                                                ?>
                                                <tr id="r<?php echo $val->id; ?>">
                                                    <td><?php echo $val->id; ?></td>
                                                    <td><?php echo $val->course; ?></td>
                                                    <td><?php echo $val->batch_code; ?></td>
                                                    <td><?php echo dateFromat($val->batch_start_date); ?></td>
                                                    <td><?php echo $val->course_fee; ?></td>
                                                    <td><button type="button" class="btn btn-info btn-sm select select-batch">Select</button></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Select Bank Model -->
                <div class="modal fade" id="bank-detail-modal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Select Bank</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <table class="table table-striped table-bordered dataTable" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <th>Bank Name</th>
                                            <th>Branch Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Select Bank Model -->
                <div class="modal fade" id="edit-bank-detail-modal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Select Bank</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <table class="table table-striped table-bordered dataTable" id="table-0">
                                    <thead>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <th>Bank Name</th>
                                            <th>Branch Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row text-xs-center">
                            <div class="col-sm-4 text-sm-left mb-0-5 mb-sm-0">
                                2018 © Rahul's IAS
                            </div>
                            <div class="col-sm-8 text-sm-right">
                                <ul class="nav nav-inline l-h-2">
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Privacy</a></li>
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Terms</a></li>
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Help</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/students.js"></script>
        <script type="text/javascript">

                                function getInvoice(id, date) {
                                    alert(id);
                                    alert(date);
                                }
                                $(document).ready(function () {

                                    $('#add-refund').on('click', function () {
                                        $('#add-debit-notes-modal').modal('show');
                                    });

                                    $('#datepicker-autoclose').datepicker({
                                        autoclose: true,
                                        todayHighlight: true
                                    });

                                    // Upload Photo
                                    $('#upload-photo').on('click', function () {
                                        $('#fileupload').click();
                                    });
                                    $("#fileupload").change(function () {
                                        $('#photo-frm').submit();
                                    });
                                    // Upload Id Proof
                                    $('#document-a').on('click', function () {
                                        $('#id-proof').click();
                                    });
                                    $("#id-proof").change(function () {
                                        $('#documents-frm').submit();
                                    });
                                    $('#leave-entitlement-1').on('click', function () {
                                        $('#leaverange').show();
                                    });
                                    $('#leave-entitlement-2').on('click', function () {
                                        $('#datepicker-leave-from').val('');
                                        $('#datepicker-leave-to').val('');
                                        $('#leaverange').hide();
                                    });
                                    $(function () {
                                        // Save Photo
                                        $("#photo-frm").on("submit", function (event) {
                                            event.preventDefault();
                                            loaderProcess();
                                            $.ajax({
                                                url: site_url + 'students/editImage',
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
                                                    $("#photo-img").attr("src", obj.payload.upload.file_url);
                                                    loaderSuccess();
                                                }
                                            });
                                        });
                                        // Save Id Proof
                                        $("#documents-frm").on("submit", function (event) {
                                            event.preventDefault();
                                            loaderProcess();
                                            $.ajax({
                                                url: site_url + 'students/editImage',
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
                                                    $("#document-img").attr("src", obj.payload.upload.file_url);
                                                    loaderSuccess();
                                                }
                                            });
                                        });

                                        $("#addFrm").on("submit", function (event) {
                                            event.preventDefault();
                                            loaderProcess();
                                            $.ajax({
                                                url: site_url + 'admissions/saveDocuments',
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
                                                    window.location.replace(site_url + 'students/profile/' + obj.payload.admission.id);
                                                    loaderSuccess();
                                                }
                                            });
                                        });
                                    });

                                });
        </script>
    </body>
</html>