<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    /**
     * Display the member's personal dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Ensure user has a linked member profile
        if (!$user->member_id || !$user->member) {
            return redirect()->route('dashboard')->with('error', 'No member profile is linked to your account.');
        }

        $member = $user->member()->with(['departments', 'tithes', 'donations', 'baptisms', 'transfers'])->first();

        return view('member.dashboard', compact('member', 'user'));
    }
}
