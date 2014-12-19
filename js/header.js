
//初始化
var def="1";
function mover(object){
  //主菜单
  var mm=document.getElementById("m_"+object);
  mm.className="m_li_a";
  //初始主菜单隐藏效果

  //子菜单
  var ss=document.getElementById("s_"+object);
  ss.style.display="block";
  //初始子菜单隐藏效果

}
function mout(object){
  //主菜单
  
  var mm=document.getElementById("m_"+object);
  mm.className="m_li";
  //子菜单
  var ss=document.getElementById("s_"+object);
  ss.style.display="none";
}

//待完成的
function mclick(object){
  var temp=object;
  var mm=document.getElementById("m_"+temp);
  mm.className="m_li_a";

}










