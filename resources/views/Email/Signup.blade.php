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
        <td>{{$user->role == 'student' ? 'طالب' : $user->role}}</td>
        <td>النوع</td>
    </tr>
    <tr>
        <td>{{$user->gender == 'male' ? 'ولد' : 'بنت'}}</td>
        <td>نوع</td>
    </tr>
    <tr>
        <td>{{$user->phone}}</td>
        <td>رقم التليفون</td>
    </tr>
    @if ($user->role == 'student')
    <tr>
        <td>{{$user->parent_phone}}</td>
        <td>رقم الوالد</td>
    </tr>
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