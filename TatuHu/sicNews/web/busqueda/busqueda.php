<style>
.ui-tooltip
{
    font-size:10pt;
    font-family:Calibri;
}
</style>
<script type="text/javascript">
    
    var nGrups, nDocs;
    
    $j(document).ready(function(){
        $j("[name='help']").tooltip();
        var param = "";
        $j.ajax({
            type: 'POST',
            url:'../src/facade/parametroFacade.php?modo=1',
            data: param,
            async: false,
            dataType: "json",				   
            success: function(data){
                nGrups = data.num_grupos;
                nDocs  = data.num_documentos;
           }

        });
     
    });
    
    function mostrarDialog(vect){
        
        //alert(vect);
        
        var palabras = vect.split(" ");        
        var param = [{name : 'idNoticia', value : palabras[0]}];
        
        palabras[0] = "";
        
        var titulo = palabras.join(" ");
        $j.ajax({
            type: 'POST',
            url:'../src/facade/noticiaFacade.php?modo=5',
            data: param,
            async: false,
            dataType: "text",				   
            success: function(data){
                
                $j("#contenidoNoticia").html(function() {

                    var imprimir = "<br><div align=\"center\">"+titulo+"</div>";
                    imprimir += "<br><br>"+data;
                    
                    return imprimir;
                });
                
                $j("#dialog-verDoc").dialog({
                    modal: true,
                    width: 700, 
                    height: "auto",
                    resizable: false, 
                    draggable: false,
                    autoOpen: false, 
                    buttons:{				
                            'Aceptar': function(){
                                $j(this).dialog('close');
                            }
                    }
                });
                $j("#dialog-verDoc").dialog('open');
                
           }

        });
        
        return 1;
    }
    
    function buscar(){

        var fechaInicial = $j('#fecha_inicial').val();
        var fechaFinal = $j('#fecha_final').val();

        if($j('#fecha_inicial').val() == ""){
            fechaInicial = "0000-00-00";
        }                
        if($j('#fecha_final').val() == ""){
            fechaFinal = "9999-99-99";
        }
        var band = true;
        if(fechaInicial < fechaFinal){            
            
            var param2 = [{name : 'numGrups', value : nGrups}];
            var temasGrupo;
            //Nombre o "Temas" de los grupos
            $j.ajax({
                type: 'POST',
                url: '../src/facade/fcmFacade.php?modo=9',
                data: param2,
                async: true,
                dataType: "json",	
                success: function(data){
                    temasGrupo = data;
                }
            });
            
            var leyenda = "1";
            var palabrasC = "2";
            //Limpiar consulta
            if($j('#pClaves').val() == ""){
                var direc = '../src/facade/fcmFacade.php?modo=7';
                palabrasC = $j('#pClaves').val();
                band = false;
            }
            else{//Limpiar palabras claves

                var direc = '../src/facade/fcmFacade.php?modo=2';  
                band = true;
                
                leyenda = $j('#pClaves').val();
                var param2 = [{name : 'palabras', value : $j('#pClaves').val()}]

                $j.ajax({
                    type: 'POST',
                    url: '../src/facade/graficoFacade.php?modo=4',
                    data: param2,
                    async: false,
                    dataType: "text",	
                    success: function(data){
                        palabrasC = data;
                    }
                });
            }

            var param = [{name : 'palabras', value : palabrasC},
                         {name : 'numGrups', value : nGrups},
                         {name : 'numDocs', value : nDocs},
                         {name : 'fechaIni', value : fechaInicial},
                         {name : 'fechaFin', value : fechaFinal}
                        ];

            $j.ajax({
                type: 'POST',
                //url: '../src/facade/fcmFacade.php?modo=2',
                url: direc,
                data: param,
                async: true,
                dataType: "text",				   
                success: function(data){

                    if(data != -1){

                        var vect = data.split("\n");
                        var idGrp = vect[0];
                        var linea = "";
                        var ids = "";
                        
                        if(band == false){
                            var vect1 = data.split("%%"); 
                            $j("#linea").empty();
                            $j("#enlaces").html(function() {
                                for(ii=1;ii<=nGrups;ii++){
                                    
                                    linea += '</br><div align=\"center\">Grupo: '+temasGrupo[ii]+'</div></br>'
                                    
                                    linea += '<div>'
                                    
                                    vect = vect1[(ii-1)].split("\n");
                                    
                                    if($j('#pClaves').val() != "")
                                        valor = 1;
                                    else
                                        valor = 0;
                                    linea += '<table>';
                                    
                                        for(i=valor;i<vect.length;i++){
                                            
                                            var vect3 = vect[i].split("##"); 

                                            var palabras = vect3[0].split(" ");  
                                            
                                            ids += palabras[0]+" ";
                                            palabras[0] = "";
                                            //alert(palabras);
                                            var titulo = palabras.join(" ");
                                            if(titulo != '') {
                                                
                                                linea += '<tr><td>';            
                                                linea += '<a href="#" onclick="mostrarNot(\''+vect3[1]+'\')";><span>'+titulo+'</span></a><br>';
                                                //linea += '<a href="./busqueda/ejemplo.php?enlace='+vect3[1]+'" TARGET=\"_blank\"><span>'+titulo+'</span></a><br>';
                                                
                                                linea += '</td>';
                                                linea += '</tr>';
                                            }
                                        }
                                    linea += '</table>';
                                    linea += '</div>'
                                }
                                return linea;
                            });      
                        }
                        else{
                            $j("#linea").empty();
                            $j("#enlaces").html(function() {
                                linea = '<div align=\"center\">Grupo: '+temasGrupo[idGrp]+'</div></br>'
                                linea += '<div id=documentos>'
                                if($j('#pClaves').val() != "")
                                    valor = 1;
                                else
                                    valor = 0;
                                linea += '<table>';
                                for(i=valor;i<vect.length;i++){
                                    
                                    var vect3 = vect[i].split("##"); 
                                    
                                    var palabras = vect3[0].split(" ");        
                                    ids += palabras[0]+" ";
                                    palabras[0] = "";
                                    var titulo = palabras.join(" ");

                                    linea += '<tr><td>';
                                    linea += '<a href="#" onclick="mostrarNot('+vect3[1]+');"><span>'+titulo+'</span></a><br>';
                                    //linea += '<a href="./busqueda/ejemplo.php?enlace='+vect3[1]+'" TARGET=\"_blank\"><span>'+titulo+'</span></a><br>';
                                    linea += '</td>';
                                    linea += '</tr>';
                                }
                                linea += '</table>';
                                linea += '<div/>'
                                return linea;
                            });
                        }

                        //CREANDO GRAFICO DE CONSULTA         
                        var fechas = fechaInicial+"<>"+fechaFinal;
                        var inicio = null, fin = null;
                        if(fechaInicial.split("-")[0] != '0000'){
                            inicio = Date.UTC(fechaInicial.split("-")[0], fechaInicial.split("-")[1], fechaInicial.split("-")[2]);
                        }
                        if(fechaFinal.split("-")[0] != '9999'){
                            fin = Date.UTC(fechaFinal.split("-")[0], fechaFinal.split("-")[1], fechaFinal.split("-")[2]);
                        }
                        
                        linea = "";
                        var i=0;    
                        var result = [];
                        var seriesOptions = [],
                            yAxisOptions = [],
                            seriesCounter = 0,
                            colors = Highcharts.getOptions().colors,
                            urlName="",
                            names = [];
                        
                        ids = ids.replace(/  /gi," ");
                        ids = ids.replace(/ /gi,"-");
                        ids = ids.replace(/--/gi,"-");
                            
                        if(band == false){//Grafico general
                            var j=0;                        
                            $j.each(temasGrupo, function(key,val){
                                result[j] = val;
                                j++;
                            });
                            names = result;
                        }
                        else{//Grafico por palabras claves
                            names = palabrasC.split(" ");
                        }                        
                        
                        //CONSULTAR INFROMACION GRAFICO
                        $j.each(names, function(i, name) {
                                $j.getJSON('../src/facade/graficoFacade.php?modo=8&idNot='+ids+"&name="+name,	function(data) {
                                        seriesOptions[i] = {
                                                name: name,
                                                data: data
                                        };
                                        seriesCounter++;

                                        if (seriesCounter == names.length) {
                                                createChart();
                                        }
                                });
                        });
                        //DIBUJAR GRAFICO
                        function createChart() {

                                $j('#container').highcharts('StockChart', {       
                                    chart: {
                                        //type: 'column'
                                    },
                                    title: {
                                        text: 'Noticias en el tiempo'
                                    },
                                    xAxis: {
                                        type: 'datetime',
                                        min:inicio,
                                        max:fin
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Relevancia'
                                        },
                                        tickInterval: 0.1,
                                        labels: {
                                                formatter: function() {
                                                        return this.value;
                                                }
                                        }
                                    },
                                    tooltip: {
                                        valueDecimals: 3    
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    exporting: {
                                             enabled: false
                                    },
                                    /*legend: {
                                        layout: 'vertical',
                                        align: 'right',
                                        verticalAlign: 'middle',
                                        borderWidth: 0
                                    },*/
                                    series: seriesOptions
                                });
                        }
                        //FIN CREANDO GRAFICO DE CONSULTA
                    }
                    else{
                        $j("#mensj-alert").html("No hay archivos para mostrar");
                        mensaje('#dialog-alerta');
                    }
                }
            });
        }
        else{
            $j("#mensj-alert").html("Inserte un rango de fecha valido");
            mensaje('#dialog-alerta');
        }

    }
    //Abrir POPUP para mostrar noticias
    function mostrarNot(url){        
        var w = window.open("../web"+url, "popupWindow", "width=900, height=600, scrollbars=yes");
        var $w = $j(w.document.body);
        $w.html('<div id="infoNot"></div>');
        return false;
    }

    function verGrahp($tipo){
    
        if($tipo == 0){
            $j("#img-graph-mes").hide('fast');
            $j("#leyendMes").hide('fast'); 
            $j("#img-graph-año").show('fast'); 
            $j("#leyendAño").show('fast'); 
            $j("#años").show('fast');    
            
        }
        else{
            $j("#años").hide('fast');    
            $j("#img-graph-año").hide('fast');  
            $j("#leyendAño").hide('fast'); 
            $j("#leyendMes").show('fast'); 
            $j("#img-graph-mes").show('fast');
            
        }

        $j("#dialog-grafico").dialog({
            modal: true,
            width: 800, 
            height: 600,
            resizable: false, 
            draggable: false,
            autoOpen: false, 
            buttons:{				
                    'Aceptar': function(){
                        $j(this).dialog('close');
                        $j("#img-graph-mes").hide();
                        $j("#img-graph-año").hide();
                    },
                    Salir: function() {
                        $j(this).dialog('close');
                        $j("#img-graph-mes").hide();
                        $j("#img-graph-año").hide();
                    }
            }
        });
        $j("#dialog-grafico").dialog('open');

    }
    
    function mensaje(etiqueta){
        $j(etiqueta).dialog({
                modal: true,
                width: 400, 
                height: 'auto',
                resizable: false, 
                draggable: false,
                autoOpen: false, 
                buttons:{				
                        'Aceptar': function(){
                            $j(this).dialog('close');
                        }
                }
        });
        $j(etiqueta).dialog('open');
    }

    Calendar.setup({
        inputField : "fecha_inicial",
        trigger    : "f_btn1",
        showTime   : 12,
        onSelect   : function(cal) { 
                        var date = cal.selection.get();
                        if (date) {
                              date = Calendar.intToDate(date);
                              document.getElementById("fecha_inicial").value = Calendar.printDate(date, "%Y-%m-%d");
                        }
                        this.hide() 
                    },
        onTimeChange : function(cal) { 
                            var date = cal.selection.get();
                            if (date) {
                                  date = Calendar.intToDate(date);
                                  document.getElementById("fecha_inicial").value = Calendar.printDate(date, "%Y-%m-%d");
                            }
                            this.hide() 
                    }
    });
    
    Calendar.setup({
        inputField : "fecha_final",
        trigger    : "f_btn2",
        showTime   : 12,
        onSelect   : function(cal) { 
                        var date = cal.selection.get();
                        if (date) {
                              date = Calendar.intToDate(date);
                              document.getElementById("fecha_final").value = Calendar.printDate(date, "%Y-%m-%d");
                        }
                        this.hide() 
                    },
        onTimeChange : function(cal) { 
                            var date = cal.selection.get();
                            if (date) {
                                  date = Calendar.intToDate(date);
                                  document.getElementById("fecha_final").value = Calendar.printDate(date, "%Y-%m-%d");
                            }
                            this.hide() 
                    }
    }); 
    
    function demoRss(){
        $j('#demosBusqueda').cycle({ 
            fx:      'scrollLeft', 
            next:   '#demosBusqueda', 
            timeout:  0, 
            easing:  'easeInOutBack' 
        });
        $j("#dialog-demoBusqueda").dialog({
            modal: true,
            width: 700, 
            height: 'auto',
            resizable: false, 
            draggable: false,
            autoOpen: false, 
            buttons:{	
                    Salir: function() {
                            $j(this).dialog('close');
                    }
            }
        });
        $j("#dialog-demoBusqueda").dialog('open');
    }
        
