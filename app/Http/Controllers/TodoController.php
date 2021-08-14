<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todo;

    public function __construct(Todo $todo){
        $this->todo = $todo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $todo = $this->todo->createTodo($request->all());
        return response()->json($todo);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request){
        try {
            $todo = $this->todo->updateTodo($id,$request->all());
            return response()->json($todo);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id){
        $todo = $this->todo->getTodo($id);
        if($todo){
            return response()->json($todo);
        }
        return response()->json(["msg"=>"Todo item not found"],404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function gets(){
        $todos = $this->todo->getsTodo();
        return response()->json($todos);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        try {
            $todo = $this->todo->deleteTodo($id);
            return response()->json(["msg"=>"delete todo success"]);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }
}
