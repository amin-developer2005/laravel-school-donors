<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    @php
        $classes = "bg-blue-600
                            text-gray-100
                            font-semibold
                            px-6
                            py-4
                            ring-offset-indigo-500
                            hover:bg-blue-900
                            hover:text-white
                            hover:border-indigo-800
                            focus:ring-4
                            focus:ring-offset-4
                            focus:ring-offset-indigo-500
                            focus:outline-hidden
                            active:bg-blue-900
                            transition-color
                            ease-in-out
                            duration-500
                            rounded-lg";
    @endphp

    @if($route)
        <a {{ $attributes->merge(['class' => $classes, 'href' => route($route) ]) }} wire:navigate>{{ $slot }}</a>
    @else
        <button {{ $attributes->merge(['class' => $classes, 'type' => 'submit']) }}>{{ $slot }}</button>
    @endif
</div>
