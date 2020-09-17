@extends('layouts.master')

@section('content-header')
    <h1>
        Rubros
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('rubros::rubros.title.rubros') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.rubros.rubros.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(array('route' => ['admin.rubros.rubros.index-ajax'],'method' => 'post', 'id' => 'search-form')) !!}
                        <div class="row">
                            <div class="col-md-2">
                                <label for="rubro" class="control-label">Rubro:</label>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" id="borrar_rubro" title="Limpiar filtro"></i>
                                    <input type="text" class="form-control input-sm" name="rubro" id="rubro" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                {!! Form::normalSelect('categoria', 'Categoría de Rubro', $errors, $categorias) !!}
                                {!! Form::hidden('categoria_id', '') !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Nombre</th>
                                <th>Unidad de medida</th>
                                <th>Precio mano de obra</th>
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
                                <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Unidad de medida</th>
                                    <th>Precio mano de obra</th>
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
        <dd>{{ trans('rubros::rubros.title.create rubros') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {

            $("#rubro").keyup(function()
            {
                $("#search-form").submit();
            });

            $("#rubro").autocomplete(
            {
                source: '{!! route('admin.rubros.rubros.search-rubro') !!}',
                minLength: 1,
                select: function (event, ui)
                {
                    $(this).val(ui.item.label);
                    $("#search-form").submit();
                }
            });

            $('#borrar_rubro').click(function()
            {
                $('#rubro').val('');
                $("#search-form").submit();
            });

            $('select[name="categoria"]').on('change', function()
            {
                var value = $(this).find("option:selected").text();
                if (value != 'Todos')
                {
                    $('input[name="categoria_id"]').val($(this).find("option:selected").val());
                    $("#search-form").submit();
                }
                else
                {
                    $('input[name="categoria_id"]').val('');
                    $("#search-form").submit();
                }
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
                    url: '{!! route('admin.rubros.rubros.index-ajax') !!}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: function (e) 
                    {
                        e.rubro = $('#rubro').val();
                        e.categoria_id = $('input[name="categoria_id"]').val();
                    }
                },
                columns: 
                [
                    { data: 'categoria', name: 'categoria' },
                    { data: 'nombre' , name: 'nombre' },
                    { data: 'unidad_medida', name: 'unidad_medida' },
                    { data: 'precio_mano_de_obra', name: 'precio_mano_de_obra' },
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
                    { key: 'c', route: "{{ route('admin.rubros.rubros.create') }}" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
@stop
