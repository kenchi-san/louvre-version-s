$(function () {


    $('#appbundle_initorder_bookingDate').datepicker(
    $.datepicker.regional['fr'] = {
        closeText: 'Fermer',
        prevText: '<Préc',
        nextText: 'Suiv>',
        currentText: 'Courant',
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        dateFormat: 'DD dd MM yy', firstDay: 1,
        isRTL: false},
    $.datepicker.setDefaults($.datepicker.regional['fr']))
});



