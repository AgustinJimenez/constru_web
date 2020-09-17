<?php namespace Modules\Proveedores\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('Proveedores'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->append('admin.proveedores.proveedores.create');
                $item->route('admin.proveedores.proveedores.index');
                $item->authorize(
                    $this->auth->hasAccess('proveedores.proveedores.index')
                );
                /*$item->item(trans('proveedores::proveedores.title.proveedores'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.proveedores.proveedores.create');
                    $item->route('admin.proveedores.proveedores.index');
                    $item->authorize(
                        $this->auth->hasAccess('proveedores.proveedores.index')
                    );
                });
                $item->item(trans('proveedores::proveedor_materiales.title.proveedor_materiales'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.proveedores.proveedor_materiales.create');
                    $item->route('admin.proveedores.proveedor_materiales.index');
                    $item->authorize(
                        $this->auth->hasAccess('proveedores.proveedor_materiales.index')
                    );
                });*/
            });
        });

        return $menu;
    }
}
