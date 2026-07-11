@props(['user' => null, 'size' => 'w-10 h-10', 'fontSize' => 'text-sm'])

@php
    $displayUser = $user ?? auth()->user();
    $hasAvatar = $displayUser && !empty($displayUser->avatar);
    $initials = '';
    if ($displayUser && $displayUser->name) {
        $words = explode(' ', trim($displayUser->name));
        if (count($words) >= 2) {
            $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(mb_substr($displayUser->name, 0, 2));
        }
    }
@endphp

@if($hasAvatar)
    <img
        src="{{ $displayUser->avatar }}"
        alt="{{ $displayUser->name ?? 'User' }}"
        {{ $attributes->merge(['class' => "$size rounded-full object-cover ring-2 ring-white shadow-sm"]) }}
    >
@elseif($initials)
    <div
        {{ $attributes->merge(['class' => "$size rounded-full bg-gradient-to-br from-[#F26C4F] to-[#E35336] text-white flex items-center justify-center font-bold $fontSize ring-2 ring-white shadow-sm"]) }}
        aria-hidden="true"
    >
        {{ $initials }}
    </div>
@else
    <img
        src="{{ asset('images/default-avatar.png') }}"
        alt="{{ $displayUser->name ?? 'User' }}"
        {{ $attributes->merge(['class' => "$size rounded-full object-cover ring-2 ring-white shadow-sm"]) }}
    >
@endif
