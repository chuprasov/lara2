<nav class="lg:flex text-sm 2xl:flex gap-8 items-center">
    @foreach ($menu->all() as $item)
        @if (is_null($item->subMenu()))
            <a href="{{ $item->link() }}"
                class="text-white hover:text-pink @if ($item->isActive()) font-bold @endif">
                {{ $item->label() }}
            </a>
        @else
            <div class="header-actions flex items-center gap-3 md:gap-5">
                <div x-data="{ {{ $item->id() }}: false }" class="relative inline-block">
                    <button @click="{{ $item->id() }} = ! {{ $item->id() }}"
                        class="flex items-center text-white hover:text-pink transition">
                        <span class="hidden md:block ml-2">
                            {{ $item->label() }}
                        </span>
                        <svg class="shrink-0 w-3 h-3 ml-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 30 16">
                            <path fill-rule="evenodd"
                                d="M27.536.72a2 2 0 0 1-.256 2.816l-12 10a2 2 0 0 1-2.56 0l-12-10A2 2 0 1 1 3.28.464L14 9.397 24.72.464a2 2 0 0 1 2.816.256Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="{{ $item->id() }}" @click.away="{{ $item->id() }} = false" x-cloak
                        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="absolute z-50 top-0 -right-20 xs:-right-8 sm:right-0 w-[280px] sm:w-[300px] mt-14 p-4 rounded-lg shadow-xl bg-card divide-y divide-gray-100">
                        <div class="pb-3">
                            <a href="{{ route('catalog') }}"
                                class="text-white hover:text-white bg-card text-xs font-medium">
                                Все категории
                            </a>
                        </div>
                        <div class="pt-3">
                            <ul class="space-y-2">
                                @foreach ($item->subMenu() as $subItem)
                                    <div class={{ $subItem->isChecked() ? 'bg-pink' : 'bg-card' }}>
                                        <li>
                                            <a href="{{ $subItem->link() }}"
                                                class="text-white hover:text-white  text-xs font-medium">
                                                {{ $subItem->label() }}
                                            </a>
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</nav>
