<?php

namespace Lifeonscreen\Google2fa;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class RecoveryCodes extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::script('google2fa', __DIR__.'/../dist/js/tool.js');
        Nova::style('google2fa', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return View
     */
    public function renderNavigation(): View
    {
        return view('google2fa::navigation');
    }

    public function menu(Request $request)
    {
        // TODO: Implement menu() method.
    }
}
