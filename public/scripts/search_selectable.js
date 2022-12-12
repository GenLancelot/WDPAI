const games = document.getElementsByClassName('gamebox');
const next = document.querySelector('button[id="next"]');
const skip = document.querySelector('button[id="skip"]');

console.log(next);
console.log(skip);

Array.from(games).forEach((game) => {
    game.addEventListener('click', () =>{
        Array.from(games).forEach((otherGame) => {
            otherGame.classList.remove('selected');
            });
        game.classList.add("selected");
    });
});

next.addEventListener('click', () =>{
    myAjax();
});

function myAjax() {
    $.ajax({
        type: "POST",
        url: '/chat',
        data:{action:'call_this'},
        success:function(html) {
            alert(html);
        }

    });
}