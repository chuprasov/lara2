<div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-lg bg-gray/5 border border-black">
    <h1 class="mb-5 text-lg font-semibold text-black">
        {{ $title }}
    </h1>
    <form class="space-y-6 mb-4" action="{{ $action }}" method="{{ $method }}">
        {{ $slot }}
    </form>

    {{ $socialAuth }}

    {{ $buttons }}

    <ul class="flex flex-col md:flex-row justify-between gap-3 md:gap-4 mt-14 md:mt-20">
        <li>
            <a href="#" class="inline-block text-black hover:text-darkblue text-xxs md:text-xs font-medium"
                target="_blank" rel="noopener">Пользовательское соглашение</a>
        </li>
        <li class="hidden md:block">
            <div class="h-full w-[2px] bg-black"></div>
        </li>
        <li>
            <a href="#" class="inline-block text-black hover:text-darkblue text-xxs md:text-xs font-medium"
                target="_blank" rel="noopener">Политика конфиденциальности</a>
        </li>
    </ul>
</div>
