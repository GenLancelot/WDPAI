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
                Unnamed Player
            </div>
        </div>

        <div class="profile-info">
            <?php if(isset($messages)){
                foreach ($messages as $message) {
                    echo $message;
                }
            }?>
            <div class="player-description">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
            <div class="player-games">
                <div class="game">
                    <div class="game-icon">
                        <img class="game-img" src="../icons/games/LoL_icon.svg"/>
                    </div>
                    <div class="game-rank-symbol">
                        <img class="game-img"src="../icons/Lol/gold.png"/>
                    </div>
                    <div class="game-rank-text">
                        Gold III
                    </div>
                </div>
                <div class="game">
                    <div class="game-icon">
                        <img class="game-img" src="../icons/games/counter-strike-global-offensive-2-logo-svgrepo-com.svg"/>
                    </div>
                    <div class="game-rank-symbol">
                        <img class="game-img" src="../icons/ranks/csgo_global-offensive.png"/>
                    </div>
                    <div class="game-rank-text">
                        Supreme
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>