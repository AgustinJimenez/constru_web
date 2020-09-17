<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors, $proveedores) !!}
    {!! Form::normalInput('direccion', 'Dirección', $errors, $proveedores) !!}
    {!! Form::normalInput('direccion_web', 'Dirección Web (Pagina Web)', $errors, $proveedores) !!}
    {!! Form::hidden("direccion_map", $proveedores->direccion_map) !!}
    {!! Form::normalInput('nro_telefono', 'Nro. de Teléfono', $errors, $proveedores) !!}
    {!! Form::normalInput('celular', 'Celular', $errors, $proveedores) !!}
    {!! Form::normalInput('email', 'Email', $errors, $proveedores) !!}

    @include('media::admin.fields.file-link',
    [
	    'entityClass' => /*'Modules\\\\Proveedores\\\\Entities\\\\Proveedores'*/get_class($proveedores),
	    'entityId' => $proveedores->id,
	    'zone' => 'imagen'
    ])
    <div class="row" align="right">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <label>DIRECCION MAPS</label>
            </div>

            <section>
                <div id='map_canvas' style="width: 500px; height: 400px;"></div>
                <div id="latitud_longitud">{!! $proveedores->latitud . ',' . $proveedores->longitud !!}</div>
            </section>
        </div>
    </div>
</div>