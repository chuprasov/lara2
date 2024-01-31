<nav class="lg:flex text-sm 2xl:flex gap-8 items-center">
    @foreach ($menu->all() as $item)
        <a href={{ $item->link() }} class="text-darkblue hover:text-blue-600 @if ($item->isActive()) font-bold @endif">
            {{ $item->label() }}
        </a>
    @endforeach

    

</nav>
