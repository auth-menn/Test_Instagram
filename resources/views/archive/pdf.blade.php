<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Archived Posts</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        img {
            height: 60px;
        }
    </style>
</head>
<body>
    <h2>Daftar Post yang Diarsipkan</h2>
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Tanggal</th>
                <th>Caption</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($archives as $post)
                <tr>
                    <td>
                        @if ($post->file_type == 'image' && file_exists(public_path('storage/' . $post->media)))
                            <img src="{{ public_path('storage/' . $post->media) }}" alt="Media">
                        @else
                            (tidak tersedia)
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}</td>
                    <td>{{ $post->caption }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
