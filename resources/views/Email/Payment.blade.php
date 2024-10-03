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

.info-table {
    width: 100%;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: bold;
    color: #333;
}

.info-value {
    color: #555;
    text-align: right; /* Align values to the right for better readability */
}

</style>

<div class="receipt-container">
    @if ($user->receipt)
        <img src="{{$user->receipt}}" alt="Receipt Image" class="receipt-image" />
    @endif
    <div class="info-table">
        <div class="info-row">
            <div class="info-value">{{$user->student}}</div>
            <div class="info-label">الاسم</div>
        </div>
        <div class="info-row">
            <div class="info-value">{{$user->category}}</div>
            <div class="info-label">السنة الدراسية</div>
        </div>
        <div class="info-row">
            <div class="info-value">{{$user->amount}}</div>
            <div class="info-label">المبلغ المدفوع</div>
        </div>
        <div class="info-row">
            <div class="info-value">{{$user->date}}</div>
            <div class="info-label">التاريخ</div>
        </div>
        <div class="info-row">
            <div class="info-value">
                @if ($user->order)
                @foreach ($user->order as $order)
                    {{$order->name}}
                    <br />
                @endforeach
                @endif
            </div>
            <div class="info-label">المشتريات</div>
        </div>
    </div>
</div>
