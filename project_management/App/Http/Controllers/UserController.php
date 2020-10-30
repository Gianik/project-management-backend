<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;
use App\Project_Todos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(Request $request, $userId)
    {
        $user = User::find($userId);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found!'], 404);
    }
    public function edit(Request $request)
    {

        if ($request->hasFile('file') != null) {
            $id = $request->id;
            $user = User::find($id);

            $filename = $request->file('file')->getClientOriginalName();
            $userArray = array(

                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->number,
                "avatar" => $filename
            );
            if ($user->avatar) {
                Storage::delete('/public/images/' . $user->avatar);
            }


            $path = $request->file('file')->storeAs('images', $filename, 'public');
            $update = User::where("id", $id)->update($userArray);
            return response()->json(['message' => 'Update Successful']);
        } else {
            $id = $request->id;
            $userArray = array(

                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->number,

            );
            $update = User::where("id", $id)->update($userArray);
            return response()->json(['message' => 'Update Successful', 'id' => $id, 'array' => $userArray]);
        }
    }
    public function updatePass(Request $request, $userId)
    {

        $updateArray = array('password' => bcrypt($request->password));
        User::where('id', $userId)->update($updateArray);
        return response()->json(['message' => 'password updated']);
    }
    public function userList()
    {

        $users = User::where('role', '!=', 'ADMIN')->get();
        if (count($users) > 0) {

            return response()->json([
                'data' => $users
            ]);
        } else {
            return response()->json(['message' => 'no Users Found']);
        }
    }
    public function userProject($userId)
    {
        // $list = Projects::find($projectId)->with('users')->first();
        $pro = User::where('id', $userId)->with('project.user')->first();
        $tsk = Project_Todos::where('user_id', $userId)->with('project')->orderBy('due_date', 'desc')->get();

        return response()->json([$pro, $tsk]);
    }
    public function updateRole(Request $request, $userId)
    {
        //Check if a role exists on roles that only one user can have
        if ($request->role === "CSSEC MODERATOR") {
            $ifExists = User::where('role', 'CSSEC MODERATOR')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A CSSEC MODERATOR ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "CS REP") {

            $ifExists = User::where('role', 'CS REP')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A CS REP ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "EXECUTIVE SECRETARY") {

            $ifExists = User::where('role', 'EXECUTIVE SECRETARY')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A EXECUTIVE SECRETARY ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "EXTERNAL VP") {
            $ifExists = User::where('role', 'EXTERNAL VP')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A EXTERNAL VP ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "INTERNAL VP") {
            $ifExists = User::where('role', 'INTERNAL VP')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A INTERNAL VP ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "SECRETARY") {
            $ifExists = User::where('role', 'SECRETARY')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A SECRETARY ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "TREASURER") {
            $ifExists = User::where('role', 'TREASURER')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A TREASURER ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "AUDITOR") {
            $ifExists = User::where('role', 'AUDITOR')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'AN AUDITOR ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        } else if ($request->role === "PUBLIC RELATIONS OFFICER") {
            $ifExists = User::where('role', 'PUBLIC RELATIONS OFFICER')->count();
            if ($ifExists >= 1) {
                return response()->json(['message' => 'A PUBLIC RELATIONS OFFICER ALREADY EXISTS'], 409);
            } else {
                $updateRole = array('role' => $request->role);
                User::where('id', $userId)->update($updateRole);
                return response()->json(['message' => 'role udated']);
            }
        }
        $updateRole = array('role' => $request->role);
        User::where('id', $userId)->update($updateRole);
        return response()->json(['message' => 'role udated']);
    }
}
