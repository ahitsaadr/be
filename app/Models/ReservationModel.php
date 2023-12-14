<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table            = 'reservation';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'restaurant_id', 'date', 'time', 'num_guest', 'created_at'];

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

    public function getReservation()
    {
        return $this->db->table('reservation')
            ->select('reservation.id, reservation.restaurant_id, reservation.user_id, reservation.date, reservation.time, reservation.num_guest, restaurant.nama_restaurant AS nama_restaurant, users.nama AS nama') 
            ->join('restaurant', 'restaurant.id=reservation.restaurant_id', 'left')
            ->join('users', 'users.id=reservation.user_id', 'left')
            ->get()
            ->getResultArray();  
    }
}
