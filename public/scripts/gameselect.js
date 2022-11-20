const wrapper = document.querySelector(".gameselect-wrapper"),
    selectBtn = wrapper.querySelector(".gameselect-btn"),
    searchInp = wrapper.querySelector("input"),
    options = wrapper.querySelector(".gameoptions");

let games = ["GTA V","CS:GO","LeagueOfLegends","FIFA","Fortnite","Warzone", "Valorant"];

function addGame(selectedGame) {
    options.innerHTML = "";
    games.forEach(game => {
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
    arr = games.filter(data => {
        return data.toLowerCase().startsWith(searchWord);
    }).map(data => {
        let isSelected = data === selectBtn.firstElementChild.innerText ? "selected" : "";
        return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
    }).join("");
    options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! Game not found</p>`;
});

selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));