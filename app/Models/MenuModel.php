<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menu_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['restaurant_id', 'nama', 'description', 'price', 'image', 'created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getMenu()
    {
        return $this->db->table('menu_items')
            ->select('menu_items.id, menu_items.restaurant_id, menu_items.nama, menu_items.price, menu_items.description, menu_items.image, restaurant.nama_restaurant AS nama_restaurant') 
            ->join('restaurant', 'restaurant.id=menu_items.restaurant_id', 'left')
            ->get()
            ->getResultArray();  
    }

    public function getFood()
    {
        return $this->db->table('menu_items')
        ->select('menu_items.id, menu_items.restaurant_id, menu_items.nama, menu_items.price, menu_items.description, menu_items.image, restaurant.nama_restaurant AS nama_restaurant') 
        ->join('restaurant', 'restaurant.id=menu_items.restaurant_id', 'left')
        ->orderBy('menu_items.id', 'desc')
        ->limit(10)
        ->get()
        ->getResultArray(); 
    }

    

}
