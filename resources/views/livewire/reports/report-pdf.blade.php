<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $report_title }}</title>
    <style>
        /* تضمين خط أميري مدمج يدعم التوصيل والقراءة الصحيحة بدون كاش الخادم */
        @import url('https://fonts.googleapis.com/css2?family=Amiri&display=swap');

        body { 
            font-family: 'Amiri', 'DejaVu Sans', sans-serif; 
            direction: rtl; 
            text-align: right; 
            background-color: #0c101b; 
            color: #f3f4f6; 
            padding: 15px;
        }
        .header { border-bottom: 2px solid #1f2937; padding-bottom: 12px; margin-bottom: 25px; }
        .title { font-size: 22px; font-weight: bold; color: #ffffff; }
        .meta { font-size: 11px; color: #9ca3af; margin-top: 5px; }
        .stats-table { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .card { background-color: #111827; border: 1px solid #1f2937; padding: 15px; text-align: center; width: 33.3%; }
        .card-label { font-size: 11px; color: #9ca3af; }
        .card-value { font-size: 18px; font-weight: bold; color: #3b82f6; margin-top: 5px; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .data-table th, .data-table td { border: 1px solid #1f2937; padding: 10px; text-align: right; }
        .data-table th { background-color: #111827; color: #9ca3af; font-size: 12px; }
        .data-table td { font-size: 11px; color: #e5e7eb; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">{{ $report_title }}</div>
        <div class="meta">نطاق التقرير: {{ $time_period }} | تاريخ ووقت التصدير: {{ $date }}</div>
    </div>

    <table class="stats-table">
        <tr>
            <td class="card">
                <div class="card-label">معدل الاجتياز الكلي</div>
                <div class="card-value" style="color: #10b981;">{{ $stat_pass_rate }}%</div>
            </td>
            <td class="card">
                <div class="card-label">جاهزية القوة البشرية</div>
                <div class="card-value">{{ $stat_readiness_rate }}%</div>
            </td>
            <td class="card">
                <div class="card-label">المعدل العام للدرجات</div>
                <div class="card-value" style="color: #ffffff;">{{ $stat_general_grade }}</div>
            </td>
        </tr>
    </table>

    <h3 style="color: #ffffff; font-size: 13px; margin-bottom: 10px;">السجل الموحد للبيانات المرفقة:</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>رمز السجل</th>
                <th>البيان / الاسم التكتيكي</th>
                <th>التصنيف الرئيسي</th>
                <th>الكفاءة والامتثال</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($table_data as $row)
                <tr>
                    <td style="color: #9ca3af;">{{ $row['code'] }}</td>
                    <td style="font-weight: bold;">{{ $row['title'] }}</td>
                    <td>{{ $row['metric_1'] }}</td>
                    <td style="color: #10b981;">{{ $row['metric_2'] }}</td>
                    <td>{{ $row['status_badge'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>