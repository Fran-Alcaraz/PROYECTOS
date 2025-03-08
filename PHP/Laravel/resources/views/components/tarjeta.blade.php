<div id="tarjeta">
    @if(isset($cabecera))
        <br><br>
        <div>
            {{ $cabecera }}
        </div>
    @endif


    @if(isset($cuerpo))
        <div>
            {{ $cuerpo }}
        </div>
    @endif


    @if(isset($footer))
        <div>
            {{ $footer }}
        </div>
    @endif
</div>