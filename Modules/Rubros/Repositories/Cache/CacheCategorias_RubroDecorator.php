<?php namespace Modules\Rubros\Repositories\Cache;

use Modules\Rubros\Repositories\Categorias_RubroRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategorias_RubroDecorator extends BaseCacheDecorator implements Categorias_RubroRepository
{
    public function __construct(Categorias_RubroRepository $categorias_rubro)
    {
        parent::__construct();
        $this->entityName = 'rubros.categorias_rubros';
        $this->repository = $categorias_rubro;
    }
}
