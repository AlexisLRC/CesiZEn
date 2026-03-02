@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['type' => 'checkbox', 'class' => 'rounded border-gray-300 text-cesi-green shadow-sm focus:ring-cesi-green focus:border-cesi-green cursor-pointer']) !!}>