<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<table>
    <thead>
    <tr>
        @foreach($user->getAttributes() as $key=>$attribute)
            @if(!in_array($key,['created_at','deleted_at','updated_at','id','lang','avatar','remember_token']))
                @if($alias = \App\Manager\Programs\Field::where('program_id',4)->where('field',$key)->first())
                    <th>{{ $alias->slug }}</th>
                @else
                    <th>{{ $key }}</th>
                @endif
            @endif
        @endforeach
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</body>
</html>