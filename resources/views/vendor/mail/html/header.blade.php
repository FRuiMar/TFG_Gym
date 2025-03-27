@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/logo/Forza64_2.png'))) }}"
                class="logo" alt="Forza Logo">
        </a>
    </td>
</tr>
