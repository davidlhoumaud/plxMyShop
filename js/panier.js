function onCheckClick(Id, callback) {
 var e = document.getElementById(Id);
 e.onclick = function (item) {
  return function () {
   callback(item);
  };
 }(e);
};
onCheckClick('choixCadeau', function (e){
 if(e.checked)
  document.getElementById('conteneurNomCadeau').style.display = "initial";
 else
  document.getElementById('conteneurNomCadeau').style.display = "";
});