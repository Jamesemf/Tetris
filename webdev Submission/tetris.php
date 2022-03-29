<html>
<head>
    <link rel="stylesheet" href="menuStyle.css">
    <audio src="gameTheme.mp3" id = gameAudio></audio>
    <audio src="MainMenu.mp3" id = menuAudio></audio>
    <audio src="intenseGameTheme.mp3" id = intenseGameAudio></audio>
</head>
<body>
<ul class="navbar">
    <li><a href="index.php" id = "alignLeft">  Home </a></li>
    <li><a href="tetris.php" id = "alignRight"> Play Tetris </a></li>
    <li><a href="leaderboard.php" id = "alignRight"> Leaderboard </a></li>
</ul>
<div class = "main" style="box-shadow: 5px 5px 5px black;background-color: #c7c7c7";>
    <H3>Score: <span id = "score"> 0 </H3>
    <button id = "startButton" > Start the game </button>
    <button id = "playPauseButton">Play or pause</button>
    <div id = "tetris-bg">
    </div>
</div>
</body>
</html>
<?php
session_Start();
if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
	header("Location: index.php");
}
?>

<script>
    const column = 21;
    const rows = 10;

    let intenseGame = false;
    let gamePaused = false;

    let horizontalPosition = 0;
    let verticalPosition = 0;

    let rotationValue = 1;
    let key;

    let score = 0;
    const scoreDisplay = document.querySelector('#score')
    const startBtn = document.querySelector('#startButton')
    const playPauseBtn = document.querySelector('#playPauseButton')



    const gamePiece = {"L" : [ [1,1],[1,2],[1,3],[2,3] ],
        "Z" : [ [1,1],[2,1],[2,2],[3,2] ],
        "S" : [ [1,2],[2,1],[2,2],[3,1] ],
        "T" : [ [1,1],[2,1],[2,2],[3,1] ],
        "O" : [ [1,1],[1,2],[2,1],[2,2] ],
        "I" : [ [1,1],[1,2],[1,3],[1,4] ]
    }
    const gamePieceR2 = {"L" : [ [1,2],[2,2],[3,2],[3,1] ],
        "Z" : [ [1,3],[1,2],[2,2],[2,1] ],
        "S" : [ [2,3],[1,2],[2,2],[1,1] ],
        "T" : [ [2,2],[2,1],[3,1],[2,0] ],
        "O" : [ [2,2],[3,2],[2,1],[3,1] ],
        "I" : [ [0,2],[1,2],[2,2],[3,2] ]
    }
    const gamePieceR3 = {"L" : [ [2,3],[2,2],[2,1],[1,1] ],
        "Z" : [ [3,3],[2,3],[2,2],[1,2] ],
        "S" : [ [3,2],[2,3],[2,2],[1,3] ],
        "T" : [ [3,1],[2,1],[2,0],[1,1] ],
        "O" : [ [3,1],[3,0],[2,1],[2,0] ],
        "I" : [ [1,3],[1,2],[1,1],[1,0] ]
    }
    const gamePieceR4 = {"L" : [ [3,2],[2,2],[1,2],[1,3] ],
        "Z" : [ [3,1],[3,2],[2,2],[2,3] ],
        "S" : [ [2,1],[3,2],[2,2],[3,3] ],
        "T" : [ [2,0],[2,1],[1,1],[2,2] ],
        "O" : [ [2,0],[1,0],[2,1],[1,1] ],
        "I" : [ [3,2],[2,2],[1,2],[0,2] ]
    }

    function GamePiece(id , positions){
        this.id = id;
        this.positions = positions;
    }

    let offSet = 3;
    let currentPosition = 0;
    let currentGamePiece = selectRandomPiece()

    //Update positions within the array
    function draw(){
        currentGamePiece.positions.forEach(index =>{
            gridArray[index[0] + currentPosition][index[1] + offSet] = currentGamePiece.id.toString();
        })
        shapeTranslate()
    }
    
    function unDraw(){
        currentGamePiece.positions.forEach(index =>{
            gridArray[index[0] + currentPosition][index[1] + offSet] = [' '];
        })
    }

    //updates position on the grid
    function shapeTranslate(){
        const pieces = Array.from(document.getElementsByClassName('block'));
        console.log(pieces)
        pieces.forEach(piece => {
            console.log(piece)
            piece.style.transform = "translate("+ horizontalPosition * 30 + "px ," + verticalPosition * 30 +"px)"
        })
    }


    //Move a piece down every second
    function moveDown() {
        unDraw()
        freeze()
        currentPosition += 1;
        verticalPosition += 1;
        shapeTranslate()
        draw();
        freeze();
    }

    //rotates a piece
    function rotate(){
        if(!gamePaused){
            unDraw();
            rotationValue ++
            if(rotationValue > 4){
                rotationValue = 1
            }
            let originalRotation = currentGamePiece.positions;
            switch(rotationValue) {
                case 1:
                    if (currentGamePiece.id == "L") {
                        currentGamePiece.positions = gamePiece.L
                        break
                    }
                    if (currentGamePiece.id == "Z") {
                        currentGamePiece.positions = gamePiece.Z
                        break
                    }
                    if (currentGamePiece.id == "S") {
                        currentGamePiece.positions = gamePiece.S
                        break
                    }
                    if (currentGamePiece.id == "T") {
                        currentGamePiece.positions = gamePiece.T
                        break
                    }
                    if (currentGamePiece.id == "O") {
                        currentGamePiece.positions = gamePiece.O
                        break
                    }
                    if (currentGamePiece.id == "I") {
                        currentGamePiece.positions = gamePiece.I
                        break
                    }
                case 2:
                    if (currentGamePiece.id == "L") {
                        currentGamePiece.positions = gamePieceR2.L
                        break
                    }
                    if (currentGamePiece.id == "Z") {
                        currentGamePiece.positions = gamePieceR2.Z
                        break
                    }
                    if (currentGamePiece.id == "S") {
                        currentGamePiece.positions = gamePieceR2.S
                        break
                    }
                    if (currentGamePiece.id == "T") {
                        currentGamePiece.positions = gamePieceR2.T
                        break
                    }
                    if (currentGamePiece.id == "O") {
                        currentGamePiece.positions = gamePieceR2.O
                        break
                    }
                    if (currentGamePiece.id == "I") {
                        currentGamePiece.positions = gamePieceR2.I
                        break
                    }
                case 3:
                    if (currentGamePiece.id == "L") {
                        currentGamePiece.positions = gamePieceR3.L
                        break
                    }
                    if (currentGamePiece.id == "Z") {
                        currentGamePiece.positions = gamePieceR3.Z
                        break
                    }
                    if (currentGamePiece.id == "S") {
                        currentGamePiece.positions = gamePieceR3.S
                        break
                    }
                    if (currentGamePiece.id == "T") {
                        currentGamePiece.positions = gamePieceR3.T
                        break
                    }
                    if (currentGamePiece.id == "O") {
                        currentGamePiece.positions = gamePieceR3.O
                        break
                    }
                    if (currentGamePiece.id == "I") {
                        currentGamePiece.positions = gamePieceR3.I
                        break
                    }
                case 4:
                    if (currentGamePiece.id == "L") {
                        currentGamePiece.positions = gamePieceR4.L
                        break
                    }
                    if (currentGamePiece.id == "Z") {
                        currentGamePiece.positions = gamePieceR4.Z
                        break
                    }
                    if (currentGamePiece.id == "S") {
                        currentGamePiece.positions = gamePieceR4.S
                        break
                    }
                    if (currentGamePiece.id == "T") {
                        currentGamePiece.positions = gamePieceR4.T
                        break
                    }
                    if (currentGamePiece.id == "O") {
                        currentGamePiece.positions = gamePieceR4.O
                        break
                    }
                    if (currentGamePiece.id == "I") {
                        currentGamePiece.positions = gamePieceR4.I
                        break
                    }

            }
            if(currentGamePiece.positions.some(index => typeof (gridArray[index[0] + currentPosition + 1][index[1] + offSet]) == "undefined" || gridArray[index[0] + currentPosition + 1][index[1] + offSet].includes("*"))){
                currentGamePiece.positions = originalRotation
            }
            draw()
            drawWorld()
        }
    }

    function freeze() {
        if (currentGamePiece.positions.some(index => gridArray[index[0] + currentPosition + 1][index[1] + offSet].includes("*"))) {
            currentGamePiece.positions.forEach(index => gridArray[index[0] + currentPosition][index[1] + offSet] = currentGamePiece.id + "*")
            rotationValue = 1;
            currentGamePiece = selectRandomPiece()
            currentPosition = 0
            offSet = 3
            if(!gameOver()){
                checkLines()
                score++;
                draw()
                drawWorld()
            }else{
                document.getElementById('#playPauseButton').hidden = true;
            }
        }
    }

    //assign functions to keycodes
    function control(e){
        if(e.keyCode === 37){
            moveLeft()
        }else if (e.keyCode ===38){
            rotate()
        }else if (e.keyCode === 39){
            moveRight()
        }else if (e.keyCode === 40){
            moveDownOnKey()
        }
    }


    //movement functions
    document.addEventListener('keyup', control)
    function moveDownOnKey(){
        if(!gamePaused){
            unDraw()
            freeze()
            currentPosition += 1;
            verticalPosition += 1;
            draw();
            freeze()

        }
    }
    function moveLeft(){
        if(!gamePaused){
            let isAtLeftEdge = false;
            for (let i = 0; i < column; i++) {
                if(gridArray[i][0] == 'S' || gridArray[i][0] ==  'O' || gridArray[i][0] == 'T' || gridArray[i][0] == 'Z' || gridArray[i][0] == 'I' || gridArray[i][0] == 'L'){
                    isAtLeftEdge = true;
                }
            }

            unDraw()
            if(!isAtLeftEdge) {
                offSet -=1
                horizontalPosition -=1;
            }

            if(currentGamePiece.positions.some(index => gridArray[index[0] + currentPosition][index[1] + offSet].includes("*"))){
                offSet +=1
                horizontalPosition +=1;
            }
            freeze()
            draw()
        }
    }
    function moveRight(){
        if(!gamePaused){
            let isAtRightEdge = false;
            for (let i = 0; i < column; i++) {
                if(gridArray[i][9] == 'S' || gridArray[i][9] ==  'O' || gridArray[i][9] == 'T' || gridArray[i][9] == 'Z' || gridArray[i][9] == 'I' || gridArray[i][9] == 'L'){
                    isAtRightEdge = true;
                }
            }
            unDraw()
            if(!isAtRightEdge) {
                offSet+=1
                horizontalPosition +=1;
            }
            if(currentGamePiece.positions.some(index => gridArray[index[0] + currentPosition][index[1] + offSet].includes("*"))){
                offSet -=1
                horizontalPosition -=1;
            }
            freeze()
            draw()
        }
    }


    function selectRandomPiece() {
        const values = Object.values(gamePiece);
        const keys = Object.keys(gamePiece);
        let randomV = Math.random();
        let currentGamePieceKey = keys[Math.floor(keys.length * randomV)];
        let gridPositions = values[Math.floor(values.length * randomV)];
        return new GamePiece(currentGamePieceKey , gridPositions);
    }

    function checkLines(){
        for (let y = 0; y < column - 1; y++) {
            let fullLine = true;
            for (let x = 0;x < rows; x++) {
                if(!gridArray[y][x].includes("*")){
                    fullLine = false;
                }
            }

            if(fullLine){
                console.log("There is a full line")
                gridArray.splice(y , 1);
                gridArray.splice(0,0,[" "," "," "," "," "," "," "," "," "," "])
                y--;
                y--;
                score +=10
                scoreDisplay.innerHTML = score
                if(score > 100 && intenseGame == false){
                    document.getElementById('gameAudio').pause();
                    document.getElementById('intenseGameAudio').play();
                    intenseGame = true;
                }
            }
        }   
    }

    function addScore(){
        for (let y = 0; y < column; y++) {
            const row = [gridArray[y][0],gridArray[y][1],gridArray[y][2],gridArray[y][3],gridArray[y][4],gridArray[y][5],gridArray[y][6],gridArray[y][7],gridArray[y][8],gridArray[y][9]]
            if(row.every(index => index.includes("*"))){
                score +=10
                scoreDisplay.innerHTML = score
                row.forEach(index => {
                    gridArray[index].remove()
                })
                const  blocksRemoved = gridArray.splice(gridArray[y][0], gridArray[y][9])
                gridArray = gridArray.concat(blocksRemoved)
            }
        }
    }

    function createGrid() {
        let gridArray = [];
        for (let y = 0; y < column; y++) {
            if(y == 20){
                gridArray[y] = ["*"];
                for (let x = 0;x < rows; x++) {
                    gridArray[y][x] = "*";
                }
            }else{
                gridArray[y] = [" "];
                for (let x = 0;x < rows; x++) {
                    gridArray[y][x] = " ";
                }
            }
        }
        return gridArray;
    }

    function drawWorld(){
        scoreDisplay.innerHTML = score
        horizontalPosition = 0;
        verticalPosition = 0;

        document.getElementById('tetris-bg').innerHTML= "";
        for(let y = 0; y < column - 1; y++){
            for(let x=0; x< gridArray[y].length; x++){
                console.log(gridArray[y][x].toString());
                switch (gridArray[y][x].toString()) {
                    case " ":
                        document.getElementById('tetris-bg').innerHTML += "<div></div>";
                        break;
                    case "L":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'block' id = 'L'></div>";
                        break;
                    case "L*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken' id = 'L'></div>";
                        break;
                    case "Z":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'block' id = 'Z'></div>";
                        break;
                    case "Z*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken' id = 'Z'></div>";
                        break;
                    case "S":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'block' id = 'S'></div>";
                        break;
                    case "S*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken' id = 'S'></div>";
                        break;
                    case "T":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'block' id = 'T'></div>";
                        break;
                    case "T*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken' id = 'T'></div>";
                        break;
                    case "O":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'block' id = 'O'></div>";
                        break;
                    case "O*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken' id = 'O'></div>";
                        break;
                    case "I":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'block' id = 'I'></div>";
                        break;
                    case "I*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken' id = 'I'></div>";
                        break;
                    case "*":
                        document.getElementById('tetris-bg').innerHTML += "<div class = 'taken'></div>";
                        break;
                }
            }
        }
    }

    function gameOver(){
        if(currentGamePiece.positions.some(index => gridArray[index[0] + currentPosition][index[1] + offSet].includes("*"))){
            clearInterval(timerId);
            gamePaused = true;
            document.getElementById('gameAudio').pause()
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("post","leaderboard.php", true)
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("gameScore=" + score);
            xmlhttp.onload = function(){
                alert("GAME OVER !!!\nYour score was " + score + "\nreturning to the homepage")
                window.location.href = "index.php";
            }
            return true;
        }
        return false;
    }

    startButton.addEventListener('click', () => {
        document.getElementById('startButton').style.display = "none";
        document.getElementById('playPauseButton').style.display = "inline-block";
        start()
    })

    playPauseBtn.addEventListener('click', () =>{
        if(timerId){
            clearInterval(timerId)
            timerId = null
            gamePaused=true;
            document.getElementById('intenseGameAudio').pause()
            document.getElementById('gameAudio').pause()
        }else{
            draw()
            timerId = setInterval(moveDown, 500)
            if(intenseGame == true){
                document.getElementById('intenseGameAudio').play()
            }else{
                document.getElementById('gameAudio').play()
            }
            gamePaused = false;
        }
    })

    function start(){
        document.getElementById('menuAudio').pause();
        timerId = setInterval(moveDown, 500)
        document.getElementById('gameAudio').play();
        gridArray = createGrid();

        draw()
        drawWorld()
    }

    document.getElementById('menuAudio').play();


</script>
<?php
