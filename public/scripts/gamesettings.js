class GameRank{

    constructor(number, gamename) {
        this.number = number;
        this.rankwrapper = document.getElementsByClassName("rankselect-wrapper")[this.number];
        this.rankselectBtn = this.rankwrapper.querySelector(".rankselect-btn");
        this.ranksearchInp = this.rankwrapper.querySelector(".rankinput");
        this.rankoptions = this.rankwrapper.querySelector(".rankoptions");
        this.ranks = [];
        const data = {search: gamename};
        fetch("/getgameranks", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then((response) =>
             response.json()
        ).then((fetchedRanks) => {
            fetchedRanks.forEach(rank => {
                this.ranks.push(rank.name);
            });
        }).then(() => {this.addRank()});

        this.ranksearchInp.addEventListener("keyup", () => {
            let arr = [];
            let searchWord = this.ranksearchInp.value.toLowerCase();
            arr = this.ranks.filter(data => {
                return data.toLowerCase().startsWith(searchWord);
            }).map(data => {
                let isSelected = data === this.rankselectBtn.firstElementChild.innerText ? "selected" : "";
                return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
            }).join("");
            this.rankoptions.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Rank not found</p>`;
        });

        this.rankselectBtn.addEventListener("click", () => this.rankwrapper.classList.toggle("active"));
    }


    addRank(selectedRank)
    {
        this.rankoptions.innerHTML = "";
        this.ranks.forEach(rank => {
            let isSelected = rank === selectedRank ? "selected" : "";
            let li = document.createElement('li');
            li.setAttribute('class', `${isSelected}`);
            li.innerHTML = `${rank}`;
            li.addEventListener("click", () => this.updateRankName(li));
            this.rankoptions.appendChild(li);
        });
    }

    updateRankName(selectedLi) {
        this.ranksearchInp.value = "";
        this.addRank(selectedLi.innerText);
        this.rankwrapper.classList.remove("active");
        this.rankselectBtn.firstElementChild.innerText = selectedLi.innerText;
    }
}

class Game {
    constructor(game, gamerank) {
        this.game = game;
        this.gamerank = gamerank;
    }
}

const wrapper = document.querySelector(".gameselect-wrapper"),
    selectBtn = wrapper.querySelector(".gameselect-btn"),
    searchInp = wrapper.querySelector(".gameinput"),
    options = wrapper.querySelector(".gameoptions");

const gamesContainer = document.querySelector('.player-games');

const gameAddBtn = document.querySelector('.add-game-button');
gameAddBtn.addEventListener('click', () => addNewUserGame());

const saveAllBtn = document.querySelector('.submit-every-setting');
saveAllBtn.addEventListener('click', () => saveAllInfo());

function saveAllInfo(){
    const newDesciption = document.querySelector('.player-description').querySelector('textarea').value;

    const newIcon = document.getElementById('icon-file').files[0];
    const newBackground = document.getElementById('background-file').files[0];

    //gamesAndRanks = [];
   var json = '{\n';
    games.forEach(currentGame =>{
       const name = currentGame.game.name;
       const rank = currentGame.gamerank.rankselectBtn.querySelector('span.current-rank-state').innerHTML;
        json += '\"' + name + '\"' + ":" + '\"' + rank +'\"' + ',\n';
    });
    json += '\"description\"' + ":" + '\"' + newDesciption + '\"' + '\n';
    json += '}';
    const data = JSON.parse(json);
    const fileData = new FormData();
    if (newIcon !== undefined){
        fileData.append('icon-file', newIcon);
    }
    if(newBackground !== undefined){
        fileData.append('background-file', newBackground);
    }

    fetch('/retrieveNewUserData',{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then( (response) => {
        location.reload();
    });

    fetch('/settings_file_edit',{
        method: "POST",
        body: fileData
    }).then( (response) => {
        location.reload();
    });
}

function addNewUserGame(){
    const gamename = selectBtn.querySelector('span').innerHTML;

    const data ={'gamename' : gamename};
    fetch('/addNewUserGame',{
        method: "POST",
        headers: {
        'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then( () => {location.reload();});
}

let notUserGames = [];
let UserGames = [];
let games = [];

const data = {search: " "};
fetch("/getnotusergames", {
    method: "POST",
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
}).then(function (response) {
    return response.json();
}).then(function (fetchedGames) {
    if(fetchedGames !== null){
        fetchedGames.forEach(game => {
            notUserGames.push(game.name);
        });
        addGame();
    }
    else{
        wrapper.parentElement.parentElement.remove();
    }
});

fetch("/getusergames", {
    method: "POST",
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
}).then(function (response) {
    return response.json();
}).then(function (fetchedGames) {
    fetchedGames.forEach(game => {
        UserGames.push(game);
    });
    loadGames();
});

function loadGames(){
    UserGames.forEach((game, index) => {
        createGame(game,index);
    })
}

function createGame(game, number){
    const template = document.querySelector("#gameSettingTemplate");

    const clone = template.content.cloneNode(true);

    const icon = clone.querySelector("img");
    icon.src = `public/icons/games/${game.filename}`;
    const name = clone.querySelector(".current-rank-state");
    name.innerHTML = game.gamerank;
    gamesContainer.appendChild(clone);
    const thisGameRank = new GameRank(number, game.name);
    thisGameRank.addRank();
    games.push(new Game(game, thisGameRank));
}

function addGame(selectedGame) {
    options.innerHTML = "";
    notUserGames.forEach(game => {
        let isSelected = game === selectedGame ? "selected" : "";
        let li = `<li onclick="updateName(this)" class="${isSelected}">${game}</li>`;
        options.insertAdjacentHTML("beforeend", li);
    });
}
addGame();

function updateName(selectedLi) {
    searchInp.value = "";
    addGame(selectedLi.innerText);
    wrapper.classList.remove("active");
    selectBtn.firstElementChild.innerText = selectedLi.innerText;
}

searchInp.addEventListener("keyup", () => {
    let arr = [];
    let searchWord = searchInp.value.toLowerCase();
    arr = notUserGames.filter(data => {
        return data.toLowerCase().startsWith(searchWord);
    }).map(data => {
        let isSelected = data === selectBtn.firstElementChild.innerText ? "selected" : "";
        return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
    }).join("");
    options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Game not found</p>`;
});

selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));

