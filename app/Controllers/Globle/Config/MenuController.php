<?php

namespace App\Controllers\Globle\Config;

use App\Controllers\BaseController;
use App\Services\Globle\Config\MenuServices;
// use App\Repositories\MenuRepository;

class MenuController extends BaseController
{
    protected $menuService;

    public function __construct()
    {
        $this->menuService = new MenuServices();
    }

    public function index()
    {


        $url = ltrim(str_replace(['index.php/', base_url()], '', current_url()), '/');
        echo "Path after base URL: " .$url ;    
        $data['menus'] = $this->menuService->getAllMenus();
        
        return view('menu_view', $data);
    }
}
