<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArchiveExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Post::where('is_archived', true)
                   ->when($this->startDate, function ($query) {
                       return $query->whereDate('created_at', '>=', $this->startDate);
                   })
                   ->when($this->endDate, function ($query) {
                       return $query->whereDate('created_at', '<=', $this->endDate);
                   })
                   ->get(['media_url', 'created_at', 'caption']);
    }

    public function headings(): array
    {
        return [
            'Media',    // Foto/Video Post
            'Tanggal',  // Tanggal Post
            'Caption',  // Caption Post
        ];
    }
}
