<?php

namespace App\Services\Framework;
use App\Repositories\framework\StakeholderMenuMapRepository;


class StakeholderMenuMapService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new StakeholderMenuMapRepository();
    }

    public function createStakeholderMenuMap($data)
    {
        return $this->repository->createStakeholderMenuMap($data);
    }

    public function getStakeholderMenuMapById($institute_id, $stakeholder_type, $stakeholder_id)
    {
        return $this->repository->getStakeholderMenuMapById($institute_id, $stakeholder_type, $stakeholder_id);
    }

    public function getAllStakeholderMenuMaps()
    {
        return $this->repository->getAllStakeholderMenuMaps();
    }

    public function getStakeholderMenuMapsByIds($ids)
    {
        return $this->repository->getStakeholderMenuMapsByIds($ids);
    }

    public function updateStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id, $data)
    {
        return $this->repository->updateStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id, $data);
    }

    public function deleteStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id)
    {
        return $this->repository->deleteStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id);
    }
}