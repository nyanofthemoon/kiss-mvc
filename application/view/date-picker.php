<script language="javascript" type="text/javascript">
$(function() {
<?php if ($language == Language::FRENCH) { ?>
	$('.date-picker').datepicker({ dateFormat: 'yy-mm-dd', showAnim: 'slideDown', showOtherMonths: true, numberOfMonths: 1, maxDate: '+0D', dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'], monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] });
<?php } else { ?>
    $('.date-picker').datepicker({ dateFormat: 'yy-mm-dd', showAnim: 'slideDown', showOtherMonths: true, numberOfMonths: 1, maxDate: '+0D' });
<?php } ?>
});
</script>