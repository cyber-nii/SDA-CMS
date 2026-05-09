<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClassFund;
use App\Models\DepartmentFund;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Services\ExportService;

class FundsController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        return view('funds-controller.index');
    }

    public function classes(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = ClassFund::with('recordedBy')->latest('date_received');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhere('class_name', 'like', "%{$search}%");
            });
        }
        if ($startDate) {
            $query->whereDate('date_received', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date_received', '<=', $endDate);
        }

        $classFunds = $query->get();
        return view('funds-controller.classes', compact('classFunds', 'search', 'startDate', 'endDate'));
    }

    public function departments(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = DepartmentFund::with('department', 'recordedBy')->latest('date_received');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }
        if ($startDate) {
            $query->whereDate('date_received', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date_received', '<=', $endDate);
        }

        $departmentFunds = $query->get();
        $departments = Department::all();
        return view('funds-controller.departments', compact('departmentFunds', 'departments', 'search', 'startDate', 'endDate'));
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date_received' => 'required|date',
        ]);

        $validated['recorded_by'] = auth()->id();
        $initials = $this->getInitials($validated['class_name']);
        $validated['receipt_number'] = $this->generateReceiptNumber($initials);

        ClassFund::create($validated);

        return redirect()->route('funds-controller.classes')->with('success', 'Class fund recorded successfully. Receipt #: ' . $validated['receipt_number']);
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,department_id',
            'amount' => 'required|numeric|min:0.01',
            'date_received' => 'required|date',
        ]);

        $validated['recorded_by'] = auth()->id();
        $department = Department::findOrFail($validated['department_id']);
        $initials = $this->getInitials($department->name);
        $validated['receipt_number'] = $this->generateReceiptNumber($initials);

        DepartmentFund::create($validated);

        return redirect()->route('funds-controller.departments')->with('success', 'Department fund recorded successfully. Receipt #: ' . $validated['receipt_number']);
    }

    protected function getInitials($name)
    {
        $words = preg_split('/\s+/', preg_replace('/[^A-Za-z0-9\s]/', '', $name), -1, PREG_SPLIT_NO_EMPTY);
        return collect($words)->map(function($word) { 
            return strtoupper(substr($word, 0, 1)); 
        })->join('');
    }

    protected function generateReceiptNumber($prefix)
    {
        return $prefix . '-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }

    /**
     * Export class funds as CSV or PDF.
     */
    public function exportClasses(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = ClassFund::latest('date_received');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhere('class_name', 'like', "%{$search}%");
            });
        }
        if ($startDate) {
            $query->whereDate('date_received', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date_received', '<=', $endDate);
        }

        $classFunds = $query->get();
        $filters = compact('search', 'startDate', 'endDate') + ['start_date' => $startDate, 'end_date' => $endDate];

        if ($request->query('format') === 'pdf') {
            return $this->exportService->exportPdf(
                'funds-controller.classes-pdf',
                compact('classFunds', 'filters'),
                'Class_Funds_Report_' . date('Y-m-d') . '.pdf'
            );
        }

        $headers = ['Date Received', 'Class Name', 'Amount ($)', 'Receipt No.'];
        $data = [];
        foreach ($classFunds as $fund) {
            $data[] = [
                \Carbon\Carbon::parse($fund->date_received)->format('Y-m-d'),
                $fund->class_name,
                $fund->amount,
                $fund->receipt_number,
            ];
        }
        $data[] = ['', 'TOTAL', $classFunds->sum('amount'), ''];

        return $this->exportService->exportCsv('Class_Funds_Report_' . date('Y-m-d') . '.csv', $headers, $data);
    }

    /**
     * Export department funds as CSV or PDF.
     */
    public function exportDepartments(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = DepartmentFund::with('department')->latest('date_received');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }
        if ($startDate) {
            $query->whereDate('date_received', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date_received', '<=', $endDate);
        }

        $departmentFunds = $query->get();
        $filters = compact('search', 'startDate', 'endDate') + ['start_date' => $startDate, 'end_date' => $endDate];

        if ($request->query('format') === 'pdf') {
            return $this->exportService->exportPdf(
                'funds-controller.departments-pdf',
                compact('departmentFunds', 'filters'),
                'Department_Funds_Report_' . date('Y-m-d') . '.pdf'
            );
        }

        $headers = ['Date Received', 'Department', 'Amount ($)', 'Receipt No.'];
        $data = [];
        foreach ($departmentFunds as $fund) {
            $data[] = [
                \Carbon\Carbon::parse($fund->date_received)->format('Y-m-d'),
                $fund->department->name ?? 'Unknown',
                $fund->amount,
                $fund->receipt_number,
            ];
        }
        $data[] = ['', 'TOTAL', $departmentFunds->sum('amount'), ''];

        return $this->exportService->exportCsv('Department_Funds_Report_' . date('Y-m-d') . '.csv', $headers, $data);
    }
}
