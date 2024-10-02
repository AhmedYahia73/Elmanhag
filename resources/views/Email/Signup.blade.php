<table width="100%">
    <tr>
        <td>الاسم</td>
        <td>{{$data->name}}</td>
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
        <td>الصف</td>
        <td>{{$data->category}}</td>
    </tr>
    <tr>
        <td>أسم ولى الأمر</td>
        <td>{{$data->parent}}</td>
    </tr>
    <tr>
        <td>نوع التعليم</td>
        <td>{{$data->education}}</td>
    </tr>
    <tr>
        <td>الوظيفة</td>
        <td>{{$data->job}}</td>
    </tr>
    @endif
</table>