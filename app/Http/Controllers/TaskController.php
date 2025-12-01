<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategToTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //get informations :
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json($tasks, 200);
    }

    //set a task :
    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $validateData = $request->validated();
        $validateData['user_id'] = $user_id;
        $task = Task::create($validateData);
        return response()->json($task, 201);
    }

    //update a task :
    public function update(updateTaskRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findorFail($id);
        if ($task->user_id != $user_id) {
            return response()->json([
                'message' => 'Unauthurized action'
            ], 403);
        }
        $task->update($request->validated());
        return response()->json($task, 200);
    }

    //show tasks : 
    public function show($id)
    {
        $task = Task::findOrFail($id); 

        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized action'
            ], 403);
        }

        return response()->json($task, 200);
    }

    //delet task :
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized action'
            ], 403);
        }

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

    // function to add categories to taks :

    public function addCategoriesToTask(AddCategToTaskRequest $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $task->categories()->syncWithoutDetaching($request->validated()['categories']);

        return response()->json([
            'message' => 'Categories added to task successfully',
            'task'    => $task->load('categories')
        ], 200);
    }

    // get categories of task :



    public function getTaskCategories($taskId)
    {
        // get id of task 
        $task = Task::findOrFail($taskId);

        $categories = $task->categories;

        return response()->json([
            'task_id' => $task->id,
            'categories' => $categories
        ], 200);
    }

    // get tasks of category

    public function getCategoriesTasks($categoryId)
    {
        // get id of category
        $category = Category::findOrFail($categoryId);

        // tasks of category
        $tasks = $category->tasks;

        return response()->json([
            'category_id' => $category->id,
            'category_name' => $category->name,
            'tasks' => $tasks
        ], 200);
    }
}
