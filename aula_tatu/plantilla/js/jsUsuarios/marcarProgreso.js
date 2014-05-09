function send(est, act, tipo, area, comp, cont, ult){
       $.ajax({
        url: '../../estudiante/procesos/agregarActividad.php?id_estudiante='+est+'&id_actividad='+act+'&tipo='+tipo+'&area='+area+'&componente='+comp+'&contenido='+cont+'&ultima='+ult,
        type: 'get',
        dataType: 'html',
        async: false,
        success: function(data) {
            result = data;
        } 
     });
     return result;
}

function progress(tipo){
    this.recompensas = "";
    this.gets = [];
    this.direccion = "";
    this.marcarProgreso = function(tipo){
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
        });
        this.gets = vars;
         this.recompensas = send(this.gets["idEstudiante"],this.gets["idActividad"],tipo, this.gets["area"],this.gets["componente"], this.gets["contenido"], this.gets["ultima"]);
          this.direccion = "../../estudiante/contenido_seleccionado.php?id_contenido="+this.gets["contenido"]+"&id_area="+this.gets["area"]+"&id_componente="+this.gets["componente"]+"&pos="+this.gets["pos"]+"&rec="+this.recompensas;
    }
    this.redireccion = function (){
            top.location.href=this.direccion;
    }
}

