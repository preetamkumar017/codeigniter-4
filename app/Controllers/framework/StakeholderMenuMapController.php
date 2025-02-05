<?php

namespace App\Controllers\Framework;
use App\Services\framework\StakeholderMenuMapService;
use CodeIgniter\RESTful\ResourceController;


class StakeholderMenuMapController extends ResourceController
{
    protected $service;

    public function __construct()
    {
        $this->service = new StakeholderMenuMapService();
    }

    public function create()
    {
        $data = $this->request->getPost();
        $result = $this->service->createStakeholderMenuMap($data);
        return $this->respondCreated($result);
    }

    public function show($id = null)
    {
        $institute_id = $this->request->getGet('institute_id');
        $stakeholder_type = $this->request->getGet('stakeholder_type');
        $stakeholder_id = $this->request->getGet('stakeholder_id');
        $menu_id = $this->request->getGet('menu_id');
        $result = $this->service->getStakeholderMenuMapById($institute_id, $stakeholder_type, $stakeholder_id, $menu_id);
        return $this->respond($result);
    }

    public function index()
    {
        $result = $this->service->getAllStakeholderMenuMaps();
        print_r($result);
        // return $this->respond($result);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $institute_id = $this->request->getGet('institute_id');
        $stakeholder_type = $this->request->getGet('stakeholder_type');
        $stakeholder_id = $this->request->getGet('stakeholder_id');
        $menu_id = $this->request->getGet('menu_id');
        $result = $this->service->updateStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id, $data);
        return $this->respond($result);
    }

    public function delete($id = null)
    {
        $institute_id = $this->request->getGet('institute_id');
        $stakeholder_type = $this->request->getGet('stakeholder_type');
        $stakeholder_id = $this->request->getGet('stakeholder_id');
        $menu_id = $this->request->getGet('menu_id');
        $result = $this->service->deleteStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id);
        return $this->respondDeleted($result);
    }
}