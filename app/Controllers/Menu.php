<?php

namespace App\Controllers;

use App\Models\MenuModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Menu extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new MenuModel();
        $data = $model->getMenu();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new MenuModel();
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
            'nama' => 'required',
            'description' => 'required',
            'price' => 'required',
            'restaurant_id' => 'required',
        ];
        $data = [
            'restaurant_id' => $this->request->getVar('restaurant_id'),
            'nama' => $this->request->getVar('nama'),
            'description' => $this->request->getVar('description'),
            'price' => $this->request->getVar('price'),
        ];
        
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new MenuModel();
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
            'nama' => 'required',
            'description' => 'required',
            'price' => 'required',
            'restaurant_id' => 'required',
        ];
        $data = [
            'restaurant_id' => $this->request->getVar('restaurant_id'),
            'nama' => $this->request->getVar('nama'),
            'description' => $this->request->getVar('description'),
            'price' => $this->request->getVar('price'),
        ];

        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new MenuModel();
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
        $model = new MenuModel();
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
