<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Caption</th>
        </tr>
    </thead>
    <tbody>
        @foreach($archives as $post)
            <tr>
                <td>{{ $post->created_at->format('d-m-Y') }}</td>
                <td>{{ $post->caption }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
