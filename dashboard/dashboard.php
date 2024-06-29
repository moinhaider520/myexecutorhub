<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>
<body>
    <?php include_once "../utils/loader.php" ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php" ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php" ?>
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid default-dashboard">
                    <div class="row widget-grid">
                        <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Users List</h4>
                                            <span>List of all the created Users.</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive theme-scrollbar">
                                                <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                    <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                        aria-describedby="basic-1_info">
                                                        <thead>
                                                            <tr role="row">
                                                                <th>Sr</th>
                                                                <th>Full Name</th>
                                                                <th>Email</th>
                                                                <th>Address</th>
                                                                <th>Contact Number</th>
                                                                <th>Role</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <?php include_once "../utils/footer.php" ?>
        </div>
    </div>
    <?php include_once "../utils/scripts.php" ?>
</body>

</html>