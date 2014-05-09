function mayuscula(campo){
        $(campo).keyup(function() {
                       $(this).val($(this).val().toUpperCase());
        });
}