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

    $id = $_GET['id'];

    ?>

</head>

<body class="bg-light customer">

    <div class="container flex mb-3">
        <div class="box room-container" style=" min-width: 100%;">
            <div class="box-body room " style="padding: 30px 10px; ">
                <div class="logo flex">
                    <h1>Attendance</h1>
                </div>

                <p>Employee attendance checking</p>

                <h2></h2>

                <form action="attendance_save.php" method="POST" style="width: 100%;">
                    <div class="form-group" style="margin-top: 50px;">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" class="form-input" value="Checking">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Bootstrap 5.3.2-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <!-- Jquery 3.7.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Date picker -->

</body>

</html>