<html>
    <head>
        <link rel="stylesheet" href="menuStyle.css">
    </head>
        <body>
        <ul class="navbar">
            <li><a href="index.php" name = "home" id = "alignLeft">  Home </a></li>
			<li><a href="tetris.php" name = "tetris" id = "alignRight"> Play Tetris </a></li>
			<li><a href="leaderboard.php" name = "leaderboard" id = "alignRight"> Leaderboard </a></li>
        </ul>
	<div class = "main" style = "background-color: #c7c7c7;box-shadow: 5px 5px 5p; ">
	      <div id="resultsTable">
	       <table style="margin: auto; color: white ; border-spacing:2px; text-align: center;" >
                <tr>
                    <th bgcolor="blue" class="Username"> Username </th>
                    <th bgcolor="blue" class="Score"> Score</th>
                </tr>
                    <?php
                    session_start();
                    $_conn = mysqli_connect('localhost', 'webAccess', 'password', 'tetris') or die("Connection Failed :" . mysqli_connect_error());

                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                        echo 'method is post'; 
                        $_username = $_SESSION['username'];
                        $_score = $_REQUEST["gameScore"];

                        function doesNotExistInScore($_username,$_conn){
                            try{
                                $result = $_conn->query("SELECT Username FROM Scores WHERE Username = '".$_username."'");
                                if($result->num_rows == 0) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }catch (ErrorException $exception){
                                echo $exception;
                            }
                        }
                    
                        function insertIntoScores($_username , $_score, $_conn){
                            if(doesNotExistInScore($_username, $_conn)){
                                echo 'Inserting';
                            try {
                                echo $_username;
                                echo $_score;
                                $_sql = " INSERT INTO Scores VALUES(NULL,'" . $_username . "','" . $_score . "')";
                                mysqli_query($_conn, $_sql);
                                mysqli_close($_conn);
                                } catch (PDOException $exception) {
                                    echo $exception;
                                }
                        }else{
                                $_result = $_conn->query("SELECT Score FROM Scores WHERE Username ='".$_username."'");
                                while($row = $_result->fetch_assoc()) {
                                    if($row['Score'] < $_score){
                                        $_sqlIntoScores =  "UPDATE Scores SET Score ='".$_score."' WHERE Username = '".$_username."'";
                                        mysqli_query($_conn, $_sqlIntoScores);
                                    }
                                }
                            }
                        }    
                        $_sqlForDisplay = "SELECT UserName, Display FROM Users";
                        $_result = $_conn->query($_sqlForDisplay);
                        while ($row = $_result->fetch_assoc()) {
                            if ($row["UserName"] == $_username && $row['Display'] == "1") {
                                insertIntoScores($_username , $_score , $_conn);
                                break;
                            }
                        }    
                    }else{
                        $_sql = "SELECT * FROM Scores ORDER BY Score DESC LIMIT 8";
                        $_result = $_conn->query($_sql);
                        while($row = $_result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $row['Username']?></td>
                        <td><?php echo $row['Score']?></td>
                    </tr>
                     <?php
                        } ?>
                   <?php }?>
	     </table>
	  </div>
        </div>
    </body>
</html>
