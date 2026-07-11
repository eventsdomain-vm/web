<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class UserAvatar extends Component
{
    public function __construct(
        public ?User $user = null,
        public string $size = 'w-10 h-10',
        public string $fontSize = 'text-sm',
    ) {}

    public function initials(): string
    {
        if (! $this->user || ! $this->user->name) {
            return '';
        }

        $words = explode(' ', trim($this->user->name));
        $initials = '';

        if (count($words) >= 2) {
            $initials = strtoupper(mb_substr($words[0], 0, 1).mb_substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(mb_substr($this->user->name, 0, 2));
        }

        return $initials;
    }

    public function hasAvatar(): bool
    {
        return $this->user && ! empty($this->user->avatar);
    }

    public function render()
    {
        return view('components.ui.user-avatar');
    }
}
