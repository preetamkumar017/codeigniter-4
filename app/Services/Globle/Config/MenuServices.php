<?php

namespace App\Services\Globle\Config;

use App\Repositories\Globle\Config\MenuRepository;

class MenuServices
{
    protected $menuRepository;

    public function __construct()
    {
        $this->menuRepository = new MenuRepository();
    }

    public function getAllMenus()
    {
        return $this->menuRepository->getAllMenus();
    }

    public function getMenuById($id)
    {
        return $this->menuRepository->getMenuById($id);
    }
    public function getMenusByIds(array $ids)
    {
        return $this->menuRepository->getMenusByIds($ids);
    }
    public function createMenu($data)
    {
        return $this->menuRepository->create($data);
    }

    public function updateMenu($id, $data)
    {
        return $this->menuRepository->update($id, $data);
    }

    public function deleteMenu($id)
    {
        return $this->menuRepository->delete($id);
    }
}