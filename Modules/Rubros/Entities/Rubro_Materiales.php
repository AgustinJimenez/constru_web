<?php namespace Modules\Rubros\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubro_Materiales extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $table = 'rubros__rubro_materiales';
    protected $fillable = ['material_id', 'rubro_id', 'cantidad'];
    protected $appends = ['precio_total'];

    public function material()
    {
        return $this->belongsTo('Modules\Materiales\Entities\Materiales', 'material_id', 'id');
    }

    public function rubro()
    {
        return $this->belongsTo('Modules\Rubros\Entities\Rubros', 'rubro_id', 'id');
    }

    public function getPrecioTotalAttribute()
    {
        if($this->material)
            return number_format(($this->material->precio_unitario*$this->cantidad), '0','','.');
        else
            return 0;
    }
}