<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERVQRS Admin - View Students</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <!-- Include any other necessary CSS files -->
</head>
<body>
    <div class="container">
        <h2>View Students</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Course & Class</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT tblstudents.StudentName, tblstudents.RollId, tblstudents.RegDate, tblstudents.StudentId, tblstudents.Status, tblclasses.ClassName, tblclasses.Section FROM tblstudents JOIN tblclasses ON tblclasses.id = tblstudents.ClassId";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;

                foreach ($results as $result) {
                    ?>
                    <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td><?php echo htmlentities($result->StudentName); ?></td>
                        <td><?php echo htmlentities($result->RollId); ?></td>
                        <td><?php echo htmlentities($result->ClassName) . '(' . htmlentities($result->Section) . ')'; ?></td>
                        <td><?php echo htmlentities($result->RegDate); ?></td>
                        <td><?php echo ($result->Status == 1) ? 'Active' : 'Blocked'; ?></td>
                    </tr>
                    <?php
                    $cnt = $cnt + 1;
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Include necessary JavaScript files here -->
    <script src="js/jquery.min.js"></script>
<script src="js/datatables.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
<?php } ?>
