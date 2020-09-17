@extends('layouts.master')

@section('content-header')
    <h1>
        Crear Proveedor
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.proveedores.proveedores.index') }}">{{ trans('proveedores::proveedores.title.proveedores') }}</a></li>
        <li class="active">{{ trans('proveedores::proveedores.title.create proveedores') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
    <style type="text/css">
        #map_canvas 
        {
            width: 980px;
            height: 500px;
        }
        #current 
        {
            padding-top: 25px;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.proveedores.proveedores.store'], 'method' => 'post', "id" => "formulario"]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('proveedores::admin.proveedores.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.proveedores.proveedores.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDurLsF4dEHoKxDmAj1JnRblxONYPChIiU&region=GB"></script>
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            var map = new google.maps.Map(document.getElementById('map_canvas'), 
            {
                zoom: 13,
                center: new google.maps.LatLng(-25.277, -57.637),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var myMarker = new google.maps.Marker
            ({
                position: new google.maps.LatLng(-25.277, -57.637),
                draggable: true
            });

            google.maps.event.addListener(myMarker, 'dragend', function (evt) 
            {
                document.getElementById('latitud_longitud').innerHTML = '<p>' + evt.latLng.lat().toFixed(3) + ',' + evt.latLng.lng().toFixed(3) + '</p>';
            });

            google.maps.event.addListener(myMarker, 'dragstart', function (evt) 
            {
                document.getElementById('latitud_longitud').innerHTML = '<p>Moviendo Marcador...</p>';
            });

            map.setCenter(myMarker.position);
            myMarker.setMap(map);


            $("#formulario").submit(function()
            {
                $("input[name=direccion_map]").val( $("#latitud_longitud").text() );
            });








            $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.proveedores.proveedores.index') }}" }]});
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: 'icheckbox_flat-blue',radioClass: 'iradio_flat-blue'});
        });
    </script>
@stop
