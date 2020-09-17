<?php namespace Modules\Proveedores\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
//use Illuminate\Database\Eloquent\SoftDeletes;


class Proveedores extends Model
{
    use MediaRelation;
    //use SoftDeletes;
    protected $table = 'proveedores__proveedores';
    protected $fillable = ['nombre', 'direccion','direccion_web','direccion_map', 'nro_telefono', 'celular', 'email'];
    protected $dates = [/*'deleted_at',*/ 'created_at', 'updated_at'];
    public function proveedor_materiales()
    {
    	return $this->hasMany('Modules\Proveedores\Entities\Proveedor_Materiales', 'proveedor_id', 'id');
    }

    public function getLatitudAttribute()
    {
        $array = explode(",", $this->direccion_map);
        return array_shift($array);
    }
    public function getLongitudAttribute()
    {
        $array = explode(",", $this->direccion_map);
        return array_pop($array);
    }


    public function with_href($attribute)
    {
        $edit = "admin.proveedores.proveedores.edit";
        $editRoute = route( $edit, [$this->id]);
        $td = "<a href='".$editRoute." '>".$this[$attribute]."</a>";
        
        return $td;
    }

    public function getImagenAttribute()
    {
        if ($this->files()->first())
            return $this->files()->first()->path->getUrl();
        else
            return "";
    }
}
