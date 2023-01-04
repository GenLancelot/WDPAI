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

function loadUser(user){
    if(user === null){
        playerInfo.innerHTML = 'No more users to find!';
        playerName.innerHTML = '';
        playerIcon.style.backgroundImage = 'url(public/photos/404.png)';
        return;
    }
    playerInfo.innerHTML = user['description'];
    playerIcon.style.backgroundImage = `url(public/photos/${user['icon_path']})`;
    playerName.innerHTML = user['email'];
}
