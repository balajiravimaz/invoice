<?php
require_once "inc/header.php";
if (isset($_SESSION['email'])) {
?>
    <div class="container mt-4">
        <!-- <table class="table">
            <thead>
                <th>S.no</th>
                <th>Name</th>
                <th>Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table> -->
        <div class="d-flex justify-content-center align-items-center">
            <a href="invoice.php" class="btn btn-warning">Create Invoice</a>
        </div>
    </div>
<?php
    require_once "inc/footer.php";
} else {
    header("Location: index.php");
}
?>