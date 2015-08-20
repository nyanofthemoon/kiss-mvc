

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{"required":{    			// Add your regex rules here, you can take telephone as an example
						"regex":"none",
						"alertText":"&#149; This field is required",
						"alertTextCheckboxMultiple":"&#149; Please select an option",
						"alertTextCheckboxe":"&#149; This checkbox is required"},
					"length":{
						"regex":"none",
						"alertText":"&#149; Between ",
						"alertText2":" and ",
						"alertText3": " characters allowed"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"&#149; Checks allowed Exceeded"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"&#149; Please select ",
						"alertText2":" options"},	
					"confirm":{
						"regex":"none",
						"alertText":"&#149; Your field is not matching"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"&#149; Invalid phone number"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"&#149; Invalid email address"},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"&#149; Invalid date, must be in YYYY-MM-DD format"},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"&#149; Numbers only"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"&#149; No special caracters allowed"},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"&#149; This user is available",	
						"alertTextLoad":"&#149; Loading, please wait",
						"alertText":"&#149; This user is already taken"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"&#149; This name is already taken",
						"alertTextOk":"&#149; This name is available",	
						"alertTextLoad":"&#149; Loading, please wait"},		
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"&#149; Letters only"},
					"validate2fields":{
    					"nname":"validate2fields",
    					"alertText":"&#149; You must have a firstname and a lastname"}	
					}	
					
		}
	}
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});