<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OncaDocument;

class OncaController extends Controller
{
    public function index()
    {
        $documents = OncaDocument::orderBy('date', 'desc')->get();
        return view('onca.index', compact('documents'));
    }

    public function create()
    {
        return view('onca.create');
    }

    public function createForm($type)
    {
        // Define metadata for types to pass to view
        $meta = $this->getDocMeta($type);
        if (!$meta) abort(404);
        
        return view('onca.form', compact('type', 'meta'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required',
            'reference' => 'required',
            'title' => 'required',
            'version' => 'required',
            'date' => 'required|date',
            'responsible' => 'nullable',
            'content' => 'array',
        ]);

        // Clean and normalize content array - remove empty entries and normalize keys
        if (isset($data['content']) && is_array($data['content'])) {
            $data['content'] = $this->normalizeContent($data['content']);
        } else {
            $data['content'] = [];
        }

        OncaDocument::create($data);

        return redirect()->route('onca.index')->with('success', 'Document créé avec succès.');
    }

    public function show(OncaDocument $onca)
    {
        return view('onca.show', ['document' => $onca]);
    }

    public function edit(OncaDocument $onca)
    {
         $type = $onca->type;
         $meta = $this->getDocMeta($type);
         return view('onca.form', ['document' => $onca, 'type' => $type, 'meta' => $meta]);
    }

    public function update(Request $request, OncaDocument $onca)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'responsible' => 'nullable',
            'content' => 'array',
        ]);

        // Clean and normalize content array - remove empty entries and normalize keys
        if (isset($data['content']) && is_array($data['content'])) {
            $data['content'] = $this->normalizeContent($data['content']);
        } else {
            $data['content'] = [];
        }

        $onca->update($data);

        return redirect()->route('onca.index')->with('success', 'Document mis à jour avec succès.');
    }

    public function destroy(OncaDocument $onca)
    {
        $onca->delete();
        return redirect()->route('onca.index')->with('success', 'Document supprimé.');
    }

    public function print(OncaDocument $onca)
    {
        return view('onca.print', ['document' => $onca]);
    }

    private function normalizeContent($content)
    {
        if (!is_array($content)) {
            return [];
        }

        $normalized = [];

        foreach ($content as $key => $value) {
            if (is_array($value)) {
                // Check if this is a table structure (array of arrays) or key-value pairs
                $isTableStructure = false;
                $tableRows = [];
                $keyValuePairs = [];
                
                foreach ($value as $subKey => $subValue) {
                    if (is_array($subValue)) {
                        // This is a table row (like health[0][time], health[new_123][name], etc.)
                        $isTableStructure = true;
                        
                        // Check if this row has any non-empty values
                        $hasData = false;
                        $rowData = [];
                        
                        foreach ($subValue as $field => $fieldValue) {
                            // Keep all fields, even if empty (for proper table structure)
                            $rowData[$field] = $fieldValue ?? '';
                            if (!empty($fieldValue) && trim($fieldValue) !== '') {
                                $hasData = true;
                            }
                        }
                        
                        // Only include rows that have at least one non-empty field
                        if ($hasData) {
                            $tableRows[] = $rowData;
                        }
                    } else {
                        // Direct key-value pairs (like preventive[door_window])
                        $keyValuePairs[$subKey] = $subValue ?? '';
                    }
                }
                
                // Set the normalized value based on structure type
                if ($isTableStructure) {
                    // For table structures, use numeric array of rows
                    $normalized[$key] = $tableRows;
                } else {
                    // For key-value pairs, preserve the structure
                    $normalized[$key] = $keyValuePairs;
                }
            } else {
                // Simple key-value pairs (like material_name at root level)
                $normalized[$key] = $value ?? '';
            }
        }

        return $normalized;
    }

    private function getDocMeta($type) {
        $types = [
            'health' => [
                'title' => 'مراقبة صحة ونظافة العاملين', 
                'title_en' => 'SURVEILLANCE DE L\'HYGIENE ET DE LA SANTE DU PERSONNEL',
                'ref' => 'PR-S-EN1', 
                'ver' => '01'
            ],
            'pest' => [
                'title' => 'التحقق من عمليات مكافحة الكائنات الضارة', 
                'title_en' => 'CONTROLE DE LA LUTTE CONTRE LES NUISIBLES',
                'ref' => 'PR-V-EN1', 
                'ver' => '01'
            ],
            'cleaning' => [
                'title' => 'مراقبة التنظيف والتطهير', 
                'title_en' => 'SURVEILLANCE DU NETTOYAGE ET DE LA DESINFECTION',
                'ref' => 'PR-N-EN1', 
                'ver' => '01'
            ],
            'batch' => [
                'title' => 'ترميز المواد الأولية', 
                'title_en' => 'LISTE DE CODIFICATION DES LOTS',
                'ref' => 'PR-T-EN2', 
                'ver' => '01'
            ],
            'storage' => [
                'title' => 'سجل تخزين المواد الأولية', 
                'title_en' => 'FICHE DE STOCK (MATIERES PREMIERES)',
                'ref' => 'PR-T-EN4', 
                'ver' => '01'
            ],
        ];
        return $types[$type] ?? null;
    }
}

