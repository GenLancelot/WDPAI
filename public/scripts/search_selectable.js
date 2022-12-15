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
    //TODO: -
    fetch('/chat', {
        method: 'POST',
        body: {
            selected:'1'
        }});
   //window.location.assign("/chat");
});

