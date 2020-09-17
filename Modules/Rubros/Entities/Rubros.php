<?php namespace Modules\Rubros\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubros extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $table = 'rubros__rubros';
    protected $fillable = ['categoria_id', 'nombre', 'unidad_medida', 'precio_mano_de_obra'];
    protected $appends = ['precio_unitario'];

    public function categoria()
    {
        return $this->belongsTo('Modules\Rubros\Entities\Categorias_Rubro', 'categoria_id', 'id');
    }

    public function rubro_materiales()
    {
    	return $this->hasMany('Modules\Rubros\Entities\Rubro_Materiales', 'rubro_id', 'id');
    }

    public function with_href($attribute)
    {
        $edit = "admin.rubros.rubros.edit";
        $editRoute = route( $edit, [$this->id]);

        if ($attribute == 'precio_mano_de_obra')
            $td = "<a href='".$editRoute." '>".$this->format_precio($attribute)."</a>";
        else
            $td = "<a href='".$editRoute." '>".$this[$attribute]."</a>";
        
        return $td;
    }

    public function format_precio($attribute)
    {
        $precio = $this->attributes[$attribute];
        $precio_format = number_format( $precio , 0 , '.' , '.' );
        return 'Gs ' . $precio_format;
    }

    public function getPrecioUnitarioAttribute()
    {
        $aux = 0;
        foreach ($this->rubro_materiales as $key => $value)
            $aux += intval(str_replace(',', '', str_replace('.', '', $value->precio_total)));

        return number_format($aux, '0','','.');
    }
}