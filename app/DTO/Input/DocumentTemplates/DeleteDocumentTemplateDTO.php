<?php

namespace App\DTO\Input\DocumentTemplates;

use App\Models\DocumentTemplate;

/**
 * Class DeleteDocumentTemplateDTO
 * @package App\DTO\Input\DocumentTemplates
 */
class DeleteDocumentTemplateDTO extends \App\DTO\BaseInputDTO
{
    /**
     * Document template instance
     * @var DocumentTemplate
     */
    private DocumentTemplate $document_template;

    /**
     * DeleteDocumentTemplateDTO constructor
     * @param DocumentTemplate $document_template
     */
    public function __construct(DocumentTemplate $document_template)
    {
        $this->document_template = $document_template;
    }

    /**
     * Get document template instance
     *
     * @return DocumentTemplate
     */
    public function getDocumentTemplate(): DocumentTemplate
    {
        return $this->document_template;
    }
}
