<?php
session_start();
?>

<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>
            Tetris
        </title>
        <link rel="stylesheet" href="menuStyle.css">
    </head>
    <body >
        <ul class="navbar">
			<li><a href="index.php" name = "home" id = "alignLeft">  Home </a></li>
			<li><a href="tetris.php" name = "tetris" id = "alignRight"> Play Tetris </a></li>
			<li><a href="leaderboard.php" name = "leaderboard" id = "alignRight"> Leaderboard </a></li>
		</ul>

        <div class="main">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST['submit'])){
                $_firstName = $_REQUEST['firstName'];
                $_lastName =  $_REQUEST['lastName'];
                $_username =  $_REQUEST['username'];
                $_password =  $_REQUEST['password'];
                $_cpassword = $_REQUEST['c_password'];
                $_display =  $_REQUEST['display'];
        
                //Check passwords are the same
                if($_cpassword !== $_password){
                    header("Location:register.php");
                }else{
                    //Attempt to create a connection to the database and insert data
                try{
                            $_sql = "INSERT INTO Users VALUES('" . $_username . "','" . $_firstName . "','" . $_lastName ."','" . $_password . "','". $_display . "')";
                            $_conn = mysqli_connect('localhost', 'webAccess', 'password', 'tetris') or die("Connection Failed :" . mysqli_connect_error());
                            mysqli_query($_conn,$_sql);
                               mysqli_close($_conn);
        
                        }catch (PDOException $exception){
                                echo 'Username taken';
                                header("Location:register.php");
                        }
        
                    header("Location:index.php");
                }
        }else{
            header("Location:register.php");
        }
        }else if(isset($_SESSION['username']) and isset($_SESSION['password'])){?>
           <div class = "loggedIn">
               <h2>Welcome to tetris</h2>
               <hr>
	       <a><button onclick="location.href='tetris.php'" id = loggedInButttons>Click here to play </button></a>
	       <a><button onclick =" location.href = 'endSession.php'" id = loggedInButttons>Logout </button></a>

           </div>
            <?php } else { ?>
            <div class = "loginForm">
                <form action = loginHandler.php method = "POST">
                    <input type = "text" placeholder="username" id = "usernameLogin" name = "username">
                    <hr>
                    <input type = "password" placeholder="password" id = "password" name = "password">
                    <hr>
                    <input type = "submit" id = "submit"name = "submit">
                </form>
                <p> Don't have a user account ?<a href = register.php>  Register now </a></p>
            </div>
	    <?php }?>




        </div>
    </body>
</html>

