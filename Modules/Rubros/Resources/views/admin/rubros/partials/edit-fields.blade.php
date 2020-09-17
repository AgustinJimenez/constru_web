<div class="box-body">
    {!! Form::normalSelect('categoria_id', 'Categoría de Rubro', $errors, $categorias, $rubro) !!}
    {!! Form::hidden('rubro_id', $rubro->id) !!}
    {!! Form::normalInput('nombre', 'Nombre', $errors, $rubro) !!}
    {!! Form::normalInput('unidad_medida', 'Unidad de medida', $errors, $rubro) !!}
    {!! Form::normalInput('precio_mano_de_obra', 'Precio mano de obra', $errors, $rubro) !!}

    <div class="row">
    	<div class="col-sm-12 text-center">
    		<h3>Materiales del rubro</h3>
    	</div>
    </div>

    <div class="row">
	    <div class="form-inline col-sm-12">
	    	<label for="material">Material:</label>
	    	<div class="form-group">
	    		{!! Form::text('mat_name', '', ['class' => 'input-sm', 'id' => 'mat_name']) !!}
		    	{!! Form::hidden('mat_id_holder', '') !!}
		    	{!! Form::hidden('mat_precio_holder', '') !!}
	    	</div>
    		<label for="cantidad" style="margin-left: 10px;">Cantidad:</label>
    		<div class="form-group">
	    		{!! Form::number('cant_mat', '', ['class' => 'input-sm', 'id' => 'cant_mat', 'min' => 0, 'max' => 1000]) !!}
    		</div>
	    	<div class="form-group" style="margin-left: 20px;">
	    		{!! Form::button('Agregar', array('class' => 'btn btn-primary add_row', 'id' => 'add_row', 'tabIndex' => "-1")) !!}
	    	</div>
	    </div>
	</div>

    <div class="col-sm-12 table-responsive" style="padding-left: 0;margin-top: 20px;">
	    <table class="table table-bordered table-hover">
	    	<thead>
	    		<tr>
	    			<th class="text-center">Material</th>
	    			<th class="text-center">Cantidad</th>
	    			<th class="text-center">Prec. Unitario</th>
	    			<th class="text-center">Prec. Total</th>
	    			<th class="text-center">Acciones</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		@foreach($materiales as $key => $value)
	    			<tr class="text-center">
	    				<td><a>{{$value->material->nombre . ' (' . $value->material->unidad_medida . ')'}}</a></td>
	    				<td><a>{{$value->cantidad}}</a></td>
	    				<td><a>{{$value->material->get_precio_format()}}</a></td>
	    				<td class="total_row"><a>Gs {{$value->precio_total}}</a></td>
	    				<td><a class='remove_bd btn btn-danger'><i class='fa fa-trash'></i></a></td>
	    				{!! Form::hidden('total_material', str_replace(".", "", $value->precio_total)) !!}
	    				{!! Form::hidden('bd_material[]', $value->material->id) !!}
	    				{!! Form::hidden('bd_row[]', $value->id) !!}
	    				{!! Form::hidden('bd_remove[]', '') !!}
	    			</tr>
	    		@endforeach
	    	</tbody>
	    	<tfoot>
	    		<tr>
	    			<th scope="col" colspan="3" class="text-center">Total</th>
	    			<th> 
		    			{!! Form::text('total_precio', '',
			    			[
			    				'id' => 'total_precio',
			    				'disabled' => 'disabled',
			    				'class' => 'text-center input-background-none input-full-width'
			    			]) 
		    			!!}
		    			{!! Form::hidden('total_holder', 0) !!}
		    		</th>
	    			<th></th>
	    		</tr>
	    	</tfoot>
	    </table>
	</div>

