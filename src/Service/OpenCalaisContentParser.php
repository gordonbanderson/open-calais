<?php
namespace Suilven\OpenCalais\Service;

use Html2Text\Html2Text;
use OpenCalais\OpenCalais;
use SilverStripe\Core\Config\Config;
use Suilven\OpenCalais\Model\Entity;

class OpenCalaisContentParser
{
    /**
     * Parse text to obtain entities about it
     *
     * @param $content the text content to be parsed
     * @return array an associative array of entities related to the document in question
     * @throws \OpenCalais\Exception\OpenCalaisException
     */
    public function getSemanticMarkupRaw($content)
    {
        $apiKey = Config::inst()->get('Suilven\OpenCalais\Service\OpenCalaisContentParser', 'api_key');
        $openCalaisClient = new OpenCalais($apiKey);
        #$openCalaisClient = new OpenCalais('6OLVc2vTZ6yhDWk4M7FoTAV28gkZ0HAT');
        $stripper = new Html2Text($content);
        $noHtmlContent = $stripper->getText();
        $entities = $openCalaisClient->getEntities($noHtmlContent);
        return $entities;
    }

    /**
     * Return social tags and entities as objects, do not save these though
     *
     * @param $content Freetext content
     * @return array Array of entities and social tags
     * @throws \OpenCalais\Exception\OpenCalaisException
     */
    public function getSemanticMarkup($content)
    {
        $rawSemanticMarkup = $this->getSemanticMarkupRaw($content);
        $result = [];
        // @todo, social tags
        error_log('RSM: ' . print_r($rawSemanticMarkup['entities'], 1));
        foreach ($rawSemanticMarkup['entities'] as $entityKey => $entityGroupings) {
            error_log('-----');
            error_log(print_r($entityGroupings, 1));
            foreach ($entityGroupings as $rawEntityValue) {
                error_log('KEY: ' . $entityKey);
                error_log('RAW: ' . print_r($rawEntityValue, 1));
                $entity = new Entity();
                $entity->Name = $entityKey;
                $entity->Value = $rawEntityValue;
                $result[] = $entity;
            }
        }
        return $result;
    }
}
