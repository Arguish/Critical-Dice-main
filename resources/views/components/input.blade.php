@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-primary-700 border-primary-600 text-white placeholder-gray-400 focus:border-accent-orange focus:ring-accent-orange rounded-md shadow-sm']) !!}>