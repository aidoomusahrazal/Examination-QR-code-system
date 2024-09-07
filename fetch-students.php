
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title> ERVQRS Admin Manage Students</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
          <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
   <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
<?php include('includes/leftbar.php');?>  

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Fetch Student info</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Students</li>
            							<li class="active">Student QR code Form</li>
            						</ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                             

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>View Students Info</h5>
                                                </div>
                                            </div>



                                            <?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $studentId = $_POST['student_id'];

        // Perform a database query to fetch the student details by ID
        $sql = "SELECT tblstudents.StudentName, tblstudents.RollId, tblstudents.RegDate, tblstudents.Status, tblclasses.ClassName, tblclasses.Section from tblstudents join tblclasses on tblclasses.id = tblstudents.ClassId WHERE tblstudents.StudentId = :studentId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentId', $studentId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if ($result) {
            $studentName = htmlentities($result->StudentName);
            $rollId = htmlentities($result->RollId);
            $className = htmlentities($result->ClassName) . ' (' . htmlentities($result->Section) . ')';
            $regDate = htmlentities($result->RegDate);
            $status = ($result->Status == 1) ? 'Active' : 'Blocked';
        } else {
            $error = "Student not found.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
</head>
<body>

<div class="container">
        <h2>Fetch Student Details by System ID</h2>
        <form method="post">
            <div class="form-group">
                <label for="student_id">Enter System ID:</label>
                <input type="text" name="student_id" id="student_id" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Fetch Details</button>
        </form>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo htmlentities($error); ?></div>
        <?php } ?>

        <?php if (isset($studentName)) { ?>
    <div id="student-data">
        <h3>Student Details:</h3>
        <p><strong>Student Name:</strong> <?php echo $studentName; ?></p>
        <p><strong>System ID:</strong> <?php echo $rollId; ?></p>
        <p><strong>Course & Class:</strong> <?php echo $className; ?></p>
        <p><strong>Registration Date:</strong> <?php echo $regDate; ?></p>
        <p><strong>Status:</strong> <?php echo $status; ?></p>
    </div>
    <br>
<?php } ?>


        
    </div>
 
    <style>
    #student-data {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
    }

    #student-data h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    #student-data p {
        margin: 5px 0;
    }

    #student-data strong {
        font-weight: bold;
    }

    /* Style to display each data point on a separate line */
    .student-info {
        display: block;
        margin-bottom: 5px;
    }
</style>

    <div id="qrcode-container" class="container">
    <!-- QR code will be displayed here -->
</div>
<!-- Include the QRCode.js library -->
<script src="qrcodejs-master/qrcode.min.js"></script>
<!-- JavaScript code for generating the QR code -->
<script>
    // JavaScript code for printing the QR code when the button is clicked
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (isset($studentName)) { ?>
            var studentData = {
                "Student Name": "<?php echo $studentName; ?>",
                "System ID": "<?php echo $rollId; ?>",
                "Course & Class": "<?php echo $className; ?>",
                "Registration Date": "<?php echo $regDate; ?>",
                "Status": "<?php echo $status; ?>"
            };

            // Create a formatted data string with line breaks
            var formattedData = Object.keys(studentData).map(function (key) {
                return key + ": " + studentData[key];
            }).join("\n");

            // Create a QRCode instance and generate the QR code
            var qrcode = new QRCode(document.getElementById("qrcode-container"), {
                text: formattedData,
                width: 188,
                height: 188,
            });

            // Add an event listener to the "Print QR Code" button
            document.getElementById("print-qrcode-button").addEventListener("click", function () {
                // Create a new window for printing
                var printWindow = window.open('', '', 'width=800,height=800');
                printWindow.document.open();
                printWindow.document.write('<html><head><title>Eamination Card for Computer Science</title></head><body>')
                printWindow.document.write('<img src="' + qrcode._el.lastChild.src + '" style="max-width:100%;">');
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // Give some time for the image to load
                setTimeout(function () {
                    // Trigger the print dialog
                    printWindow.print();

                    // Close the print window after printing
                    printWindow.close();
                }, 1000); // Adjust the delay (in milliseconds) as needed
            });
        <?php } ?>
    });
</script>
<br><br>
<div id="qrcode-container" class="container">
    <!-- QR code will be displayed here -->
    <button id="print-qrcode-button" class="btn btn-primary">Print QR Code</button>
</div>







</body>
</html>


<?php } ?>


                                                                                                    
                                                    </tbody>
                                                </table>

                                         
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->

                                                               
                                                </div>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                    

                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->



        

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>
        <script src="/qrcodejs-masterqrcode.min.js"></script>
        <!-- ========== THEME JS ========== -->
        

        
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>
    </body>
</html>
<?php } ?>



