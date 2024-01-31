<?php

declare(strict_types=1);

namespace App\Menu;

use Support\Traits\Makeable;

class MenuItem
{
    use Makeable;

    protected bool $isChecked = false;

    public function __construct(
        protected string $id,
        protected string $link,
        protected string $label,
        protected null|Menu $subMenu = null
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function link(): string
    {
        return $this->link;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function subMenu(): null|Menu
    {
        return $this->subMenu;
    }

    public function isChecked(): bool
    {
        return $this->isChecked;
    }

    public function check()
    {
        $this->isChecked = true;
    }

    public function isActive(): bool
    {
        $path = parse_url($this->link(), PHP_URL_PATH) ?? '/';

        if ($path === '/') {
            return request()->path() === $path;
        }

        return request()->fullUrlIs($this->link() . '*');
    }
}
