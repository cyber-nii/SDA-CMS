<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\ExportService;

class DepartmentController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        $departments = Department::withCount('members')
            ->orderBy('name')
            ->get();

        return view('departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        $department->load('members');
        return view('departments.show', compact('department'));
    }

    /**
     * Export departments to CSV.
     */
    public function export(Request $request)
    {
        $departments = Department::withCount('members')
            ->orderBy('name')
            ->get();

        $headers = ['Department Name', 'Number of Members', 'Description', 'Status'];
        $data = [];

        foreach ($departments as $dept) {
            $data[] = [
                $dept->name,
                $dept->members_count,
                $dept->description ?? 'N/A',
                $dept->is_active ? 'Active' : 'Inactive'
            ];
        }

        $filename = 'Departments_List_' . date('Y-m-d') . '.csv';

        if ($request->query('format') === 'pdf') {
            return $this->exportService->exportPdf('departments.pdf', compact('departments'), 'Departments_List_' . date('Y-m-d') . '.pdf');
        }

        return $this->exportService->exportCsv($filename, $headers, $data);
    }
}