</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		var materiales = new Array();

		initMateriales();
		function initMateriales()
		{
			$('input[name="bd_material[]"]').each(function()
			{
				var id = $(this).val();
				materiales[id] = id;
			});

			var total = 0;
			$('input[name="total_material"]').each(function()
			{
				var value = $(this).val();
				total = Number(total) + Number(value);
			});
			sum_total(total);
		}

		$("#mat_name").autocomplete(
        {
            source: function (request, response)
            {
            	$.ajax({
		          url: '{!! route('admin.rubros.rubros.search-material') !!}',
		          dataType: "json",
		          data: {
		            term: request.term,
		            datos: materiales,
		          },
		          success: function( data ) {
		            response(data);
		          }
		        });
            },
            minLength: 1,
            select: function (event, ui)
            {
                $(this).val(ui.item.label);
                $('input[name="mat_id_holder"]').val(ui.item.id);
                $('input[name="mat_precio_holder"]').val(ui.item.precio);
            }
        });

        $("#mat_name").keyup(function()
        {
        	$('input[name="mat_id_holder"]').val('');
        });

		$("#add_row").click(function()
		{
            var mat = $("#mat_name").val();
            var id = $('input[name="mat_id_holder"]').val();
            var cant = $("#cant_mat").val();
            var precio = $('input[name="mat_precio_holder"]').val();

            if (id == '')
            	$.alert({title: 'Atención!',content: 'El material no existe'});
            else if (mat == '')
            	$.alert({title: 'Atención!',content: 'Debe ingresar un material'});
            else if (cant == '')
            	$.alert({title: 'Atención!', content: 'Debe ingresar una cantidad'});
            else
            {
            	materiales[id] = id;
            	var total = Number(cant)*Number(precio);

            	var row = "<tr class='text-center'><td><a>" + mat + "</a></td><td><a>" + cant + "</a></td><td><a> Gs " + number_format(precio) + "</a></td><td><a> Gs " + number_format(total) + "</a></td><td><a class='remove_row btn btn-danger'><i class='fa fa-trash'></i></a></td><input type='hidden' name='total_material' value='"+total+"'><input type='hidden' name='material[]' value='"+id+"'><input type='hidden' name='cantidad["+id+"]' value='"+cant+"' class='cantidad-material'></tr>";
	            $('table tbody').append(row);
	            
	            sum_total(total);
	            clean_input();
            }
        });

        $('table tbody').on('click', 'a.remove_row', function(e)
        {
        	var $row = $(this);
		    e.preventDefault();
		    e.stopImmediatePropagation();
		    $.confirm({
			    title: 'Atención!',
			    content: 'Está seguro que desea eliminar el material?',
			    buttons: {
			        formSubmit: {
			            text: 'Aceptar',
			            btnClass: 'btn-danger',
			            action: function ()
			            {
			            	var i = materiales.indexOf($row.parents('tr').find('input[name="material[]"]').val());
			            	if (i != -1)
			            		materiales.splice(i, 1);
			            	var $input_total = $row.parents('tr').find('input[name="total_material"]');
			            	res_total($input_total.val());
			            	$input_total.val('');
			                $row.parents("tr").remove();
			            }
			        },
			        cancel: function () {},
			    },
			});
		});

		$('table tbody').on('click', 'a.remove_bd', function(e)
		{
		    var $row = $(this);
		    e.preventDefault();
		    e.stopImmediatePropagation();
		    $.confirm({
			    title: 'Atención!',
			    content: 'Está seguro que desea eliminar el material?',
			    buttons: {
			        formSubmit: {
			            text: 'Aceptar',
			            btnClass: 'btn-danger',
			            action: function ()
			            {
			            	var i = materiales.indexOf($row.parents('tr').find('input[name="bd_material[]"]').val());
							if (i != -1)
			            		materiales.splice(i, 1);
			            	var row_val = $row.parents('tr').find('input[name="bd_row[]"]').val();
			            	$row.parents('tr').find('input[name="bd_remove[]"]').val(row_val);
			            	var $input_total = $row.parents('tr').find('input[name="total_material"]');
			            	res_total($input_total.val());
			            	$input_total.val('');
			                $row.parents('tr').hide();
			            }
			        },
			        cancel: function () {},
			    },
			});
		});

		function res_total(total)
		{
			var $input = $('input[name="total_holder"]');
			var total_value = $input.val();
			total_value = Number(total_value) - Number(total);
			$input.val(total_value);
			$('input[name="total_precio"]').val('Gs ' + number_format(total_value));
		}

		function sum_total(total)
		{
			var $input = $('input[name="total_holder"]');
			var total_value = $input.val();
			total_value = Number(total_value) + Number(total);
			$input.val(total_value);
			$('input[name="total_precio"]').val('Gs ' + number_format(total_value));
		}

        function clean_input()
        {
        	$('#mat_name').val('').text('');
        	$("#cant_mat").val('').text('');
        	$('input[name="mat_id_holder"]').val('');
        	$('input[name="mat_precio_holder"]').val('');
        }

        $('#form-submit').click(function(event)
        {
            event.preventDefault();

            var nombre_val = $('input[name="nombre"]').val();
            if (nombre_val != '')
            	validate_nombre();
            else
            	$.alert({title: 'Atención!', content: 'El nombre del rubro es requerido'});
        });

        function validate_nombre()
        {
        	$.ajax({
				type: 'POST',
				url: '{!! route('admin.rubros.rubros.validate-rubro') !!}',
				headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				data: {
					'nombre':$('input[name="nombre"]').val(),
					'rubro_id':$('input[name="rubro_id"]').val()
				},
				success: function(result)
				{
					if (result.msg)
						$.alert({title: 'Atención!', content: 'El nombre del rubro ya existe en el sistema'});
					else
						validate_form();
				}
			});
        }

        function validate_form()
        {
        	var categoria_val = $('input[name="categoria_id"]').val();
        	var unidad_val = $('input[name="unidad_medida"]').val();

        	if (categoria_val == '')
        		$.alert({title: 'Atención!', content: 'La categoría es requerida'});
        	else if (unidad_val == '')
        		$.alert({title: 'Atención!', content: 'La unidad de medida es requerida'});
        	else 
        		$('#edit-form').submit();
        }

        $('#edit-form').submit(function()
        {
	        $('input[name="bd_remove[]"]').each(function()
            {
                if ($(this).val() == '')
                	$(this).prop('disabled', true);
            });

            this.submit();
            return true;
        });

        function number_format(n, dp)
        {
			var s = ''+(Math.floor(n)), d = n % 1, i = s.length, r = '';
			while ( (i -= 3) > 0 ) { r = '.' + s.substr(i, 3) + r; }
			return s.substr(0, i + 3) + r + (d ? '.' + Math.round(d * Math.pow(10,dp||2)) : '');
		}

	});
</script>