<?php
require_once "inc/header.php";
if (isset($_SESSION['email'])) {
    require_once "class/Database.php";

    $db = new Database();
    $email = $_SESSION['email'];
    $db->query("select id from users where email =  '$email' ");
    $user = $db->resultset();
    $user_id = $user[0]['id'];

    $db->query("SELECT * from address where user_id = :id");
    $db->bind(":id", $user_id);
    $result = $db->resultset();
?>
    <div class="container md-table mt-4">

        <?php if (!empty($result)) : ?>
            <table class="table table-bordered ">
                <thead class="bg-dark">
                    <th class="text-white text-center" >S.no</th>
                    <th class="text-white text-center" >Invoice No</th>
                    <th class="text-white text-center" >Date</th>
                    <th class="text-white text-center" >Due Date</th>
                    <th class="text-white text-center" >Action</th>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($result as $data) : ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $data['invoice_id']; ?></td>
                            <td><?php echo $data['invoice_date']; ?></td>
                            <td><?php echo $data['due_date']; ?></td>
                            <td>
                                <a href="print.php?id=<?php echo $data['invoice_id'] ?>" target="_blank" class="btn btn-sm btn-success">Save</a>
                                <a href="edit.php?id=<?php echo $data['invoice_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $data['invoice_id'] ?>" class="btn btn-sm btn-danger">Delete</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="d-flex justify-content-center align-items-center">
                <a href="invoice.php" class="btn btn-warning">Create Invoice</a>
            </div>
        <?php endif; ?>
    </div>
<?php
    require_once "inc/footer.php";
} else {
    header("Location: index.php");
}
?>