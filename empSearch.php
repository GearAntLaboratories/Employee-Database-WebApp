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
        <title>Employee Database</title>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css"> 

    </head>
    <body>
        <div class="container">
            <div class="row col-md-8 col-md-offset-2 custyle">
                <span class="text-center"><h1>Employee Database</h1></span><br/>

                <table class="table table-striped custab">
                    <thead>
                        <?php
                        echo "<div class=\"pull-right\">";
                        echo "" . $_SESSION['user'];
                        echo "<a href=\"logout.php\"> Logout</a>";
                        echo "</div>";
                        ?>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th></th>
                        </tr>
                    </thead>

                    <?php
                    require_once("Includes/db.php");
                    $result = EmployeeDB::getInstance()->get_all_employees();
                    while ($row = mysqli_fetch_array($result)):
                        echo "<tr><td>" . htmlentities($row["FirstName"]) . "</td>";
                        echo "<td>" . htmlentities($row["LastName"]) . "</td>";
                        echo "<td>" . htmlentities($row["Email"]) . "</td>";
                        echo "<td>" . htmlentities($row["title"]) . "</td>";
                        $empID = $row["EmployeeID"];
                        ?>
                        <td>
                            <form name="getDetails" action="empDetails.php" method="GET">
                                <input type="hidden" name="empID" value="<?php echo $empID; ?>"/>
                                <button type="submit" name="getDetails" class='btn btn-primary btn-xs'><span class="glyphicon glyphicon-menu-hamburger"></span> Details</button>
                            </form>
                        </td>
    <?php
    echo "</tr>\n";
endwhile;
mysqli_free_result($result);
?>
                </table>

<?php
if ($al == 1) {
    echo "<div class=\"button text-right\">";
    echo "<form name=\"getDetails\" action=\"addNewEmployee.php\" method=\"GET\">";
    echo "<button type=\"submit\" name=\"addEmp\" class=\"btn btn-primary\"><b>+</b> Add new employee</button>";
    echo "</form>";
    echo "</div>";
}
?>

            </div>
        </div>

    </body>
</html>