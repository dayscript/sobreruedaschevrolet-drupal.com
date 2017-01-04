<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>cedula</th>
        <th>nombre</th>
        <th>jefe</th>
        <th>periodo</th>
        <th>liquidacion</th>
        <th>meta</th>
        <th>desafio</th>
        <th>valor</th>
        <th>puntos</th>
    </tr>
    </thead>
    <tbody>
    @foreach($values as $value)
        <tr>
            <td>{{ $value->user->identification }}</td>
            <td>{{ $value->user->name }}</td>
            <td>{{ $value->user->parent?$value->user->parent->name:'' }}</td>
            <td>{{ $value->period }}</td>
            <td>{{ $value->updated_at }}</td>
            <td>{{ $value->goal->name }}</td>
            <td>{{ $value->goal->challenge->name }}</td>
            <td>{{ $value->value }}</td>
            <td>{{ $value->points }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>