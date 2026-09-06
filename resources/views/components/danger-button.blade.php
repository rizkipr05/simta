<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-rose-600/20 transition-all duration-150']) }}>
    {{ $slot }}
</button>
