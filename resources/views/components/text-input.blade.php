@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/5 border-white/10 text-white placeholder-white/30 focus:border-[#06b6d4] focus:ring-[#06b6d4] rounded-md shadow-sm']) }}>
