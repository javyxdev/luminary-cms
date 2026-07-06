<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#06b6d4] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#0e7490] focus:bg-[#0e7490] active:bg-[#155e75] focus:outline-none focus:ring-2 focus:ring-[#06b6d4] focus:ring-offset-2 focus:ring-offset-[#0a0a1a] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
