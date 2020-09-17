@extends('layouts.master')

@section('content-header')
    <h1>
        {{$proveedor->nombre}} Materiales
    </h1>
    <ol class="breadcrumb">
        <li class="active">Proveedor {{$proveedor->nombre}} materiales</li>
    </ol>
@stop

@section('styles')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(array('route' => ['admin.proveedores.proveedores.index-materiales'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="row">
                            <div class="col-md-2">
                                <label for="material" class="control-label">Material:</label>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" id="borrar_material" title="Limpiar filtro"></i>
                                    <input type="text" class="form-control input-sm" name="material" id="material" value="">
                                </div>
                            </div>
                        </div>
                        {!! Form::hidden('proveedor_id', $proveedor->id, ['id' => 'proveedor_id']) !!}
                    {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Unidad de medida</th>
                                <th>Precio unitario</th>
                                <th data-sortable="false">Agregar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td align="center"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Unidad de medida</th>
                                <th>Precio unitario</th>
                                <th data-sortable="false">Agregar</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <div class="box-footer">
                    <div class="col-sm-12 btn-group">
                        <a class="btn btn-primary pull-left btn-flat" href="{{ route('admin.proveedores.proveedores.index')}}">Atrás</a>
                    </div>
                <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
@stop

@section('footer')
    
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {

            $('.data-table').on("click", "tbody tr input[type='checkbox']", function(e)
            {
                e.stopImmediatePropagation();
                id = $(this).val();
                if ($(this).is(":checked"))
                    save_material(id, 'add');
                else
                    save_material(id, 'delete');
            });

            function save_material(id, action)
            {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('admin.proveedores.proveedores.save-material') !!}',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: {'proveedor_id': $('#proveedor_id').val(), 'material_id':id, 'action':action},
                    success: function(result)
                    {
                        // console.log(result);
                    }
                });
            }

            $("#material").keyup(function()
            {
                $("#search-form").submit();
            });

            $("#material").autocomplete(
            {
                source: '{!! route('admin.materiales.materiales.search-material') !!}',
                minLength: 1,
                select: function (event, ui)
                {
                    $(this).val(ui.item.label);
                    $("#search-form").submit();
                }
            });

            $('#borrar_material').click(function()
            {
                $('#material').val('');
                $("#search-form").submit();
            });

            $('#search-form').on('submit', function(e) 
            {
                table.draw();
                e.preventDefault();
            });

            var table = $('.data-table').DataTable(
            {
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                "deferRender": true,
                processing: false,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "iDisplayLength": 50,
                ajax: 
                 {
                    url: '{!! route('admin.proveedores.proveedores.index-materiales') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.proveedor_id = $('#proveedor_id').val();
                        e.material = $('#material').val();
                    }
                },
                columns: 
                [
                    { data: 'nombre', name: 'nombre' },
                    { data: 'unidad_medida' , name: 'unidad_medida' },
                    { data: 'precio_unitario', name: 'precio_unitario' },
                    { data: 'agregar', name: 'agregar', orderable: false, searchable: false}
                ],
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "Mostrando de _START_ al _END_ registros de un total de _TOTAL_ registros",
                    infoFiltered:   ".",
                    infoPostFix:    "",
                    loadingRecords: "Cargando Registros...",
                    zeroRecords:    "No existen registros disponibles",
                    emptyTable:     "No existen registros disponibles",
                    paginate: {
                        first:      "Primera",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Ultima"
                    }
                }
            });
        });
    </script>
    <?php $locale = locale(); ?>
@stop