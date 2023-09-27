<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TodoModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class TodoController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //
       $todoModel = new TodoModel();
       $session = session();
       $userId = $session->get('user_id');
       $status = $this->request->getVar('status') ?? null;

       $todos = $todoModel->getTodoByUser($userId,$status);

       return $this->respondCreated([
        'status' => 200,
        'data' => $todos,
    ]);
    }

    public function create() {
        $session = session();
        $data = [
            'description' => $this->request->getVar('description'),
            'status' => 1 ,
            'user_id' => $session->get('user_id'),
            'created_at' => new Time('now'),
        ];

        $todosModel = new TodoModel();

        $todosModel->save($data);

        return $this->respondCreated([
            'status' => 200,
            'message' => 'Create new todo successful',
        ]);
    }

    public function delete($todoId) {
        try {
            $todo = new TodoModel();

            $todo->where('id',$todoId)->delete();
    
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'delete successfull',
            ]);
        } catch (Exception $error) {
            return $this->respondDeleted([
                'status' => 400,
                'error' => $error,
            ]);
        }
       
    }

    public function changeStatus() {
        $todoModel = new TodoModel();
       $todoId = $this->request->getVar('todo_id');
       $status = $this->request->getVar('status');
        try {
            $dataUpdate = [
                'status' => $status,
            ];
    
            $todoModel->where('id',$todoId)->set($dataUpdate)->update();
            return $this->respondUpdated([
                'status' => 200,
                'message' => 'update status todo successfull',
            ]);
        } catch (Exception $error)
        {
            return $this->respondUpdated([
                'status' => 400,
                'error' => $error,
            ]);
        }
        
    }

    public function update($todoId){
        $todoModel = new TodoModel();
        try {
            $dataUpdate = [
                'description' => $this->request->getVar('description'),
            ];
    
            $todoModel->where('id',$todoId)->set($dataUpdate)->update();
            return $this->respondUpdated([
                'status' => 200,
                'message' => 'update todo successfull',
            ]);
        } catch (Exception $error)
        {
            return $this->respondUpdated([
                'status' => 400,
                'error' => $error,
            ]);
        }
    }
        
}
