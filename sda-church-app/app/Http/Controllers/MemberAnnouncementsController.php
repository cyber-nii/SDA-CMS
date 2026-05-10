<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class MemberAnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::active()->latest('publish_date')->paginate(10);
        
        $readAnnouncementIds = auth()->user()->readAnnouncements()->pluck('announcements.announcement_id')->toArray();

        return view('member.announcements', compact('announcements', 'readAnnouncementIds'));
    }

    public function markAsRead(Announcement $announcement)
    {
        auth()->user()->readAnnouncements()->syncWithoutDetaching([$announcement->announcement_id]);
        return response()->json(['success' => true]);
    }
}
