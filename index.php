<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="materialize\css\materialize.min.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<div class="container">
    <header>
        <h1>STORY | MAPS

            <img src="https://upload.wikimedia.org/wikipedia/en/thumb/6/60/San_Diego_State_University_seal.svg/912px-San_Diego_State_University_seal.svg.png" alt="logo" align="right" height="75" width="75"/>
            <img src="https://i.vimeocdn.com/portrait/7508128_300x300.jpg" alt="logo" align="right" height="75" width="75"/>
        </h1>
    </header>
	<nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo right"></a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="#">Account | Log In</a></li>
            </ul>
        </div>
    </nav>
    </br>

    <div class="row">
        <form class="col s12" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="email" class="validate">
                    <label for="email" data-error="wrong" data-success="right">Email</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>

            <button class="btn waves-effect waves-light" type="submit" name="submit">Log In
                <i class="material-icons right"></i>
            </button>


        </form>
    </div>

    <p><a href="register.php">Registration</a></p>
    <p><a href="forgot_password.php">Forgot Password ?</a></p>


    <p><?php
        //to make page secure
        if($_SERVER['SERVER_PORT'] != '443') { header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); exit(); }
        //to show logged out message on login form
        if(!empty($_GET["status"]))
        {
            echo "<b>You are logged out successfully!</b>";
        }
        ?></p>

    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">LARC Labs</h5>
                    <h5 class="white-text">San Diego State University</h5>

                    <p class="grey-text text-lighten-4"></p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text"></h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!"></a></li>
                        <li><a class="grey-text text-lighten-3" href="#!"></a></li>
                        <li><a class="grey-text text-lighten-3" href="#!"></a></li>
                        <li><a class="grey-text text-lighten-3" href="#!"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                Story Map Project
                <a class="grey-text text-lighten-4 right" href="#!"></a>
            </div>
        </div>
    </footer>

<?php
require 'database.php';

if(isset($_POST["submit"]))
{
    if(!empty($_POST["email"])&&!empty($_POST["password"]))
    {
        $email=$_POST["email"];
        $password=$_POST["password"];
        $password=md5($password);
        //$hmac=hash_hmac('sha512', $password);

        $query=mysql_query("SELECT * FROM student WHERE email='".$email."' AND password='".$password."'");
        $numrows=mysql_num_rows($query);

        if($numrows!=0)
        {
            while($row=mysql_fetch_assoc($query))
            {
                $dbemail=$row['email'];
                $dbpassword=$row['password'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $studentID=$row['studentID'];
            }

            if($email==$dbemail && $password==$dbpassword)
                //if($studentID=auth_user($email, $password))
            {
                session_start();
                $_SESSION['email']=$email;
                $_SESSION['fname'] = $fname;
                $_SESSION['lname'] = $lname;
                $_SESSION['studentID']=$studentID;
                $student_id = (int)$studentID;

                //Redirect the Browser
                $find_forgot_pass=mysql_query("SELECT *FROM security_answers where student_id=".$student_id);
                $numrows=mysql_num_rows($find_forgot_pass);
                if ($numrows==0) {
                    header("Location: current_user_security_question.php");
                }
                else{
                    header("Location: userspace.php");
                }
            }
        }
        else
        {
            echo "Invalid Email and Password!";

        }
    }
    else
    {
        echo "<b><h5><font color='red'>** All fields are required!</font></h5></b>";
    }
}
?>
<br>
<form>
    <b>
        <?php
        //to show logged out message on login form
        /*if(!empty($_GET["status"]))
        {
            echo "You have logged out successfully!";
        }*/
        ?>
    </b>
</form>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="materialize\js\materialize.min.js"></script>
</div>
</body>
</html>