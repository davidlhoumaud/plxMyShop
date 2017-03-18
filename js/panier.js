jQuery(function ($) {
 afficherConteneurNomCadeau($);
 $("#choixCadeau").click(function () {afficherConteneurNomCadeau($);});
});
function afficherConteneurNomCadeau($) {
 var conteneurNomCadeau = $(".conteneurNomCadeau");
 if ($("#choixCadeau").prop("checked")) {
  conteneurNomCadeau.show();
 } else {
  conteneurNomCadeau.hide();
 }
}