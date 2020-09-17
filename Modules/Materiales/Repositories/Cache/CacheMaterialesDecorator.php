<?php namespace Modules\Materiales\Repositories\Cache;

use Modules\Materiales\Repositories\MaterialesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMaterialesDecorator extends BaseCacheDecorator implements MaterialesRepository
{
    public function __construct(MaterialesRepository $materiales)
    {
        parent::__construct();
        $this->entityName = 'materiales.materiales';
        $this->repository = $materiales;
    }
}
