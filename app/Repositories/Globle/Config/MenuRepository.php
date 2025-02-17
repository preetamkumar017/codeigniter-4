<?php

namespace App\Repositories\Globle\Config;

use App\Models\Globle\Config\MenuModel;

class MenuRepository
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();  // MenuModel object
    }

    // Fetch all menus
    public function getAllMenus()
    {
        return $this->menuModel->getAllMenus();
    }

    // Fetch a single menu by ID
    public function getMenuById($id)
    {
        return $this->menuModel->getMenuById($id);
    }
    // Fetch multiple menus by an array of IDs
    public function getMenusByIds($ids)
    {
        return $this->menuModel->getMenusByIds($ids);
    }

    // Create a new menu
    public function createMenu($data)
    {
        return $this->menuModel->createMenu($data);
    }

    // Update an existing menu
    public function updateMenu($id, $data)
    {
        return $this->menuModel->updateMenu($id, $data);
    }

    // Delete a menu by ID
    public function deleteMenu($id)
    {
        return $this->menuModel->deleteMenu($id);
    }

    
}