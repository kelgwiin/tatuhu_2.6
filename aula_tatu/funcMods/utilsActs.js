/*
 * Registra una actividad realizada por un
 * estudiante
 * @idEst identificador del estudiante en la BD
 * @idAct identificador de la actividad de la BD
 */
function registrarActividad(idEst, idAct){
    if(idEst !== "" && idAct !== ""){
         $.get( 'registroActividad.php', {estudiante:idEst,actividad:idAct}).done(function(data) {
             if(data === "true")  return true;
             return false;
         });
    }
}