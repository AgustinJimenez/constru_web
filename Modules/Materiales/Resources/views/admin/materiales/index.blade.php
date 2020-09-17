@extends('layouts.master')

@section('content-header')
    <h1>
        Materiales
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('materiales::materiales.title.materiales') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.materiales.materiales.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(array('route' => ['admin.materiales.materiales.index-ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="row">
                            <div class="col-md-2">
                                <label for="material" class="control-label">Nombre:</label>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" id="borrar_material" title="Limpiar filtro"></i>
                                    <input type="text" class="form-control input-sm" name="material" id="material" value="">
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table-materiales" class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Unidad de medida</th>
                                <th>Precio unitario</th>
                                <th>Observación</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot> 
                            <tr>
                                <th>Nombre</th>
                                <th>Unidad de medida</th>
                                <th>Precio unitario</th>
                                <th>Observación</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('materiales::materiales.title.create materiales') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">

        <?php $locale = locale(); ?>
        $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.materiales.materiales.create') }}" }]});
        $( document ).ready(function() 
        {

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
                ajax: 
                 {
                    url: '{!! route('admin.materiales.materiales.index-ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.material = $('#material').val();
                    }
                },
                columns: 
                [
                    { data: 'nombre', name: 'nombre' },
                    { data: 'unidad_medida' , name: 'unidad_medida' },
                    { data: 'precio_unitario', name: 'precio_unitario' },
                    { data: 'observacion', name: 'observacion' },
                    { data: 'action', name: 'action', orderable: false, searchable: false} 
                ],
                language: 
                {
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
    
@stop
