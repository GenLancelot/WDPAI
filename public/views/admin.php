<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/styleselect.css">
    <title>Admin Panel</title>
</head>
<body>
<div class="container settings">
    <img src="public/icons/logout.svg" onclick="window.location.assign('/logout')" class="logouticon adminlogout"/>
    <div class="profile-container">
        <div class="adminmessage">
            You are logged in as admin! You can add new game to the game database!<br>

            <?php
            if(isset($messages)){
                foreach ($messages as $message) {
                    echo $message;
                }
            }?>

        </div>
        <form class="adminform" action="admin" method="POST" ENCTYPE="multipart/form-data">
            <input name="gamename" type="text" placeholder="Provide game name!">
            <input name="gameicon" class="fileinput" type="file">
            <button class="adminsendbtn" type="submit">Add game to the games library</button>
        </form>
    </div>
</div>
</body>
