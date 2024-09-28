
<table>
    <tr>
        <td>{{$user->name}}</td>
        <td>الاسم</td>
    </tr>
    <tr>
        <td>{{date('d-m-Y', $user->created_at)}}</td>
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
        <td>{{$user->category}}</td>
        <td>الصف</td>
    </tr>
    <tr>
        <td>{{$user->parent}}</td>
        <td>أسم ولى الأمر</td>
    </tr>
    <tr>
        <td>{{$user->education}}</td>
        <td>نوع التعليم</td>
    </tr>
    <tr>
        <td>{{$user->job}}</td>
        <td>الوظيفة</td>
    </tr>
    @endif
</table>