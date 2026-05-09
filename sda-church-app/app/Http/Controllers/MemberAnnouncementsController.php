<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class MemberAnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::active()->latest('publish_date')->paginate(10);

        return view('member.announcements', compact('announcements'));
    }
}
