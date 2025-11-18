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
        $task = Task::create(
            [
                'title'=>$request->title,
                'description'=>$request->description,
                'priority'=>$request->priority
            ]
            );
            return response()->json($task,201);
    }

    //update a task :
    public function update(Request $request,$id) {

        $task = Task::findorFail($id);
        $task->update($request->all());
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