</script>

<form id="busqueda" name="busqueda" action="" method="post" enctype="application/x-www-form-urlencoded">
    <h1><span class="titulosGrandes">Realizar B&uacute;squeda</span></h1>
    
    <br></br>
    
    <table width="100%" CELLPADDING="5" CELLSPACING="5">
        <tr>
            <td width="50%">
                <table cellpadding="3" cellspacing="2">
                    <tr>
                        <td colspan ="2" align="justify">
                            <h1><span class="titulos">Escriba palabras claves de su consulta separada por espacios en blancos</span></h1></br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Palabras claves:</div>
                        </td>
                        <td colspan ="2" align="left">
                            <div><input id="pClaves" type="text"></input>
                            <img name="help"  onclick="demoRss()" title="Las palabras claves filtran los documentos de acuerdo a lo escrito. Ademas, se muestra la relevancia de las mismas en una linea de tiempo. CLICK PARA AQUÍ PARA VER DEMO" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/>
                            </div>
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan ="2" align="justify">
                            <br />
                            <h1><span class="titulos">Definir un rango de fecha para la consulta</span>
                                <img name="help" title="Defina las fechas en las que quiere hacer su analisis. Las fechas abiertas, es decir sin definir, son validas en la consulta" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td><span>DESDE</span></td>
                        <td><input size="15" id="fecha_inicial" /><button id="f_btn1">...</button></td>
                    </tr>
                    <tr>
                        <td><span>HASTA</span></td>
                        <td><input size="15" id="fecha_final" /><button id="f_btn2"><!--<img src="./css/imagenes/calendario.jpg" width="37px" height="20px"/>-->...</button><br /></td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <div  id="enlaces" class="busqueda2" style="cursor:pointer"></div>
            </td>
        </tr>
        <tr>
            <td align="center">   
                </br><p> <span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="buscar()" class="art-button">Aplicar B&uacute;squeda</a></span> <br /></p>
            </td>
            <td align="right">                
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="verGrahp(0)" class="art-button">Ver Gr&aacute;fico</a></span> <br /></p>
            </td>
        </tr>
    </table>
