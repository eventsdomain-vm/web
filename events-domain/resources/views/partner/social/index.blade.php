<x-app-layout>
    <x-slot name="title">Social Accounts - EventsDomain</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2.5 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Connected Social Accounts</h1>
                        <p class="text-sm text-gray-500">Connect your social media accounts to promote your services across platforms.</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-emerald-700 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-700 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $platforms = [
                        'facebook' => ['name' => 'Facebook', 'color' => '#1877F2', 'desc' => 'Share services and manage pages.'],
                        'linkedin' => ['name' => 'LinkedIn', 'color' => '#0A66C2', 'desc' => 'Share services on your professional network.'],
                        'instagram' => ['name' => 'Instagram', 'color' => '#E4405F', 'desc' => 'Share visual service content.'],
                        'google' => ['name' => 'YouTube', 'color' => '#FF0000', 'desc' => 'Upload service videos and share links.'],
                    ];
                @endphp
                @foreach($platforms as $key => $info)
                    @php $account = $accounts->get($key); @endphp
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 transition hover:shadow-md">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: {{ $info['color'] }}20">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="{{ $info['color'] }}">
                                        @if($key === 'facebook')
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        @elseif($key === 'linkedin')
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        @elseif($key === 'instagram')
                                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/>
                                        @elseif($key === 'google')
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1zM12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23zM5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62zM12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $info['name'] }}</h3>
                                    <p class="text-xs text-gray-500">{{ $info['desc'] }}</p>
                                </div>
                            </div>
                        </div>

                        @if($account)
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center gap-3">
                                    @if($account->avatar)
                                        <img src="{{ $account->avatar }}" class="w-10 h-10 rounded-full" alt="">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">
                                            {{ strtoupper(substr($account->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-gray-900 truncate">{{ $account->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $account->email ?? $account->provider }}</p>
                                    </div>
                                    <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-medium">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                        Connected
                                    </span>
                                </div>
                                @if($account->token_expires_at)
                                    <p class="text-xs text-gray-400 mt-2">
                                        Token expires: {{ $account->token_expires_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('partner.social.connect', $key) }}" class="flex-1 text-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    Reconnect
                                </a>
                                <form action="{{ route('partner.social.disconnect', $key) }}" method="POST" class="flex-1" onsubmit="return confirm('Disconnect {{ $info['name'] }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition">
                                        Disconnect
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('partner.social.connect', $key) }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-medium text-white rounded-lg transition hover:opacity-90" style="background-color: {{ $info['color'] }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                                </svg>
                                Connect {{ $info['name'] }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>


        </div>
    </div>
</x-app-layout>