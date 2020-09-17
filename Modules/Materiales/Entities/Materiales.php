<?php namespace Modules\Materiales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Proveedores\Entities\Proveedor_Materiales;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiales extends Model
{
    use SoftDeletes;
    protected $table = 'materiales__materiales';
    protected $fillable = ['nombre', 'unidad_medida', 'precio_unitario', 'observacion'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function with_href($attribute)
    {
        $edit = "admin.materiales.materiales.edit";
        $editRoute = route( $edit, [$this->id]);
        
        if ($attribute == 'precio_unitario')
            $td = "<a href='".$editRoute." '>".$this->get_precio_format()."</a>";
        else
            $td = "<a href='".$editRoute." '>".$this[$attribute]."</a>";
        
        return $td;
    }

    public function get_precio_format()
    {
        $precio = $this->attributes['precio_unitario'];
        $precio_format = number_format( $precio , 0 , '.' , '.' );
        return 'Gs ' . $precio_format;
    }

    public function rubro_materiales()
    {
        return $this->hasMany('Modules\Rubros\Entities\Rubro_Materiales', 'material_id', 'id');
    }

    public function proveedor_materiales()
    {
        return $this->hasMany('Modules\Proveedores\Entities\Proveedor_Materiales', 'material_id', 'id');
    }

    public function proveedores()
    {
        return $this->belongsToMany( \Proveedores::class, 'proveedores__proveedor_materiales', 'material_id', 'proveedor_id' )->orderBy("nombre", "ASC");
    }

    public function proveedor_has_material($proveedor_id)
    {
        return Proveedor_Materiales::where('proveedor_id', $proveedor_id)->where('material_id', $this->attributes['id'])->exists();
    }
}