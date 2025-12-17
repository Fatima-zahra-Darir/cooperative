<div style="margin-bottom: 1.5rem;">
    <!-- Section 1: Preventive Measures -->
    <div class="onca-form-section" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: white; margin-bottom: 1.5rem;">
        <h3 class="onca-form-section-title">1. نتائج عمليات الوقاية / Preventive Results</h3>
        
        @php
            $checklist = [
                'door_window' => 'مدى عدم قابلية الأبواب والنوافذ لتسريب الكائنات الضارة',
                'surfaces' => 'أسطح الأرضيات والحيطان والأسقف',
                'screens' => '"ناموسيات" النوافذ',
                'drains' => 'بالوعات ومجاري الصرف الصحي',
                'cleanliness' => 'الحالة العامة لأماكن تواجد مصائد الفئران والحشرات ونظافتها',
                'insect_traps' => 'عمل مصائد الحشرات',
                'rat_traps' => 'عمل مصائد الفئران',
                'animals' => 'وجود الحيوانات الأليفة أو البرية',
            ];
        @endphp

        <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
            @foreach($checklist as $key => $label)
            <div style="display: flex; flex-direction: column; gap: 1rem; padding: 0.75rem; background: #f9fafb; border-radius: 0.25rem; border: 1px solid #f3f4f6;">
                <label class="onca-form-label" style="width: 100%;">{{ $label }}</label>
                <div style="width: 100%;">
                    <input type="text" 
                        name="content[preventive][{{ $key }}]" 
                        value="{{ $content['preventive'][$key] ?? '' }}" 
                        placeholder="Observation..."
                        class="onca-form-input">
                </div>
            </div>
            @endforeach
        </div>
        
        <div style="margin-top: 1rem;">
            <label class="onca-form-label">خلاصة / Summary</label>
            <textarea name="content[preventive_summary]" rows="2" class="onca-form-textarea">{{ $content['preventive_summary'] ?? '' }}</textarea>
        </div>
    </div>

    <!-- Section 2: Curative Measures -->
    <div class="onca-form-section" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: white; margin-bottom: 1.5rem;">
        <h3 class="onca-form-section-title">2. إجراءات المعالجة / Curative Measures</h3>
        <div style="overflow-x: auto;">
            <table class="onca-form-table" id="table-curative" style="min-width: 800px;">
                <thead>
                    <tr>
                        <th>مكان التدخل / Lieu</th>
                        <th>نوع التدخل / Type</th>
                        <th>مسئول المعالجة / Responsable</th>
                        <th>المادة الكيميائية المستخدمة / Produit</th>
                        <th style="width: 5rem;">التركيز / Conc.</th>
                        <th>وتيرة التطبيق / Fréquence</th>
                        <th style="width: 2.5rem;"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($content['curative']) && is_array($content['curative']))
                        @foreach($content['curative'] as $index => $row)
                            <tr>
                                <td><input type="text" name="content[curative][{{ $index }}][location]" value="{{ $row['location'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td><input type="text" name="content[curative][{{ $index }}][type]" value="{{ $row['type'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td><input type="text" name="content[curative][{{ $index }}][resp]" value="{{ $row['resp'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td><input type="text" name="content[curative][{{ $index }}][product]" value="{{ $row['product'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td><input type="text" name="content[curative][{{ $index }}][conc]" value="{{ $row['conc'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td><input type="text" name="content[curative][{{ $index }}][freq]" value="{{ $row['freq'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div style="margin-top: 0.75rem;">
             <button type="button" onclick="addPestRow()" class="onca-btn-add" style="display: inline-flex; align-items: center; gap: 0.25rem;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajouter une ligne
            </button>
        </div>
        
        <div style="margin-top: 1rem;">
            <label class="onca-form-label">خلاصة (نتائج المعالجة) / Treatment Summary</label>
            <textarea name="content[curative_summary]" rows="2" class="onca-form-textarea">{{ $content['curative_summary'] ?? '' }}</textarea>
        </div>
    </div>
</div>

<template id="tpl-curative">
    <tr>
        <td><input type="text" name="content[curative][new_{index}][location]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[curative][new_{index}][type]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[curative][new_{index}][resp]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[curative][new_{index}][product]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[curative][new_{index}][conc]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[curative][new_{index}][freq]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
    </tr>
</template>

<script>
    function addPestRow() {
        const uniqueId = Date.now();
        const table = document.getElementById('table-curative').querySelector('tbody');
        const template = document.getElementById('tpl-curative').innerHTML;
        const tr = document.createElement('tr');
        tr.innerHTML = template.replace(/{index}/g, uniqueId);
        table.appendChild(tr);
    }
</script>
