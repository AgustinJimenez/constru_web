<?php namespace Modules\Proveedores\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor_Materiales extends Model
{
    //use SoftDeletes;
    protected $table = 'proveedores__proveedor_materiales';
    protected $fillable = ['proveedor_id', 'material_id'];
    protected $dates = [/*'deleted_at',*/'created_at', 'updated_at'];
    public function proveedor()
    {
        return $this->belongsTo('Modules\Proveedores\Entities\Proveedores', 'proveedor_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('Modules\Materiales\Entities\Materiales', 'material_id', 'id');
    }


}
