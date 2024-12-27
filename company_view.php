<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'company';
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                COMPANY
                <small>View</small>
            </h1>
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-3">

                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <?php $id=$_GET['id'];
                            $result=select('company','*','id='.$id);
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $name=$row['name'];
                    $address=$row['address'];
                    $email=$row['email'];
                }
                ?>

                            <h3 class="profile-username text-center"><?php echo $name; ?></h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Address:</b> <i><?php echo $address; ?></i>
                                </li>

                                <li class="list-group-item">
                                    <b>Email:</b> <i><?php echo $email; ?></i>
                                </li>
                            </ul>

                            <a href="cus_view.php" class="btn btn-primary btn-block m-0"><b>Back</b></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.col (left) -->


                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#location" data-toggle="tab">Location</a></li>
                            <li><a href="#contact" data-toggle="tab">Contact Cards</a></li>
                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                            <li><a href="#shift" data-toggle="tab">shift</a></li>

                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="location">
                                <span onclick="click_open('add')" class="btn btn-primary btn-sm mx-2">Add New
                                    Location</span>
                                <div>
                                    <table id="location_table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Type</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $result = select('location', '*', 'company_id='.$id);
                                            for ($i = 0; $row = $result->fetch(); $i++) {
                                                $location_id = $row['id'];
                                                $company_id = $row['company_id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['type']; ?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-warning"
                                                        onclick="click_open('edit', <?php echo $location_id; ?>)">Edit</a>
                                                    <a class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete(<?php echo $location_id; ?>)">Delete</a>
                                                </td>
                                            </tr>

                                            <!-- Popup for editing each location -->
                                            <div class="container-up d-none"
                                                id="edit_popup_<?php echo $location_id; ?>">
                                                <div class="row w-70">
                                                    <div class="box box-success popup" style="width: 80%;">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Edit Location:
                                                                <?php echo $row['name']; ?></h3>
                                                            <small onclick="click_close(<?php echo $location_id; ?>)"
                                                                class="btn btn-sm btn-success pull-right">
                                                                <i class="fa fa-times"></i>
                                                            </small>
                                                        </div>
                                                        <div class="box-body">
                                                            <form method="POST" action="save/location_save.php">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="<?php echo $row['name']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Address</label>
                                                                            <input type="text" name="address"
                                                                                class="form-control"
                                                                                value="<?php echo $row['address']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Type</label>
                                                                            <input type="text" name="type"
                                                                                class="form-control"
                                                                                value="<?php echo $row['type']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Email</label>
                                                                            <input type="text" name="email"
                                                                                class="form-control"
                                                                                value="<?php echo $row['email']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $location_id; ?>">
                                                                    <input type="hidden" name="company_id"
                                                                        value="<?php echo $company_id; ?>">
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Save</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                                             <div class="active tab-pane" id="shift">
                                <span onclick="click_open('add')" class="btn btn-primary btn-sm mx-2">Add New
                                    shift</span>
                                <div>
                                    <table id="location_table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Type</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $result = select('gen_shift', '*', 'company_id='.$id);
                                            for ($i = 0; $row = $result->fetch(); $i++) {
                                                $location_id = $row['id'];
                                                $company_id = $row['company_id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['type']; ?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-warning"
                                                        onclick="click_open('edit', <?php echo $location_id; ?>)">Edit</a>
                                                    <a class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete(<?php echo $location_id; ?>)">Delete</a>
                                                </td>
                                            </tr>

                                            <!-- Popup for editing each location -->
                                            <div class="container-up d-none"
                                                id="edit_popup_<?php echo $location_id; ?>">
                                                <div class="row w-70">
                                                    <div class="box box-success popup" style="width: 80%;">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Edit Location:
                                                                <?php echo $row['name']; ?></h3>
                                                            <small onclick="click_close(<?php echo $location_id; ?>)"
                                                                class="btn btn-sm btn-success pull-right">
                                                                <i class="fa fa-times"></i>
                                                            </small>
                                                        </div>
                                                        <div class="box-body">
                                                            <form method="POST" action="save/location_save.php">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="<?php echo $row['name']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Address</label>
                                                                            <input type="text" name="address"
                                                                                class="form-control"
                                                                                value="<?php echo $row['address']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Type</label>
                                                                            <input type="text" name="type"
                                                                                class="form-control"
                                                                                value="<?php echo $row['type']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Email</label>
                                                                            <input type="text" name="email"
                                                                                class="form-control"
                                                                                value="<?php echo $row['email']; ?>"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $location_id; ?>">
                                                                    <input type="hidden" name="company_id"
                                                                        value="<?php echo $company_id; ?>">
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Save</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane" id="contact">
                                <span onclick="click_open(2)" class="btn btn-primary btn-sm mx-2">Add New Contact</span>
                                <div>
                                    <table id="contact_table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Contact No</th>
                                                <th>Location</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $result = select('contact','*','company_id='.$id); for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                            <tr>
                                                <th><?php echo $row['id']; ?></th>
                                                <th><?php echo $row['name']; ?></th>
                                                <th><?php echo $row['position']; ?></th>
                                                <th><?php echo $row['phone_no']; ?></th>
                                                <th><?php echo $row['location']; ?></th>
                                                <td>
                                                    <a class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="settings">
                                <form method="post" action="edit_company.php" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name"
                                                value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="address"
                                                value="<?php echo $address; ?>" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">E-mail</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="email"
                                                value="<?php echo $email; ?>" placeholder="E-mail">
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="unit" value="1">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to <a href="#">Submit</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.box-body -->
                <!-- /.box -->
                <!-- /.col (right) -->
                <!-- /.row -->
        </section>
        <!-- /.content -->










        <?php
    $add_con = 'd-none'; // Initially hide the container
   ?>
        <!-- Container for the popup -->
        <div class="container-up <?php echo $add_con; ?>" id="add_location_container">
            <div class="row w-70">
                <div class="box box-success popup d-none" id="add_location_popup" style="width: 80%;">
                    <div class="box-header with-border">
                        <h3 class="box-title">LOCATION SAVE</h3>
                        <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                            <i class="fa fa-times"></i>
                        </small>
                    </div>
                    <div class="box-body d-block">
                        <form method="POST" action="save/location_save.php">
                            <div class="row" style="display: block;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" id="com_name" class="form-control"
                                            autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" id="com_add" class="form-control"
                                            autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control select2 hidden-search" id="com_type" name="type"
                                            style="width: 100%;" required>
                                            <option value="branch">Branch</option>
                                            <option value="hed">Head Office</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control" id="com_email"
                                            autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="company_id" value="<?php echo $id; ?>">

                                        <input type="hidden" name="id" value="0">
                                        <input type="submit" id="com_save" style="margin-top: 23px; width: 100%;"
                                            value="Save" class="btn btn-info btn-sm pull-right">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php
    $add_con = 'd-none'; // Initially hide the container
   ?>
        <!-- Container for the popup -->
        <div class="container-up <?php echo $add_con; ?>" id="add_shift_container">
            <div class="row w-70">
                <div class="box box-success popup d-none" id="add_shift_popup" style="width: 80%;">
                    <div class="box-header with-border">
                        <h3 class="box-title">SHIFT SAVE</h3>
                        <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                            <i class="fa fa-times"></i>
                        </small>
                    </div>
                    <div class="box-body d-block">
                    <form action="save/shift_save.php" method="post">
                                    <div class="input-group input-group-sm">
                                        <select class="form-control select2" name="location_id[]" multiple="multiple"
                                            data-placeholder="Select Team" style="width: 100%;" autocomplete="off"
                                            required>
                                            <?php 
                                            $set_cat = 1;
                                            $result = select('employee'); 
                                            for ($i = 0; $row = $result->fetch(); $i++) { 
                                                $set_cat = 0; 
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['username'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="submit" id="u2" class="btn btn-info btn-flat">Save</button>
                                        </span>
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <input type="hidden" name="job_id" value="<?php echo $id ?>">
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>




        <div class="box box-success popup d-none" id="popup_2" style="width: 80%;">
            <div class="box-header with-border">
                <h3 class="box-title">CONTACT SAVE</h3>
                <small onclick="click_close(2)" class="btn btn-sm btn-success pull-right"><i
                        class="fa fa-times"></i></small>
            </div>

            <div class="box-body d-block">
                <form method="POST" action="save/contact_save.php">

                    <div class="row" style="display: block;">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Person Name</label>
                                <input type="text" name="name" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone No</label>
                                <input type="text" name="phone_no" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone No 2</label>
                                <input type="text" name="phone_no2" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Position</label>
                                <input type="text" name="position" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Location</label>
                                <select class="form-control select2 hidden-search" name="location_id"
                                    style="width: 100%;" required>
                                    <?php $result=select('location',"*","company_id=".$id);
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                         ?>

                                    <option value="<?php echo $row['id']  ?>"> <?php echo $row['name']  ?> </option>
                                    <?php } ?>


                                </select>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="company_id" value="<?php echo $id; ?>">
                                <input type="submit" style="margin-top: 23px; width: 100%;" value="Save"
                                    class="btn btn-info btn-sm pull-right">
                            </div>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- /.content-wrapper -->
    <?php
    include("dounbr.php");
    ?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <script>
    function click_open(type, id = null) {
        // Hide all popups initially
        document.querySelectorAll('.container-up').forEach(function(popup) {
            popup.classList.add('d-none');
        });

        // Open the Add New Location or Contact popup
        if (type === 'add') {
            document.getElementById('add_location_popup').classList.remove('d-none');
            document.getElementById('add_shift_popup').classList.remove('d-none');

            document.getElementById('add_location_container').classList.remove('d-none');
            document.getElementById('add_shift_container').classList.remove('d-none');

        }

        // Open the Add New Contact popup
        if (type === 2) {
            document.getElementById('popup_2').classList.remove('d-none');
            document.getElementById('add_contact_container').classList.remove('d-none');
        }

        // Open the Edit Location popup
        if (type === 'edit') {
            document.getElementById('edit_popup_' + id).classList.remove('d-none');
        }
    }

    function click_close(type) {
        if (type === 'add') {
            document.getElementById('add_location_popup').classList.add('d-none');
            document.getElementById('add_shift_popup').classList.add('d-none');

            document.getElementById('add_location_container').classList.add('d-none');
            document.getElementById('add_shift_container').classList.add('d-none');

        } else if (type === 2) {
            document.getElementById('popup_2').classList.add('d-none');
            document.getElementById('add_contact_container').classList.add('d-none');
        } else {
            document.getElementById('edit_popup_' + type).classList.add('d-none');
        }
    }
    </script>

    <script>
    function confirmDelete(location_id) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = "delete_location.php?id=" + location_id;
        }
    }
    </script>





</body>

</html>