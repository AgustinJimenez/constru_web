<?php namespace Modules\Materiales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialesRequest extends FormRequest {

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
				'nombre' => 'required|max:500|unique:materiales__materiales,nombre,'.$this->materiales->id
			];
        }
        else
        {
        	$custom_rules =
        	[
				'nombre' => 'required|max:500|unique:materiales__materiales'
			];
        }

        $basic_rules = 
        [
        	'unidad_medida' => 'required|max:255',
			'precio_unitario' => 'required',
            'observacion' => 'max:1000'
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
            'nombre.required' => 'El nombre del material es requerido',
            'nombre.max' => 'La cantidad maxima de caracteres aceptada es 500',
            'nombre.unique' => 'El nombre ya existe en el sistema',
            'unidad_medida.required' => 'La unidad de medida es requerida',
            'unidad_medida.max' => 'La cantidad maxima de caracteres aceptada es 255',
            'precio_unitario.required' => 'El precio unitario es requerido',
            'observacion.max' => 'La cantidad maxima de caracteres aceptada es 1000'
        ];
    }
}
