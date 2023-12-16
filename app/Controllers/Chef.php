<?php

namespace App\Controllers;

use App\Models\ChefModel;
use CodeIgniter\RESTful\ResourceController;

class Chef extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new ChefModel();
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
        $model = new ChefModel();
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
            'image' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,1024]',
        ];
        $data = [
            'nama' => $this->request->getVar('nama'),
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $image = $this->request->getFile('image');

        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('images/chef/', $newName);
            $data['image'] = $newName;
        }

        $model = new ChefModel();
        $model->save($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data Inserted',
            ],
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
            'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]', // Allow image upload with max size 1MB
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new ChefModel();
        $menu = $model->find($id);
        if (!$menu) {
            return $this->failNotFound('No Data Found');
        }

        $data = [
            'nama' => $this->request->getVar('nama'),
        ];

        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            if ($menu['image'] && file_exists('images/chef/' . $menu['image'])) {
                unlink('images/chef/' . $menu['image']);
            }

            $newImageName = $image->getRandomName();
            $image->move('images/chef/', $newImageName);

            $data['image'] = $newImageName;
        }

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
        $model = new ChefModel();
        $menu = $model->find($id);
        if (!$menu) {
            return $this->failNotFound('No Data Found');
        }

        if ($menu['image'] && file_exists('images/chef/' . $menu['image'])) {
            unlink('images/chef/' . $menu['image']);
        }

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
