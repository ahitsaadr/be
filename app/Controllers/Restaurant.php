<?php

namespace App\Controllers;

use App\Models\RestaurantModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Restaurant extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new RestaurantModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new RestaurantModel();
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
            'nama_restaurant' => 'required',
            'description_restaurant' => 'required',
            'location' => 'required',
        ];
        $data = [
            'nama_restaurant' => $this->request->getVar('nama_restaurant'),
            'description_restaurant' => $this->request->getVar('description_restaurant'),
            'location' => $this->request->getVar('location'),
        ];
        
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new RestaurantModel();
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
            'nama_restaurant' => 'required',
            'description_restaurant' => 'required',
            'location' => 'required',
        ];
        $data = [
            'nama_restaurant' => $this->request->getVar('nama_restaurant'),
            'description_restaurant' => $this->request->getVar('description_restaurant'),
            'location' => $this->request->getVar('location'),
        ];

        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new RestaurantModel();
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
        $model = new RestaurantModel();
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
