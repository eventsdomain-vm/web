<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsPageController extends Controller
{
    public function show(Request $request): View
    {
        $slug = $request->route()->getName();

        $page = CmsPage::published()->where('slug', $slug)->firstOrFail();

        return view('cms-page', compact('page'));
    }
}
