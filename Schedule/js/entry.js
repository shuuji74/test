window.addEventListener("scroll", progressBar, false);
window.addEventListener("load", progressBar, false);
window.addEventListener("resize", progressBar, false);

function progressBar() {
  article = document.querySelector("article");

  if (article) {
    windowHeight = window.innerHeight;
    scrollTop = window.scrollY || window.pageYOffset;
    scrollbottom = scrollTop + windowHeight;

    articleHeight = article.clientHeight;
    articleTop = article.offsetTop;
    articleBottom = articleTop + articleHeight;

    progressTop = scrollbottom;
    progressBottom = articleBottom;

    progress = (progressTop / progressBottom) * 100;

    progressBar = document.getElementById("js-progress-bar");

    if (scrollbottom > windowHeight && scrollbottom < articleBottom) {
      progressBar.setAttribute("value", progressInt);
    } else {
      progressBar.setAttribute("value", 100);
    }
  }
}