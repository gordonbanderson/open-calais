<?php
namespace Suilven\OpenCalais\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\View\ArrayData;
use Suilven\OpenCalais\Model\Entity;
use Suilven\OpenCalais\Service\OpenCalaisContentParser;

class OpenCalaisDataObjectExtension extends Extension
{
    /**
     * @var array extension parameters, here a flag to indicate if open calais is dirty or not (ie needs parsed)
     */
    private static $db = [
        'OpenCalaisDirty' => 'Boolean'
    ];

    /**
     * @var array an object with entity has many entities
     */
    private static $many_many = [
        'Entities' => Entity::class,
    ];

    /**
     * @var array Nothing is parsed by default, set dirty flag to true
     */
    private static $defaults = [
        'OpenCalaisDirty' => 1
    ];

    /**
     * @throws \OpenCalais\Exception\OpenCalaisException
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function updateSemanticMarkup()
    {
        $content = $this->owner->Title . "\n\n" . $this->owner->Content;
        $parser = new OpenCalaisContentParser();
        $entities = $parser->getSemanticMarkup($content);

        // @todo Delete old entities

        // these are entities which are stored in the database already, these need to be 1 to many against from
        // DataObject to Entity
        $entitiesToAssociate = [];
        foreach($entities as $entity)
        {
            /** @var DataList $existingEntities */
            $existingEntities = Entity::get()->filter([
                'Name' => $entity->Name,
                'Value' => $entity->Value
            ]);

            /** @var Entity $entity */

            // should only be one
            if ($existingEntities->count() > 0) {
                $newEntity = $existingEntities->first();
                $entitiesToAssociate[] = $newEntity;
            } else {
                $entity->write();
                $entitiesToAssociate[] = $entity;
            }
        }

        $this->owner->Entities()->removeAll();
        $this->owner->Entities()->addMany($entitiesToAssociate);
    }

    /**
     * Mark this record as needing reparsed open calais wise
     */
    public function onBeforeWrite() {
        $this->owner->OpenCalaisDirty = 1;
        parent::onBeforeWrite();
    }

    /**
     * For rendering purposes, get the entities in a list of key => list of values, as opposed to key => value1,
     * key => value2 etc
     */
    public function getGroupedEntities()
    {
        $grouped = [];
        foreach ($this->owner->Entities() as $entity)
        {
            if (!isset($grouped[$entity->Name])) {
                $grouped[$entity->Name] = new ArrayList();
            }
            $ad = new ArrayData(['Value' => $entity->Value]);
            $grouped[$entity->Name]->push($ad);

            echo $entity->Name;
        }

        $groupedList = new ArrayList();
        foreach(array_keys($grouped) as $key) {
            $groupedList->push([
                'Name' => $key,
                'Entities' => $grouped[$key],
            ]);
        }

        return new ArrayData(['List' => $groupedList]);
    }

}
