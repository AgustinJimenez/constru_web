<?php namespace Modules\Rubros\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Rubros\Entities\Rubro_Materiales;
use Modules\Rubros\Repositories\Rubro_MaterialesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Rubro_MaterialesController extends AdminBaseController
{
    /**
     * @var Rubro_MaterialesRepository
     */
    private $rubro_materiales;

    public function __construct(Rubro_MaterialesRepository $rubro_materiales)
    {
        parent::__construct();

        $this->rubro_materiales = $rubro_materiales;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$rubro_materiales = $this->rubro_materiales->all();

        return view('rubros::admin.rubro_materiales.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('rubros::admin.rubro_materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->rubro_materiales->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('rubros::rubro_materiales.title.rubro_materiales')]));

        return redirect()->route('admin.rubros.rubro_materiales.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Rubro_Materiales $rubro_materiales
     * @return Response
     */
    public function edit(Rubro_Materiales $rubro_materiales)
    {
        return view('rubros::admin.rubro_materiales.edit', compact('rubro_materiales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Rubro_Materiales $rubro_materiales
     * @param  Request $request
     * @return Response
     */
    public function update(Rubro_Materiales $rubro_materiales, Request $request)
    {
        $this->rubro_materiales->update($rubro_materiales, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('rubros::rubro_materiales.title.rubro_materiales')]));

        return redirect()->route('admin.rubros.rubro_materiales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Rubro_Materiales $rubro_materiales
     * @return Response
     */
    public function destroy(Rubro_Materiales $rubro_materiales)
    {
        $this->rubro_materiales->destroy($rubro_materiales);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('rubros::rubro_materiales.title.rubro_materiales')]));

        return redirect()->route('admin.rubros.rubro_materiales.index');
    }
}
