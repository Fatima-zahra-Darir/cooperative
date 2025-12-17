<div class="onca-form-section" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: white; margin-bottom: 1.5rem;">
    <h3 class="onca-form-section-title">Liste des Matières Premières / Raw Materials List</h3>
    <div style="overflow-x: auto;">
        <table class="onca-form-table" id="table-batch" style="min-width: 600px;">
            <thead>
                <tr>
                    <th style="width: 8rem;">تاريخ الاستلام / Date</th>
                    <th>المصدر / Source</th>
                    <th>المزود / Fournisseur</th>
                    <th>المادة / Matière</th>
                    <th style="width: 8rem;">(N) ترميز رقم الدفعة / Lot (N)</th>
                    <th style="width: 2.5rem;"></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($content['items']) && is_array($content['items']))
                    @foreach($content['items'] as $index => $row)
                        <tr>
                            <td><input type="date" name="content[items][{{ $index }}][date]" value="{{ $row['date'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[items][{{ $index }}][source]" value="{{ $row['source'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[items][{{ $index }}][supplier]" value="{{ $row['supplier'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[items][{{ $index }}][material]" value="{{ $row['material'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td><input type="text" name="content[items][{{ $index }}][batch_no]" value="{{ $row['batch_no'] ?? '' }}" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
                            <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div style="margin-top: 0.75rem;">
        <button type="button" onclick="addBatchRow()" class="onca-btn-add" style="display: inline-flex; align-items: center; gap: 0.25rem;">
            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajouter une ligne
        </button>
    </div>
</div>

<template id="tpl-batch">
    <tr>
        <td><input type="date" name="content[items][new_{index}][date]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[items][new_{index}][source]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[items][new_{index}][supplier]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[items][new_{index}][material]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td><input type="text" name="content[items][new_{index}][batch_no]" style="width: 100%; padding: 0.375rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;"></td>
        <td style="text-align: center;"><button type="button" onclick="removeRow(this)" class="onca-btn-remove">&times;</button></td>
    </tr>
</template>

<script>
    function addBatchRow() {
        const uniqueId = Date.now();
        const table = document.getElementById('table-batch').querySelector('tbody');
        const template = document.getElementById('tpl-batch').innerHTML;
        const tr = document.createElement('tr');
        tr.innerHTML = template.replace(/{index}/g, uniqueId);
        table.appendChild(tr);
    }
</script>
