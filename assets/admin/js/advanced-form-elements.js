$(function () {
 
    var $demoMaskedInput = $('.demo-masked-input');

    //Mobile Phone Number
    $demoMaskedInput.find('.mobile-phone-number').inputmask('+99 (999) 999-99-99', { placeholder: '+__ (___) ___-__-__' });

});