<?php

namespace App\Models\Framework;

use CodeIgniter\Model;
use Config\Database;

class StakeholderMenuMapModel extends Model
{
    protected $table = 'framework.stakeholder_menu_map';
    protected $primaryKey = ['institute_id', 'stakeholder_type', 'stakeholder_id', 'menu_id'];
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'institute_id',
        'stakeholder_type',
        'stakeholder_id',
        'menu_id',
        'active_from',
        'active_to',
        'access_status',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'created_by_type',
        'modified_by_type'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_on';
    protected $updatedField = 'modified_on';
    protected $dateFormat = 'datetime';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect('database2');
    }

    public function createStakeholderMenuMap($data)
    {
        if ($this->db->table($this->table)->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function getStakeholderMenuMapById($institute_id, $stakeholder_type, $stakeholder_id)
    {
        $return =  $this->db->table($this->table)
            ->where('institute_id', $institute_id)
            ->where('stakeholder_type', $stakeholder_type)
            ->where('stakeholder_id', $stakeholder_id)
            ->get()
            ->getResultArray();
            
        //  echo $this->db->getLastQuery();
        //  echo '<pre>';

         return $return;
    }

    public function getAllStakeholderMenuMaps()
    {
        $maps = $this->db->table($this->table)->get()->getResultArray();
        if (!empty($maps)) {
            return $maps;
        } else {
            return [];
        }
    }

    public function getStakeholderMenuMapsByIds($ids)
    {
        return $this->db->table($this->table)
            ->whereIn('institute_id', array_column($ids, 'institute_id'))
            ->whereIn('stakeholder_type', array_column($ids, 'stakeholder_type'))
            ->whereIn('stakeholder_id', array_column($ids, 'stakeholder_id'))
            ->whereIn('menu_id', array_column($ids, 'menu_id'))
            ->get()
            ->getResultArray();
    }

    public function updateStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id, $data)
    {
        return $this->db->table($this->table)
            ->where('institute_id', $institute_id)
            ->where('stakeholder_type', $stakeholder_type)
            ->where('stakeholder_id', $stakeholder_id)
            ->where('menu_id', $menu_id)
            ->update($data);
    }

    public function deleteStakeholderMenuMap($institute_id, $stakeholder_type, $stakeholder_id, $menu_id)
    {
        return $this->db->table($this->table)
            ->where('institute_id', $institute_id)
            ->where('stakeholder_type', $stakeholder_type)
            ->where('stakeholder_id', $stakeholder_id)
            ->where('menu_id', $menu_id)
            ->delete();
    }
}