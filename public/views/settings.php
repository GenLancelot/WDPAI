<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="/public/css/styleselect.css">

    <title>Settings</title>
</head>
<body>
    <div class="container settings">

        <div class="profile-container">
            <div class="player-wall">
                <div class="edit">
                    <img src="../icons/edit.svg"./>
                </div>
                <div class="player-icon profile-view">

                </div>
                <div class="player-nickname">
                    <?php echo $user->getEmail()?>
                </div>
            </div>

            <div class="profile-info">
                <div class="player-description">
                    <?php echo $user->getDescription()?>
                </div>
                <div class="player-games">
                    <?php foreach ($games as $game):?>
                    <div class="game">
                        <div class="game-icon">
                            <img class="game-img" src="public/icons/games/<?php echo $game['filename']?>"/>
                        </div>
                        <div class="game-rank-symbol">
                            <img class="game-img"src="public/icons/ranks/<?php echo $game['gamerankfilename']?>"/>
                        </div>
                        <div class="game-rank-text">
                            <?php echo $game['gamerank']?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
