<!DOCTYPE html>
<head>
    <link rel="stylesheet"  type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="public/scripts/script.js" defer></script>
    <title>Register to Teamfinder</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <div id="logotext">Teamfinder</div>
            <div id="sublogo">Find people to play games!</div>
        </div>
        <div class="login-container">
            <form action="registration" method="POST">
                <div id="loginform">
                    <h1>Register to our app</h1>
                    <input name="email" type="text" placeholder="unnamedplayer@gmail.com" >
                    <input name="password" type="password" placeholder="password">
                    <input name="confirmedpassword" type="password" placeholder="confirm password">
                    <button type="submit">Next</button>
                </div>
                <p id="registration">Or sing in <a href="/login">here!</a></p>
            </form>
        </div>
    </div>
</body>