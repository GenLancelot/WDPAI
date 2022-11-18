<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/style.css">

    <title>Login to Teamfinder</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <div id="logotext">Teamfinder</div>
            <div id="sublogo">Find people to play games!</div>
        </div>
        <div class="login-container">
            <form action="login" method="POST">
                <div id="loginform">
                    <div class="message">
                        <?php if(isset($messages)){
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }?>
                    </div>
                    <h1>Login to our app</h1>
                    <input name="email" type="text" placeholder="unnamedplayer@gmail.com">
                    <input name="password" type="password" placeholder="password">
                    <button type="submit">Next</button>
                </div>
                <p id="registration">Or sing up <a>here!</a></p>
            </form>
        </div>
    </div>
</body>