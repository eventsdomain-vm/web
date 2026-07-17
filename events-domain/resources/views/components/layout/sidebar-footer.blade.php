{{-- Sidebar Footer User Profile --}}
@php
    $user = auth()->user();
    $initials = '';
    if ($user && $user->name) {
        $words = explode(' ', trim($user->name));
        if (count($words) >= 2) {
            $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(mb_substr($user->name, 0, 2));
        }
    }
@endphp

<div
    x-data="{ showConfirm: false }"
    class="mt-auto border-t border-gray-100 bg-white shrink-0" style="background-color: #ffffff !important;"
>
    {{-- User Info --}}
    <div class="px-4 pt-4 pb-2">
        <div class="flex items-center gap-3">
            {{-- Avatar --}}
            <div class="relative flex-shrink-0">
                <x-ui.user-avatar size="w-10 h-10" fontSize="text-sm" />
                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white"></div>
            </div>

            {{-- User Details --}}
            <div class="min-w-0 flex-1">
                <p class="text-[15px] font-semibold text-gray-900 leading-tight truncate">
                    {{ $user->name }}
                </p>
                <p class="text-[13px] text-gray-500 leading-tight mt-0.5 truncate">
                    {{ $user->email }}
                </p>
            </div>
        </div>
    </div>

    {{-- Bottom actions: icon-only on mobile, full on larger screens --}}
    <div class="px-2 pb-3">
        <div class="flex items-stretch gap-2 sm:flex-col sm:gap-0">
            {{-- Support Link --}}
            <a
                href="https://support.eventsdomain.com/"
                target="_blank"
                rel="noopener noreferrer"
                title="Support"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 group"
            >
                <svg class="w-[18px] h-[18px] text-gray-400 group-hover:text-terracotta-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                </svg>
                <span class="group-hover:font-semibold transition-all sm:hidden">Support</span>
            </a>

            {{-- Logout Button --}}
            <button
                @click="showConfirm = true"
                title="Sign Out"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group"
            >
                <svg class="w-[18px] h-[18px] text-gray-400 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
                <span class="group-hover:font-semibold transition-all sm:hidden">Sign Out</span>
            </button>
        </div>
    </div>

    {{-- Confirmation Dialog --}}
    <div
        x-show="showConfirm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div
            class="absolute inset-0 bg-black/50"
            @click="showConfirm = false"
        ></div>

        {{-- Dialog --}}
        <div
            x-show="showConfirm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6"
            role="dialog"
            aria-modal="true"
            aria-labelledby="logout-title"
        >
            {{-- Icon --}}
            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
            </div>

            {{-- Title --}}
            <h3 id="logout-title" class="text-lg font-semibold text-gray-900 text-center">
                Sign Out
            </h3>

            {{-- Message --}}
            <p class="mt-2 text-sm text-gray-500 text-center">
                Are you sure you want to sign out? You'll need to log in again to access your account.
            </p>

            {{-- Buttons --}}
            <div class="flex gap-3 mt-6">
                <button
                    @click="showConfirm = false"
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-300"
                >
                    Cancel
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-terracotta-500 to-terracotta-600 rounded-xl shadow-lg hover:from-terracotta-600 hover:to-terracotta-700 transform hover:-translate-y-0.5 transition focus:outline-none focus:ring-4 focus:ring-terracotta-200 focus:ring-offset-2"
                    >
                        <svg class="w-4 h-4 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
