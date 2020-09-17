<?php namespace Modules\Rubros\Repositories\Cache;

use Modules\Rubros\Repositories\RubrosRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRubrosDecorator extends BaseCacheDecorator implements RubrosRepository
{
    public function __construct(RubrosRepository $rubros)
    {
        parent::__construct();
        $this->entityName = 'rubros.rubros';
        $this->repository = $rubros;
    }
}
