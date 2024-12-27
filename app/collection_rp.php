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

    $user_id = $_SESSION['SESS_MEMBER_ID'];
    $date = date('Y-m-d');

    $result = $db->prepare("SELECT * FROM user WHERE id = '$user_id' ");
    $result->bindParam(':id', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $pos = $row['position'];
    }

    if ($pos == 'admin') {
        $sql1 = "SELECT sum(amount) FROM payment WHERE  pay_type = 'cash' AND date ='$date' ";
        $sql2 = "SELECT sum(amount) FROM expenses_records WHERE  pay_type = 'cash' AND date ='$date' ";
    } else {
        $sql1 = "SELECT sum(amount) FROM payment WHERE user_id = '$user_id' AND pay_type = 'cash' AND date = '$date' ";
        $sql2 = "SELECT sum(amount) FROM expenses_records WHERE user = '$user_id' AND pay_type = 'cash' AND date = '$date' ";
    }

    $result = $db->prepare($sql1);
    $result->bindParam(':id', $user_id);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $collection = $row['sum(amount)'];
    }

    $result = $db->prepare($sql2);
    $result->bindParam(':id', $user_id);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $expenses = $row['sum(amount)'];
    }

    ?>
</head>

<body class="bg-light customer">

    <div class="container-fluid container-md mt-4">
        <div class="box px-2 mb-0 mt-3 ">
            <div class="box-header px-0 mb-0">
                <a class="nav-link border-0 btn fs-1 d-md-none" aria-current="page" href="report.php"><i class="fa-solid fa-chevron-left fa-fw"></i></a>
                <a class="nav-link border-0 btn fs-1 d-md-none" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i></a>
                <a class="nav-link btn border-0 bg-theme px-3 fs-4 py-2 d-none d-md-block" aria-current="page" href="report.php"><i class="fa-solid fa-chevron-left fa-fw me-2"></i></i>Back</a>
                <a class="nav-link btn border-0 bg-theme px-3 fs-4 py-2 d-none d-md-block" aria-current="page" href="index.php"><i class="fa-solid fa-house me-2"></i>Home</a>
            </div>
        </div>
    </div>

    <div class="container my-3">
        <div class="box room-container">
            <div class="box-body room " style="padding: 30px 10px;">
                <div class="logo flex">
                    <h1>Collection</h1>
                </div>

                <p>Today all collections</p>

                <h2>Collection: <small>Rs.</small> <?php echo number_format($collection, 2); ?> </h2>
                <h2>Expenses: <small>Rs.</small> <?php echo number_format($expenses, 2); ?> </h2>
                <h2 style="font-size: 40px;">Rs.<?php echo number_format($collection - $expenses, 2); ?></h2>

            </div>
        </div>
    </div>

    <?php if ($pos == 'admin') { ?>
        <div class="container room-container">
            <div class="row" id="room-box">
                <?php $expenses = 0;
                $collection = 0;
                $result = $db->prepare("SELECT * FROM payment  JOIN user ON user.id = payment.user_id WHERE payment.pay_type = 'cash' AND  payment.date = '$date' GROUP BY payment.user_id ");
                $result->bindParam(':id', $user_id);
                $result->execute();
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $user = $row['user_id'];
                    $user_name = $row['name'];

                    $re = $db->prepare("SELECT sum(amount) FROM expenses_records WHERE user = '$user' AND pay_type = 'cash' AND date = '$date' ");
                    $re->bindParam(':id', $user_id);
                    $re->execute();
                    for ($i = 0; $r = $re->fetch(); $i++) {
                        $expenses = $r['sum(amount)'];
                    }

                    $re = $db->prepare("SELECT sum(amount) FROM payment WHERE user_id = '$user' AND pay_type = 'cash' AND date = '$date' ");
                    $re->bindParam(':id', $user_id);
                    $re->execute();
                    for ($i = 0; $r = $re->fetch(); $i++) {
                        $collection = $r['sum(amount)'];
                    }
                ?>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                        <div class="ajk_ady ">
                            <div class="info-box" style="border: 2px solid rgb(var(--bg-theme));">
                                <div class="row w-100">
                                    <div class="col-12 mb-3">
                                        <div class="sl_nad"><i class="fa-solid fa-user mx-3"></i><?php echo $user_name; ?></div>
                                    </div>
                                    <div class="col-12">
                                        <div class="sjk_sk">Collection: <small>Rs.</small> <?php echo number_format($collection, 2); ?> </div>
                                        <div class="sjk_sk">Expenses: <small>Rs.</small> <?php echo number_format($expenses, 2); ?> </div>
                                        <div class="sjk_sk sm">Balance: <small>Rs.</small> <?php echo number_format($collection - $expenses, 2); ?> </div>
                                    </div>
                                    <a href="collection_user_rp.php?id=<?php echo $user_id; ?>" class="btn" style="background: rgba(var(--bg-dark), 0.1);">
                                        <span style="color: rgb(var(--bg-theme));font-weight: 600;">View More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <!-- Bootstrap 5.3.2-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <!-- Jquery 3.7.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Date Picker -->
    <script src="js/datepik.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../../../plugins/morris/morris.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../../../plugins/chartjs/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../plugins/sparkline/jquery.sparkline.min.js"></script>

    <script>

    </script>
</body>

</html>