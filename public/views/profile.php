<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="/public/css/styleselect.css">
    <script src="public/scripts/changeUrlBg.js"></script>
    <title>Profile</title>
</head>
<body>
<div class="container settings">

    <div class="profile-container">
        <div class="player-wall">
            <div class="player-icon">
                <script>
                    const url = `<?php echo $icon;?>`;
                    const urlBg = `<?php echo $bg;?>`;
                    changeIcon(url);
                    changeBg(urlBg);
                </script>
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
                            <img class="game-img" src="public/icons/ranks/<?php echo $game['gamerankfilename']?>"/>
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