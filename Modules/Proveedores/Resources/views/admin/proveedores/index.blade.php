@extends('layouts.master')

@section('content-header')
    <h1>
        Proveedores
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('proveedores::proveedores.title.proveedores') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.proveedores.proveedores.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(array('route' => ['admin.proveedores.proveedores.index-ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="row">
                            <div class="col-md-2">
                                <label for="proveedor" class="control-label">Proveedor:</label>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" id="borrar_proveedor" title="Limpiar filtro"></i>
                                    <input type="text" class="form-control input-sm" name="proveedor" id="proveedor" value="">
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Nro. Teléfono</th>
                                <th>Celular</th>
                                <th>Email</th>
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
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Nro. Teléfono</th>
                                <th>Celular</th>
                                <th>Email</th>
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
        <dd>{{ trans('proveedores::proveedores.title.create proveedores') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {

            $("#proveedor").keyup(function()
            {
                $("#search-form").submit();
            });

            $("#proveedor").autocomplete(
            {
                source: '{!! route('admin.proveedores.proveedores.search-proveedor') !!}',
                minLength: 1,
                select: function (event, ui)
                {
                    $(this).val(ui.item.label);
                    $("#search-form").submit();
                }
            });

            $('#borrar_proveedor').click(function()
            {
                $('#proveedor').val('');
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
                    url: '{!! route('admin.proveedores.proveedores.index-ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.proveedor = $('#proveedor').val();
                    }
                },
                columns: 
                [
                    { data: 'nombre', name: 'nombre' },
                    { data: 'direccion' , name: 'direccion' },
                    { data: 'nro_telefono', name: 'nro_telefono' },
                    { data: 'celular', name: 'celular' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false} 
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

            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "{{ route('admin.proveedores.proveedores.create') }}" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
@stop
