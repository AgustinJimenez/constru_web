<?php namespace Modules\Proveedores\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Proveedores\Entities\Proveedor_Materiales;
use Modules\Proveedores\Repositories\Proveedor_MaterialesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Proveedor_MaterialesController extends AdminBaseController
{
    /**
     * @var Proveedor_MaterialesRepository
     */
    private $proveedor_materiales;

    public function __construct(Proveedor_MaterialesRepository $proveedor_materiales)
    {
        parent::__construct();

        $this->proveedor_materiales = $proveedor_materiales;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$proveedor_materiales = $this->proveedor_materiales->all();

        return view('proveedores::admin.proveedor_materiales.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('proveedores::admin.proveedor_materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->proveedor_materiales->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('proveedores::proveedor_materiales.title.proveedor_materiales')]));

        return redirect()->route('admin.proveedores.proveedor_materiales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Proveedor_Materiales $proveedor_materiales
     * @return Response
     */
    public function edit(Proveedor_Materiales $proveedor_materiales)
    {
        return view('proveedores::admin.proveedor_materiales.edit', compact('proveedor_materiales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Proveedor_Materiales $proveedor_materiales
     * @param  Request $request
     * @return Response
     */
    public function update(Proveedor_Materiales $proveedor_materiales, Request $request)
    {
        $this->proveedor_materiales->update($proveedor_materiales, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('proveedores::proveedor_materiales.title.proveedor_materiales')]));

        return redirect()->route('admin.proveedores.proveedor_materiales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Proveedor_Materiales $proveedor_materiales
     * @return Response
     */
    public function destroy(Proveedor_Materiales $proveedor_materiales)
    {
        $this->proveedor_materiales->destroy($proveedor_materiales);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('proveedores::proveedor_materiales.title.proveedor_materiales')]));

        return redirect()->route('admin.proveedores.proveedor_materiales.index');
    }
}
