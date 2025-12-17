@php
    $sections = [
        'work_halls' => '1. قاعات العمل / Work Halls',
        'packing_halls' => '2. قاعات التعبئة / Packing Halls',
        'admin_offices' => '3. قاعة العرض والمكاتب الإدارية / Administration / Offices',
        'warehouses' => '4. المخازن / Warehouses',
        'changing_rooms' => '5. الممرات وغرف تغيير الملابس / Changing Rooms',
        'sanitary' => '6. المرافق الصحية والمغاسل / Sanitary Facilities',
        'external' => '7. حالات أخرى (خارج المؤسسة وبعد الصيانة) / External Areas',
    ];
@endphp

@foreach($sections as $key => $label)
<div class="onca-form-section" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: white; margin-bottom: 1.5rem;">
    <h3 class="onca-form-section-title">{{ $label }}</h3>
    <div style="overflow-x: auto;">
        <table class="onca-form-table" id="table-{{ $key }}" style="min-width: 600px;">
            <thead>
                <tr>
                    <th style="width: 6rem;">الساعة / Heure</th>
                    <th>العيب الملاحظ / Défaut Constaté</th>
                    <th style="width: 25%;">المكان / Emplacement</th>
                    <th style="width: 20%;">المسئول / Responsable</th>
                    <th style="width: 25%;">الإجراء المتخذ / Action Corrective</th>
                    <th style="width: 2.5rem;"></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($content[$key]) && is_array($content[$key]))
                    @foreach($content[$key] as $index => $row)
                        <tr>
                            <td><input type="time" name="content[{{ $key }}][{{ $index }}][time]" value="{{ $row['time'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[{{ $key }}][{{ $index }}][defect]" value="{{ $row['defect'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[{{ $key }}][{{ $index }}][location]" value="{{ $row['location'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[{{ $key }}][{{ $index }}][resp]" value="{{ $row['resp'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[{{ $key }}][{{ $index }}][action]" value="{{ $row['action'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div style="margin-top: 0.75rem;">
        <button type="button" onclick="addSameRow('{{ $key }}')" class="onca-btn-add" style="display: inline-flex; align-items: center; gap: 0.25rem;">
            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajouter une ligne
        </button>
    </div>
</div>

<template id="tpl-{{ $key }}">
    <tr>
        <td><input type="time" name="content[{{ $key }}][new_{index}][time]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[{{ $key }}][new_{index}][defect]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[{{ $key }}][new_{index}][location]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[{{ $key }}][new_{index}][resp]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[{{ $key }}][new_{index}][action]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
    </tr>
</template>
@endforeach

<script>
    function addSameRow(key) {
        const ms = Date.now();
        const rand = Math.floor(Math.random() * 1000);
        const uniqueId = ms + '_' + rand;
        
        const table = document.getElementById('table-' + key).querySelector('tbody');
        const template = document.getElementById('tpl-' + key).innerHTML;
        
        const tr = document.createElement('tr');
        tr.innerHTML = template.replace(/{index}/g, uniqueId);
        table.appendChild(tr);
    }
</script>
