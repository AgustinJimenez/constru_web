<?php namespace Modules\Proveedores\Repositories\Cache;

use Modules\Proveedores\Repositories\Proveedor_MaterialesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProveedor_MaterialesDecorator extends BaseCacheDecorator implements Proveedor_MaterialesRepository
{
    public function __construct(Proveedor_MaterialesRepository $proveedor_materiales)
    {
        parent::__construct();
        $this->entityName = 'proveedores.proveedor_materiales';
        $this->repository = $proveedor_materiales;
    }
}
