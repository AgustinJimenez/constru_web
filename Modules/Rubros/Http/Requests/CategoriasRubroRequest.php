<?php namespace Modules\Rubros\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriasRubroRequest extends FormRequest {

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
				'nombre' => 'required|max:500|unique:rubros__categorias_rubros,nombre,'.$this->categorias_rubro->id
			];
        }
        else
        {
        	$custom_rules =
        	[
				'nombre' => 'required|max:500|unique:rubros__categorias_rubros'
			];
        }

        $basic_rules = 
        [
        	'numero' => 'required'
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
            'numero.required' => 'El número es requerido'
        ];
    }
}
