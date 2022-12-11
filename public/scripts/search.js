const search = document.querySelector('input[placeholder="search game"]');
const gamesContainer = document.querySelector('.selectableobjects');


search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (games) {
            gamesContainer.innerHTML = "";
            loadGames(games)
        });
    }
});


function loadGames(games){
    games.forEach(game => {
        console.log(game);
        createGame(game);
    })
}

function createGame(game){
    const template = document.querySelector("#gameTemplate");

    const clone = template.content.cloneNode(true);

    const icon = clone.querySelector("img");
    icon.src = `public/icons/games/${game.filename}`;
    const name = clone.querySelector(".gamebox-name");
    name.innerHTML = game.name;

    gamesContainer.appendChild(clone);
}