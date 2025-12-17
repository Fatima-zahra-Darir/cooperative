<div style="margin-bottom: 1.5rem;">
    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; margin-bottom: 1.5rem;">
        <label class="onca-form-label">المادة / Matière</label>
        <input type="text" name="content[material_name]" value="{{ $content['material_name'] ?? '' }}" class="onca-form-input" style="max-width: 50%;">
    </div>

    <div class="onca-form-section" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: white; margin-bottom: 1.5rem;">
        <h3 class="onca-form-section-title">مجمو عات المواد الأولية / Stock Movements</h3>
        <div style="overflow-x: auto;">
            <table class="onca-form-table" id="table-storage" style="min-width: 600px;">
                <thead>
                    <tr>
                        <th rowspan="2" style="border-right: 1px solid #e5e7eb; vertical-align: bottom; padding-bottom: 0.5rem;">التاريخ / Date</th>
                        <th colspan="2" style="text-align: center; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">دخول المادة الأولية / Entrée</th>
                        <th colspan="1" style="text-align: center; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">خروج المادة الأولية / Sortie</th>
                        <th colspan="1" style="text-align: center; border-bottom: 1px solid #e5e7eb;">المخزون النهائي / Stock</th>
                        <th rowspan="2" style="width: 2.5rem; vertical-align: bottom;"></th>
                    </tr>
                    <tr>
                        <th style="text-align: left; border-right: 1px solid #e5e7eb; font-size: 0.625rem;">رقم الدفعة / Lot Nº</th>
                        <th style="text-align: left; border-right: 1px solid #e5e7eb; font-size: 0.625rem;">الكمية (كلغ) / Qte (kg)</th>
                        <th style="text-align: left; border-right: 1px solid #e5e7eb; font-size: 0.625rem;">الكمية (كلغ) / Qte (kg)</th>
                        <th style="text-align: left; font-size: 0.625rem;">الكمية (كلغ) / Qte (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($content['movements']) && is_array($content['movements']))
                        @foreach($content['movements'] as $index => $row)
                            <tr>
                                <td style="border-right: 1px solid #e5e7eb;"><input type="date" name="content[movements][{{ $index }}][date]" value="{{ $row['date'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td style="border-right: 1px solid #e5e7eb;"><input type="text" name="content[movements][{{ $index }}][in_batch]" value="{{ $row['in_batch'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td style="border-right: 1px solid #e5e7eb;"><input type="number" step="0.01" name="content[movements][{{ $index }}][in_qty]" value="{{ $row['in_qty'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td style="border-right: 1px solid #e5e7eb;"><input type="number" step="0.01" name="content[movements][{{ $index }}][out_qty]" value="{{ $row['out_qty'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td><input type="number" step="0.01" name="content[movements][{{ $index }}][stock]" value="{{ $row['stock'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                                <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div style="margin-top: 0.75rem;">
            <button type="button" onclick="addStorageRow()" class="onca-btn-add" style="display: inline-flex; align-items: center; gap: 0.25rem;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajouter une ligne
            </button>
        </div>
    </div>
</div>

<template id="tpl-storage">
    <tr>
        <td style="border-right: 1px solid #e5e7eb;"><input type="date" name="content[movements][new_{index}][date]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="border-right: 1px solid #e5e7eb;"><input type="text" name="content[movements][new_{index}][in_batch]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="border-right: 1px solid #e5e7eb;"><input type="number" step="0.01" name="content[movements][new_{index}][in_qty]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="border-right: 1px solid #e5e7eb;"><input type="number" step="0.01" name="content[movements][new_{index}][out_qty]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="number" step="0.01" name="content[movements][new_{index}][stock]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
    </tr>
</template>

<script>
    function addStorageRow() {
        const uniqueId = Date.now();
        const table = document.getElementById('table-storage').querySelector('tbody');
        const template = document.getElementById('tpl-storage').innerHTML;
        const tr = document.createElement('tr');
        tr.innerHTML = template.replace(/{index}/g, uniqueId);
        table.appendChild(tr);
    }
</script>
