<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\Budgets;
use App\User;

class ProjectsController extends Controller
{
    public function add(Request $request)
    {
        $project = Projects::create([
            'title' => $request->title,
            'content' => $request->desc,
            'start_date' => $request->sDate,
            'end_date' => $request->fDate,
            'priority' => $request->priority,
            'user_id' => $request->id

        ]);
        Budgets::create([
            'project_id' => $project->id,
            'remaining_budget' => 0,
            'current_budget' => 0,
            'original_budget' => 0,
        ]);
        $user = User::find($request->id);
        $project->users()->attach($user);
        return response()->json($project);
    }
    public function projectList()
    {
        $projects = Projects::with('user')->get();
        if (count($projects) > 0) {


            return response()->json(
                $projects
            );
        } {
            return response()->json([
                'message' => 'No projects found'
            ], 404);
        }
    }
    public function projectDetail($projectId, $userId)
    {
        $isinProject = false;
        $projects = Projects::where('id', $projectId)->with('user')->first();
        // $projects = Projects::with('user')->wherein('id', $projectId)->get();
        $check = Projects::find($projectId);
        $users = User::select('id', 'name')->where([['role', '!=', 'MEMBER'], ['role', '!=', 'ADMIN']])->get(); //for changing manager
        if ($projects->users()->where('user_id', $userId)->exists()) {
            $isinProject = true;
        } else {
            $isinProject = false;
        }
        if ($projects) {
            return response()->json([$projects, $users, $isinProject]);
        } else {
            return response()->json([
                'message' => 'Project Detail not found'
            ], 404);
        }
    }
    public function editProject(Request $request, $projectId)
    {

        $projectArray = array(
            'title' => $request->title,
            'content' => $request->desc,
            'start_date' => $request->sDate,
            'end_date' => $request->fDate,
            'priority' => $request->priority,
        );
        Projects::where('id', $projectId)->update($projectArray);
        return response()->json(['message' => 'update successful']);
    }
    public function changeManager(Request $request, $projectId)
    {
        $projects = Projects::find($projectId);
        $user = User::find($request->managerId);
        if ($projects->user_id != $request->managerId) {

            $newManager = array(
                'user_id' => $request->managerId
            );

            // $inProject = $projects->users()->where('user_id', $request->managerId)->exists();
            if ($projects->users()->where('user_id', $request->managerId)->exists()) {

                Projects::where('id', $projectId)->update($newManager);
                return response()->json(['message' => 'Project Manager changed']);
            }
            //add new manager to project 
            else {
                $projects->users()->attach($user);
                Projects::where('id', $projectId)->update($newManager);
                return response()->json(['message' => 'Project Manager changed']);
            }
        } else {
            return response()->json([
                'message' => 'Update Failed'
            ], 404);
        }
    }
    public function joinProject(Request $request)
    {
        $projects = Projects::find($request->projectId);
        $user = User::find($request->userId);
        $projects->users()->attach($user);
        return response()->json(['message' => 'Project Joined']);
    }
    public function leaveProject(Request $request)
    {
        $projects = Projects::find($request->projectId);
        $user = User::find($request->userId);
        $projects->users()->detach($user);
        return response()->json(['message' => 'Project Left']);
    }
    public function deleteProject($projectId)
    {
        $project = Projects::find($projectId);
        if ($project != null) {
            $project->delete();
            return response()->json(['message' => 'delete successful']);
        } else {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }
    public function listMembers($projectId)
    {
        // $project = Projects::find($projectId)with;
        // foreach ($project->users as $user) {
        //     $user->pivot->projects_user;
        // }
        $list = Projects::find($projectId)->with('users')->first();
        // $list = Projects::find($projectId)->with('users')->pluck('user.id');
        // $memberList = $list->pluck('users');
        return response()->json($list);
    }
}
