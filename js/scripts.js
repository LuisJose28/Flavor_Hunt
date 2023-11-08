$(document).ready(function(){
    $('.label-menu li a:first').addClass('active'); /* Aqui estamos diciendo que le agregaremos la clase active, que es el color de fondo de los titulos de los tabs al estar sobre ellos */
    $('.content article').hide(); /* Ocultaremos por defecto todos los tabs */
    $('.content article:first').show(); /* Mostraremos solo el primer tab */

    $('.label-menu li a').click(function(){
        /* Cada que demos en cualquiera de los enlaces donde demos clic, le quitaremos la clase y se lo agregaremos al que le estamos dando clic */
        $('.label-menu li a').removeClass('active');
        $(this).addClass('active');

        $('.content article').hide(); /* Cada vez que hagamos clic en uno, todos los demas tabs se oculten */

        /* Esta variable nos ayudara a mostrar solo al que le hemos dado clic */
        var activeTab = $(this).attr('href');/* Creamos una variable y su valor sera el valor del atributo href a */
        $(activeTab).show();
        return false;

    });
    
    


});