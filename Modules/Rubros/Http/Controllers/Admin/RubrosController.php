<?php namespace Modules\Rubros\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Rubros\Entities\Rubros;
use Modules\Rubros\Repositories\RubrosRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Rubros\Entities\Categorias_Rubro;
use Yajra\Datatables\Facades\Datatables;
use Modules\Rubros\Http\Requests\RubrosRequest;
use Modules\Rubros\Entities\Rubro_Materiales;
use DB;

class RubrosController extends AdminBaseController
{
    /**
     * @var RubrosRepository
     */
    private $rubros;

    public function __construct(RubrosRepository $rubros)
    {
        parent::__construct();

        $this->rubros = $rubros;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categorias[0] = 'Todos';
        $query = Categorias_Rubro::orderBy('nombre')->lists('nombre', 'id')->all();
        foreach ($query as $key => $value)
            $categorias[$key] = $value;

        return view('rubros::admin.rubros.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categorias = Categorias_Rubro::orderBy('nombre')->lists('nombre', 'id')->all();

        return view('rubros::admin.rubros.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $categoria_id = $request->get('categoria_id');
        $nombre = $request->get('nombre');
        $unidad_medida = $request->get('unidad_medida');
        $precio_mano_obra = $request->get('precio_mano_de_obra');

        if ($precio_mano_obra == '')
            $precio_mano_obra = 0;

        $materiales = $request->get('material');
        $cantidad = $request->get('cantidad');

        DB::beginTransaction();

        try
        {
            $rubro = Rubros::create([
                'categoria_id' => $categoria_id,
                'nombre' => $nombre,
                'unidad_medida' => $unidad_medida,
                'precio_mano_de_obra' => $precio_mano_obra,
            ]);

            foreach ($materiales as $key => $material)
            {
                if (isset($cantidad[$material]))
                {
                    Rubro_Materiales::create([
                        'material_id' => $material,
                        'rubro_id' => $rubro->id,
                        'cantidad' => (double) $cantidad[$material],
                    ]);
                }
            }
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error('Hubo un error al crear los datos');
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource created', ['name' => 'Rubro']));

        return redirect()->route('admin.rubros.rubros.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Rubros $rubros
     * @return Response
     */
    public function edit(Rubros $rubro)
    {
        $categorias = Categorias_Rubro::orderBy('nombre')->lists('nombre', 'id')->all();

        $materiales = Rubro_Materiales::where('rubro_id', $rubro->id)
                                ->join('materiales__materiales', 'materiales__materiales.id', '=', 'rubros__rubro_materiales.material_id')
                                ->orderBy('materiales__materiales.nombre')
                                ->select('rubros__rubro_materiales.*')
                                ->get();

        return view('rubros::admin.rubros.edit', compact('rubro', 'categorias', 'materiales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Rubros $rubros
     * @param  Request $request
     * @return Response
     */
    public function update(Rubros $rubro, Request $request)
    {
        $categoria_id = $request->get('categoria_id');
        $nombre = $request->get('nombre');
        $unidad_medida = $request->get('unidad_medida');
        $precio_mano_obra = $request->get('precio_mano_de_obra');

        if ($precio_mano_obra == '')
            $precio_mano_obra = 0;

        $materiales = $request->get('material');
        $cantidad = $request->get('cantidad');
        $remove = $request->get('bd_remove');

        DB::beginTransaction();

        try
        {
            Rubros::where('id', $rubro->id)->update([
                'categoria_id' => $categoria_id,
                'nombre' => $nombre,
                'unidad_medida' => $unidad_medida,
                'precio_mano_de_obra' => $precio_mano_obra
            ]);

            if (is_array($remove) && !empty($remove))
            {
                foreach ($remove as $key => $value)
                {
                    if (Rubro_Materiales::where('id', $value)->exists())
                        Rubro_Materiales::where('id', $value)->delete();
                }
            }

            if (is_array($materiales) && !empty($materiales))
            {
                foreach ($materiales as $key => $material)
                {
                    if (isset($cantidad[$material]))
                    {
                        Rubro_Materiales::create([
                            'material_id' => $material,
                            'rubro_id' => $rubro->id,
                            'cantidad' => $cantidad[$material],
                        ]);
                    }
                }
            }
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error('Hubo un error al actualizar los datos');
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource updated', ['name' => 'Rubro']));

        return redirect()->route('admin.rubros.rubros.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Rubros $rubros
     * @return Response
     */
    public function destroy(Rubros $rubros)
    {
        DB::beginTransaction();

        try
        {
            if (Rubro_Materiales::where('rubro_id', $rubros->id)->exists())
                Rubro_Materiales::where('rubro_id', $rubros->id)->delete();

            $this->rubros->destroy($rubros);
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error('Hubo un error al eliminar los datos');
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource deleted', ['name' => 'Rubro']));

        return redirect()->route('admin.rubros.rubros.index');
    }

    public function index_ajax(Request $request)
    {
        $query = Rubros::join('rubros__categorias_rubros', 'rubros__categorias_rubros.id', '=', 'rubros__rubros.categoria_id')
                        ->select([
                            'rubros__rubros.*',
                            'rubros__categorias_rubros.nombre as categoria'
                        ])
                        ->orderBy('rubros__categorias_rubros.nombre')
                        ->orderBy('rubros__rubros.nombre');

        $object = Datatables::of($query)
                    ->addColumn('action', function ($tabla) {
                        $edit = "admin.rubros.rubros.edit";
                        $destroy = "admin.rubros.rubros.destroy";
                        $editRoute = route( $edit, [$tabla->id]);
                        $deleteRoute = route( $destroy, [$tabla->id]);

                        $buttons="<div class='btn-group'>
                            <a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                <i class='fa fa-trash'></i>
                            </button>
                            </div>";

                        return $buttons;
                    })
                    ->editColumn('categoria', function ($tabla) {
                        return '<a>'.$tabla->categoria.'</a>';
                    })
                    ->editColumn('nombre', function ($tabla) {
                        return $tabla->with_href('nombre');
                    })
                    ->editColumn('unidad_medida', function ($tabla) {
                        return $tabla->with_href('unidad_medida');
                    })
                    ->editColumn('precio_mano_de_obra', function ($tabla) {
                        return $tabla->with_href('precio_mano_de_obra');
                    })
                    ->filter(function ($query) use ($request)
                    {
                        if ($request->has('rubro')  && trim($request->get('rubro') !== '') )
                            $query->where('rubros__rubros.nombre', 'like', "%{$request->get('rubro')}%");

                        if ($request->has('categoria_id'))
                            $query->where('rubros__rubros.categoria_id', '=', $request->get('categoria_id'));
                    })
                    ->make(true);
        
        return $object;
    }

    public function search_rubro(Request $request)
    {
        if ($request->has('term')  && trim($request->has('term') !== '') )  
        {
            $query = DB::table('rubros__rubros')
                ->where('nombre', 'like', "%{$request->get('term')}%")
                ->take(5)
                ->get(['id', 'nombre']);
        }

        foreach ($query as $q)
            $results[] = [ 'id' => $q->id, 'value' => $q->nombre];
        
        if (isset($results) && !empty($results))
            return response()->json($results);
        else
            return response()->json("");
    }

    public function search_material(Request $request)
    {
        $datos = array();
        if ($request->has('datos'))
        {
            $datos = $request->get('datos');
            foreach ($datos as $key => $value)
                if ($value == "")
                    unset($datos[$key]);
        }

        if ($request->has('term')  && trim($request->has('term') !== '') )  
        {
            $query = \Materiales::
                whereNotIn('id', $datos)
                ->where('nombre', 'like', "%{$request->get('term')}%")
                ->take(5)
                ->get();
        }

        foreach ($query as $q)
            $results[] = [ 'id' => $q->id, 'value' => $q->nombre.' ('.$q->unidad_medida.')', 'precio' => $q->precio_unitario];
        
        if (isset($results) && !empty($results))
            return response()->json($results);
        else
            return response()->json("");
    }

    public function validate_rubro(Request $request)
    {
        $rubro_id = null;
        $nombre = $request->get('nombre');

        if ($request->has('rubro_id'))
        {   
            $rubro_id = $request->get('rubro_id');
            if (Rubros::where('nombre', $nombre)->where('id', '!=', $rubro_id)->exists())
                return response()->json(['msg' => true]);
            else
                return response()->json(['msg' => false]);
        }
        else
        {
            if (Rubros::where('nombre', $nombre)->exists())
                return response()->json(['msg' => true]);
            else
                return response()->json(['msg' => false]);
        }
    }
}