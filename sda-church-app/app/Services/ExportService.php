<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    /**
     * Export data to a CSV file.
     *
     * @param string $filename
     * @param array $headers The headers for the CSV
     * @param iterable $data The raw row data arrays
     * @return StreamedResponse
     */
    public function exportCsv(string $filename, array $headers, iterable $data): StreamedResponse
    {
        $headersFormatted = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $callback = function () use ($headers, $data) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for proper Excel display
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, $headers);

            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headersFormatted);
    }

    /**
     * Export a blade view to a styled PDF.
     *
     * @param string $view
     * @param array $data
     * @param string $filename
     * @param string $orientation
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(string $view, array $data, string $filename, string $orientation = 'portrait')
    {
        $pdf = Pdf::loadView($view, $data)->setPaper('a4', $orientation);
        return $pdf->download($filename);
    }

    /**
     * Package multiple files into a single ZIP archive for downloading.
     *
     * @param array $filePaths Array of absolute paths or storage disk paths
     * @param string $zipName The desired name for the downloaded zip
     * @param string $disk The storage disk if using Laravel Storage
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|null
     */
    public function exportZip(array $filePaths, string $zipName, string $disk = 'public')
    {
        $zipFile = tempnam(sys_get_temp_dir(), 'zip');
        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($filePaths as $file) {
                $absolutePath = Storage::disk($disk)->path($file['path']);
                if (file_exists($absolutePath)) {
                    $zip->addFile($absolutePath, $file['name']);
                }
            }
            $zip->close();
        }

        if (file_exists($zipFile)) {
            return response()->download($zipFile, $zipName)->deleteFileAfterSend(true);
        }

        return null;
    }
}
