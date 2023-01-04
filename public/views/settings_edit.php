<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/styleselect.css">


    <title>Settings</title>
</head>
<body>
<div class="container settings">

    <div class="profile-container">
        <div class="player-wall">
            <div class="player-icon" style='background-image: url("public/photos/<?php echo $icon?>")'>
            </div>
            <div class="player-nickname">
                Unnamed Player
            </div>
        </div>

        <div class="profile-info">
            <form class="settingseditform" action="settings_file_edit" method="POST" ENCTYPE="multipart/form-data">
                <div class="settings_fileinput">
                    <div class="settings_filetext">New background:</div>
                    <input class= "fileinput" type="file" name="background-file" id="background-file">
                </div>
                <div class="settings_fileinput">
                    <div class="settings_filetext">New icon:      </div>
                    <input class="fileinput"type="file" name="icon-file" id="icon-file">
                </div>
                <button class="settings_filesend" type="submit">Send background files</button>
            </form>
            <div class="player-description">
                <textarea placeholder="Provide your description!"></textarea>
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

                        <button class="add-game-button" type="button">Add game</button>
                    </div>
                </form>
            </div>
            <div>
                <button class="submit-every-setting" type="button">Save</button>
            </div>
        </div>
    </div>
    <script src="public/scripts/gamesettings.js"></script>
</div>
</body>

<template id="gameSettingTemplate">
    <div class="game">
        <div class="game-icon">
            <img class="game-img" src=""/>
        </div>
        <div class="game-rank-text">
            <div class="rankselect-wrapper">
                <div class="rankselect-btn">
                    <span class="current-rank-state"></span>
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
</template>