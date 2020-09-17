<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors) !!}
    {!! Form::normalInput('direccion', 'Dirección', $errors) !!}
    {!! Form::normalInput('direccion_web', 'Dirección Web (Pagina Web)', $errors) !!}
    {!! Form::hidden("direccion_map","") !!}
    {!! Form::normalInput('nro_telefono', 'Nro. de Teléfono', $errors) !!}
    {!! Form::normalInput('celular', 'Celular', $errors) !!}
    {!! Form::normalInput('email', 'Email', $errors) !!}

    @include('media::admin.fields.new-file-link-single', ['zone' => 'imagen'])
	<div class="row" align="right">
		<div class="col-md-6">
		</div>
		<div class="col-md-6">
    		<div class="text-center">
	    		<label>DIRECCION MAPS</label>
	    	</div>

			<section>
		        <div id='map_canvas' style="width: 500px; height: 400px;"></div>
		        <div id="latitud_longitud">-25.277, -57.637</div>
		    </section>
		</div>
	</div>
</div>
