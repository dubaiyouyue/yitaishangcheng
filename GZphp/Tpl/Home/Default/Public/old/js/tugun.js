<!--//
//使用div时，请保证colee_left2与colee_left1是在同一行上.

var speed=30;//速度数值越大速度越慢
var colee_left2=window.document.getElementById("colee_left2");
var colee_left1=window.document.getElementById("colee_left1");
var colee_left=window.document.getElementById("colee_left");
colee_left2.innerHTML=colee_left1.innerHTML;
function Marquee(){
if(colee_left2.offsetWidth-colee_left.scrollLeft<=0)//offsetWidth 是对象的可见宽度
colee_left.scrollLeft-=colee_left1.offsetWidth;//scrollWidth 是对象的实际内容的宽，不包边线宽度
else{
colee_left.scrollLeft++;
}
}
var MyMar=setInterval(Marquee,speed);
colee_left.onmouseover=function() {clearInterval(MyMar)};
colee_left.onmouseout=function() {MyMar=setInterval(Marquee,speed)};
//-->