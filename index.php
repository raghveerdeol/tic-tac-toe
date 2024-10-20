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
    // if there is no moves 
    return null;
};


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerMove = $_POST['tic'];
    $playerArray = str_split($playerMove);
    // add player move 
    $boardData[$playerArray[0]][$playerArray[1]] = 'x';
    
    
    $computerMove = game($boardData);
    $computerArray = str_split($computerMove);
    // add computer move 
    $boardData[$computerArray[0]][$computerArray[1]] = 'o';
    
    // update board 
    $_SESSION['boardData'] = $boardData;
    echo json_encode([$computerMove]);
    exit();
}


if (isset($_POST['reset'])) {
    session_destroy();  // Distruggi la sessione esistente
    header("Location: index.php");  // Ricarica la pagina
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

    </main>

    <script src="./script.js"></script>
</body>
</html>