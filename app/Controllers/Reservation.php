<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Reservation extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new ReservationModel();
        $data = $model->getReservation();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new ReservationModel();
        $data = $model->find(['id' => $id]);
        if(!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data[0]);
    }


    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        helper(['form']);

        $rules = [
            'user_id' => 'required',
            'restaurant_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'num_guest' => 'required',
        ];
        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'restaurant_id' => $this->request->getVar('restaurant_id'),
            'date' => $this->request->getVar('date'),
            'time' => $this->request->getVar('time'),
            'num_guest' => $this->request->getVar('num_guest'),
        ];
        
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new ReservationModel();
        $model->save($data);
        $response = [
            'status' => 201,
            'eror' => null,
            'messages' => [
                'success' => 'Data Inserted'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        helper(['form']);
        $rules = [
            'user_id' => 'required',
            'restaurant_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'num_guest' => 'required',
        ];
        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'restaurant_id' => $this->request->getVar('restaurant_id'),
            'date' => $this->request->getVar('date'),
            'time' => $this->request->getVar('time'),
            'num_guest' => $this->request->getVar('num_guest'),
        ];

        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new ReservationModel();
        $findById = $model->find(['id' => $id]);
        if(!$findById) return $this->failNotFound('No Data Found');
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new ReservationModel();
        $findById = $model->find(['id' => $id]);
        if(!$findById) return $this->failNotFound('No Data Found');
        $model->delete($id);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];
        return $this->respond($response);
    }
}
