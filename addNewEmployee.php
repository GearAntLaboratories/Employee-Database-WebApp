<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add New Employee</title>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css"> 
    </head>
    <body>

        <?php
// define variables and set to empty values
        $fnameErr = $lnameErr = $emailErr = $alErr = $unErr = $pwErr = $hdateErr = $cposErr = "";
        $fname = $lname = $email = $accessLevel = $hdate = $cpos = $un = $pw = "";
        $noErrors = true;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["fname"])) {
                $fnameErr = "First Name is required";
                $noErrors = false;
            } else {
                $fname = test_input($_POST["fname"]);
            }
            if (empty($_POST["lname"])) {
                $lnameErr = "Last Name is required";
                $noErrors = false;
            } else {
                $lname = test_input($_POST["lname"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
                $noErrors = false;
            } else {
                $email = test_input($_POST["email"]);
            }

            if (empty($_POST["un"])) {
                $unErr = "User Name is required";
                $noErrors = false;
            } else {
                $un = test_input($_POST["un"]);
            }

            if (empty($_POST["pw"])) {
                $pwErr = "Password is required";
                $noErrors = false;
            } else {
                $pw = test_input($_POST["pw"]);
            }

            if (empty($_POST["hdate"])) {
                $hdateErr = "Hire Date is required";
                $hdate = "";
            } else {
                $hdate = test_input($_POST["hdate"]);
            }

            if (empty($_POST["cpos"])) {
                $cposErr = "Job Title is required";
                $cpos = "";
            } else {
                $cpos = test_input($_POST["cpos"]);
            }

            if (empty($_POST["accessLevel"])) {
                $alErr = "Access Level is Required";
                $noErrors = false;
            } else {
                $accessLevel = test_input($_POST["accessLevel"]);
            }

            if ($noErrors) {

                if ($accessLevel == "User Access") {
                    $alInput = 0;
                } else {
                    $alInput = 1;
                }


                require_once("Includes/db.php");
                EmployeeDB::getInstance()->add_employee($fname, $lname, $email, $un, $pw, $hdate, $cpos, $alInput);
                header('Location: empSearch.php');
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>


        <div class="container">
            <div class="row"><br/><br/>
                <div class="col-md-6 col-md-offset-3">
                    <div class="well well-sm">
                        <form class="form-horizontal" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <fieldset>
                                <legend class="text-center">Add New Employee</legend>

                                <!-- First Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name">First Name</label>
                                    <div class="col-md-9">
                                        <input id="fname" name="fname" type="text" placeholder="First name" value="<?php echo $fname; ?>" class="form-control">
                                    </div>
                                </div>

                                <!-- Last Name input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="name">Last Name</label>
                                    <div class="col-md-9">
                                        <input id="lname" name="lname" type="text" placeholder="Last name" class="form-control">
                                    </div>
                                </div>

                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="email">Email</label>
                                    <div class="col-md-9">
                                        <input id="email" name="email" type="text" placeholder="Email" class="form-control">
                                    </div>
                                </div>

                                <!-- UN input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="un">Username</label>
                                    <div class="col-md-9">
                                        <input id="un" name="un" type="text" placeholder="Username" class="form-control">
                                    </div>
                                </div>

                                <!-- PW input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="pw">Password</label>
                                    <div class="col-md-9">
                                        <input id="pw" name="pw" type="password" placeholder="Password" class="form-control">
                                    </div>
                                </div>

                                <!-- position input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="cpos">Job Title</label>
                                    <div class="col-md-9">
                                        <input id="cpos" name="cpos" type="text" placeholder="Job Title" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="status" class="col-sm-3 control-label">Access Level</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="accessLevel" name="accessLevel">
                                            <option>User Access</option>
                                            <option>Administrative Access</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hdate" class="col-sm-3 control-label">Hire Date</label>
                                    <div class="col-md-9">
                                        <input id="hdate" name="hdate" type="text" placeholder="YYYY-MM-DD" class="form-control">
                                    </div>
                                </div>

<?php
if (!$noErrors)
    echo "<div class=\"text-right\"><span class=\"error\">* All fields required.</span></div>";
?>
                                <!-- Form actions -->
                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <a href="empSearch.php" class="btn btn-primary btn-lg">Cancel</a>
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>