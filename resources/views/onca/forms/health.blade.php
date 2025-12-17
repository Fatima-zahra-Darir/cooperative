@php
    $sections = [
        'health' => '1. صحة العمال / Health Status',
        'behavior' => '2. سلوك العمال / Worker Behavior',
        'hands' => '3. الغسل الصحي لليدين / Hand Washing',
        'clothes' => '4. لباس الشغل / Work Clothes'
    ];
@endphp

@foreach($sections as $key => $label)
<div class="onca-form-section" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: white; margin-bottom: 1.5rem;">
    <h3 class="onca-form-section-title">{{ $label }}</h3>
    <div style="overflow-x: auto;">
        <table class="onca-form-table" id="table-{{ $key }}">
            <thead>
                <tr>
                    <th style="width: 6rem;">الساعة / Heure</th>
                    <th style="width: 25%;">اسم العامل / Nom</th>
                    <th>{{ $key === 'health' ? 'وصف الحالة / Description' : ($key === 'behavior' ? 'السلوك غير مقبول / Behavior' : 'العيب الملاحظ / Observation') }}</th>
                    <th style="width: 25%;">الإجراء المتخذ / Action</th>
                    <th style="width: 2.5rem;"></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($content[$key]) && is_array($content[$key]))
                    @foreach($content[$key] as $index => $row)
                        <tr>
                            <td>
                                <input type="time" name="content[{{ $key }}][{{ $index }}][time]" value="{{ $row['time'] ?? '' }}" class="onca-form-table input" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;">
                            </td>
                            <td>
                                <input type="text" name="content[{{ $key }}][{{ $index }}][name]" value="{{ $row['name'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;" placeholder="Nom">
                            </td>
                            <td>
                                <input type="text" name="content[{{ $key }}][{{ $index }}][desc]" value="{{ $row['desc'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;" placeholder="Observation">
                            </td>
                            <td>
                                <input type="text" name="content[{{ $key }}][{{ $index }}][action]" value="{{ $row['action'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;" placeholder="Action">
                            </td>
                            <td style="text-align: center;">
                                <button type="button" onclick="removeRow(this)" class="onca-btn-remove">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
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
        <td>
            <input type="time" name="content[{{ $key }}][new_{index}][time]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;">
        </td>
        <td>
            <input type="text" name="content[{{ $key }}][new_{index}][name]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;" placeholder="Nom">
        </td>
        <td>
            <input type="text" name="content[{{ $key }}][new_{index}][desc]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;" placeholder="Observation">
        </td>
        <td>
            <input type="text" name="content[{{ $key }}][new_{index}][action]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;" placeholder="Action">
        </td>
        <td style="text-align: center;">
            <button type="button" onclick="removeRow(this)" class="onca-btn-remove">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </td>
    </tr>
</template>
@endforeach

<script>
    // Specific helper bound to this form's templates
    function addSameRow(key) {
        // Generate a random ID for 'new_{index}' to ensure uniqueness if multiple added
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
