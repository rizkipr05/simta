<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-emerald-600/20 transition-all duration-150']) }}>
    {{ $slot }}
</button>
