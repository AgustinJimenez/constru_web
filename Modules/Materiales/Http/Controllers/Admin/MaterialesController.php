<?php namespace Modules\Materiales\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Materiales\Entities\Materiales;
use Modules\Materiales\Repositories\MaterialesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Materiales\Http\Requests\MaterialesRequest;
use Yajra\Datatables\Facades\Datatables;
use DB;

class MaterialesController extends AdminBaseController
{
    /**
     * @var MaterialesRepository
     */
    private $materiales;

    public function __construct(MaterialesRepository $materiales)
    {
        parent::__construct();

        $this->materiales = $materiales;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('materiales::admin.materiales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('materiales::admin.materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(MaterialesRequest $request)
    {
        $this->materiales->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => 'Material']));

        return redirect()->route('admin.materiales.materiales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Materiales $materiales
     * @return Response
     */
    public function edit(Materiales $materiales)
    {
        return view('materiales::admin.materiales.edit', compact('materiales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Materiales $materiales
     * @param  Request $request
     * @return Response
     */
    public function update(Materiales $materiales, MaterialesRequest $request)
    {
        $this->materiales->update($materiales, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => 'Material']));

        return redirect()->route('admin.materiales.materiales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Materiales $materiales
     * @return Response
     */
    public function destroy(Materiales $materiales)
    {
        $this->materiales->destroy($materiales);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => 'Material']));

        return redirect()->route('admin.materiales.materiales.index');
    }

    public function index_ajax(Request $request)
    {
        $query = Materiales::orderBy('nombre');

        if ($request->has('material')  && trim($request->get('material') !== '') )
            $query->where('nombre', 'like', "%{$request->get('material')}%");
        
        $object = Datatables::of($query)
            ->addColumn('action', function ($tabla) {
                $edit = "admin.materiales.materiales.edit";
                $destroy = "admin.materiales.materiales.destroy";
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
            ->editColumn('nombre', function ($tabla) 
            {
                return $tabla->with_href('nombre');
            })
            ->editColumn('unidad_medida', function ($tabla) 
            {
                return $tabla->with_href('unidad_medida');
            })
            ->editColumn('precio_unitario', function ($tabla) 
            {
                return $tabla->with_href('precio_unitario');
            })
            ->editColumn('observacion', function ($tabla) 
            {
                return $tabla->with_href('observacion');
            })
            ->make(true);
        return $object;
    }

    public function search_material(Request $request)
    {
        if ($request->has('term')  && trim($request->has('term') !== '') )  
        {
            $query = DB::table('materiales__materiales')
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
}