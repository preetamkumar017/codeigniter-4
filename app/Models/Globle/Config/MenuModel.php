<?php

namespace App\Models\Globle\Config;

use CodeIgniter\Model;
use Config\Database;

class MenuModel extends Model
{
    protected $table = 'config.menu';
    protected $primaryKey = 'm_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'display_name',
        'parent_m_id',
        'link',
        'fa_icon',
        'display_order',
        'description',
        'delete_flag',
        'can_be_delegated',
        'sublinks',
        'pending_job_service',
        'pending_job_method',
        'help_video_url',
        'help_instruction'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;


      public function __construct()
      {
          $this->db = \Config\Database::connect();
      }
      
    public function createMenu($data)
    {
        $lastId = $this->db->table($this->table)->selectMax($this->primaryKey)->get()->getRowArray()[$this->primaryKey];
        $data[$this->primaryKey] = $lastId + 1;
        if ($this->db->table($this->table)->insert($data)) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }

    public function getMenuById($id)
    {
        return $this->db->table($this->table)->where($this->primaryKey, $id)->get()->getRowArray();
    }

    public function getAllMenus()
    {
        $menus = $this->db->table($this->table)->get()->getResultArray();
        if (!empty($menus)) {
            return $menus;
        } else {
            return [];
        }
    }

    public function getMenusByIds($ids)
    {
        return $this->db->table($this->table)->whereIn($this->primaryKey, $ids)->get()->getResultArray();
    }

    public function updateMenu($id, $data)
    {
        return $this->db->table($this->table)->where($this->primaryKey, $id)->update($data);
    }

    public function deleteMenu($id)
    {
        return $this->db->table($this->table)->where($this->primaryKey, $id)->delete();
    }
}
?>