<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Services\DocumentService;
use Livewire\Component;

class DocumentIndex extends Component
{
    public $search = '';

    public function render()
    {
        $query = Document::query()
            ->join("document_metadata_type", "documents.id", "=", "document_metadata_type.document_id")
            ->where("document_metadata_type.metadata_type_id", 1);

        if ($this->search) {
            $query->where('document_metadata_type.value', 'like', '%' . $this->search . '%');
        }

        $query->select("documents.*");

        $documents = $query->paginate(25);

        return view('livewire.document-index', [
                'documents' => $documents
            ]
        )->extends('layouts.autenticado')->section('main-content');
    }

    public function deleteDocument(Document $document)
    {
        DocumentService::can($document, "delete");

        $document->delete();
    }
}
