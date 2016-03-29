<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
    require_once("Includes/db.php");
    $accessLevel = mysqli_fetch_array(EmployeeDB::getInstance()->get_access_rights_by_user($_SESSION['user']));
    $al = $accessLevel["AccessLevel"];
    if ($al == 0) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modify Employee</title>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css"> 
    </head>
    <body>

        <div class="container">
            <div class="row"><br/><br/>

                <div class="col-md-6 col-md-offset-3">   
                    <?php
                    echo "<div class=\"pull-right\">";
                    echo "" . $_SESSION['user'];
                    echo "<a href=\"logout.php\"> Logout</a>";
                    echo "</div>";
                    ?>
                </div>


                <div class="col-md-6 col-md-offset-3">
                    <div class="well well-sm">

                        <legend class="text-center">Employee Record</legend>     
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $f = $_POST["eFirstName"];
                            $eID = $_POST["empID"];
                            EmployeeDB::getInstance()->update_record($eID, $_POST["eFirstName"], $_POST["eLastName"], $_POST["eEmail"], $_POST["eAccessLevel"]);
                            header('Location: empDetails.php?empID=' . $eID);
                            exit;
                        } else if (array_key_exists("empID", $_GET)) {

                            $employee = mysqli_fetch_array(EmployeeDB::getInstance()->get_details_by_employee_id($_GET["empID"]));
                            $ar = mysqli_fetch_array(EmployeeDB::getInstance()->get_access_rights_by_id($_GET["empID"]));
                        } else {
                            echo "GET NO EXIST";
                        }
                        ?>

                        <fieldset>
                            <form name="editEmployee" class="form-horizontal"  action="modifyEmployee.php" method = "POST">
                                <input type="hidden" name="empID" value="<?php echo $employee["EmployeeID"]; ?>"/>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="eFirstName">First Name</label>
                                    <div class="col-md-9">
                                        <input id="eFirstName" name="eFirstName" value="<?php echo $employee['FirstName']; ?>" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="eLasstName">Last Name</label>
                                    <div class="col-md-9">
                                        <input id="eLastName" name="eLastName" value="<?php echo $employee['LastName']; ?>" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="eEmail">Email</label>
                                    <div class="col-md-9">
                                        <input id="eEmail" name="eEmail" value="<?php echo $employee['Email']; ?>" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="eAccessLevel">Access Level</label>
                                    <div class="col-md-9">
                                        <input id="eAccessLevel" name="eAccessLevel" value="<?php echo $ar['AccessLevel']; ?>" class="form-control">
                                    </div>
                                </div>

                                <input type="hidden" name="empID" value="<?php echo ($_GET["empID"]); ?>"/>

                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <a href="empSearch.php" class="btn btn-primary ">Cancel</a>
                                        <button type="submit" name="saveUpdate" value="Save Changes" class="btn btn-primary ">Save</button>
                                    </div>
                                </div>
                            </form>
                            <form  class="form-horizontal" name="deleteEmployee" action="deleteEmployee.php" method="POST">
                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <input type="hidden" name="empID" value="<?php echo ($_GET["empID"]); ?>"/>
                                        <button type="submit" name="delete" value="Delete Employee Record" class="btn btn-danger ">Delete Employee Record</button>
                                    </div>
                                </div>
                            </form>
                        </fieldset>   
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>    