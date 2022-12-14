<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/styleselect.css">

    <title>Teamfinder - chat</title>
</head>
<body>
<?php if(isset($messages)){
    foreach ($messages as $message) {
        echo $message;
    }
}?>
    <div class="container">
        <div class="headline">
            <img src="public/icons/logout.svg" onclick="window.location.assign('/logout')" class="logouticon"/>
            <a onclick="window.location.assign('/main')">Find Player</a>
            <a class="currentactive">Friends</a>
            <img src="public/icons/user.svg" onclick="window.location.assign('/settings')" class="usericon"/>
        </div>
        <div class="chat">
           <div class="messages">
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
                <div class="player-message">
                    <div class="player-icon-box" >
                        <div class="player-chat-icon"></div>
                        <div class="player-status-icon"></div>
                    </div>
                    <div class="player-name" >player 1</div>
                    <div class="player-last-message" >last sent message</div>
                    <div class="player-status">status</div>
                </div>
           </div>
           <div class="current-conversation">
            <div class = "headline-conversation">Player 1</div>    
            <div class = "conversation-screen">
                <div class = "message-row-receiver">
                    <div class="message-time">10:51</div>
                    <div class="message receiver">Hey</div>
                </div>
                <div class = "message-row">
                    <div class="message-time">10:50</div>
                    <div class="message sender">Hey</div>
                </div>    
            </div>
            <div class = "conversation-type">
                <input class="chat-type-inputbox" placeholder="type here"/>
                <img src="public/icons/send.svg" />
            </div>
           </div>
        </div>
        <div class="empty-space">

        </div>
    </div>
</body>
