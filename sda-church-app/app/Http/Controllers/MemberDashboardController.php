<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->member_id || !$user->member) {
            return redirect()->route('dashboard')->with('error', 'No member profile is linked to your account.');
        }

        $member = $user->member()->with(['departments', 'tithes', 'donations', 'baptisms', 'transfers'])->first();

        $announcements = Announcement::active()->latest('publish_date')->take(5)->get();
        $announcementCount = Announcement::active()->count();

        return view('member.dashboard', compact('member', 'user', 'announcements', 'announcementCount'));
    }
}
