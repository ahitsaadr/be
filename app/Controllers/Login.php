<?php

namespace App\Controllers;

use App\Models\UserModel;
// use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        helper(['form']);
        echo view('login');
    } 
 
    public function auth()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        if($data){
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                $ses_data = [
                    'id'       => $data['id'],
                    'nama'     => $data['nama'],
                    'username' => $data['username'],
                    'email'    => $data['email'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return $this->respond($ses_data);
            }else{
                // Invalid password, respond with error message
                return $this->fail('Wrong Password', 401);
            }
        }else{
            // Username not found, respond with error message
            return $this->fail('Username not Found', 404);
        }
    }    
 
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
} 
