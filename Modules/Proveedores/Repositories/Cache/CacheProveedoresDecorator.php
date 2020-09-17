<?php namespace Modules\Proveedores\Repositories\Cache;

use Modules\Proveedores\Repositories\ProveedoresRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProveedoresDecorator extends BaseCacheDecorator implements ProveedoresRepository
{
    public function __construct(ProveedoresRepository $proveedores)
    {
        parent::__construct();
        $this->entityName = 'proveedores.proveedores';
        $this->repository = $proveedores;
    }
}
