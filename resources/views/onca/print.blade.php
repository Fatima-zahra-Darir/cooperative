<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ $document->title }}</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; } /* Landscape might be better for some */
        body { font-family: sans-serif; -webkit-print-color-adjust: exact; margin: 0; padding: 0; }
        
        .container { width: 100%; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid black; padding: 4px; text-align: center; vertical-align: middle; font-size: 12px; }
        
        .header-box { border: 1px solid black; display: flex; margin-bottom: 10px; }
        .header-right { width: 25%; border-left: 1px solid black; padding: 10px; text-align: center; }
        .header-center { flex: 1; text-align: center; padding: 10px; display: flex; flex-direction: column; justify-content: center; }
        .header-left { width: 15%; border-right: 1px solid black; padding: 5px; font-size: 12px; }
        
        .info-bar { display: flex; justify-content: space-between; border: 1px solid black; padding: 5px 10px; margin-bottom: 10px; background: #f9f9f9; }
        
        /* Health Specific */
        .health-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; border: 1px solid black; }
        .health-col { border-left: 1px solid black; }
        .health-col:last-child { border-left: none; }
        .health-col-header { background: #eee; font-weight: bold; padding: 5px; text-align: center; border-bottom: 1px solid black; writing-mode: vertical-rl; transform: rotate(180deg); height: 100px; display: flex; align-items: center; justify-content: center; } /* Vertical text attempt */
        /* Actually horizontal header is better unless space constrained */
        
        .vertical-header { writing-mode: vertical-rl; text-orientation: mixed; height: 100px; }
    </style>
</head>
<body onload="window.print()">

    <div class="header-box">
        <div class="header-right" style="width: 20%; font-size: 10px;">
            <table style="margin: 0; border: none;">
                <tr style="border: none;"><td style="border: none; text-align: left;">الرمز:</td><td style="border: 1px solid black; text-align: center; font-weight: bold; width: 60px;">{{ $document->reference }}</td></tr>
                <tr style="border: none;"><td style="border: none; text-align: left;">الإصدار:</td><td style="border: 1px solid black; text-align: center; font-weight: bold; width: 60px;">{{ $document->version }}</td></tr>
            </table>
        </div>
        <div class="header-center">
            <div style="font-size: 16px; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding: 0 20px; margin-bottom: 5px;">تسجيل:</div>
            <div style="font-size: 20px; font-weight: bold;">{{ $document->title }}</div>
        </div>
        <div class="header-left" style="width: 25%; display: flex; align-items: center; justify-content: space-between;">
             <div style="text-align: right; font-size: 11px; line-height: 1.2;">
                <strong>تعاونية أنوار نكادير</strong><br>
                Cooperative Anwar Ngadirin
            </div>
            <img src="/logo.png" alt="Logo" style="max-height: 50px; margin-left: 10px;">
        </div>
    </div>

    <div class="info-bar" style="border: none; border-bottom: 1px solid black; background: none; margin-bottom: 20px;">
        <div>التاريخ: <span style="border-bottom: 1px dotted black; min-width: 150px; display: inline-block;">{{ $document->date->format('Y/m/d') }}</span></div>
        <div>المسئول: <span style="border-bottom: 1px dotted black; min-width: 150px; display: inline-block;">{{ $document->responsible }}</span></div>
    </div>

    @php $c = $document->content; @endphp

    @if($document->type === 'health')
        <!-- Health Layout: 4 major sections side-by-side -->
        <table style="width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #f2f2f2;">1- صحة العمال</th>
                    <th colspan="4" style="background-color: #f2f2f2;">2- سلوك العمال</th>
                    <th colspan="4" style="background-color: #f2f2f2;">3- الغسل الصحي لليدين</th>
                    <th colspan="4" style="background-color: #f2f2f2;">4- لباس الشغل</th>
                </tr>
                <tr style="font-size: 10px;">
                    <!-- Section 1 -->
                    <th>الساعة</th><th>اسم العامل</th><th>وصف الحالة</th><th>الإجراء</th>
                    <!-- Section 2 -->
                    <th>الساعة</th><th>اسم العامل</th><th>السلوك</th><th>الإجراء</th>
                    <!-- Section 3 -->
                    <th>الساعة</th><th>اسم العامل</th><th>العيب</th><th>الإجراء</th>
                    <!-- Section 4 -->
                    <th>الساعة</th><th>اسم العامل</th><th>العيب</th><th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $h = isset($c['health']) && is_array($c['health']) ? array_values($c['health']) : [];
                    $b = isset($c['behavior']) && is_array($c['behavior']) ? array_values($c['behavior']) : [];
                    $w = isset($c['hands']) && is_array($c['hands']) ? array_values($c['hands']) : []; 
                    $l = isset($c['clothes']) && is_array($c['clothes']) ? array_values($c['clothes']) : [];
                    $max = max(count($h), count($b), count($w), count($l), 15);
                @endphp
                
                @for($i=0; $i<$max; $i++)
                    <tr style="height: 25px;">
                        <!-- 1 -->
                        <td>{{ isset($h[$i]) && is_array($h[$i]) ? ($h[$i]['time'] ?? '') : '' }}</td>
                        <td>{{ isset($h[$i]) && is_array($h[$i]) ? ($h[$i]['name'] ?? '') : '' }}</td>
                        <td>{{ isset($h[$i]) && is_array($h[$i]) ? ($h[$i]['desc'] ?? '') : '' }}</td>
                        <td>{{ isset($h[$i]) && is_array($h[$i]) ? ($h[$i]['action'] ?? '') : '' }}</td>
                        <!-- 2 -->
                        <td>{{ isset($b[$i]) && is_array($b[$i]) ? ($b[$i]['time'] ?? '') : '' }}</td>
                        <td>{{ isset($b[$i]) && is_array($b[$i]) ? ($b[$i]['name'] ?? '') : '' }}</td>
                        <td>{{ isset($b[$i]) && is_array($b[$i]) ? ($b[$i]['desc'] ?? '') : '' }}</td>
                        <td>{{ isset($b[$i]) && is_array($b[$i]) ? ($b[$i]['action'] ?? '') : '' }}</td>
                        <!-- 3 -->
                        <td>{{ isset($w[$i]) && is_array($w[$i]) ? ($w[$i]['time'] ?? '') : '' }}</td>
                        <td>{{ isset($w[$i]) && is_array($w[$i]) ? ($w[$i]['name'] ?? '') : '' }}</td>
                        <td>{{ isset($w[$i]) && is_array($w[$i]) ? ($w[$i]['desc'] ?? '') : '' }}</td>
                        <td>{{ isset($w[$i]) && is_array($w[$i]) ? ($w[$i]['action'] ?? '') : '' }}</td>
                        <!-- 4 -->
                        <td>{{ isset($l[$i]) && is_array($l[$i]) ? ($l[$i]['time'] ?? '') : '' }}</td>
                        <td>{{ isset($l[$i]) && is_array($l[$i]) ? ($l[$i]['name'] ?? '') : '' }}</td>
                        <td>{{ isset($l[$i]) && is_array($l[$i]) ? ($l[$i]['desc'] ?? '') : '' }}</td>
                        <td>{{ isset($l[$i]) && is_array($l[$i]) ? ($l[$i]['action'] ?? '') : '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        
        <div style="margin-top: 20px; font-weight: bold; text-align: left;">تأشير مسئول الجودة: .................................</div>

    @elseif($document->type === 'pest')
        <!-- Pest Control -->
        <h4 style="margin: 0 0 5px 0;">1. نتائج عمليات الوقاية: ملاحظات حول:</h4>
        <table style="width: 100%;">
            <tbody>
                @foreach([
                    'door_window' => 'مدى عدم قابلية الأبواب والنوافذ لتسريب الكائنات الضارة',
                    'surfaces' => 'أسطح الأرضيات والحيطان والأسقف',
                    'screens' => '"ناموسيات" النوافذ',
                    'drains' => 'بالوعات ومجاري الصرف الصحي',
                    'cleanliness' => 'الحالة العامة لأماكن تواجد مصائد الفئران والحشرات ونظافتها',
                    'insect_traps' => 'عمل مصائد الحشرات',
                    'rat_traps' => 'عمل مصائد الفئران',
                    'animals' => 'وجود الحيوانات الأليفة أو البرية'
                ] as $key => $label)
                <tr>
                    <td style="text-align: right; width: 60%; padding: 3px 10px;">{{ $label }}</td>
                    <td style="text-align: center;">{{ $c['preventive'][$key] ?? '' }}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="text-align: right; font-weight: bold; padding: 5px 10px;">خلاصة:</td>
                    <td style="padding: 10px; text-align: right;">{{ $c['preventive_summary'] ?? '' }}</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin: 10px 0 5px 0;">2. إجراءات المعالجة:</h4>
        <table>
            <thead>
                <tr style="background: #f2f2f2;">
                    <th>مكان التدخل</th>
                    <th>نوع التدخل</th>
                    <th>مسئول المعالجة</th>
                    <th>المادة الكيميائية المستخدمة</th>
                    <th>التركيز</th>
                    <th>وتيرة التطبيق</th>
                </tr>
            </thead>
            <tbody>
                @php $cur = $c['curative'] ?? []; $max_cur = max(count($cur), 8); @endphp
                @for($i=0; $i<$max_cur; $i++)
                <tr style="height: 25px;">
                    <td>{{ $cur[$i]['location'] ?? '' }}</td>
                    <td>{{ $cur[$i]['type'] ?? '' }}</td>
                    <td>{{ $cur[$i]['resp'] ?? '' }}</td>
                    <td>{{ $cur[$i]['product'] ?? '' }}</td>
                    <td>{{ $cur[$i]['conc'] ?? '' }}</td>
                    <td>{{ $cur[$i]['freq'] ?? '' }}</td>
                </tr>
                @endfor
            </tbody>
            <tfoot>
                 <tr>
                    <td colspan="1" style="text-align: right; font-weight: bold; border: none; padding-top: 10px;">خلاصة (نتائج المعالجة):</td>
                    <td colspan="5" style="padding: 10px; text-align: right; border: none; border-bottom: 1px dotted black;">{{ $c['curative_summary'] ?? '' }}</td>
                </tr>
            </tfoot>
        </table>
         <div style="margin-top: 30px; font-weight: bold; text-align: left;">تأشير مسئول النظافة: .................................</div>

    @elseif($document->type === 'cleaning')
        
        @php
            $sections = [
                'work_halls' => '1. قاعات العمل:',
                'packing_halls' => '2. قاعات التعبئة:',
                'admin_offices' => '3. قاعة العرض والمكاتب الإدارية:',
                'warehouses' => '4. المخازن:',
                'changing_rooms' => '5. الممرات وغرف تغيير الملابس:',
                'sanitary' => '6. المرافق الصحية والمغاسل:',
                'external' => '7. حالات أخرى (خارج المؤسسة وبعد الصيانة):',
            ];
        @endphp
        
        @foreach($sections as $key => $label)
             <h4 style="margin: 5px 0 2px 0; font-size: 12px; text-decoration: underline;">{{ $label }}</h4>
             <table style="margin-bottom: 5px;">
                <thead>
                    <tr style="background: #f2f2f2;">
                        <th width="10%">الساعة</th>
                        <th width="30%">العيب الملاحظ</th>
                        <th width="20%">المكان</th>
                        <th width="20%">المسئول</th>
                        <th width="20%">الإجراء المتخذ</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rows = $c[$key] ?? []; $max_r = max(count($rows), 3); @endphp
                    @for($i=0; $i<$max_r; $i++)
                    <tr style="height: 22px;">
                        <td>{{ $rows[$i]['time'] ?? '' }}</td>
                        <td>{{ $rows[$i]['defect'] ?? '' }}</td>
                         <td>{{ $rows[$i]['location'] ?? '' }}</td>
                        <td>{{ $rows[$i]['resp'] ?? '' }}</td>
                        <td>{{ $rows[$i]['action'] ?? '' }}</td>
                    </tr>
                    @endfor
                </tbody>
             </table>
        @endforeach
         <div style="margin-top: 15px; font-weight: bold; text-align: left;">تأشير مسئول الإنتاج: .................................</div>

    @elseif($document->type === 'batch')
        <table style="width: 100%;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th>تاريخ الاستلام</th>
                    <th>المصدر</th>
                    <th>المزود</th>
                    <th>المادة</th>
                    <th>ترميز رقم الدفعة (N)</th>
                </tr>
            </thead>
            <tbody>
                @php $items = $c['items'] ?? []; $max_i = max(count($items), 20); @endphp
                @for($i=0; $i<$max_i; $i++)
                <tr style="height: 25px;">
                    <td>{{ $items[$i]['date'] ?? '' }}</td>
                     <td>{{ $items[$i]['source'] ?? '' }}</td>
                    <td>{{ $items[$i]['supplier'] ?? '' }}</td>
                    <td>{{ $items[$i]['material'] ?? '' }}</td>
                    <td>{{ $items[$i]['batch_no'] ?? '' }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
         <div style="margin-top: 20px; font-weight: bold; text-align: left;">تأشير مسئول الإنتاج: .................................</div>

    @elseif($document->type === 'storage')
        <div style="text-align: right; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid black; padding-bottom: 5px;">المادة: <span style="font-weight: normal; margin-right: 20px;">{{ $c['material_name'] ?? '................................' }}</span></div>
        <table style="width: 100%;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th rowspan="2">التاريخ</th>
                    <th colspan="2">دخول المادة الأولية</th>
                    <th colspan="1">خروج المادة الأولية</th>
                    <th colspan="1">المخزون النهائي</th>
                </tr>
                <tr style="background: #f2f2f2;">
                     <th>رقم الدفعة</th>
                     <th>الكمية (كلغ)</th>
                     <th>الكمية (كلغ)</th>
                     <th>(كلغ)</th>
                </tr>
            </thead>
            <tbody>
                @php $moves = $c['movements'] ?? []; $max_m = max(count($moves), 25); @endphp
                @for($i=0; $i<$max_m; $i++)
                <tr style="height: 25px;">
                    <td>{{ $moves[$i]['date'] ?? '' }}</td>
                    <td>{{ $moves[$i]['in_batch'] ?? '' }}</td>
                    <td>{{ $moves[$i]['in_qty'] ?? '' }}</td>
                    <td>{{ $moves[$i]['out_qty'] ?? '' }}</td>
                    <td>{{ $moves[$i]['stock'] ?? '' }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
         <div style="margin-top: 20px; font-weight: bold; text-align: left;">تأشير مسئول الإنتاج: .................................</div>

    @endif

</body>
</html>
