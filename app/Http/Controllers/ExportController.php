<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArchivesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:xlsx,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Post::where('user_id', Auth::id())->where('is_archived', true);

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $archives = $query->get();

        if ($request->format === 'xlsx') {
            return Excel::download(new ArchivesExport($archives), 'archive.xlsx');
        }

        $pdf = PDF::loadView('archive.pdf', compact('archives'));
        return $pdf->download('archive.pdf');
    }
}
