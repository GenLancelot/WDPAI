<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/styleselect.css">
    <script type="text/javascript" src="public/scripts/search.js" defer></script>
    <title>Select your game</title>
</head>
<body>

    <div class="container">
        <div class="headline">
            <h1>Select your game!</h1>
        </div>
        <div class="select-container">
            <header class = "searchbox">
                <input name ="searchgame" type = "text" placeholder="search game"/>
            </header>
            <div class ="selectableobjects">
                <?php foreach ($games as $game): ?>
                    <div class="gamebox">
                        <img class ="gamebox-icon" src="public/icons/games/<?= $game->getFilename(); ?>">
                        <div class="gamebox-name">
                            <?= $game->getName(); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="buttons">
                <button type="submit">Skip</button>
                <button type="submit">Next</button>
            </div>
        </div>
    </div>
</body>

<template id="gameTemplate">
    <div class="gamebox">
        <img class ="gamebox-icon" src="">
        <div class="gamebox-name">

        </div>
    </div>
</template>