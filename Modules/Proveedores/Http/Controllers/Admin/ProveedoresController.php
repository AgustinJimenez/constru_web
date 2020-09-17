<?php namespace Modules\Proveedores\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Proveedores\Entities\Proveedores;
use Modules\Proveedores\Repositories\ProveedoresRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Proveedores\Http\Requests\ProveedoresRequest;
use Yajra\Datatables\Facades\Datatables;
use Modules\Proveedores\Entities\Proveedor_Materiales;
use Modules\Materiales\Entities\Materiales;
use DB;
use Modules\Proveedores\Events\ProveedorWasCreated;
use Modules\Media\Repositories\FileRepository;

class ProveedoresController extends AdminBaseController
{
    /**
     * @var ProveedoresRepository
     */
    private $proveedores;

    public function __construct(ProveedoresRepository $proveedores)
    {
        parent::__construct();

        $this->proveedores = $proveedores;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$proveedores = $this->proveedores->all();

        return view('proveedores::admin.proveedores.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('proveedores::admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(ProveedoresRequest $request)
    {
        $proveedor = $this->proveedores->create($request->all());

        event(new ProveedorWasCreated($proveedor, $request->all()));

        flash()->success(trans('core::core.messages.resource created', ['name' => 'Proveedor']));

        return redirect()->route('admin.proveedores.proveedores.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Proveedores $proveedores
     * @return Response
     */
    public function edit(Proveedores $proveedores, FileRepository $FileRepository)
    {
        $imagen = $FileRepository->findFileByZoneForEntity('imagen', $proveedores);
        $direccion = explode(',', $proveedores->direccion_map);
        $latitud = (double)array_shift( $direccion );
        $longitud = (double)array_shift( $direccion );
        return view('proveedores::admin.proveedores.edit', compact('proveedores', 'imagen', 'latitud', 'longitud'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Proveedores $proveedores
     * @param  Request $request
     * @return Response
     */
    public function update(Proveedores $proveedores, ProveedoresRequest $request)
    {
        $this->proveedores->update($proveedores, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => 'Proveedor']));

        return redirect()->route('admin.proveedores.proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Proveedores $proveedores
     * @return Response
     */
    public function destroy(Proveedores $proveedores)
    {
        DB::beginTransaction();

        try
        {
            if (Proveedor_Materiales::where('proveedor_id', $proveedores->id)->exists())
                Proveedor_Materiales::where('proveedor_id', $proveedores->id)->delete();

            $this->proveedores->destroy($proveedores);
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error('Hubo un error al eliminar los datos');
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success(trans('core::core.messages.resource deleted', ['name' => 'Proveedor']));

        return redirect()->route('admin.proveedores.proveedores.index');
    }

    public function index_ajax(Request $request)
    {
        $query = Proveedores::orderBy('nombre');

        $object = Datatables::of($query)
                    ->addColumn('action', function ($tabla) {
                        $edit = "admin.proveedores.proveedores.edit";
                        $destroy = "admin.proveedores.proveedores.destroy";
                        $editRoute = route( $edit, [$tabla->id]);
                        $deleteRoute = route( $destroy, [$tabla->id]);
                        $material = "admin.proveedores.proveedores.proveedor-materiales";
                        $materialRoute = route( $material, [$tabla->id]);

                        $buttons="<div class='btn-group'>
                            <a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                            <a href='".$materialRoute." ' class='btn btn-default btn-flat'>
                                Materiales
                            </a>
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                <i class='fa fa-trash'></i>
                            </button>
                            </div>";

                        return $buttons;
                    })
                    ->editColumn('nombre', function ($tabla) {
                        return $tabla->with_href('nombre');
                    })
                    ->editColumn('direccion', function ($tabla) {
                        return $tabla->with_href('direccion');
                    })
                    ->editColumn('nro_telefono', function ($tabla) {
                        return $tabla->with_href('nro_telefono');
                    })
                    ->editColumn('celular', function ($tabla) {
                        return $tabla->with_href('celular');
                    })
                    ->editColumn('email', function ($tabla) {
                        return $tabla->with_href('email');
                    })
                    ->filter(function ($query) use ($request)
                    {
                        if ($request->has('proveedor')  && trim($request->get('proveedor') !== '') )
                            $query->where('nombre', 'like', "%{$request->get('proveedor')}%");
                    })
                    ->make(true);
        
        return $object;
    }

    public function search_proveedor(Request $request)
    {
        if ($request->has('term')  && trim($request->has('term') !== '') )  
        {
            $query = DB::table('proveedores__proveedores')
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

    public function proveedor_materiales(Proveedores $proveedor)
    {
        return view('proveedores::admin.proveedores.index-materiales', compact('proveedor'));
    }

    public function index_materiales(Request $request)
    {
        $query = Materiales::orderBy('nombre');

        if ($request->has('proveedor_id'))
            $proveedor_id = $request->get('proveedor_id');

        $object = Datatables::of($query)
                    ->addColumn('agregar', function ($tabla) use ($proveedor_id) {

                        if ($tabla->proveedor_has_material($proveedor_id))
                            $checkbox="<input type='checkbox' name='material' class='check-material' value='".$tabla->id."' checked='checked'>";
                        else
                            $checkbox="<input type='checkbox' name='material' class='check-material' value='".$tabla->id."'>";

                        return $checkbox;
                    })
                    ->editColumn('nombre', function ($tabla) {
                        return $tabla->with_href('nombre');
                    })
                    ->editColumn('unidad_medida', function ($tabla) {
                        return $tabla->with_href('unidad_medida');
                    })
                    ->editColumn('precio_unitario', function ($tabla) {
                        return $tabla->with_href('precio_unitario');
                    })
                    ->filter(function ($query) use ($request)
                    {
                        if ($request->has('material')  && trim($request->get('material') !== '') )
                            $query->where('nombre', 'like', "%{$request->get('material')}%");
                    })
                    ->make(true);
        
        return $object;
    }

    public function save_material(Request $request)
    {
        $proveedor_id = $request->get('proveedor_id');
        $material_id = $request->get('material_id');
        $action = $request->get('action');

        DB::beginTransaction();

        try
        {
            if ($action == 'add')
                Proveedor_Materiales::create(['proveedor_id' => $proveedor_id, 'material_id' => $material_id]);
            else
                Proveedor_Materiales::where('proveedor_id', $proveedor_id)->where('material_id', $material_id)->delete();
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            return response()->json('Hubo un error al procesar los datos');
        }

        DB::commit();

        return response()->json('Datos actualizados correctamente');
    }
}