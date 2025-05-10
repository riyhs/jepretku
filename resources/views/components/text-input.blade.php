@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-red-800 focus:ring-red-800 rounded-md shadow-sm']) }}>
