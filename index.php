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

// get computer move  
function game($board) {
    for ($a=0; $a < count($board); $a++) { 
        for ($i=0; $i < count($board[$a]); $i++) { 
            if ($board[$a][$i] === '') {
                return $a.$i;
            }
        }
    }
    return null;
}

// check the winner 
function checkWinner($board) {
    for($i = 0; $i < 3; $i++) {
        // check row 
        if ($board[$i][0] === $board[$i][1] && $board[$i][1] === $board[$i][2] && $board[$i][0] !== '') {
            return 'win';
        }
        // check col 
        if ($board[0][$i] === $board[1][$i] && $board[1][$i] === $board[2][$i] && $board[0][$i] !== '') {
            return 'win';
        }
    }
    if ($board[0][0] === $board[1][1] && $board[1][1] === $board[2][2] && $board[0][0] !== '') {
        return 'win';
    }
    if ($board[0][2] === $board[1][1] && $board[1][1] === $board[2][0] && $board[0][2] !== '') {
        return 'win';
    }
    return '';
}


$game = '';
$playerWin = '';
$computerWin = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get player move 
    $playerMove = $_POST['cell'];
    // split player cell move value  
    $playerArray = str_split($playerMove);
    // Add player move 
    $boardData[$playerArray[0]][$playerArray[1]] = 'x';

    // check if player win 
    $playerWin = checkWinner($boardData);
    if ($playerWin === 'win') {
        $game = 'The Player Win';
    }

    // get computer move 
    $computerMove = game($boardData);
    if ($computerMove != null) {
        // split computer cell move value
        $computerArray = str_split($computerMove);
        // ad computer move 
        $boardData[$computerArray[0]][$computerArray[1]] = 'o';
        // check if computer win 
        $computerWin = checkWinner($boardData);
        if ($computerWin === 'win' && $playerWin === '') {
            $game = 'The Computer Win';
        }
    }


    $_SESSION['boardData'] = $boardData;
    // if there is no more moves
    if ($computerMove === null && $playerWin === '' && $computerWin === '') {
        $game = 'Game over';
    }

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
        <!-- reset game  -->
        <form action="index.php" method="GET" id="newGameForm">
            <button type="submit" name="reset" class="newGame">Start New Game</button>
        </form>
        <!-- game board form -->
        <form action="index.php" method="POST" id="gameForm" class="gameContainer">
            <?php for ($a=0; $a < count($boardData); $a++) { ?>
                <?php for ($i=0; $i < count($boardData[$a]); $i++) { ?>
                    <input 
                        type="radio" 
                        class="square hiddenRadio inputCell" 
                        name="cell" 
                        value="<?php echo $a.$i ?>"
                        id="<?php echo 'cell'.$a.$i ?>"
                        <?php if ($boardData[$a][$i] !== '' || $game !== '') { ?> disabled <?php } ?>
                        required
                        >
                <?php } ?>
            <?php } ?>
            <?php for ($a=0; $a < count($boardData); $a++) { ?>
                <?php for ($i=0; $i < count($boardData[$a]); $i++) { ?>
                    <label 
                        for="<?php echo 'cell'.$a.$i ?>"
                        class="square cell
                        <?php if ($boardData[$a][$i] === 'x') { ?>
                            tic
                        <?php } elseif ($boardData[$a][$i] === 'o') { ?>
                            toe
                        <?php } ?>
                        ">
                    </label>
                <?php } ?>
            <?php } ?>
            <button type="submit" class="newGame">Submit your move</button>
        </form>



        <section>
            <h2>
                <?php if ($game != '') {
                    echo $game;
                } ?>
            </h2>
        </section>
    </main>

    <script src="./script.js"></script>
</body>
</html>
<?php 
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>