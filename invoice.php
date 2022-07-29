<?php
require_once "inc/header.php";
if (isset($_SESSION['email'])) { ?>
    <div class="container mt-5 invoice">
        <div class="card p-4">
            <div class="row gx-5">
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" placeholder="Your Company">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="Company Address">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="City, State, Zipcode">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="Country">
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="input-group">
                        <input type="text" placeholder="Title Logo" class="logo">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row gx-5 mt-3">

                <div class="col-md-7">
                    <h4>Bill to:</h4>
                    <div class="input-group">
                        <input type="text" placeholder="Your Client Company">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="Client Company Address">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="City, State, Zipcode">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="Country">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <label for="invoiceno" class="col-sm-6 col-form-label">Invoice#</label>
                        <div class="col-sm-6">
                            <input type="text" id="invoiceno" placeholder="INV-12">
                        </div>
                    </div>
                    <div class="row">
                        <label for="invDate" class="col-sm-6 col-form-label">Invoice Date</label>
                        <div class="col-sm-6">
                            <input type="date" id="invDate" value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="row">
                        <label for="dueDate" class="col-sm-6 col-form-label">Due Date</label>
                        <div class="col-sm-6">
                            <input type="date" id="dueDate" value="<?php echo date('Y-m-d') ?>">
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
                                <textarea placeholder="Enter items name"></textarea>
                            </td>
                            <td>
                                <input type="number" placeholder="qty" name="" class="qty" value="1">
                            </td>
                            <td>
                                <input type="number" placeholder="Amount" name="" class="amt">
                            </td>
                            <td align="center">
                                <span class="rate">0.00</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td>
                                <textarea placeholder="Enter items name"></textarea>
                            </td>
                            <td>
                                <input type="number" placeholder="qty" name="" class="qty" value="1">
                            </td>
                            <td>
                                <input type="number" placeholder="Amount" name="" class="amt">
                            </td>
                            <td align="center">
                                <span class="rate">0.00</span>
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
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
    require_once "inc/footer.php";
} else {
    header("Location: index.php");
}
?>