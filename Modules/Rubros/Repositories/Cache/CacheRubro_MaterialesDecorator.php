<?php namespace Modules\Rubros\Repositories\Cache;

use Modules\Rubros\Repositories\Rubro_MaterialesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRubro_MaterialesDecorator extends BaseCacheDecorator implements Rubro_MaterialesRepository
{
    public function __construct(Rubro_MaterialesRepository $rubro_materiales)
    {
        parent::__construct();
        $this->entityName = 'rubros.rubro_materiales';
        $this->repository = $rubro_materiales;
    }
}
