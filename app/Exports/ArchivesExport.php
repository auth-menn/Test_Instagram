<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ArchivesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $archives;

    public function __construct($archives)
    {
        $this->archives = $archives;
    }

    public function collection()
    {
        return $this->archives;
    }

    public function headings(): array
    {
        return [
            'Foto/Video',
            'Tanggal Post',
            'Caption',
        ];
    }

    public function map($post): array
    {
        $mediaUrl = $post->media ? asset('storage/' . $post->media) : 'Tidak ada media';

        return [
            $mediaUrl,
            $post->created_at->format('d M Y'),
            $post->caption,
        ];
    }
}
