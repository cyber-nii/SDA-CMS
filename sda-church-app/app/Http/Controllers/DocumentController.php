<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ExportService;

class DocumentController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $documents = Document::with('uploader')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('documents.index', compact('documents', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
        ]);

        // Optional Log
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Document Uploaded',
            'description' => 'Uploaded document: ' . $request->title,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        // For downloading the file directly
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found on server.');
        }

        return Storage::disk('public')->download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'Document information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        // Ensure user has permission (can add explicit Gate if needed, currently assumes any auth user can del unless restricted)
        // Here we restrict so only Super Admin or Pastor can delete documentation
        if (!in_array(auth()->user()->role, ['Super Admin', 'Pastor'])) {
            return redirect()->route('documents.index')->with('error', 'You do not have permission to delete documents.');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    /**
     * Bulk download all available documents as a ZIP file.
     */
    public function bulkDownload(Request $request)
    {
        $search = $request->input('search');

        $query = Document::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $documents = $query->get();

        if ($documents->isEmpty()) {
            return redirect()->route('documents.index')->with('error', 'No documents found to zip.');
        }

        $files = [];
        foreach ($documents as $doc) {
            $files[] = [
                'path' => $doc->file_path,
                'name' => $doc->title . '_' . $doc->document_id . '.' . pathinfo($doc->file_path, PATHINFO_EXTENSION)
            ];
        }

        $zipName = 'Church_Documents_' . date('Y-m-d') . '.zip';
        $download = $this->exportService->exportZip($files, $zipName, 'public');

        return $download ?? redirect()->route('documents.index')->with('error', 'Failed to generate ZIP archive.');
    }
}
