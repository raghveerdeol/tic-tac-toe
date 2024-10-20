<?php 
session_start();
// declare two-dimensional array to store board state
if (!isset($_SESSION['boardData']) || count($_SESSION['boardData']) !== 3) {
    $_SESSION['boardData'] = array(
        array('', '', ''),
        array('', '', ''),
        array('', '', ''),
    ); 
}
$boardData = $_SESSION['boardData'];


function game($board) {
    for ($z=0; $z < count($board); $z++) {
        for ($i=0; $i < count($board[$z]); $i++) { 
            if ($board[$z][$i] === '') {
                return $z.$i;
            }
        }
    }
};

function checkWinner($board){
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] === $board[$i][1] && $board[$i][1] === $board[$i][2] && $board[$i][0] !== '') {
            return $board[$i][0];
        }
        if ($board[0][$i] === $board[1][$i] && $board[1][$i] === $board[2][$i] && $board[0][$i] !== '') {
            return $board[0][$i];
        }
    }
    if ($board[0][0] === $board[1][1] && $board[1][1] === $board[2][2] && $board[0][0] !== '') {
        return $board[0][0];
    }
    if ($board[0][2] === $board[1][1] && $board[1][1] === $board[2][0] && $board[0][2] !== '') {
        return $board[0][2];
    }
    return ''; // Nessun vincitore
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerMove = $_POST['tic'];
    $playerArray = str_split($playerMove);
    // add player move 
    $boardData[$playerArray[0]][$playerArray[1]] = 'x';

    $winner = checkWinner($boardData);
    if ($winner !== '') {
        echo json_encode(['winner' => "Il vincitore è: " . $winner]);
        session_destroy(); // Reset del gioco in caso di vittoria
        exit();
    }
    
    $computerMove = game($boardData);

    $computerArray = str_split($computerMove);
    // add computer move 
    $boardData[$computerArray[0]][$computerArray[1]] = 'o';

    $winner = checkWinner($boardData);
    if ($winner !== '') {
        echo json_encode(['winner' => "Il vincitore è: " . $winner]);
        session_destroy(); // Reset del gioco
        exit();
    }

    // update board 
    $_SESSION['boardData'] = $boardData;
    echo json_encode(['computerMove' => $computerMove]);
    exit();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tris</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <header></header>
    
    <main>
        <h1>Play the game</h1>
        <form action="index.php" method="GET">
            <button type="submit" name="reset">Start New Game</button>
        </form>
        <form action="index.php" method="POST" id="gameForm" class="gameContainer">
            <?php for ($a=0; $a < count($boardData); $a++) { ?>
                <?php for ($i=0; $i < count($boardData[$a]); $i++) { ?>
                    <input type="radio" class="square" name="tic" value="<?php echo $a.$i ?>"></input>
                <?php } ?>
            <?php } ?>
        </form>
        <section>
            <h2 id="gameOver"></h2>
        </section>
    </main>

    <script src="./script.js"></script>
</body>
</html>
<?php 
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>