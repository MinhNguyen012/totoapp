<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class UserController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        return $this->respond(['hello' => 'world']);
    }

    public function login(){

        $users = new UserModel();
       
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $is_user  = $users->where('email',$email)->first();
        if($is_user) {
            $verify_password = password_verify($password,$is_user['password']);
            if($verify_password) {
                $key = 'minhnguyen';
                $payload = [
                    'iss' => 'localhost',
                    'aud' => 'localhost',
                    'data' => [
                        'user_id' => $is_user['id'],
                        'name' => $is_user['name'],
                        'email' => $is_user['email'],
                    ],
                ];
                $jwt = JWT::encode($payload,$key,'HS256');
                return $this->respondCreated([
                    'status' => 200,
                    'message' => 'Login successfully!',
                    'jwt' => $jwt,
                ]);
            }

            return $this->respondCreated([
                'status' => 400,
                'message' => 'Password or Email not correct!',
            ]);
        }

        return $this->respondCreated([
            'status' => 400,
            'message' => 'Password or Email not correct!',
        ]);
    }

    public function createUser () {
       $users = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $name = $this->request->getVar('name');

        $is_user  = $users->where('email',$email)->first();
        if($is_user) {
            return $this->respondCreated([
                'status' => 400,
                'message' => 'Email has exist!',
            ]);
        }

        $data = [
            'email' => $email,
            'password' => password_hash($this->request->getVar('password'),PASSWORD_DEFAULT),
            'name' => $name,
        ];

        $result = $users->save($data);

        if($result) {
            return $this->respondCreated([
                'status' => 200,
                'message' => 'Create user successfull',
            ]);
        }

        return $this->respondCreated([
            'status' => 400,
            'message' => 'Create user not successfull',
        ]);
    }

    public function getUser() {
        $users = new UserModel();
        return $this->respond([
            'stauts' => 200,
            'message' => $users->findall(),
        ]);
    }

}
