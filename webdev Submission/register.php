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
    <div class = main>
        <div class = registerForm>
            <form action = index.php method = "POST">
                <label for = "firstName"> <b> First name:</b></label>
                <input type = "text" id = "firstName" name = firstName required>

                <label for = "lastName"> <b> Last name: </b></label>
                <input type = "text" id = "lastName" name = lastName required>
                <hr>

                <label for = "username"> <b> Username: </b></label>
                <input type = "text" id = "username" name = username required>
                <hr>

                <input type = "password" placeholder="Password" id = "passwordFieldOne" name = "password" required>
                <input type = "password" placeholder="Confirm password" id = "passwordFieldTwo" name = "c_password" required>

                <hr>
                <b> Display Scores on leaderboard</b>
                <label for = "radioField">Yes</label>
                <input type = "radio" id = "radioField" value= 1  name = "display" checked>

                <label for="radioField">No</label>
                <input type="radio" id="radioField" value = 0  name="display">
                <hr>

                <input type = "submit" name = "submit"/>
                <input type = "reset" name = "cancelButton"/>
        </div>
    </div>
    </body>
</html>

