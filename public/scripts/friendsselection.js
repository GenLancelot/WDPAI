const acceptBtn = document.getElementById('acceptbutton');
const declineBtn = document.getElementById('rejectbutton');
const playerInfo = document.querySelector('.player-info').querySelector('p');
const playerIcon = document.querySelector('.player-icon');
const playerName = document.querySelector('.player-nickname');


acceptBtn.addEventListener('click', () => getNextUser(true));
declineBtn.addEventListener('click', () => getNextUser(false));

fetch('/getnextuser',{
    method: "POST",
    headers: {
        'Content-Type': 'application/json'
    }
}).then( (response) => {
    return response.json();
}).then(nextUser => {
    loadUser(nextUser);
});

function getNextUser(approved){
    let data;
    if(approved === true){
        data = {
            'action' : true,
            'email' : playerName.innerHTML
        };
    }
    else{
        data = {
            'action' : false,
            'email' : playerName.innerHTML
        };
    }

    fetch('/getnextuser',{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then( (response) => {
        return response.json();
    }).then(nextUser => {
        loadUser(nextUser);
    });
}
var css = document.styleSheets[0];

function changeIcon(newUrl) {
    myRule = css.cssRules[11];
    myRule.style.backgroundImage = newUrl;
}

function loadUser(user){
    if(user === null){
        playerInfo.innerHTML = 'No more users to find!';
        playerName.innerHTML = '';
        changeIcon('url(../../public/photos/404.png)');
        return;
    }
    playerInfo.innerHTML = user['description'];
    changeIcon(`url(../../public/photos/${user['icon_path']})`);
    playerName.innerHTML = user['email'];
}
