<?php
require_once("Includes/db.php");
$logonSuccess = false;

//verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $logonSuccess = (EmployeeDB::getInstance()->verify_employee_credentials($_POST['user'], $_POST['userpassword']));
    if ($logonSuccess == true) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        header('Location:empSearch.php');
        exit;
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Employee Logion</title>
        <link href='empLogin.css' type ='text/css' rel='stylesheet' media='all'/>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <div class="container">
            <div class="row"> 
                <div class="col-md-3 col-md-offset-4" >
                    <div class="form-login">
                        <h4>Employee Login</h4>
                        <form name = "logon" action ="index.php" method="POST">
                            <input type="text" id="userName" name="user" class="form-control input-sm chat-input" placeholder="username" />
                            </br>
                            <input type="text" id="userPassword"  name="userpassword" class="form-control input-sm chat-input" placeholder="password" />
                            </br>
                            <div class="wrapper">            	
                                <span class="group-btn">    
                                    <button type="submit" class="btn btn-primary btn-md">
                                        login <i class="fa fa-sign-in"></i></button>
                                </span>

                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (!$logonSuccess) {
                                echo "<br/><br/><b>Invalid name and/or password</b>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>
</html>