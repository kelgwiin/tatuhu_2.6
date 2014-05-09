/* Reproduce un sonido cargado en la etiqueta <audio> 
 * @id es el id de la etiqueta <audio>
 */
playing = false;

function play(id){
   if (!window.playing){
        audios = document.getElementById(id);
        audios.play();
        window.playing=true;
   }
}

function stop(id){
   if (window.playing){
        audios = document.getElementById(id);
        audios.pause();
        window.playing=false;
   }
}

/*
 * Reproduce un sonido al hacer hover sobre un elemento o un listado
 * @id es el id de la etiqueta <audio>
 * @elem es el id o class de los elementos sobre los cuales se aplicara el
 * audio en el formato jQuery, Ej: .contenido li, #lista a...
 */

function playOnHover(id,elem){
        $(elem).each(function(i) {
          if (i != 0) { 
            $("#" + id)
              .clone()
              .attr("id", id + i)
              .appendTo($(this).parent()); 
          }
          $(this).data("sonido", i);
        })
        .mouseenter(function() {
          $("#"+id + $(this).data("sonido"))[0].play();
        });
        $("#"+id).attr("id", id+"0");
}