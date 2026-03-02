@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-cesi-green focus:ring-cesi-green rounded-md shadow-sm']) !!}>