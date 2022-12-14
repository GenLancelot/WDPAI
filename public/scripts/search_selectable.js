const games = document.getElementsByClassName('gamebox');
const next = document.querySelector('button[id="next"]');
const skip = document.querySelector('button[id="skip"]');


Array.from(games).forEach((game) => {
    game.addEventListener('click', () =>{
        Array.from(games).forEach((otherGame) => {
            otherGame.classList.remove('selected');
            });
        game.classList.add("selected");
    });
});

next.addEventListener('click', () =>{
    const selected = document.getElementsByClassName('selected');
    if(selected.length === 0){
        goToFindPlayer();
    }
    const id = selected[0].getAttribute('id');
    const data = {"selected" : id};
    fetch('/gameselection', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(() => {
        goToFindPlayer();
    });
});

skip.addEventListener('click', () =>{
    goToFindPlayer();
});

function goToFindPlayer(){
    window.location.assign("/main");
}