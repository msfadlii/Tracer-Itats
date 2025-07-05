@props(['label', 'value', 'icon' => 'info', 'color' => 'gray'])

@php
  $colors = [
    'blue' => 'text-blue-600 bg-blue-50',
    'green' => 'text-green-600 bg-green-50',
    'yellow' => 'text-yellow-600 bg-yellow-50',
    'purple' => 'text-purple-600 bg-purple-50',
    'gray' => 'text-gray-600 bg-gray-50',
  ];
@endphp

<div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
  <div>
    <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
    <h3 class="text-2xl font-bold mt-1">{{ $value }}</h3>
  </div>
  <div class="p-3 rounded-full {{ $colors[$color] ?? $colors['gray'] }}">
    <i class="fas fa-{{ $icon }} {{ $colors[$color] ?? 'text-gray-600' }} text-xl"></i>
  </div>
</div>
