<?php

namespace App\Http\Controllers;

use App\Models\Baptism;
use Illuminate\Http\Request;
use App\Services\ExportService;

class BaptismController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baptisms = Baptism::with('member')->latest('baptism_date')->paginate(15);
        return view('baptisms.index', compact('baptisms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = \App\Models\Member::orderBy('last_name')->get();
        return view('baptisms.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'baptism_date' => 'required|date',
            'pastor_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Baptism::create($validated);

        return redirect()->route('baptisms.index')->with('success', 'Baptism record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Baptism $baptism)
    {
        return view('baptisms.show', compact('baptism'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baptism $baptism)
    {
        $members = \App\Models\Member::orderBy('last_name')->get();
        return view('baptisms.edit', compact('baptism', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Baptism $baptism)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'baptism_date' => 'required|date',
            'pastor_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $baptism->update($validated);

        return redirect()->route('baptisms.index')->with('success', 'Baptism record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baptism $baptism)
    {
        $baptism->delete();
        return redirect()->route('baptisms.index')->with('success', 'Baptism record deleted successfully.');
    }

    /**
     * Export baptisms to CSV.
     */
    public function export(Request $request)
    {
        $baptisms = Baptism::with('member')->orderBy('baptism_date', 'desc')->get();

        $headers = ['Full Name', 'Date of Baptism', 'Officiating Minister', 'Location', 'Notes'];
        $data = [];

        foreach ($baptisms as $baptism) {
            $data[] = [
                $baptism->member ? $baptism->member->first_name . ' ' . $baptism->member->last_name : 'Unknown Member',
                \Carbon\Carbon::parse($baptism->baptism_date)->format('Y-m-d'),
                $baptism->pastor_name,
                $baptism->location ?? 'N/A',
                $baptism->notes ?? ''
            ];
        }

        $filename = 'Baptisms_Record_' . date('Y-m-d') . '.csv';

        if ($request->query('format') === 'pdf') {
            return $this->exportService->exportPdf('baptisms.pdf', compact('baptisms'), 'Baptisms_Record_' . date('Y-m-d') . '.pdf');
        }

        return $this->exportService->exportCsv($filename, $headers, $data);
    }
}
