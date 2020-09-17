<?php namespace Modules\Proveedores\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedoresRequest extends FormRequest {

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
				'nombre' => 'required|max:500|unique:proveedores__proveedores,nombre,'.$this->proveedores->id
			];
        }
        else
        {
        	$custom_rules =
        	[
				'nombre' => 'required|max:500|unique:proveedores__proveedores'
			];
        }

        $basic_rules = 
        [
        	'direccion' => 'max:500',
        	'nro_telefono' => 'max:255',
        	'celular' => 'max:255',
        	'email' => 'max:255',
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
            'nombre.required' => 'El nombre del proveedor es requerido',
            'nombre.max' => 'La cantidad maxima de caracteres aceptada es 500',
            'nombre.unique' => 'El nombre del proveedor ya existe en el sistema',
            'direccion.max' => 'La cantidad maxima de caracteres aceptada es 255',
            'nro_telefono.max' => 'La cantidad maxima de caracteres aceptada es 255',
            'celular.max' => 'La cantidad maxima de caracteres aceptada es 255',
            'email.max' => 'La cantidad maxima de caracteres aceptada es 255',
        ];
    }
}