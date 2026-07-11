<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public function __construct(
        public bool $showHeader = true,
    ) {}

    public function render()
    {
        return view('layouts.app');
    }
}
