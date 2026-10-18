<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\HasRepository;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\DocumentGenerator\Letters\Models\Letter;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use Nip\Records\AbstractModels\RecordManager;

/**
 *
 */
class ImportFieldsFrom extends Action
{
    use HasSubject;
    use HasRepository;

    /**
     * @param Letter $from
     * @return void
     */
    public function from($from)
    {
        $subject = $this->getSubject();

        $fields = $from->getLetterFields();
        $count = 0;
        foreach ($fields as $field) {
            $field->duplicate(['id_letter' => $subject->id]);
            $count++;
        }
        return $count;
    }


    protected function generateRepository(): RecordManager
    {
        return DocumentGeneratorModels::letters();
    }
}
