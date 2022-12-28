const wrapper = document.querySelector(".gameselect-wrapper"),
    selectBtn = wrapper.querySelector(".gameselect-btn"),
    searchInp = wrapper.querySelector(".gameinput"),
    options = wrapper.querySelector(".gameoptions");

const rankwrapper = document.querySelector(".rankselect-wrapper"),
    rankselectBtn = rankwrapper.querySelector(".rankselect-btn"),
    ranksearchInp = rankwrapper.querySelector(".rankinput"),
    rankoptions = rankwrapper.querySelector(".rankoptions");

let games = [];

const data = {search: " "};
fetch("/search", {
    method: "POST",
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
}).then(function (response) {
    return response.json();
}).then(function (fetchedGames) {
    fetchedGames.forEach(game => {
        games.push(game.name);
        console.log(game[0]);
    });
    addGame();
});

let ranks = ["Bronze I","Bronze II","Bronze III","Bronze IV",];

function addGame(selectedGame) {
    options.innerHTML = "";
    games.forEach(game => {
        let isSelected = game === selectedGame ? "selected" : "";
        let li = `<li onclick="updateName(this)" class="${isSelected}">${game}</li>`;
        options.insertAdjacentHTML("beforeend", li);
    });
}
addGame();
function addRank(selectedRank) {
    rankoptions.innerHTML = "";
    ranks.forEach(rank => {
        let isSelected = rank === selectedRank ? "selected" : "";
        let li = `<li onclick="updateRankName(this)" class="${isSelected}">${rank}</li>`;
        rankoptions.insertAdjacentHTML("beforeend", li);
    });
}
addRank();

function updateName(selectedLi) {
    searchInp.value = "";
    addGame(selectedLi.innerText);
    wrapper.classList.remove("active");
    selectBtn.firstElementChild.innerText = selectedLi.innerText;
}

function updateRankName(selectedLi) {
    ranksearchInp.value = "";
    addRank(selectedLi.innerText);
    rankwrapper.classList.remove("active");
    rankselectBtn.firstElementChild.innerText = selectedLi.innerText;
}

searchInp.addEventListener("keyup", () => {
    let arr = [];
    let searchWord = searchInp.value.toLowerCase();
    arr = games.filter(data => {
        return data.toLowerCase().startsWith(searchWord);
    }).map(data => {
        let isSelected = data === selectBtn.firstElementChild.innerText ? "selected" : "";
        return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
    }).join("");
    options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Game not found</p>`;
});

ranksearchInp.addEventListener("keyup", () => {
    let arr = [];
    let searchWord = ranksearchInp.value.toLowerCase();
    arr = ranks.filter(data => {
        return data.toLowerCase().startsWith(searchWord);
    }).map(data => {
        let isSelected = data === rankselectBtn.firstElementChild.innerText ? "selected" : "";
        return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
    }).join("");
    rankoptions.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Rank not found</p>`;
});

selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));
rankselectBtn.addEventListener("click", () => rankwrapper.classList.toggle("active"));