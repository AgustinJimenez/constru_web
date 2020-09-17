<?php namespace Modules\Rubros\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Rubros\Entities\Categorias_Rubro;
use Modules\Rubros\Repositories\Categorias_RubroRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Rubros\Http\Requests\CategoriasRubroRequest;

class Categorias_RubroController extends AdminBaseController
{
    /**
     * @var Categorias_RubroRepository
     */
    private $categorias_rubro;

    public function __construct(Categorias_RubroRepository $categorias_rubro)
    {
        parent::__construct();

        $this->categorias_rubro = $categorias_rubro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categorias_rubros = Categorias_Rubro::orderBy('numero')->get();

        return view('rubros::admin.categorias_rubros.index', compact('categorias_rubros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('rubros::admin.categorias_rubros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CategoriasRubroRequest $request)
    {
        $this->categorias_rubro->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => 'Categoría de Rubro']));

        return redirect()->route('admin.rubros.categorias_rubro.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Categorias_Rubro $categorias_rubro
     * @return Response
     */
    public function edit(Categorias_Rubro $categorias_rubro)
    {
        return view('rubros::admin.categorias_rubros.edit', compact('categorias_rubro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Categorias_Rubro $categorias_rubro
     * @param  Request $request
     * @return Response
     */
    public function update(Categorias_Rubro $categorias_rubro, CategoriasRubroRequest $request)
    {
        $this->categorias_rubro->update($categorias_rubro, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => 'Categoría de Rubro']));

        return redirect()->route('admin.rubros.categorias_rubro.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Categorias_Rubro $categorias_rubro
     * @return Response
     */
    public function destroy(Categorias_Rubro $categorias_rubro)
    {
        $this->categorias_rubro->destroy($categorias_rubro);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => 'Categoría de Rubro']));

        return redirect()->route('admin.rubros.categorias_rubro.index');
    }
}
