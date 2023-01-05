<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/styleselect.css">
    <script src="public/scripts/friendsselection.js" defer></script>
    <title>Looking for teammate</title>
</head>
<body>
    <div class="container">
        <div class="headline">
            <a class="currentactive">Find Player</a>
            <a onclick="window.location.assign('/chat')">Friends</a>
            <img src="public/icons/user.svg" onclick="window.location.assign('/settings')" class="usericon"/>
        </div>
        <div class="info-container">
            <div>
                <div class="player-icon">

                </div>
                <div class="player-nickname">

                </div>
            </div>
            <div class="player-info">
                <p>
                </p>
            </div>
        </div>
        <div class="buttons">
            <button class = "button-nostyle" id="rejectbutton"><img src="public/icons/decline.svg"/></button>
            <button class = "button-nostyle" id="acceptbutton"><img src="public/icons/approve.svg"/></button>
        </div>

    </div>
</body>