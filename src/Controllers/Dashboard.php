<?php

namespace Dash\Controllers;

use App\Http\Controllers\Controller;

//use Symfony\Component\HttpFoundation\Cookie;

class Dashboard extends Controller
{

    // View dashboards
    public function index()
    {
        $content = '';
        foreach (app('dash')['dashboards'] as $dashboard) {
            foreach ($dashboard::cards() as $card) {
                $content .= $card;
            }
        }
        // if new dashboard setup fire the ui Session settings
        $this->fireFirstUi();
        return view('dash::dashboard', [
            'content' => $content,
        ]);
    }

    // no_permission
    public function no_permission()
    {
        return view('dash::errors.403');
    }

    public function changeLanguage($lang)
    {

        session()->forget('DASHBOARD_CURRENT_LANG');
        session()->put('DASHBOARD_CURRENT_LANG', $lang);

        // \Cache::forget('DASHBOARD_CURRENT_LANG');
        // \Cache::forever('DASHBOARD_CURRENT_LANG', $lang);

        $previousUrl = url()->previous();
        $previousUrlWithoutQuery = strtok($previousUrl, '?');
        return redirect($previousUrlWithoutQuery . '?lang=' . $lang);
    }

    public function changeDarkMode($dark)
    {
        session()->forget('DARK_MODE');
        session()->put('DARK_MODE', $dark);
        return $dark;
    }
    public function sidenav_toggled($toggle)
    {
        session()->forget('sidenav_toggled');
        session()->put('sidenav_toggled', $toggle);
        return $toggle;
    }

    public function ui()
    {
        $ui = session()->has('ui') ? session('ui') : [];
        if (!empty(request('navbarFixed'))) {
            $ui['navbarFixed'] = request('navbarFixed');
        }
        if (!empty(request('darkVersion'))) {
            $ui['darkVersion'] = request('darkVersion');
        }
        if (!empty(request('bg'))) {
            $ui['bg'] = request('bg');
        }
        if (!empty(request('color'))) {
            $ui['color'] = request('color');
        }
        session()->put('ui', $ui);
    }

    public function fireFirstUi()
    {
        if (!session()->has('ui')) {
            session()->put('ui', [
                'navbarFixed' => 'no',
                'darkVersion' => 'no',
                'bg'          => 'bg-gradient-dark',
                'color'       => 'info',
            ]);
        }
    }
}
