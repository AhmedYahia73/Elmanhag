
<style>
    .receipt-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.receipt-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}
</style>

<div class="receipt-container">
    @if ($user['receipt'])
        <img src="{{$user['receipt']}}" alt="Receipt Image" class="receipt-image" />
    @endif
<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">المعلومات</th>
            <th style="text-align: right; padding: 10px; border: 1px solid #ddd;">التفاصيل</th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{$user['student']}}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">الاسم</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{$user['category']}}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">السنة الدراسية</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{$user['amount']}}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">المبلغ المدفوع</td>
        </tr> 
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{$user['payment_method']}}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">طريقة الدفع</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{date('d-m-Y')}}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">التاريخ</td>
        </tr> 
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">
                @if ($user['order'])
                    @foreach ($user['order'] as $order)
                        {{$order->name}}
                        <br />
                    @endforeach
                @endif
            </td>
            <td style="padding: 10px; border: 1px solid #ddd;">المشتريات</td>
        </tr>
    </tbody>
</table>
</div>
 
 
