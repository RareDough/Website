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
  // console.log(currentPosition);
  if (currentPosition > 70) {
    $("#mobHideMenu, #stickyNavbar").css("background", "black");
  } else {
    $("#mobHideMenu, #stickyNavbar").css("background", "unset");
  }
});

// load more
function loadMore(){
    $("#loadMore").removeClass("loadMore");
    $(".loadMoreMob").removeClass("loadMore");

  // document.querySelector(".loadMoreMob").classList.remove("loadMore")
}

// scroll bar
let lastScrollTop=0
let navBar=document.querySelector(".navbar")
window.addEventListener("scroll",()=>{
  let scrollTop=window.pageYOffset||document.documentElement.scrollTop
  if(scrollTop>lastScrollTop){
    navBar.style.top="-100px"
  }
  else{
    navBar.style="top:0;background-color:rgba(0,0,0,0.7);"

  }
  lastScrollTop=scrollTop
  if(lastScrollTop===0){
    navBar.style="background-color:transperent;"
  }
})

// get page
const page = document.body.dataset.page;

// copy text
document.querySelectorAll('.copyTextTrigger').forEach(el => {
  el.addEventListener('click', e => {
    let text = el.querySelector('.copyText').getAttribute('data-copy');
    navigator.clipboard.writeText(text);
    alert('Wallet address copied');
  })
})