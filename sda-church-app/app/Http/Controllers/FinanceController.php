<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Tithe;
use App\Models\Offering;
use App\Models\Donation;
use App\Models\Expenditure;
use App\Models\DepartmentFund;
use App\Models\ClassFund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PaymentReceipt;
use Illuminate\Support\Str;
use App\Services\ExportService;

class FinanceController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of financial records.
     */
    public function index()
    {
        $members = Member::orderBy('last_name')->orderBy('first_name')->get();
        $tithes = Tithe::with('member')->latest('date_received')->take(10)->get();
        $offerings = Offering::latest('date_received')->take(10)->get();
        $donations = Donation::with('member')->latest('date_received')->take(10)->get();
        $expenditures = Expenditure::latest('expenditure_date')->take(10)->get();

        $totalTithes = Tithe::sum('amount');
        $totalOfferings = Offering::sum('amount');
        $totalDonations = Donation::sum('amount');
        $totalExpenses = Expenditure::sum('amount');
        $totalIncome = $totalTithes + $totalOfferings + $totalDonations;
        $netBalance = $totalIncome - $totalExpenses;

        $expenditureCategories = [
            'Salaries',
            'Utilities',
            'Maintenance',
            'Events',
            'Administration',
            'Mission & Outreach',
            'Other',
        ];
        $paymentMethods = ['Cash', 'Cheque', 'Bank Transfer', 'Mobile Money'];

        $existingOfferingCategories = Offering::distinct()->pluck('category')->toArray();
        $existingDonationPurposes = Donation::distinct()->pluck('purpose')->toArray();

        $departmentFunds = DepartmentFund::with('department', 'recordedBy')->latest('date_received')->take(10)->get();
        $classFunds = ClassFund::latest('date_received')->take(10)->get();
        $totalDeptFunds = DepartmentFund::sum('amount');
        $totalClassFunds = ClassFund::sum('amount');

        return view('finance.index', compact(
            'members',
            'tithes',
            'offerings',
            'donations',
            'expenditures',
            'totalTithes',
            'totalOfferings',
            'totalDonations',
            'totalExpenses',
            'totalIncome',
            'netBalance',
            'expenditureCategories',
            'paymentMethods',
            'existingOfferingCategories',
            'existingDonationPurposes',
            'departmentFunds',
            'classFunds',
            'totalDeptFunds',
            'totalClassFunds'
        ));
    }

    // ────────────────────────────────────────────────────────────────
    //  Expenditure CRUD
    // ────────────────────────────────────────────────────────────────

    /**
     * Store a new expenditure record.
     */
    public function storeExpenditure(Request $request)
    {
        $validated = $request->validate([
            'expenditure_date' => 'required|date',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $validated['recorded_by'] = auth()->id(); // Audit field — stored internally

        Expenditure::create($validated);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Expenditure Recorded',
            'description' => 'Recorded expenditure of $' . $validated['amount'] . ' — ' . $validated['title'] . ' (' . $validated['category'] . ')',
        ]);

        return redirect()->route('finance.index')->with('success', 'Expenditure recorded successfully.');
    }

    /**
     * Delete an expenditure record.
     */
    public function destroyExpenditure(Expenditure $expenditure)
    {
        $expenditure->delete();
        return redirect()->route('finance.index')->with('success', 'Expenditure deleted successfully.');
    }

    // ────────────────────────────────────────────────────────────────
    //  Tithe CRUD (unchanged)
    // ────────────────────────────────────────────────────────────────

    public function storeTithe(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'amount' => 'required|numeric|min:0.01',
            'date_received' => 'required|date',
            'receipt_number' => 'nullable|string|max:255',
        ]);

        $validated['recorded_by'] = auth()->id();
        $validated['receipt_number'] = $this->generateReceiptNumber('TIT');

        $tithe = Tithe::create($validated);

        try {
            $member = Member::find($validated['member_id']);
            if ($member && $member->email) {
                Mail::to($member->email)->send(new PaymentReceipt($tithe, $member, 'Tithe'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send tithe receipt email: ' . $e->getMessage());
        }

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Tithe Recorded',
            'description' => 'Recorded tithe of $' . $validated['amount'] . ' for member ID ' . $validated['member_id'] . '. Receipt: ' . $validated['receipt_number'],
        ]);

        return redirect()->route('finance.index')->with('success', 'Tithe recorded successfully. Receipt #: ' . $validated['receipt_number']);
    }

    public function destroyTithe(Tithe $tithe)
    {
        $tithe->delete();
        return redirect()->route('finance.index')->with('success', 'Tithe deleted successfully.');
    }

    // ────────────────────────────────────────────────────────────────
    //  Offering CRUD (unchanged)
    // ────────────────────────────────────────────────────────────────

    public function storeOffering(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date_received' => 'required|date',
        ]);

        $validated['recorded_by'] = auth()->id();
        Offering::create($validated);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Offering Recorded',
            'description' => 'Recorded offering of $' . $validated['amount'] . ' (' . $validated['category'] . ')',
        ]);

        return redirect()->route('finance.index')->with('success', 'Offering recorded successfully.');
    }

    public function destroyOffering(Offering $offering)
    {
        $offering->delete();
        return redirect()->route('finance.index')->with('success', 'Offering deleted successfully.');
    }

    // ────────────────────────────────────────────────────────────────
    //  Donation CRUD (unchanged)
    // ────────────────────────────────────────────────────────────────

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,member_id',
            'purpose' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date_received' => 'required|date',
            'receipt_number' => 'nullable|string|max:255',
        ]);

        $validated['recorded_by'] = auth()->id();
        $validated['receipt_number'] = $this->generateReceiptNumber('DON');

        $donation = Donation::create($validated);

        if (!empty($validated['member_id'])) {
            try {
                $member = Member::find($validated['member_id']);
                if ($member && $member->email) {
                    Mail::to($member->email)->send(new PaymentReceipt($donation, $member, 'Donation'));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send donation receipt email: ' . $e->getMessage());
            }
        }

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Donation Recorded',
            'description' => 'Recorded donation of $' . $validated['amount'] . ' for ' . $validated['purpose'] . '. Receipt: ' . $validated['receipt_number'],
        ]);

        return redirect()->route('finance.index')->with('success', 'Donation recorded successfully. Receipt #: ' . $validated['receipt_number']);
    }

    public function destroyDonation(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('finance.index')->with('success', 'Donation deleted successfully.');
    }

    // ────────────────────────────────────────────────────────────────
    //  Helpers
    // ────────────────────────────────────────────────────────────────

    protected function generateReceiptNumber($prefix)
    {
        return $prefix . '-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }

    // ────────────────────────────────────────────────────────────────
    //  Export (CSV + PDF) — now includes Expenditures
    // ────────────────────────────────────────────────────────────────

    public function export(Request $request)
    {
        $tithes = Tithe::with('member')->get();
        $offerings = Offering::get();
        $donations = Donation::with('member')->get();
        $expenditures = Expenditure::get();

        $format = $request->query('format', 'csv');

        if ($format === 'pdf') {
            $totalTithes = $tithes->sum('amount');
            $totalOfferings = $offerings->sum('amount');
            $totalDonations = $donations->sum('amount');
            $totalExpenses = $expenditures->sum('amount');
            $totalIncome = $totalTithes + $totalOfferings + $totalDonations;
            $netBalance = $totalIncome - $totalExpenses;

            return $this->exportService->exportPdf(
                'finance.pdf',
                compact(
                    'tithes',
                    'offerings',
                    'donations',
                    'expenditures',
                    'totalTithes',
                    'totalOfferings',
                    'totalDonations',
                    'totalExpenses',
                    'totalIncome',
                    'netBalance'
                ),
                'Financial_Report_' . date('Y-m-d') . '.pdf'
            );
        }

        // CSV — Expenditures included as a separate section
        $headers = ['Date', 'Record Type', 'Category / Purpose', 'Contributor / Title', 'Amount', 'Receipt / Method'];
        $data = [];

        foreach ($tithes as $t) {
            $data[] = [\Carbon\Carbon::parse($t->date_received)->format('Y-m-d'), 'Tithe', 'General Tithe', $t->member ? $t->member->first_name . ' ' . $t->member->last_name : 'N/A', $t->amount, $t->receipt_number];
        }
        foreach ($offerings as $o) {
            $data[] = [\Carbon\Carbon::parse($o->date_received)->format('Y-m-d'), 'Offering', $o->category, 'Anonymous', $o->amount, 'N/A'];
        }
        foreach ($donations as $d) {
            $data[] = [\Carbon\Carbon::parse($d->date_received)->format('Y-m-d'), 'Donation', $d->purpose, $d->member ? $d->member->first_name . ' ' . $d->member->last_name : 'Anonymous', $d->amount, $d->receipt_number];
        }
        foreach ($expenditures as $e) {
            $data[] = [\Carbon\Carbon::parse($e->expenditure_date)->format('Y-m-d'), 'Expenditure', $e->category, $e->title, -$e->amount, $e->payment_method];
        }

        usort($data, fn($a, $b) => strtotime($b[0]) - strtotime($a[0]));

        $tt = $tithes->sum('amount');
        $to = $offerings->sum('amount');
        $td = $donations->sum('amount');
        $te = $expenditures->sum('amount');

        $data[] = ['', '', '', '', '', ''];
        $data[] = ['TOTAL TITHES', '', '', '', $tt, ''];
        $data[] = ['TOTAL OFFERINGS', '', '', '', $to, ''];
        $data[] = ['TOTAL DONATIONS', '', '', '', $td, ''];
        $data[] = ['TOTAL INCOME', '', '', '', $tt + $to + $td, ''];
        $data[] = ['TOTAL EXPENSES', '', '', '', $te, ''];
        $data[] = ['NET BALANCE', '', '', '', $tt + $to + $td - $te, ''];

        return $this->exportService->exportCsv('Financial_Report_' . date('Y-m-d') . '.csv', $headers, $data);
    }
}
