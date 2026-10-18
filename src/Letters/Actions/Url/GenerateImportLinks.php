<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Actions\Url;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\HasRepository;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use Nip\Records\AbstractModels\RecordManager;

/**
 *
 */
class GenerateImportLinks extends Action
{
    use HasSubject;

    protected $siblings = [];
    protected $manager;

    public function forItems($subject, $items)
    {
        $action = static::for($subject);
        $action->setSiblings($items);

        return $action;
    }


    protected function handle()
    {
        $return = [];
        foreach ($this->siblings as $item) {
            $return[] = $this->generateLink($item);
        }
        return $return;
    }

    /**
     * @param $item
     * @return array
     */
    protected function generateLink($item)
    {
        $manager = $this->getRepository();
        return [
            'name' => $item->getName(),
            'label' => $item->getName(),
            'href' => $this->getSubject()->compileURL('importFrom', [
                'from' => $item->getManager()->getController(),
                'from_id' => $item->id,
            ])
        ];
    }

    /**
     * @return mixed
     */
    public function getSiblings()
    {
        return $this->siblings;
    }

    /**
     * @param mixed $siblings
     */
    public function setSiblings($siblings): void
    {
        $this->siblings = $siblings;
    }
}