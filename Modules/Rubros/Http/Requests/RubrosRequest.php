<?php namespace Modules\Rubros\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RubrosRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if($this->method() == 'PUT')
        {
        	$custom_rules =
        	[
				'nombre' => 'required|max:500|unique:rubros__rubros,nombre,'.$this->rubros->id
			];
        }
        else
        {
        	$custom_rules =
        	[
				'nombre' => 'required|max:500|unique:rubros__rubros'
			];
        }

        $basic_rules = 
        [
        	'categoria_id' => 'required',
        	'unidad_medida' => 'required',
        	'precio_mano_de_obra' => 'numeric'
        ];

        $rules = array_merge($basic_rules, $custom_rules);

        return $rules;
	}

	/**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
	public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la categoría es requerido',
            'nombre.max' => 'La cantidad maxima de caracteres aceptada es 500',
            'nombre.unique' => 'El nombre ya existe en el sistema',
            'categoria_id.required' => 'La categoria es requerida',
            'unidad_medida.required' => 'La unidad de medida es requerida',
			'precio_mano_de_obra.numeric' => 'El precio de mano de obra debe ser númerico',
        ];
    }

}
