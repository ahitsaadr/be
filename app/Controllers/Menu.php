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

    public function menuLanding()
    {
        $model = new MenuModel();
        $data = $model->getFood();
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
            'image' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,1024]',
        ];
        $data = [
            'restaurant_id' => $this->request->getVar('restaurant_id'),
            'nama' => $this->request->getVar('nama'),
            'description' => $this->request->getVar('description'),
            'price' => $this->request->getVar('price'),
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $image = $this->request->getFile('image');

        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('images/menu/', $newName);
            $data['image'] = $newName;
        }

        $model = new MenuModel();
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
        
        // Validation rules
        $rules = [
            'nama' => 'required',
            'description' => 'required',
            'price' => 'required',
            'restaurant_id' => 'required',
            'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]', // Allow image upload with max size 1MB
        ];

        // Validate request data
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        // Get existing menu data
        $model = new MenuModel();
        $menu = $model->find($id);
        if (!$menu) {
            return $this->failNotFound('No Data Found');
        }

        // Prepare data for update
        $data = [
            'restaurant_id' => $this->request->getVar('restaurant_id'),
            'nama' => $this->request->getVar('nama'),
            'description' => $this->request->getVar('description'),
            'price' => $this->request->getVar('price'),
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            // Remove old image
            if ($menu['image'] && file_exists('images/menu/' . $menu['image'])) {
                unlink('images/menu/' . $menu['image']);
            }

            // Save new image
            $newImageName = $image->getRandomName();
            $image->move('images/menu/', $newImageName);

            // Update data with new image
            $data['image'] = $newImageName;
        }

        // Update menu data
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
        $menu = $model->find($id);
        if (!$menu) {
            return $this->failNotFound('No Data Found');
        }

        if ($menu['image'] && file_exists('images/menu/' . $menu['image'])) {
            unlink('images/menu/' . $menu['image']);
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
