<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
     //get informations :
    public function index()
    {
        $task = Task::all();
        return response()->json($task, 200);
    }

    //set a task :
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->Validated());
        return response()->json($task, 201);
    }

    //update a task :
    public function update(updateTaskRequest $request, $id)
    {
        $task = Task::findorFail($id);
        $task->update($request->validated());
        return response()->json($task, 200);
    }

    //show tasks : 
    public function show($id)
    {

        $task = Task::findorFail($id);
        return response()->json($task, 200);
    }

    //delet task :
    public function destroy($id)
    {

        $task = Task::findorFail($id);
        $task->delete();
        return response()->json(null, 204);
    }

    // get user by his task :
    
    public function getTaskUser($id)
    {
        $user = Task::with('user')->findOrFail($id)->user;

        if (!$user) {
            return response()->json(['message' => 'tasks not found'], 404);
        }
        return response()->json($user, 200);
    }
}
