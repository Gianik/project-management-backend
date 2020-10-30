<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Projects;
use App\User;
use App\Project_Todos;

class ProjectTodosController extends Controller
{
    public function taskList($projectId)
    {
        $list = Projects::find($projectId)->with('users')->first();
        $ongoing_query = ['project_id' => $projectId, 'status' => 0];
        $completed_query = ['project_id' => $projectId, 'status' => 1];
        $ongoingTaskList = Project_Todos::where($ongoing_query)->with('user')->get();
        $completedTaskList = Project_Todos::where($completed_query)->with('user')->get();
        if ($list) {


            return response()->json(['list' => $list, 'ongoing' => $ongoingTaskList, 'completed' => $completedTaskList]);
        } else {
            return response()->json(['message' => 'no Task List found']);
        }
    }
    public function addTask(Request $request)
    {
        $task = Project_Todos::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => 0,
            'project_id' => $request->projectId,
            'user_id' => $request->userId,
            'due_date' => $request->due_date
        ]);
        return response()->json([$task]);
    }
    public function editTask(Request $request, $taskId)
    {
        $taskArray = array(
            'title' => $request->title,
            'content' => $request->desc,
            'user_id' => $request->userId,
            'due_date' => $request->due_date,
        );
        Project_Todos::where('id', $taskId)->update($taskArray);
        return response()->json(['message' => 'update successful']);
    }
    public function setTaskComplete(Request $request, $taskId)
    {
        $date_today = Carbon::now();
        $setComplete = array(
            'status' => 1,
            'completion_date' => $date_today
        );

        Project_Todos::where('id', $taskId)->update($setComplete);
        return response()->json(['message' => 'update successful']);
    }
    public function setTaskIncomplete(Request $request, $taskId)
    {
        $setComplete = array(
            'status' => 0,
        );

        Project_Todos::where('id', $taskId)->update($setComplete);
        return response()->json(['message' => 'update successful']);
    }
    public function taskDelete($taskId)
    {
        $task = Project_Todos::find($taskId);
        if ($task != null) {
            $task->delete();
            return response()->json(['message' => 'delete successful']);
        } else {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }
}
