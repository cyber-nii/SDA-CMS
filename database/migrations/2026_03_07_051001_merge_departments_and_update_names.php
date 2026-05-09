<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Adventist Youth Merge
        $ay = DB::table('departments')->where('name', 'Adventist Youth (AY)')->orWhere('name', 'Adventist Youth')->first();
        if (!$ay) {
            $ay_id = DB::table('departments')->insertGetId([
                'name' => 'Adventist Youth',
                'description' => 'Adventist Youth Department',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $ay_id = $ay->department_id;
            DB::table('departments')->where('department_id', $ay_id)->update(['name' => 'Adventist Youth']);
        }

        $pathfinder = DB::table('departments')->where('name', 'Pathfinder Club')->first();
        $adventurer = DB::table('departments')->where('name', 'Adventurer Club')->first();
        
        $old_youth_ids = array_filter([$pathfinder?->department_id ?? null, $adventurer?->department_id ?? null]);
        
        foreach ($old_youth_ids as $old_id) {
            $members = DB::table('member_departments')->where('department_id', $old_id)->get();
            foreach ($members as $member) {
                // Check if member is already in Adventist Youth
                $exists = DB::table('member_departments')
                    ->where('member_id', $member->member_id)
                    ->where('department_id', $ay_id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('member_departments')->insert([
                        'member_id' => $member->member_id,
                        'department_id' => $ay_id,
                        'role' => $member->role,
                        'joined_date' => $member->joined_date,
                    ]);
                }
            }
            DB::table('member_departments')->where('department_id', $old_id)->delete();
            DB::table('departments')->where('department_id', $old_id)->delete();
        }

        // 2. Deacons and Deaconesses Merge
        $deacons = DB::table('departments')->where('name', 'Deacons')->first();
        $deaconesses = DB::table('departments')->where('name', 'Deaconesses')->first();

        if ($deacons) {
            DB::table('departments')->where('department_id', $deacons->department_id)->update(['name' => 'Deacons & Deaconesses']);
            $target_deacon_id = $deacons->department_id;
        } else if ($deaconesses) {
            DB::table('departments')->where('department_id', $deaconesses->department_id)->update(['name' => 'Deacons & Deaconesses']);
            $target_deacon_id = $deaconesses->department_id;
        } else {
            $target_deacon_id = DB::table('departments')->insertGetId([
                'name' => 'Deacons & Deaconesses',
                'description' => 'Deacons & Deaconesses Department',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($deaconesses && $deaconesses->department_id != $target_deacon_id) {
            $members = DB::table('member_departments')->where('department_id', $deaconesses->department_id)->get();
            foreach ($members as $member) {
                $exists = DB::table('member_departments')
                    ->where('member_id', $member->member_id)
                    ->where('department_id', $target_deacon_id)
                    ->exists();
                
                if (!$exists) {
                    DB::table('member_departments')->insert([
                        'member_id' => $member->member_id,
                        'department_id' => $target_deacon_id,
                        'role' => $member->role,
                        'joined_date' => $member->joined_date,
                    ]);
                }
            }
            DB::table('member_departments')->where('department_id', $deaconesses->department_id)->delete();
            DB::table('departments')->where('department_id', $deaconesses->department_id)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Merge migrations are difficult to reverse perfectly without detailed history
    }
};
