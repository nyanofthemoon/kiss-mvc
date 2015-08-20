

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = {"required":{    
						"regex":"none",
						"alertText":"&#149; Ce champs est requis",
						"alertTextCheckboxMultiple":"&#149;Choisir une option",
						"alertTextCheckboxe":"&#149; Ce checkbox est requis"},
					"length":{
						"regex":"none",
						"alertText":"&#149; Entre ",
						"alertText2":" et ",
						"alertText3":" caractères requis"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"&#149; Nombre max the boite exceder"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"&#149; Veuillez choisir ",
						"alertText2":" options"},		
					"confirm":{
						"regex":"none",
						"alertText":"&#149; Votre champs n'est pas identique"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"&#149; Numéro de téléphone invalide"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"&#149; Adresse email invalide"},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"&#149; Date invalide, format YYYY-MM-DD requis"},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"&#149; Chiffres seulement accepté"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"&#149; Aucune caractère spécial accepté"},	
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"&#149; Lettres seulement accepté"},
					"ajaxUser":{
						"file":"validateUser.php",
						"alertTextOk":"&#149; Ce nom est déjà pris",	
						"alertTextLoad":"&#149; Chargement, veuillez attendre",
						"alertText":"&#149; Ce nom est déjà pris"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"&#149; Ce nom est déjà pris",
						"alertTextOk":"&#149;Ce nom est disponible",	
						"alertTextLoad":"&#149; LChargement, veuillez attendre"},
					"validate2fields":{
    					"nname":"validate2fields",
    					"alertText":"Vous devez avoir un prénom et un nom"}	
					}	
		}
	}
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});