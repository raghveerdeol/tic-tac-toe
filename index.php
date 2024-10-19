<?php 

// declare two-dimensional array to store board state 
$boardData = array(
    array('', '', ''),
    array('', '', ''),
    array('', '', ''),
); 

function game($board) {
    for ($z=0; $z < count($board); $i++) {
        for ($i=0; $i < count($board[$z]); $i++) { 
            if ($board[$z][$i] === '') {
                $board[$z][$i] = 'toe';
                return $z.$i;
            }
        }
    }
};


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerInput = $_POST['tic'];
    $playerArray = str_split($playerInput);
    $boardData[$playerArray[0]][$playerArray[1]] = 'tic';
    echo game($boardData);
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
        <form action="index.php" method="POST" id="gameForm" class="gameContainer">
            <?php for ($a=0; $a < count($boardData); $a++) { ?>
                <?php for ($i=0; $i < count($boardData[$a]); $i++) { ?>
                    <input type="radio" class="square" name="tic" value="<?php echo $a,$i ?>"></input>
                <?php } ?>
            <?php } ?>
        </form>
        <button type="submit">Play</button>
    </main>

    <script src="./script.js"></script>
</body>
</html>