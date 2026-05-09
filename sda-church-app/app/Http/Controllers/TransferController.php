<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\ExportService;

class TransferController extends Controller
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
        $transfers = Transfer::with('member')->latest('request_date')->paginate(15);
        return view('transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::orderBy('last_name')->get();
        return view('transfers.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'transfer_type' => 'required|in:In,Out',
            'from_church' => 'nullable|string|max:255',
            'to_church' => 'nullable|string|max:255',
            'request_date' => 'required|date',
            'approval_date' => 'nullable|date',
            'status' => 'required|in:Pending,Approved,Completed,Rejected',
            'notes' => 'nullable|string',
        ]);

        Transfer::create($validated);

        return redirect()->route('transfers.index')->with('success', 'Transfer record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        return view('transfers.show', compact('transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        $members = Member::orderBy('last_name')->get();
        return view('transfers.edit', compact('transfer', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'transfer_type' => 'required|in:In,Out',
            'from_church' => 'nullable|string|max:255',
            'to_church' => 'nullable|string|max:255',
            'request_date' => 'required|date',
            'approval_date' => 'nullable|date',
            'status' => 'required|in:Pending,Approved,Completed,Rejected',
            'notes' => 'nullable|string',
        ]);

        $transfer->update($validated);

        return redirect()->route('transfers.index')->with('success', 'Transfer record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
        return redirect()->route('transfers.index')->with('success', 'Transfer record deleted successfully.');
    }

    /**
     * Export transfers to CSV.
     */
    public function export(Request $request)
    {
        $transfers = Transfer::with('member')->orderBy('request_date', 'desc')->get();

        $headers = ['Member Name', 'Transfer Type', 'Origin Church', 'Destination Church', 'Date of Transfer', 'Status', 'Notes'];
        $data = [];

        foreach ($transfers as $transfer) {
            $data[] = [
                $transfer->member ? $transfer->member->first_name . ' ' . $transfer->member->last_name : 'Unknown Member',
                $transfer->transfer_type,
                $transfer->from_church ?? 'N/A',
                $transfer->to_church ?? 'N/A',
                \Carbon\Carbon::parse($transfer->request_date)->format('Y-m-d'),
                $transfer->status,
                $transfer->notes ?? ''
            ];
        }

        $filename = 'Transfers_Record_' . date('Y-m-d') . '.csv';

        if ($request->query('format') === 'pdf') {
            return $this->exportService->exportPdf('transfers.pdf', compact('transfers'), 'Transfers_Record_' . date('Y-m-d') . '.pdf');
        }

        return $this->exportService->exportCsv($filename, $headers, $data);
    }
}
