<?php
if(isset($_POST['submit'])) {
    $_username = $_REQUEST['username'];
    $_password = $_REQUEST['password'];

    $_conn = mysqli_connect('localhost', 'webAccess', 'password', 'tetris');
    $_sql = "SELECT UserName, Password From Users";
    $_result = $_conn->query($_sql);
    mysqli_close($_conn);

    $_loggedIn = false;
    while($row = $_result->fetch_assoc()) {
        if($row["Password"] == $_password and $row["UserName"] == $_username){
		session_start();
		$_SESSION['username'] = $_username;
		$_SESSION['password'] = $_password;
		$_loggedIn = true;	
		header("Location:index.php");
        }
    }
    if($_loggedIn == false){
    	header("Location:index.php");
    }

}else{
    echo "Login could not be sent";
}

?>
