<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Department;
use App\Models\Baptism;
use App\Models\Tithe;
use App\Models\Offering;
use App\Models\Donation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the church dashboard.
     */
    public function index()
    {
        if (auth()->user()->role === 'Member') {
            return redirect()->route('member.dashboard');
        }

        $membersCount = Member::count();
        $maleCount = Member::where('gender', 'Male')->count();
        $femaleCount = Member::where('gender', 'Female')->count();
        $departmentsCount = Department::count();
        $baptismsCount = Baptism::count();
        
        // Total financial summary (Tithes + Offerings + Donations)
        $totalTithes = Tithe::sum('amount');
        $totalOfferings = Offering::sum('amount');
        $totalDonations = Donation::sum('amount');
        $totalFinances = $totalTithes + $totalOfferings + $totalDonations;

        $activities = ActivityLog::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'membersCount',
            'maleCount',
            'femaleCount',
            'departmentsCount', 
            'baptismsCount', 
            'totalFinances', 
            'activities'
        ));
    }
}
