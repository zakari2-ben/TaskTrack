<?php

namespace App\Http\Controllers;

use App\Models\Task;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class TaskController extends Controller
{
    //get informations :
    public function index(){
        $task = Task::all();
        return response()->json($task,200);
    }

    //set a task :
    public function store (Request $request){

        $validatedate = $request->validate(
            [
                'title'=>'required|string|max:60',
                'description'=>'nullable|string',
                'priority'=>'required|integer|min:1|max:5',
            ]
            );

            $task = Task::create($validatedate);
            return response()->json($task, 201);
    }

    //update a task :
    public function update(Request $request,$id) {

        $task = Task::findorFail($id);
        $validatedate = $request->validate(
            [
                'title'=>'sometimes|required|string|max:60',
                'description'=>'sometimes|nullable|string',
                'priority'=>'sometimes|required|integer|min:1|max:5',
            ]
            );
        $task->update($validatedate);
        return response()->json($task,200);

    }

    //show tasks : 
    public function show($id) {

        $task = Task::findorFail($id);
        return response()->json($task,200);
    }

    //delet task :
    public function destroy($id) {

        $task = Task::findorFail($id);
        $task -> delete();
        return response()->json(null,204 );

    }

}
