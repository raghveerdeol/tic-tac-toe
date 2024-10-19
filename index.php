<?php 

// declare two-dimensional array to store board state 
$boardData = array(
    array('', '', ''),
    array('', '', ''),
    array('', '', ''),
); 

$playerInput = '';
$playerArray = str_split($playerInput);


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
        <form class="gameContainer">
            <?php for ($a=0; $a < count($boardData); $a++) { ?>
                <?php for ($i=0; $i < count($boardData[$a]); $i++) { ?>
                    <input type="checkbox" class="square" value="<?php echo $a,$i ?>"></input>
                <?php } ?>
            <?php } ?>
        </form>
    </main>
</body>
</html>