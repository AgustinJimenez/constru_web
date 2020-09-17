<?php namespace Modules\Rubros\Sidebar;

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
            $group->item(trans('Rubros'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('Categorias de rubros'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.rubros.categorias_rubro.create');
                    $item->route('admin.rubros.categorias_rubro.index');
                    $item->authorize(
                        $this->auth->hasAccess('rubros.categorias_rubros.index')
                    );
                });
                $item->item(trans('Rubros'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.rubros.rubros.create');
                    $item->route('admin.rubros.rubros.index');
                    $item->authorize(
                        $this->auth->hasAccess('rubros.rubros.index')
                    );
                });
                /*$item->item(trans('rubros::rubro_materiales.title.rubro_materiales'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.rubros.rubro_materiales.create');
                    $item->route('admin.rubros.rubro_materiales.index');
                    $item->authorize(
                        $this->auth->hasAccess('rubros.rubro_materiales.index')
                    );
                });*/
            });
        });

        return $menu;
    }
}
