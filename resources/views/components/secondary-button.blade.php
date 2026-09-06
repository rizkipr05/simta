<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-800 font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-150']) }}>
    {{ $slot }}
</button>
