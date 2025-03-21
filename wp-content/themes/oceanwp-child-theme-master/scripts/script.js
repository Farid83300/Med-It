

/* ////////////  Correction du script pour que la popup se ferme en cliquant sur la croix \\\\\\\\\\\\
     Pour éviter tous conflits,  Le code est placé dans une fonction anonyme jQuery(document).ready(function($) {...}) qui :
- Attend que le document soit prêt
- Utilise $ comme alias de jQuery sans risque de conflit avec d'autres bibliothèques */
jQuery(document).ready(function($) {
    $('.popup-close').on('click', function() {
        $('.popup-overlay').hide();
    });
});