<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcements;
use Illuminate\Support\Carbon;

class AnnouncementsController extends Controller
{
    public function announceList()
    {
        $announce = Announcements::with('user')->get();
        if (count($announce) > 0) {
            return response()->json([
                'data' => $announce
            ]);
        }
    }
    public function add(Request $request)
    {
        $date_today = Carbon::now();
        $announcement = Announcements::create([
            'title' => $request->title,
            'content' => $request->content,
            'date_updated' => $date_today,
            'user_id' => $request->id

        ]);
        return response()->json([
            'message' => 'Announcement added'
        ]);
    }
    public function delete($announcementId)
    {
        $announcement = Announcements::find($announcementId);
        if ($announcement != null) {
            $announcement->delete();
            return response()->json(['message' => 'delete successful']);
        } else {
            return response()->json(['message' => 'delete failed']);
        }
    }
    public function show($id)
    {
        $announcement = Announcements::find($id);

        if ($announcement) {
            return response()->json($announcement);
        }
        return response()->json(['message' => 'Announcement not found'], 404);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $announceArray = array(
            "title" => $request->title,
            "content" => $request->content,

        );
        $update = Announcements::where("id", $id)->update($announceArray);
        return response()->json(['message' => 'Update successful', 'id' => $id, 'array' => $announceArray]);
    }
}
