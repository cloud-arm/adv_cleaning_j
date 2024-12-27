<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$unit = $_GET['unit'];

if ($unit == 1) {
    $type = $_GET['type'] . '_pay';  ?>
    <option> </option>
    <?php
    $result = $db->prepare("SELECT * FROM hr_payroll WHERE $type = '0'  GROUP BY date ORDER BY date ASC ");
    $result->bindParam(':userid', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) { ?>
        <option> <?php echo $month = $row['date']; ?> </option>
<?php  }
}


if ($unit == 2) {
    $type = $_GET['type'];
    $month = $_GET['month'];

    $result = $db->prepare("SELECT sum($type) FROM hr_payroll WHERE date = '$month'");
    $result->bindParam(':userid', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $hr_blc = $row['sum(' . $type . ')'];
    }

    echo number_format($hr_blc, 2);
}

if ($unit == 3) {
    $type = $_GET['type'];
    $month = $_GET['month'];

    $result = $db->prepare("SELECT sum($type) FROM hr_payroll WHERE date = '$month'");
    $result->bindParam(':userid', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $hr_blc = $row['sum(' . $type . ')'];
    }

    echo number_format($hr_blc / 8 * 12, 2);
}

if ($unit == 4) {
    $type = $_GET['type'];
    $month = $_GET['month'];

    $result = $db->prepare("SELECT sum($type) FROM hr_payroll WHERE date = '$month'");
    $result->bindParam(':userid', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $hr_blc = $row['sum(' . $type . ')'];
    }

    echo number_format($hr_blc += $hr_blc / 8 * 12, 2);
}
