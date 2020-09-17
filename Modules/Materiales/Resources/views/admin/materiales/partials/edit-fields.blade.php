<div class="box-body">
    {!! Form::normalInput('nombre', 'Nombre', $errors, $materiales) !!}
    {!! Form::normalInput('unidad_medida', 'Unidad de medida', $errors, $materiales) !!}
    {!! Form::normalInput('precio_unitario', 'Precio unitario', $errors, $materiales) !!}
    {!! Form::normalInput('observacion', 'Observación', $errors, $materiales) !!}
</div>