<?php
session_start();
if (array_key_exists("user", $_SESSION)) {
    require_once("Includes/db.php");
    $accessLevel = mysqli_fetch_array(EmployeeDB::getInstance()->get_access_rights_by_user($_SESSION['user']));
    $al = $accessLevel["AccessLevel"];
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
        <title>Employee Details</title>
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
                        <legend class="text-center">Employee Details</legend>

                        <?php
                        $e = $_GET["empID"];
                        require_once("Includes/db.php");
                        $result = mysqli_fetch_array(EmployeeDB::getInstance()->get_details_by_employee_id($e));
                        $cp = mysqli_fetch_array(EmployeeDB::getInstance()->get_current_job($e));
                        echo "<ul><li>Name: " . htmlentities($result["FirstName"]) . "";
                        echo " " . htmlentities($result["LastName"]) . "</li>";
                        echo "<li>Email: " . htmlentities($result["Email"]) . "</li>";
                        echo "<li>Employee ID: " . htmlentities($result["EmployeeID"]) . "</li>";
                        echo "<li>Current Position: " . htmlentities($cp["title"]) . "</li></ul>\n";
                        ?>

                    </div>

                    <br/>
                    <div class="well-title">
                        <legend class="text-center">Job History</legend>
                    </div>
                    <div class='center'>
                        <table class="table table-striped custab">
                            <tr>
                                <th>Title</th>
                                <th>From Date</th>
                                <th>To Date</th>
                            </tr>


<?php
require_once("Includes/db.php");
$result2 = EmployeeDB::getInstance()->get_job_history_by_employee_id($e);
while ($row = mysqli_fetch_array($result2)) {
    echo "<tr><td>" . htmlentities($row["title"]) . "</td>";
    echo "<td>" . htmlentities($row["FromDate"]) . "</td>";
    $rToDate = $row["ToDate"];
    if ($rToDate == "") {
        echo "<td>Current</td></tr>\n";
    } else {
        echo "<td>$rToDate</td></tr>\n";
    }
}
mysqli_free_result($result2);
?>
                        </table>
                        <br>
                    </div>
                    <div class="col-md-12 text-right">
<?php
echo "<a class=\"btn btn-primary mg-right\" href=\"empSearch.php\">Back</a>";
if ($al == 1) {
    echo "<a class=\"btn btn-primary \" href=\"modifyEmployee.php?empID=" . $e . "\">Modify Record</a>";
}
?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>