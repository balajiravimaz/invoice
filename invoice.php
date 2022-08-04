<?php
require_once "inc/header.php";


if (isset($_SESSION['email'])) {
?>
    <div class="container mt-5 invoice">
        <!-- <div class="btn-grp mb-4">
            <a href="#" class="btn btn-sm btn-danger">Get Pdf</a>
            <a href="#" class="btn btn-sm btn-warning">Print</a>
            <a href="#" class="btn btn-sm btn-success">Save</a>
        </div> -->
        <div class="card p-4">
            <form action="invoice_add.php" method="POST">
                <div class="row gx-5">
                    <div class="col-md-7">
                        <div class="input-group">
                            <input type="text" placeholder="Your Company" name="cname" required="required">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="Company Address" name="caddress" required="required">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="City, State, Zipcode" name="city" required="required">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="Country" name="country" required="required">
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="input-group">
                            <input type="text" placeholder="Title Logo" class="logo" name="logo" required="required">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row gx-5 mt-3">

                    <div class="col-md-7">
                        <h4>Bill to:</h4>
                        <div class="input-group">
                            <input type="text" placeholder="Your Client Company" name="cc_name" required="required">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="Client Company Address" name="cc_address" required="required">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="City, State, Zipcode" name="cc_state" required="required">
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="Country" name="cc_country" required="required">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label for="invoiceno" class="col-sm-6 col-form-label">Invoice#</label>
                            <div class="col-sm-6">
                                <input type="text" id="invoiceno" placeholder="INV-12" name="invno" readonly required="required">
                            </div>
                        </div>
                        <div class="row">
                            <label for="invDate" class="col-sm-6 col-form-label">Invoice Date</label>
                            <div class="col-sm-6">
                                <input type="date" id="invDate" value="<?php echo date('Y-m-d') ?>" name="invDate">
                            </div>
                        </div>
                        <div class="row">
                            <label for="dueDate" class="col-sm-6 col-form-label">Due Date</label>
                            <div class="col-sm-6">
                                <input type="date" id="dueDate" value="<?php echo date('Y-m-d') ?>" name="dueDate">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="items">

                    <table class="table" id="invoice">
                        <thead class="bg-secondary">
                            <tr>
                                <th><input type="text" value="Item Description" readonly></th>
                                <th><input type="text" value="Qty" readonly></th>
                                <th><input type="text" value="Amount" readonly></th>
                                <th><input type="text" value="Rate" readonly></th>
                            </tr>
                        </thead>
                        <tbody class="tbdy">

                            <tr style="border-bottom: 1px solid #ddd;">
                                <td>
                                    <textarea placeholder="Enter items name" name="item[]" required="required"></textarea>
                                </td>
                                <td>
                                    <input type="number" placeholder="qty" name="qty[]" class="qty" value="1" required="required">
                                </td>
                                <td>
                                    <input type="number" placeholder="Amount" name="amt[]" class="amt" required="required">
                                </td>
                                <td align="center">
                                    <input type="text" readonly class="rate" name="rate[]" value="0.00">
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="newitem">
                                        <a href="" id="add"><span class="plus">&plus;</span> Add new item</a>
                                    </div>
                                </td>
                                <td align="right" colspan="2">
                                    <b>Sub Total</b>
                                </td>
                                <td align="right">
                                    <input type="text" readonly value="00.00" id="sub_total" name="sub">
                                </td>
                            </tr>
                            <tr>
                                <td align="right" colspan="3">
                                    <div class="d-flex justify-content-end">
                                        <b>CGST(%) + IGST(%)</b>
                                        <input type="number" name="gst" required="required" value="" id="tax_in" style="width: 40px;border: 1px dotted #333" ;>
                                    </div>
                                </td>
                                <td align="right">
                                    <input type="text" readonly id="tax" value="00.00" name="gstamount">
                                </td>
                            </tr>
                            <tr class="total">
                                <td colspan="3" align="right">
                                    <p><b>Total</b></p>
                                </td>
                                <td align="right" style="background: #efefef;">
                                    <input type="text" readonly id="tot" name="total" value="00.00">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="mb-0"><b>Notes:</b></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <textarea cols="30" rows="10" name="notes" placeholder="It was great doing business with you." style="width: 100%;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="mb-0">Terms and Conditions</p>
                                </td>
                            </tr>
                            <tr>
                                Please make the payment by the due date.
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-end mt-4">
                        <input type="submit" class="btn btn-md btn-success" value="save" name="save" style="width: 200px;">                        
                    </div>
            </form>

        </div>
    </div>
    </div>
<?php
    require_once "inc/footer.php";
} else {
    header("Location: index.php");
}
?>