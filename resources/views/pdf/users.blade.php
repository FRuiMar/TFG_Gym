<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .admin-role {
            color: purple;
            font-weight: bold;
        }

        .user-role {
            color: green;
            font-weight: bold;
        }

        .no-membership {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>
    <h1>Lista de Usuarios</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Membresía</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->dni ?? 'N/A' }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role == 'ADMIN')
                    <span class="admin-role">{{ $user->role }}</span>
                    @else
                    <span class="user-role">{{ $user->role }}</span>
                    @endif
                </td>
                <td>
                    @if($user->membership && $user->membership->type !== 'Sin membresía')
                    {{ $user->membership->type }}
                    @else
                    <span class="no-membership">Sin membresía</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>