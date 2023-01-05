var css = document.styleSheets[0];

function changeIcon(newUrl) {
    const url = `url(../../public/photos/${newUrl})`;
    myRule = css.cssRules[11];
    myRule.style.backgroundImage = url;
}

function changeBg(newUrl) {
    const url = `url(../../public/photos/${newUrl})`
    myRule = css.cssRules[45];
    myRule.style.backgroundImage = url;
}