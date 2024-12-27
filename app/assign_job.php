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

    $id = $_SESSION['SESS_MEMBER_ID'];
    $date = date("Y-m-d");
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

    <div class="container-fluid mb-3">
        <div class="box">
            <div class="box-header">
                <h4 class="fs-4 m-0">Assign Job List</h4>
            </div>
        </div>
    </div>

    <div class="container room-container">
        <div class="row">
            <?php
            $date=date('Y-m-d');
            $uid=$_SESSION['SESS_MEMBER_ID'];
            $result = $db->prepare('SELECT * FROM user WHERE  id=:id ');
            $result->bindParam(':id', $uid);
            $result->execute();
            for($i=0; $row = $result->fetch(); $i++){ $emp_id=$row['emp_id']; }

            $sql = "SELECT * FROM sales_list JOIN job ON sales_list.invoice_no=job.invoice_no WHERE job.action='pending' AND job.app_date='$date' AND sales_list.emp='$emp_id'    ";
            $result = $db->prepare($sql);
            $result->bindParam(':userid', $date);
            $result->execute();

            for ($i = 0; $row = $result->fetch(); $i++) {
          
                //----------------------------------------------------//
            ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="ajk_ady ">
                        <div class="info-box" style="border: 2px solid rgb(var(--bg-theme));">
                            <div class="w-100">
                                <div class="as_jdk">
                                    <div class="i_n_b">
                                        <span class="head"><?php echo $row['name']; ?></span>
                                    </div>
                                    <div class="info-foot">
                                        <div class="anl">
                                            <span class="anl_hed"><i class="fa-solid fa-arrow-up-1-9 me-2"></i>Time : <span><?php echo $row['app_time'] ?></span></span>
                                            <a class="nav-link" style="align-self: end;" href="order.php?id=<?php echo $row['id'] ?>">
                                                <span class="bin btn">View</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>


    <!-- Bootstrap 5.3.2-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Jquery 3.7.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


</body>

</html>