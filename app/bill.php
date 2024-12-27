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
    ?>
</head>

<body class="bg-light">

    <div class="container-fluid container-md mt-4">
        <div class="box px-2 mb-0 mt-3 ">
            <div class="box-header px-0 mb-0">
                <a class="nav-link border-0 btn fs-1 d-md-none" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i></a>
                <a class="nav-link btn border-0 bg-theme px-3 fs-4 py-2 d-none d-md-block" aria-current="page" href="index.php"><i class="fa-solid fa-house me-2"></i>Home</a>
            </div>
        </div>
    </div>

    <div class="container my-3">
        <div class="box room-container">
            <div class="box-body room " style="padding: 30px 10px;">
                <div class="logo flex">
                    <h1>Invoice</h1>
                </div>

                <p>Liyathra Salon</p>

                <table class="w-100 mb-2">
                    <thead>
                        <tr style="text-align: center;">
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tot = 0;
                        $result = $db->prepare('SELECT * FROM sales_list WHERE  invoice_no=:id ');
                        $result->bindParam(':id', $_GET['id']);
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {  ?>
                            <tr style="text-align: center;">
                                <td><?php echo $row['name']  ?></td>
                                <td><?php echo $row['qty']  ?></td>
                                <td><?php echo $row['amount']  ?></td>
                            </tr>
                        <?php $tot += $row['amount'];
                        } ?>
                    </tbody>
                </table>
                <h2 style="font-size: 40px;color: rgb(var(--bg-theme));">Rs.<?php echo number_format($tot, 2); ?></h2>

            </div>
        </div>
    </div>

    <div class="container-fluid my-4 flex">
        <a href="index.php" class="cate-info active" style="width: 90%;justify-content: center;font-size: 25px; color: rgb(var(--bg-white)); font-weight: 600;">Home</a>
    </div>


    <!-- Bootstrap 5.3.2-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


</body>

</html>