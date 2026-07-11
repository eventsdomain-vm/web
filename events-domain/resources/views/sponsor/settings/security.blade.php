<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Security Settings</h2>
    </x-slot>

    <div class="space-y-6 max-w-3xl">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">API Keys</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('sponsor.settings.api-keys.store') }}" method="POST" class="flex items-end gap-3 mb-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Key Name</label>
                        <input type="text" name="name" placeholder="e.g., Production API Key" class="w-full rounded-lg border-gray-200 text-sm" required>
                    </div>
                    <button type="submit" class="btn-primary text-sm px-4 py-2">Generate Key</button>
                </form>

                @if($integrations->isNotEmpty())
                    <div class="space-y-2">
                        @foreach($integrations as $integration)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $integration->name }}</h4>
                                    <p class="text-xs text-gray-500 font-mono">{{ substr($integration->api_key ?? '', 0, 12) }}...{{ substr($integration->api_key ?? '', -4) }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-{{ $integration->status === 'active' ? 'success' : 'danger' }} text-xs">{{ ucfirst($integration->status) }}</span>
                                    @if($integration->status === 'active')
                                        <form action="{{ route('sponsor.settings.api-keys.revoke', $integration) }}" method="POST" onsubmit="return confirm('Revoke this API key? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:underline">Revoke</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No API keys generated yet.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Two-Factor Authentication</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('sponsor.settings.two-factor') }}" method="POST" class="flex items-center justify-between">
                    @csrf
                    <div>
                        <p class="text-sm text-gray-700">Protect your account with an additional authentication layer.</p>
                        <p class="text-xs text-gray-500 mt-0.5">Uses authenticator app or SMS OTP.</p>
                    </div>
                    <button type="submit" name="two_factor_enabled" value="{{ $user->two_factor_enabled ? '0' : '1' }}"
                            class="{{ $user->two_factor_enabled ? 'btn-outline' : 'btn-primary' }} text-sm px-4 py-2">
                        {{ $user->two_factor_enabled ? 'Disable' : 'Enable' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Single Sign-On (SSO)</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('sponsor.settings.sso') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SSO Provider</label>
                            <select name="sso_provider" class="w-full rounded-lg border-gray-200 text-sm">
                                <option value="">-- Select Provider --</option>
                                <option value="google" {{ ($sponsor->sso_provider ?? '') === 'google' ? 'selected' : '' }}>Google Workspace</option>
                                <option value="microsoft" {{ ($sponsor->sso_provider ?? '') === 'microsoft' ? 'selected' : '' }}>Microsoft 365</option>
                                <option value="okta" {{ ($sponsor->sso_provider ?? '') === 'okta' ? 'selected' : '' }}>Okta</option>
                                <option value="azure" {{ ($sponsor->sso_provider ?? '') === 'azure' ? 'selected' : '' }}>Azure AD</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Client ID</label>
                            <input type="text" name="sso_client_id" value="{{ $sponsor->sso_client_id ?? '' }}" class="w-full rounded-lg border-gray-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Client Secret</label>
                            <input type="password" name="sso_client_secret" value="{{ $sponsor->sso_client_secret ?? '' }}" class="w-full rounded-lg border-gray-200 text-sm">
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-2">
                                <input type="hidden" name="sso_enabled" value="0">
                                <input type="checkbox" name="sso_enabled" value="1" {{ ($sponsor->sso_enabled ?? false) ? 'checked' : '' }} class="rounded border-gray-300">
                                <span class="text-sm text-gray-700">Enable SSO</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary text-sm px-4 py-2">Save SSO Configuration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
