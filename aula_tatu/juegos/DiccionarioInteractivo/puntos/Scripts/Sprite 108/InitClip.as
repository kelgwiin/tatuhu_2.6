//InitClip
dynamic class punto
{
    var calter: Number = 153;
    var calter2: Number = 16776960;
    var posx: Number = 0;
    var posy: Number = 0;
    var tamx: Number = 10;
    var tamy: Number = 10;
    var scolor: Number = 16777215;
    var sforma: Number = 0;
    var sson: String = "";
    var stexto: String = "";
    var simaxe: String = "";
    var cson: String = "";
    var ctexto: String = "";
    var cobxecto: String = "";
    var cliga: String = "";
    var clibro: String = "";
    var conta: Number = 0;
    var conmarca: Boolean = false;
    var spfdcolor: Boolean = true;
    var colb;
    var colf;
    var ftip;
    var marca;
    var maxtiptx;
    var maxtipty;
    var pfpreme;
    var pfson;
    var smodo;
    var tempmc;
    var temppt;

    function punto(pai, prof, fson, ffiestra)
    {
        this.tempmc = pai.createEmptyMovieClip("punto" + prof, prof);
        this.marca = this.tempmc.attachMovie("marca", "marca", 2);
        this.marca._visible = false;
        this.pfson = fson;
        this.pfpreme = ffiestra;
        this.conta = prof;
    }

    function set forma(valor)
    {
        this.sforma = valor;
    }

    function crearpunto()
    {
        if (this.sforma == 0) 
        {
            this.temppt = this.tempmc.attachMovie("prepuntor", "obxecto", 0);
        }
        else 
        {
            if (this.sforma == 1) 
            {
                this.temppt = this.tempmc.attachMovie("prepuntoc", "obxecto", 0);
            }
            else 
            {
                if (this.sforma == 2) 
                {
                    this.temppt = this.tempmc.attachMovie("prepuntoc", "obxecto", 0);
                }
                else 
                {
                    if (this.sforma == 3) 
                    {
                        this.temppt = this.tempmc.attachMovie("prepuntod", "obxecto", 0);
                    }
                }
            }
        }
        if (this.spfdcolor == false) 
        {
            this.temppt.fondo._alpha = 0;
        }
        this.colf = new Color(this.temppt.fondo);
        this.colb = new Color(this.temppt.borde);
        this.colb.setRGB(this.scolor);
        this.colf.setRGB(this.scolor);
        this.calter = this.scolor >> 10;
        this.temppt.onRollOver = mx.utils.Delegate.create(this, this.sobre_punto);
        this.temppt.onRollOut = mx.utils.Delegate.create(this, this.fora_punto);
        this.temppt.onDragOut = mx.utils.Delegate.create(this, this.fora_punto);
        this.temppt.onRelease = mx.utils.Delegate.create(this, this.preme_punto);
        this.tempmc._visible = false;
    }

    function set x(valor)
    {
        this.tempmc._x = valor;
    }

    function set y(valor)
    {
        this.tempmc._y = valor;
    }

    function set confondo(valor)
    {
        this.spfdcolor = valor;
    }

    function get x()
    {
        return this.tempmc._x;
    }

    function get y()
    {
        return this.tempmc._y;
    }

    function get modo()
    {
        return this.smodo;
    }

    function set tx(valor)
    {
        this.temppt._width = valor;
        this.marca.marca3._x = valor;
    }

    function set ty(valor)
    {
        this.temppt._height = valor;
    }

    function set visible(valor)
    {
        this.tempmc._visible = valor;
    }

    function set vertip(valor)
    {
        if (this.smodo < 5) 
        {
            this.ftip._visible = valor;
        }
    }

    function set son(valor)
    {
        this.sson = valor;
    }

    function set ckson(valor)
    {
        this.cson = valor;
        if (this.conmarca == false) 
        {
            this.conmarca = true;
        }
    }

    function get ckson()
    {
        return this.cson;
    }

    function set cktexto(valor)
    {
        this.ctexto = valor;
        if (this.conmarca == false) 
        {
            this.conmarca = true;
        }
    }

    function set ckobxecto(valor)
    {
        this.cobxecto = valor;
        if (this.conmarca == false) 
        {
            this.conmarca = true;
        }
    }

    function set ckliga(valor)
    {
        this.cliga = valor;
        if (this.conmarca == false && this.cliga != "") 
        {
            this.conmarca = true;
        }
    }

    function set cklibro(valor)
    {
        this.clibro = valor;
        if (this.conmarca == false) 
        {
            this.conmarca = true;
        }
    }

    function set texto(valor)
    {
        this.stexto = valor;
    }

    function set imaxe(valor)
    {
        this.simaxe = valor;
    }

    function pon_imaxe_tip()
    {
        this.encher();
    }

    function set pfiestra(valor)
    {
        this.conmarca = valor;
    }

    function set color(valor)
    {
        this.scolor = valor;
    }

    function set alpha(valor)
    {
        this.tempmc._alpha = valor;
    }

    function set maximx(valor)
    {
        this.maxtiptx = valor;
    }

    function set maximy(valor)
    {
        this.maxtipty = valor;
    }

    function set tip(valor)
    {
        this.smodo = valor;
        if (valor == 1) 
        {
            this.ftip = this.tempmc._parent.attachMovie("mctip1", "mctip" + this.conta, 1000 + this.conta);
            this.ftip.texto.texto.text = this.stexto;
        }
        else 
        {
            if (valor == 3) 
            {
                this.ftip = this.tempmc._parent.attachMovie("mctip2", "mctip" + this.conta, 1000 + this.conta);
                this.ftip.texto.texto.text = this.stexto;
            }
            else 
            {
                if (valor == 5) 
                {
                    this.ftip = this.tempmc._parent.attachMovie("mctip3", "mctip", 1000);
                }
                else 
                {
                    if (valor == 6) 
                    {
                        this.ftip = this.tempmc.createEmptyMovieClip("mctip", 1000);
                        this.ftip.createTextField("texto", 1, 0, 0, 150, 20);
                        var __reg3 = new TextFormat();
                        __reg3.size = 14;
                        this.ftip.texto.setNewTextFormat(__reg3);
                        this.ftip.texto.text = this.stexto;
                    }
                }
            }
        }
        this.ftip._visible = false;
    }

    function poner_tip()
    {
        if (this.smodo == 1) 
        {
            if (this.tempmc._x + this.temppt._width < 500) 
            {
                this.ftip._x = this.tempmc._x + this.tempmc._width;
            }
            else 
            {
                this.ftip._x = this.tempmc._x - this.ftip._width;
            }
            if (this.tempmc._y + this.temppt._height < 450) 
            {
                this.ftip._y = this.tempmc._y + this.temppt._height;
            }
            else 
            {
                this.ftip._y = this.tempmc._y - 40;
            }
            return;
        }
        if (this.smodo == 3) 
        {
            if (this.tempmc._x + this.temppt._width < 510) 
            {
                this.ftip._x = this.tempmc._x + this.tempmc._width - 5;
            }
            else 
            {
                this.ftip._x = this.tempmc._x - 230;
                trace(this.ftip._width);
            }
            if (this.tempmc._y + this.temppt._height < 260) 
            {
                this.ftip._y = this.tempmc._y + this.temppt._height - 80;
            }
            else 
            {
                this.ftip._y = this.tempmc._y - 100;
            }
            return;
        }
        if (this.smodo == 5) 
        {
            this.ftip._y = 450;
            this.ftip._x = 0;
            this.ftip._visible = true;
            return;
        }
        if (this.smodo == 6) 
        {
            this.ftip._x = this.posx;
            this.ftip._y = this.posy;
        }
    }

    function sobre_punto()
    {
        this.colb.setRGB(this.calter);
        if (this.sson == "") 
        {
            this.tempmc._accProps = this.stexto;
        }
        else 
        {
            this.pfson(this.sson);
        }
        if (this.conmarca == true) 
        {
            this.marca._visible = true;
        }
        if (this.smodo == 5) 
        {
            this.ftip.texto.texto.htmlText = this.stexto;
            return;
        }
        this.ftip._visible = true;
    }

    function fora_punto()
    {
        this.colb.setRGB(this.scolor);
        if (this.conmarca == true) 
        {
            this.marca._visible = false;
        }
        if (this.smodo == 5) 
        {
            this.ftip.texto.texto.text = "";
            return;
        }
        this.ftip._visible = false;
    }

    function preme_punto()
    {
        if (this.conmarca == true) 
        {
            this.pfpreme(this.cson, this.ctexto, this.cobxecto, this.cliga, this.clibro);
        }
    }

    function encher()
    {
        this.ftip.createEmptyMovieClip("imaxe", 2);
        this.ftip.imaxe._x = 6;
        this.ftip.imaxe._y = 31;
        var __reg2 = new cargaimaxe(0);
        __reg2.abre(this.simaxe, this.ftip.imaxe, this.maxtiptx, this.maxtipty);
    }

}

