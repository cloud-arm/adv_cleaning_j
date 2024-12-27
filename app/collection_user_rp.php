<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLOUD ARM</title>

    <?php
    include("head.php");
    include("../connect.php");
    date_default_timezone_set("Asia/Colombo");

    $user = $_GET['id'];
    $date = date('Y-m-d');

    $result = $db->prepare("SELECT * FROM user WHERE id = '$user' ");
    $result->bindParam(':id', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $name = $row['name'];
    }

    $sql1 = "SELECT sum(amount) FROM payment WHERE user_id = '$user' AND pay_type = 'cash' AND date = '$date' ";
    $sql2 = "SELECT sum(amount) FROM expenses_records WHERE user = '$user' AND pay_type = 'cash' AND date = '$date' ";

    $result = $db->prepare($sql1);
    $result->bindParam(':id', $user);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $collection = $row['sum(amount)'];
    }

    $result = $db->prepare($sql2);
    $result->bindParam(':id', $user);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $expenses = $row['sum(amount)'];
    }
    ?>

</head>

<body class="bg-light customer" style="overflow-y: scroll;">

    <div class="container-fluid container-md mt-4">
        <div class="box px-2 mb-0 mt-3 ">
            <div class="box-header px-0 mb-0">
                <a class="nav-link border-0 btn fs-1 d-md-none" aria-current="page" href="collection_rp.php"><i class="fa-solid fa-chevron-left fa-fw"></i></a>
                <a class="nav-link border-0 btn fs-1 d-md-none" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i></a>
                <a class="nav-link btn border-0 bg-theme px-3 fs-4 py-2 d-none d-md-block" aria-current="page" href="collection_rp.php"><i class="fa-solid fa-chevron-left fa-fw me-2"></i></i>Back</a>
                <a class="nav-link btn border-0 bg-theme px-3 fs-4 py-2 d-none d-md-block" aria-current="page" href="index.php"><i class="fa-solid fa-house me-2"></i>Home</a>
            </div>
        </div>
    </div>

    <div class="container flex my-3">
        <div class="box room-container pt-0" style=" min-width: 100%;">
            <div class="box-body room mt-0 " style="padding: 30px 10px;">
                <div class="logo flex">
                    <h1><?php echo $name; ?></h1>
                </div>

                <p>Employee collection details </p>
                <?php if ($expenses > 0) { ?>
                    <h2 class="mt-3">Expenses</span></h2>
                    <table class="w-100 tbl-assign">
                        <?php
                        $result = $db->prepare("SELECT * FROM expenses_records WHERE user = '$user' AND pay_type = 'cash' AND date = '$date' ");
                        $result->bindParam(':id', $res);
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) { ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><?php echo $row['comment']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>

                <?php if ($collection > 0) { ?>
                    <h2 class="mt-3">Collection</span></h2>
                    <table class="w-100 tbl-assign">
                        <?php
                        $result = $db->prepare("SELECT *,payment.time AS sn FROM payment JOIN sales ON payment.invoice_no = sales.invoice_number WHERE payment.user_id = '$user' AND payment.pay_type = 'cash' AND payment.date = '$date' ");
                        $result->bindParam(':id', $res);
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) { ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['sn']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.2-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <!-- Jquery 3.7.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</body>

</html>