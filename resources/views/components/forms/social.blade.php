<ul class="space-y-3 my-2">
    <li>
        <a href="{{ route('socialRedirect', ['socialName' => 'github']) }}"
            class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5">
            <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 0C4.475 0 0 4.475 0 10a9.994 9.994 0 0 0 6.838 9.488c.5.087.687-.213.687-.476 0-.237-.013-1.024-.013-1.862-2.512.463-3.162-.612-3.362-1.175-.113-.287-.6-1.175-1.025-1.412-.35-.188-.85-.65-.013-.663.788-.013 1.35.725 1.538 1.025.9 1.512 2.337 1.087 2.912.825.088-.65.35-1.088.638-1.338-2.225-.25-4.55-1.112-4.55-4.937 0-1.088.387-1.987 1.025-2.688-.1-.25-.45-1.274.1-2.65 0 0 .837-.262 2.75 1.026a9.28 9.28 0 0 1 2.5-.338c.85 0 1.7.112 2.5.337 1.912-1.3 2.75-1.024 2.75-1.024.55 1.375.2 2.4.1 2.65.637.7 1.025 1.587 1.025 2.687 0 3.838-2.337 4.688-4.562 4.938.362.312.675.912.675 1.85 0 1.337-.013 2.412-.013 2.75 0 .262.188.574.688.474A10.017 10.017 0 0 0 20 10c0-5.525-4.475-10-10-10Z"
                    clip-rule="evenodd" />
            </svg>
            <span class="grow text-xxs md:text-xs font-bold text-center">GitHub</span>
        </a>
    </li>
    <li>
        <a href="{{ route('socialRedirect', ['socialName' => 'google']) }}"
            class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5">
            <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" fill="currentColor"
                enable-background="new 0 0 32 32" version="1.1" viewBox="0 0 32 32" xml:space="preserve"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Flat_copy">
                    <path
                        d="M31.37,13c0.2,1.07,0.31,2.19,0.31,3.36C31.68,25.5,25.56,32,16.32,32c-8.84,0-16-7.16-16-16s7.16-16,16-16   c4.32,0,7.93,1.59,10.7,4.17L22.51,8.68V8.67c-1.68-1.6-3.81-2.42-6.189-2.42c-5.28,0-9.57,4.46-9.57,9.74   c0,5.279,4.29,9.75,9.57,9.75c4.79,0,8.05-2.74,8.721-6.5H16.32V13L31.37,13L31.37,13z" />
                </g>
            </svg>
            <span class="grow text-xxs md:text-xs font-bold text-center">Google</span>
        </a>
    </li>
</ul>
