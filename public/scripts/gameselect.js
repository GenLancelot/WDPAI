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
            //TODO - fix onclick
            let li = `<li onclick="updateRankName(this)" class="${isSelected}">${rank}</li>`;
            this.rankoptions.insertAdjacentHTML("beforeend", li);
        });
    }

    updateRankName(selectedLi) {
        this.ranksearchInp.value = "";
        this.addRank(selectedLi.innerText);
        this.rankwrapper.classList.remove("active");
        this.rankselectBtn.firstElementChild.innerText = selectedLi.innerText;
    }
}

const wrapper = document.querySelector(".gameselect-wrapper"),
    selectBtn = wrapper.querySelector(".gameselect-btn"),
    searchInp = wrapper.querySelector(".gameinput"),
    options = wrapper.querySelector(".gameoptions");

const gamesContainer = document.querySelector('.player-games');

let notUserGames = [];
let UserGames = [];

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
    fetchedGames.forEach(game => {
        notUserGames.push(game.name);
    });
    addGame();
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

