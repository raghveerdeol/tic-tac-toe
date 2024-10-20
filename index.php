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
    for ($a=0; $a < count($board); $a++) { 
        for ($i=0; $i < count($board[$a]); $i++) { 
            if ($board[$a][$i] === '') {
                return $a.$i;
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get player move 
    $playerMove = $_POST['tic'];
    // split player cell move value  
    $playerArray = str_split($playerMove);
    // Add player move 
    $boardData[$playerArray[0]][$playerArray[1]] = 'x';

    // get computer move 
    $computerMove = game($boardData);
    // split computer cell move value
    $computerArray = str_split($computerMove);
    // ad computer move 
    $boardData[$computerArray[0]][$computerArray[1]] = 'o';

    $_SESSION['boardData'] = $boardData;


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
                    <input 
                    type="radio" 
                    class="square" 
                    name="tic" 
                    value="<?php echo $a.$i ?>"
                    <?php if ($boardData[$a][$i] !== '') { ?> disabled <?php } ?>
                    >
                </input>
                <?php } ?>
            <?php } ?>
            <button type="submit">Submit your move</button>
        </form>
        <section>
            <h2></h2>
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