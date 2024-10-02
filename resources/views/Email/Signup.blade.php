<table width="100%">
    <tr>
        <td>الاسم</td>
        <td>{{$user->name}}</td>
    </tr>
    <tr>
        <td>{{date('d-m-Y', strtotime($user->created_at))}}</td>
        <td>التاريخ</td>
    </tr>
    <tr>
        <td>{{$user->role}}</td>
        <td>النوع</td>
    </tr>
    <tr>
        <td>{{$user->gender}}</td>
        <td>نوع الجنس</td>
    </tr>
    @if ($user->role == 'student')
    <tr>
        <td>الصف</td>
        <td>{{$user->category}}</td>
    </tr>
    <tr>
        <td>أسم ولى الأمر</td>
        <td>{{$user->parent}}</td>
    </tr>
    <tr>
        <td>نوع التعليم</td>
        <td>{{$user->education}}</td>
    </tr>
    <tr>
        <td>الوظيفة</td>
        <td>{{$user->job}}</td>
    </tr>
    @endif
</table>