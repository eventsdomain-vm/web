<x-guest-layout>
    <x-slot name="title">{{ $page->meta_title ?: $page->title }} - EventsDomain</x-slot>
    <x-slot name="meta_description">{{ $page->meta_description ?: Str::limit(strip_tags($page->content), 160) }}</x-slot>

    {!! $page->content !!}
</x-guest-layout>
