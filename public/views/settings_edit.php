<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/styleselect.css">


    <title>Settings</title>
</head>
<body>
<div class="container settings">

    <div class="profile-container">
        <div class="player-wall">
            <div class="player-icon profile-view">
            </div>
            <div class="player-nickname">
                Unnamed Player
            </div>
        </div>

        <div class="profile-info">
            <form action="settings" method="POST" ENCTYPE="multipart/form-data">
                <?php if(isset($messages)){
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }?>
            <input type="file" name="background-file">
            <button type="submit">Send background file</button>
            </form>
            <div class="player-description">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
            <div class="player-games">
                <form>
                    <div class = "game">
                        <div class="gameselect-wrapper">
                            <div class="gameselect-btn">
                                <span>Select Game</span>
                            </div>
                            <div class="gameselect-content">
                                <div class="gamesearch">
                                    <input class="gameinput" spellcheck="false" type="text" placeholder="Search">
                                </div>
                                <ul class="gameoptions"></ul>
                            </div>
                        </div>

                        <button class="add-game-button" type="submit">Add game</button>
                    </div>
                </form>
                <div class="game">
                    <div class="game-icon">
                        <img class="game-img" src="../icons/games/LoL_icon.svg"/>
                    </div>
                    <div class="game-rank-text">
                        <div class="rankselect-wrapper">
                            <div class="rankselect-btn">
                                <span>Select rank</span>
                            </div>
                            <div class="rankselect-content">
                                <div class="ranksearch">
                                    <input class ="rankinput" spellcheck="false" type="text" placeholder="Search">
                                </div>
                                <ul class="rankoptions"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="game">
                    <div class="game-icon">
                        <img class="game-img" src="../icons/games/counter-strike-global-offensive-2-logo-svgrepo-com.svg"/>
                    </div>
                    <div class="game-rank-text">
                        Supreme
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="public/scripts/gameselect.js"></script>
</div>
</body>