<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>identification</th>
        <th>periodo</th>
        <th>canales</th>
        @foreach($template->variables as $variable)
            <th>{{ $variable->slug }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php($users = $user->users)
    @can('edit',new \App\Manager\User\ImportTemplate)
        @php($users = \App\Manager\User\Role::find(7)->users)
    @endcan
    @foreach($users as $us)
        <tr>
            <td>{{ $us->identification }}</td>
            <td>{{ $date }}</td>
            <td>{{ implode(', ',$us->channels->pluck('name')->toArray()) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>