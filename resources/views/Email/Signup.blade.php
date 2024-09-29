<table>
    <tr>
        <td>{{$data->name}}</td>
        <td>الاسم</td>
    </tr>
    <tr>
        <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
        <td>التاريخ</td>
    </tr>
    <tr>
        <td>{{$data->role}}</td>
        <td>النوع</td>
    </tr>
    <tr>
        <td>{{$data->gender}}</td>
        <td>نوع الجنس</td>
    </tr>
    @if ($data->role == 'student')
    <tr>
        <td>{{$data->category}}</td>
        <td>الصف</td>
    </tr>
    <tr>
        <td>{{$data->parent}}</td>
        <td>أسم ولى الأمر</td>
    </tr>
    <tr>
        <td>{{$data->education}}</td>
        <td>نوع التعليم</td>
    </tr>
    <tr>
        <td>{{$data->job}}</td>
        <td>الوظيفة</td>
    </tr>
    @endif
</table>