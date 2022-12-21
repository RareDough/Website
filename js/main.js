// Hide Menu
document
  .getElementById("hideMenuIcon")
  .addEventListener("click", menuBtnHandleClick);

function menuBtnHandleClick() {
  document.getElementById("mobHideMenu").classList.toggle("show");
  document.getElementById("hideMenuIcon").classList.toggle("is-active");
}

let bodyWrapper = document.querySelectorAll(".bodyWapper");
for (let i = 0; i < bodyWrapper.length; i++) {
  bodyWrapper[i].addEventListener("click", bodyBtnHandleClick);
}
function bodyBtnHandleClick() {
  document.getElementById("mobHideMenu").classList.remove("show");
  document.getElementById("hideMenuIcon").classList.remove("is-active");
}

// Scroll for Mobile
$(window).scroll(function () {
  var currentPosition = window.scrollY;
  console.log(currentPosition);
  if (currentPosition > 70) {
    $("#mobHideMenu, #stickyNavbar").css("background", "black");
  } else {
    $("#mobHideMenu, #stickyNavbar").css("background", "unset");
  }
});
