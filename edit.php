<?php
require_once "inc/header.php";
require_once "class/Database.php";


if (isset($_SESSION['email'])) {
    if (isset($_GET['id'])) {
        $inv_id = $_GET['id'];

        $db = new Database();
        $db->query("SELECT * FROM `address` join billing on address.invoice_id = billing.invoice_id join total on billing.invoice_id = total.invoice_id join notes on total.invoice_id = notes.invoice_id where address.invoice_id = :invId ;");
        $db->bind(":invId",$inv_id);
        $address = $db->resultset();

        $db->query("SELECT * from items where invoice_id = :invId ");
        $db->bind(":invId", $inv_id);
        $items = $db->resultset();

?>
        <div class="container mt-5 invoice">
            <!-- <div class="btn-grp mb-4">
            <a href="#" class="btn btn-sm btn-danger">Get Pdf</a>
            <a href="#" class="btn btn-sm btn-warning">Print</a>
            <a href="#" class="btn btn-sm btn-success">Save</a>
        </div> -->
            <div class="card p-4">
                <form action="edit_add.php" method="POST">
                    <div class="row gx-5">
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="text" placeholder="Your Company" value="<?php echo $address[0]['name'] ?>" name="cname" required="required">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Company Address" value="<?php echo $address[0]['c_address'] ?>" name="caddress" required="required">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="City, State, Zipcode" name="city" value="<?php echo $address[0]['city'] ?>" required="required">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Country" name="country" value="<?php echo $address[0]['country'] ?>" required="required">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="input-group">
                                <input type="text" placeholder="Title Logo" class="logo" name="logo"value="<?php echo $address[0]['title'] ?>" required="required">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row gx-5 mt-3">

                        <div class="col-md-7">
                            <h4>Bill to:</h4>
                            <div class="input-group">
                                <input type="text" placeholder="Your Client Company" name="cc_name" value="<?php echo $address[0]['b_name'] ?>" required="required">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Client Company Address" name="cc_address" value="<?php echo $address[0]['b_address'] ?>" required="required">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="City, State, Zipcode" name="cc_state" value="<?php echo $address[0]['b_city'] ?>" required="required">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Country" name="cc_country" value="<?php echo $address[0]['b_country'] ?>" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- <div class="row">
                            <label for="invoiceno" class="col-sm-6 col-form-label">Invoice#</label>
                            <div class="col-sm-6">
                                <input type="text" id="invoiceno" placeholder="INV-12" name="invno" readonly required="required">
                            </div>
                        </div> -->
                            <div class="row">
                                <label for="invDate" class="col-sm-6 col-form-label">Invoice Date</label>
                                <div class="col-sm-6">
                                    <input type="date" id="invDate" value="<?php echo $address[0]['invoice_date'] ?>" name="invDate">
                                </div>
                            </div>
                            <div class="row">
                                <label for="dueDate" class="col-sm-6 col-form-label">Due Date</label>
                                <div class="col-sm-6">
                                    <input type="date" id="dueDate" value="<?php echo $address[0]['due_date'] ?>" name="dueDate">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="items">

                        <table class="table" id="invoice">
                            <thead class="bg-secondary">
                                <tr>
                                    <th class="text-white">Item Description</th>
                                    <th class="text-white">quantity</th>
                                    <th class="text-white">Amount</th>
                                    <th class="text-white">Rate</th>
                                </tr>
                            </thead>
                            <tbody class="tbdy">
                                <?php foreach($items as $item): ?>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td>
                                        <input type="hidden" value="<?php echo $item['id'] ?>" name="itemId[]">
                                        <textarea placeholder="Enter items name" name="item[]" required="required"><?php echo $item['item'] ?></textarea>
                                    </td>
                                    <td>
                                        <input type="number" placeholder="qty" name="qty[]" value="<?php echo $item['qty'] ?>" class="qty" value="1" required="required">
                                    </td>
                                    <td>
                                        <input type="number" placeholder="Amount" value="<?php echo $item['amount'] ?>" name="amt[]" class="amt" required="required">
                                    </td>
                                    <td align="center">
                                        <input type="text" readonly class="rate" value="<?php echo $item['rate'] ?>.00" name="rate[]" value="0.00">
                                    </td>
                                    <td><a class="close" data-id="<?php echo $item['id'] ?>">×</a></td>
                                </tr>
                                <?php endforeach; ?>
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
                                        <input type="text" readonly value="<?php echo $address[0]['sub_total'] ?>.00" id="sub_total" name="sub">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="3">
                                        <div class="d-flex justify-content-end">
                                            <b>CGST(%) + IGST(%)</b>
                                            <input type="number" name="gst" required="required" value="<?php echo $address[0]['gst'] ?>"  id="tax_in" style="width: 40px;border: 1px dotted #333" ;>
                                        </div>
                                    </td>
                                    <td align="right">
                                        <input type="text" readonly id="tax" value="<?php echo $address[0]['gst_amount'] ?>.00" name="gstamount">
                                    </td>
                                </tr>
                                <tr class="total">
                                    <td colspan="3" align="right">
                                        <p><b>Total</b></p>
                                    </td>
                                    <td align="right" style="background: #efefef;">
                                        <input type="text" readonly id="tot" name="total" value="<?php echo $address[0]['total'] ?>.00" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="mb-0"><b>Notes:</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <textarea cols="30" rows="10" name="notes" placeholder="It was great doing business with you." style="width: 100%;"><?php echo $address[0]['notes'] ?></textarea>
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
                            <input type="hidden" value="<?php echo $inv_id ?>" name="invid">
                            <input type="submit" class="btn btn-md btn-success" value="update" name="update" style="width: 200px;">
                        </div>
                </form>

            </div>
        </div>
        </div>
<?php
        require_once "inc/footer.php";
    }
} else {
    header("Location: index.php");
}
?>