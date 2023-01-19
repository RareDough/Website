// leader board changer
document.querySelector(".leftArrow").style.display="none"  
function shiftLeft(){
  document.querySelector(".leftArrow").style.display="inline-block"
  document.querySelector(".rightArrow").style.display="none"
  document.getElementById("tableChange1").src="./img/tableTweet.svg"
  document.getElementById("tableChange2").src="./img/tableUser.svg"
  document.getElementById("tableChange3").src="./img/tableMsg.svg"

  document.querySelector('.retweet').classList.add("tweet")
  document.querySelector('.msg').classList.add("user")
  document.querySelector('.like').classList.add("msg")
}
function shiftRight(){
  document.querySelector(".leftArrow").style.display="none"  
  document.querySelector(".rightArrow").style.display="inline-block"
  document.getElementById("tableChange1").src="./img/change.svg"
  document.getElementById("tableChange2").src="./img/tableMsg.svg"
  document.getElementById("tableChange3").src="./img/heart.svg"

  document.querySelector('.retweet').classList.remove("tweet")
  document.querySelector('.like').classList.remove("msg")
  document.querySelector('.msg').classList.remove("user")
}

// responsive leader board buttons
let count=1
$(".toolTip.resp").addClass(`toolTip1`)
function respTable(arrow){
  if(arrow==="right"){
    if(count<5){
      $("#tableChangeResp").attr("src",`./img/t${++count}.svg`)
      $(".toolTip.resp").addClass(`toolTip${count}`)
    }
  }
  if(arrow==="left"){
    if(count>1){
      $("#tableChangeResp").attr("src",`./img/t${--count}.svg`)
      console.log($(".toolTip.resp").removeClass(`toolTip${count+2}`));
      $(".toolTip.resp").removeClass(`toolTip${count+1}`)
    }
  }
}