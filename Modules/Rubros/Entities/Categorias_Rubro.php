<?php namespace Modules\Rubros\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorias_Rubro extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $table = 'rubros__categorias_rubros';
    protected $fillable = ['numero', 'nombre'];

    public function rubros()
    {
    	return $this->hasMany('Modules\Rubros\Entities\Rubros', 'categoria_id', 'id');
    }
}