</form>

<div id="dialog-verDoc" style="display:none" title="Noticia">
    <table align="center">
        <tr>
            <td>
                <div id="contenidoNoticia" style="padding:10px 10px; width:auto; height:500px;"></div>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-grafico" style="display:none" title="Gráfico de tendencias en las noticias">
    
    <table width="100%" CELLSPACING="7" align="center">
        <tr>
            <td colspan="3">
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </td>
        </tr>
    </table>
</div> 
<div id="dialog-demoBusqueda"  style="display:none" title="Demostracion">
    <table align="center" width ="100%">
        <tr>
            <td align="center">
                <h1><span class="titulosGrandesRojo">Click en la imagen para  ver siguiente</span>
            </td>
        </tr>
        <tr>
            <td align="center">                
                <div style="cursor:pointer" id="demosBusqueda">
                    <img src="./css/imagenes/busqueda1.jpg" width="400" height="400">
                    <img src="./css/imagenes/busqueda2.jpg" width="400" height="400">
                    <img src="./css/imagenes/busqueda3.jpg" width="400" height="400">
                </div>
            </td>
        </tr>
    </table>
</div> 
<div id="dialog-alerta" style="display:none" title="Atenci&oacute;n">
    <table align="center">
        <tr>
            <td><img src="./css/imagenes/alert-warning.png" width="40px" height="40px"/></td>
            <td class="cajaTexto">
                <div id="mensj-alert"></div>
            </td>
        </tr>
    </table>
</div> 
