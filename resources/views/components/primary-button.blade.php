<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-600 focus:bg-orange-500 active:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-red-800 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
