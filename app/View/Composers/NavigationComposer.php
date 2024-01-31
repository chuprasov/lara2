<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Domain\Catalog\Models\Category;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view): void
    {
        $menu = Menu::make()
            ->add(MenuItem::make('main', route('home'), 'Главная'))
            ->add(MenuItem::make('catalog', route('catalog'), 'Каталог'));

        $subMenu = Menu::make();

        $categories = Category::query()->get();

        $checkedCategory = request('category');

        foreach ($categories as $category) {
            $subMenuItem = MenuItem::make('category-'.$category->id, route('catalog', $category), $category->title);

            if (isset($checkedCategory) && ($checkedCategory->id === $category->id)) {
                $subMenuItem->check();
            }

            $subMenu->add($subMenuItem);
        }

        $menu->add(MenuItem::make('categories', '#', 'Категории', $subMenu));

        $view->with('menu', $menu);
    }
}
