//Action tag #0

function limpacr(sucio)
{
    paltemp = "";
    var __reg1 = 0;
    while (__reg1 < sucio.length) 
    {
        if (sucio.charCodeAt(__reg1) != 13) 
        {
            paltemp = paltemp + sucio.charAt(__reg1);
        }
        ++__reg1;
    }
    return paltemp;
}
function f_sube_texto()
{
    fiestra.textoc.scroll = fiestra.textoc.scroll + 1;
}
function f_baixa_texto()
{
    fiestra.textoc.scroll = fiestra.textoc.scroll - 1;
}
function f_son(texto)
{
    pon_son(texto);
}
function f_pechar_fiestra()
{
    nvs.close();
    botons._visible = true;
    mapa._visible = true;
    fiestra._visible = false;
    musica.stop();
}
function f_noson()
{
    if (conson == false) 
    {
        conson = true;
        botons.bt_noson.cruz._visible = false;
        return;
    }
    conson = false;
    botons.bt_noson.cruz._visible = true;
    musica.stop();
}
function f_liga()
{
    getURL(fliga, "_blank");
}
function f_amosar_tips()
{
    if (amosados == false) 
    {
        a = 1;
        while (a < num_puntos + 1) 
        {
            pmc[a].vertip = true;
            ++a;
        }
        amosados = true;
        return;
    }
    a = 1;
    while (a < num_puntos + 1) 
    {
        pmc[a].vertip = false;
        ++a;
    }
    amosados = false;
}
function f_son_inicio(sond)
{
    pon_son(sond);
}
function f_toda_pantalla()
{
    if (Stage.displayState == "normal") 
    {
        Stage.displayState = "fullscreen";
        return;
    }
    Stage.displayState = "normal";
}
function empezar(success)
{
    if (success) 
    {
        xmben = xdata.status;
        if (xmben != 0) 
        {
            botons.txtentra.text = "Erro na estructura do arquivo";
            return;
        }
        var __reg7 = this.firstChild;
        if (__reg7.nodeName == "puntos") 
        {
            exern = __reg7.childNodes.length;
            epn = 0;
            while (epn < exern) 
            {
                var __reg4 = __reg7.childNodes[epn];
                if (__reg4.nodeName == "fondo") 
                {
                    if (__reg4.firstChild.nodeValue != "0" && __reg4.firstChild.nodeValue != undefined) 
                    {
                        if (__reg4.attributes.color != undefined) 
                        {
                            var __reg6 = new Color(base);
                            valor = "0x" + __reg4.attributes.color;
                            __reg6.setRGB(valor);
                        }
                        if (__reg4.attributes.imaxe != undefined && __reg4.attributes.imaxe != "") 
                        {
                            imxfondo = __reg4.attributes.imaxe;
                        }
                        if (__reg4.attributes.son != undefined && __reg4.attributes.son != "") 
                        {
                            soninicio = __reg4.attributes.son;
                        }
                        else 
                        {
                            soninicio = "";
                            botons.bt_son._visible = false;
                        }
                        if (__reg4.attributes.texto != undefined) 
                        {
                            var __reg5 = __reg4.attributes.texto;
                            botons.texto.htmlText = __reg5;
                        }
                    }
                }
                else 
                {
                    if (__reg4.nodeName == "punto") 
                    {
                        ++num_puntos;
                        var __reg3 = new punto(mapa, num_puntos + 10, pon_son, pon_fiestra);
                        pmc[num_puntos] = __reg3;
                        if (con_imaxe == true) 
                        {
                            __reg3.__set__visible(false);
                        }
                        if (__reg4.attributes.posx != undefined) 
                        {
                            __reg3.__set__x(Number(__reg4.attributes.posx));
                        }
                        if (__reg4.attributes.posy != undefined) 
                        {
                            __reg3.__set__y(Number(__reg4.attributes.posy));
                        }
                        if (__reg4.attributes.modo != undefined) 
                        {
                            if (__reg4.attributes.modo == "1") 
                            {
                                va = 5;
                            }
                            else 
                            {
                                if (__reg4.attributes.modo == "2") 
                                {
                                    va = 6;
                                }
                                else 
                                {
                                    va = 0;
                                }
                            }
                        }
                        exer = __reg4.childNodes.length;
                        ep = 0;
                        while (ep < exer) 
                        {
                            datos[ep] = new Array(7);
                            var __reg2 = __reg4.childNodes[ep];
                            if (__reg2.nodeName == "forma") 
                            {
                                if (__reg2.firstChild.nodeValue != undefined) 
                                {
                                    __reg3.__set__forma(Number(__reg2.firstChild.nodeValue));
                                    __reg3.crearpunto();
                                    if (__reg2.attributes.tamx != undefined) 
                                    {
                                        __reg3.__set__tx(Number(__reg2.attributes.tamx));
                                    }
                                    if (__reg2.attributes.tamy != undefined) 
                                    {
                                        __reg3.__set__ty(Number(__reg2.attributes.tamy));
                                    }
                                }
                            }
                            if (__reg2.nodeName == "color") 
                            {
                                if (__reg2.firstChild.nodeValue != undefined) 
                                {
                                    __reg3.__set__color(Number("0x" + __reg2.firstChild.nodeValue));
                                    if (__reg2.attributes.trans != undefined) 
                                    {
                                        __reg3.__set__alpha(Number(__reg2.attributes.trans));
                                        if (__reg2.attributes.trans == "1") 
                                        {
                                            _focusrect = false;
                                        }
                                    }
                                    if (__reg2.attributes.cfondo != undefined) 
                                    {
                                        if (__reg2.attributes.cfondo == "0") 
                                        {
                                            __reg3.__set__confondo(false);
                                        }
                                    }
                                }
                            }
                            if (__reg2.nodeName == "sobre") 
                            {
                                tempimaxe = 0;
                                if (__reg2.firstChild.nodeValue == "1") 
                                {
                                    if (__reg2.attributes.son == undefined) 
                                    {
                                        __reg3.__set__son("");
                                    }
                                    else 
                                    {
                                        __reg3.__set__son(__reg2.attributes.son);
                                    }
                                    if (__reg2.attributes.texto == undefined) 
                                    {
                                        __reg3.__set__texto("");
                                    }
                                    else 
                                    {
                                        __reg3.__set__texto(__reg2.attributes.texto);
                                        if (va < 4) 
                                        {
                                            va = va + 1;
                                        }
                                    }
                                    if (__reg2.attributes.imaxe != undefined && __reg2.attributes.imaxe != "") 
                                    {
                                        __reg3.__set__imaxe(__reg2.attributes.imaxe);
                                        tempimaxe = 1;
                                        __reg3.__set__maximx(192);
                                        __reg3.__set__maximy(130);
                                        if (va < 4) 
                                        {
                                            va = va + 2;
                                        }
                                    }
                                    else 
                                    {
                                        tempimaxe = 0;
                                        __reg3.__set__imaxe("");
                                    }
                                }
                                __reg3.__set__tip(va);
                                if (__reg3.__get__modo() != 5) 
                                {
                                    if (tempimaxe == 1) 
                                    {
                                        __reg3.pon_imaxe_tip();
                                    }
                                }
                            }
                            if (__reg2.nodeName == "click") 
                            {
                                if (__reg2.firstChild.nodeValue != "0") 
                                {
                                    if (__reg2.firstChild.nodeValue != undefined && __reg2.firstChild.nodeValue != "1") 
                                    {
                                        __reg3.__set__cklibro(limpacr(__reg2.firstChild.nodeValue));
                                        __reg3.__set__pfiestra(true);
                                    }
                                    if (__reg2.attributes.son == undefined) 
                                    {
                                        __reg3.__set__ckson("");
                                    }
                                    else 
                                    {
                                        __reg3.__set__ckson(__reg2.attributes.son);
                                    }
                                    if (__reg2.attributes.obxecto == undefined) 
                                    {
                                        __reg3.__set__ckobxecto("");
                                    }
                                    else 
                                    {
                                        __reg3.__set__ckobxecto(__reg2.attributes.obxecto);
                                    }
                                    if (__reg2.attributes.texto == undefined) 
                                    {
                                        __reg3.__set__cktexto("");
                                    }
                                    else 
                                    {
                                        __reg3.__set__cktexto(__reg2.attributes.texto);
                                    }
                                    if (__reg2.attributes.liga == undefined) 
                                    {
                                        __reg3.__set__ckliga("");
                                    }
                                    else 
                                    {
                                        __reg3.__set__ckliga(__reg2.attributes.liga);
                                        __reg3.__set__pfiestra(true);
                                    }
                                }
                            }
                            ++ep;
                        }
                    }
                }
                ++epn;
            }
        }
        iniciar();
    }
}
function pon_son(sonid)
{
    if (conson == true) 
    {
        if (sonid == "") 
        {
            musica.stop();
        }
        else 
        {
            musica.stop();
            musica.loadSound(sonid, true);
            musica.start();
        }
        musica.onSoundComplete = function ()
        {
        }
        ;
    }
}
function pon_fiestra(son, texto, obxecto, liga, libro)
{
    if (texto != "" || obxecto != "" || libro != "") 
    {
        fiestra.texto.texto.text = texto;
        if (liga == "") 
        {
            fliga = "";
            fiestra.iconliga._visible = false;
        }
        else 
        {
            fliga = liga;
            fiestra.iconliga._visible = true;
        }
        if (son == "") 
        {
            fson = "";
            fiestra.son_fiestra._visible = false;
        }
        else 
        {
            fiestra.son_fiestra._visible = true;
            pon_son(son);
            fson = son;
        }
        if (libro == "") 
        {
            var __reg3 = fiestra.createEmptyMovieClip("imaxe", 20);
            fiesimx = 700;
            fiesimy = 450;
            if (fiestra.bt_abaixo._visible == true) 
            {
                fiestra.bt_abaixo._visible = false;
                fiestra.bt_arriba._visible = false;
            }
        }
        else 
        {
            removeMovieClip(fiestra.imaxe);
            fiesimx = 220;
            fiesimy = 300;
            if (obxecto == "") 
            {
                fiestra.textoc._x = 45;
                fiestra.textoc._y = 45;
                fiestra.textoc._width = 660;
            }
            else 
            {
                fiestra.textoc._x = 260;
                fiestra.textoc._y = 45;
                fiestra.textoc._width = 435;
            }
            fiestra.textoc.htmlText = libro;
            if (fiestra.textoc.maxscroll > 1) 
            {
                fiestra.bt_abaixo._visible = true;
                fiestra.bt_arriba._visible = true;
            }
            else 
            {
                fiestra.bt_abaixo._visible = false;
                fiestra.bt_arriba._visible = false;
            }
        }
        if (obxecto != "") 
        {
            __reg3 = fiestra.createEmptyMovieClip("imaxe", 20);
            __reg3._x = 30;
            __reg3._y = 35;
            obxecto = obxecto.toLowerCase();
            if (obxecto.indexOf(".flv") > 0 || obxecto.indexOf(".mp4") > 0) 
            {
                fiestra.control_video._visible = true;
                video(obxecto, fiestra.imaxe, 1, fiesimx, fiesimy, 230, 430);
            }
            else 
            {
                fiestra.control_video._visible = false;
                var __reg5 = new cargaimaxe(0);
                __reg5.abre(obxecto, fiestra.imaxe, fiesimx, fiesimy);
            }
        }
        botons._visible = false;
        mapa._visible = false;
        fiestra._visible = true;
        return;
    }
    if (son == "") 
    {
        fson = "";
    }
    else 
    {
        pon_son(son);
        fson = son;
    }
    if (liga != "") 
    {
        f_liga(liga);
    }
}
function control_imaxe(modo, pimx, pimy)
{
    if (pimx != undefined) 
    {
        if (modo == 1) 
        {
            var __reg1 = pimx;
            var __reg2 = pimy;
            a = 1;
            while (a < num_puntos + 1) 
            {
                if (con_imaxe == true) 
                {
                    pmc[a].x = pmc[a].x + __reg1;
                    pmc[a].y = pmc[a].y + __reg2;
                    pmc[a].poner_tip();
                }
                pmc[a].visible = true;
                ++a;
            }
            pon_son(soninicio);
        }
    }
}
function iniciar()
{
    if (imxfondo != "") 
    {
        var __reg1 = new cargaimaxe(1, control_imaxe);
        __reg1.abre(imxfondo, mapa.imaxe, maximx_x, maximx_y);
        con_imaxe = true;
        return;
    }
    a = 1;
    while (a < num_puntos + 1) 
    {
        pmc[a].x = pmc[a].x;
        pmc[a].y = pmc[a].y;
        pmc[a].poner_tip();
        pmc[a].visible = true;
        ++a;
    }
    pon_son(soninicio);
}
Stage.scaleMode = showAll;
var maximx_x = 760;
var maximx_y = 510;
var pmc = new Array();
var num_puntos = 0;
var musica = new Sound(this);
var con_imaxe = false;
var va = 0;
var amosados = false;
var soninicio = "";
var ligazon = "";
var fson = "";
var fliga = "";
var conson = true;
var imxfondo = "";
var controlteclado = new Object();
this.attachMovie("fondof", "base", 0);
this.attachMovie("binfo", "binfo", 4000);
this.attachMovie("botons", "botons", 4001);
this.attachMovie("fiestra", "fiestra", 5000);
botons.bt_noson.cruz._visible = false;
base._x = -420;
base._y = 0;
binfo._x = 10;
binfo._y = 505;
botons._x = 20;
botons._y = 508;
fiestra.iconliga.swapDepths(30);
fiestra.sombra.useHandCursor = false;
fiestra.sombra.onPress = function ()
{
}
;
fiestra.texto.onRelease = function ()
{
    if (fliga != "") 
    {
        f_liga();
    }
}
;
fiestra.bt_abaixo.onRelease = function ()
{
    f_sube_texto();
}
;
fiestra.bt_arriba.onRelease = function ()
{
    f_baixa_texto();
}
;
fiestra.son_fiestra.onRelease = function ()
{
    if (fson != "") 
    {
        f_son(fson);
    }
}
;
fiestra.pechar_fiestra.onRelease = function ()
{
    f_pechar_fiestra();
}
;
botons.bt_noson.onRelease = function ()
{
    f_noson();
}
;
botons.bt_amplia.onRelease = function ()
{
    f_toda_pantalla();
}
;
botons.bt_amosa.onRelease = function ()
{
    f_amosar_tips();
}
;
botons.bt_son.onRelease = function ()
{
    pon_son(soninicio);
}
;
fiestra._visible = false;
controlteclado.onKeyDown = function ()
{
    if ((__reg0 = Key.getCode()) === 118) 
    {
        if (fiestra._visible == true) 
        {
            pon_son(fson);
        }
        else 
        {
            pon_son(soninicio);
        }
        return;
    }
    else 
    {
        if (__reg0 === 119) 
        {
            f_amosar_tips();
            return;
        }
        else 
        {
            if (__reg0 === 120) 
            {
                f_toda_pantalla();
                return;
            }
            else 
            {
                if (__reg0 === 117) 
                {
                    f_noson();
                    return;
                }
                else 
                {
                    if (__reg0 === 27) 
                    {
                        if (fiestra._visible == true) 
                        {
                            f_pechar_fiestra();
                        }
                        return;
                    }
                    else 
                    {
                        if (__reg0 === 38) 
                        {
                            if (fiestra._visible == true) 
                            {
                                f_baixa_texto();
                            }
                            return;
                        }
                        else 
                        {
                            if (__reg0 !== 40) 
                            {
                                return;
                            }
                        }
                    }
                }
            }
        }
    }
    if (fiestra._visible == true) 
    {
        f_sube_texto();
    }
    return;
}
;
_focusrect = true;
Key.addListener(controlteclado);
this.createEmptyMovieClip("mapa", 1);
mapa._x = 0;
mapa._y = 0;
mapa.createEmptyMovieClip("imaxe", 1);
xdata = new XML();
xdata.ignoreWhite = true;
video = function (nvideo, fimx, vidauto, vidl, vida, vidrx, vidry)
{
    function playVideo()
    {
        xaplay = true;
        nvs.pause();
    }
    function pauseVideo()
    {
        nvs.pause();
    }
    var h = 0;
    var w = 0;
    mostempo = function ()
    {
        control_video.mando.barra._width = nvs.time * prop;
        date.setHours(0, 0, nvs.time, 0);
        control_video.mando.tempo.text = substring(date.getHours() + 100, 2, 2) + ":" + substring(date.getMinutes() + 100, 2, 2) + ":" + substring(date.getSeconds() + 100, 2, 2);
    }
    ;
    fimx.attachMovie("mvideo", "fvid", 60);
    control_video = fimx.fvid;
    control_video.fondov._visible = false;
    control_video.mando._y = vidry;
    control_video.mando._x = vidrx;
    xaplay = false;
    control_video.mando.bpause._visible = false;
    control_video.mando.barra._width = 0;
    var date = new Date(2004, 0, 1, 0, 0, 0, 0);
    var datef = new Date(2004, 0, 1, 0, 0, 0, 0);
    control_video.mando.barra.setMask(control_video.mando.barram);
    nvc = new NetConnection();
    nvc.connect(null);
    nvs = new NetStream(nvc);
    nvs.setBufferTime(10);
    control_video.createEmptyMovieClip("snd", 0);
    control_video.snd.attachAudio(nvs);
    musica = new Sound(control_video.snd);
    control_video.fondov.attachVideo(nvs);
    nvs.play(nvideo);
    nvs.onMetaData = function (obj)
    {
        this.totalTime = obj.duration;
        w = obj.width;
        h = obj.height;
        if (w == undefined) 
        {
            w = 300;
        }
        if (h == undefined) 
        {
            h = 250;
        }
        if (w > vidl) 
        {
            w = vidl;
        }
        if (h > vida) 
        {
            h = vida;
        }
        bw = obj.duration / 3.5;
        iniciado = true;
        control_video.fondov._width = w;
        control_video.fondov._height = h;
        posx = (vidl - w) / 2;
        posy = (vida - h) / 2;
        control_video.fondov._y = posy;
        control_video.fondov._x = posx;
        control_video.fondov._visible = true;
        duracion = nvs.totalTime;
        totald = nvs.totalTime;
        prop = control_video.mando.barram._width / totald;
        iprop = totald / control_video.mando.barram._width;
        datef.setHours(0, 0, nvs.totalTime, 0);
        control_video.mando.tempo2.text = substring(datef.getHours() + 100, 2, 2) + ":" + substring(datef.getMinutes() + 100, 2, 2) + ":" + substring(datef.getSeconds() + 100, 2, 2);
        nvs.pause();
        medir = setInterval(mostempo, 10);
    }
    ;
    nvs.onStatus = function (object)
    {
        if (object.code == "NetStream.Play.Start") 
        {
            duracion = nvs.totalTime;
            return;
        }
        if (object.code != "NetStream.Buffer.Full") 
        {
            if (object.code == "NetStream.Play.Stop") 
            {
                nvs.seek(0);
                if (versic < 8) 
                {
                    pauseVideo();
                }
                control_video.mando.barra._width = 0;
                control_video.mando.bplay._visible = true;
                control_video.mando.bpause._visible = false;
            }
        }
    }
    ;
    control_video.mando.arrastre.onPress = function ()
    {
        startDrag(this._parent, 0);
    }
    ;
    control_video.mando.arrastre.onRelease = function ()
    {
        stopDrag();
    }
    ;
    control_video.mando.bplay.onRelease = function ()
    {
        xaplay = true;
        tplay = true;
        pauseVideo();
        control_video.mando.bplay._visible = false;
        control_video.mando.bpause._visible = true;
    }
    ;
    control_video.mando.bpanta.onRelease = function ()
    {
        if (control_video.fondov._width > vidl - 10) 
        {
            control_video.fondov._width = w;
            control_video.fondov._height = h;
            control_video.fondov._y = posy;
            control_video.fondov._x = posx;
            return;
        }
        control_video.fondov._x = 0;
        control_video.fondov._width = vidl;
        control_video.fondov._y = 0;
        control_video.fondov._height = vida;
    }
    ;
    control_video.mando.bstop.onRelease = function ()
    {
        if (nvs.time > 0) 
        {
            nvs.seek(0);
        }
        control_video.mando.barra._width = 0;
        control_video.mando.bplay._visible = true;
        control_video.mando.bpause._visible = false;
    }
    ;
    control_video.mando.bpause.onRelease = function ()
    {
        xaplay = false;
        pauseVideo();
        control_video.mando.bplay._visible = true;
        control_video.mando.bpause._visible = false;
    }
    ;
    control_video.mando.barram.onPress = function ()
    {
        scl = this._xmouse * iprop;
        nvs.seek(scl);
    }
    ;
    if (vidauto == 1) 
    {
        pauseVideo();
        xaplay = true;
        tplay = true;
        control_video.mando.bplay._visible = false;
        control_video.mando.bpause._visible = true;
    }
}
;
xdata.onLoad = empezar;
if (nome == undefined) 
{
    var arrswf = this._url.split("/");
    var nomeswf = unescape(String(arrswf.pop()));
    arrswf = nomeswf.split(".");
    nome = arrswf[0] + ".xml";
}
xdata.load(nome);
stop();

