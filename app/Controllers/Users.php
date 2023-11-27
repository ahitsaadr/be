<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new UserModel();
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
        $model = new UserModel();
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
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'email' => 'required|valid_email'
        ];
        $data = [
            'nama' => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'email' => $this->request->getVar('email')
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UserModel();
        $model->save($data);
        $response = [
            'status' => 201,
            'error' => null,
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
            'username' => 'required',
            'password' => 'min_length[8]',
            'email' => 'required|valid_email'
        ];
        $data = [
            'nama' => $this->request->getVar('nama'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'email' => $this->request->getVar('email')
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UserModel();
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
        $model = new UserModel();
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
