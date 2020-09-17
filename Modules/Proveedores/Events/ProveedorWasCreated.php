<?php

namespace Modules\Proveedores\Events;

use Modules\Proveedores\Entities\Proveedores;
use Modules\Media\Contracts\StoringMedia;

class ProveedorWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var proveedores
     */
    public $proveedores;

    public function __construct($proveedores, array $data)
    {
        $this->data = $data;

        $this->proveedores = $proveedores;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->proveedores;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
