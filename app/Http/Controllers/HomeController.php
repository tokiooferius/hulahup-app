<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Canteen;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home/dashboard page with available menus
     */
    public function index(): View
    {
        // Get all active menus with relationships
        $allMenus = Menu::with(['canteen' => function($query) {
                $query->with('ibuKantin');
            }])
            ->whereHas('canteen', function ($query) {
                $query->where('status', 'active');
            })
            ->get();
        
        // Get all active canteens with ibu kantin
        $canteens = Canteen::with('ibuKantin')
            ->where('status', 'active')
            ->get();
        
        return view('home', [
            'menus' => $allMenus,
            'canteens' => $canteens,
        ]);
    }
}
