<?php
namespace Suilven\OpenCalais\Model;

use SilverStripe\ORM\DataObject;

class Entity extends DataObject
{
    const ALL_ENTITIES  = [
        'Anniversary',
        'City',
        'Company',
        'Continent',
        'Country',
        'Currency',
        'EmailAddress',
        'EntertainmentAwardEvent',
        'Facility',
        'FaxNumber',
        'Holiday',
        'IndustryTerm',
        'MarketIndex',
        'MedicalCondition',
        'MedicalTreatment',
        'Movie',
        'MusicAlbum',
        'MusicGroup',
        'NaturalDisaster',
        'NaturalFeature',
        'OperatingSystem',
        'Organization',
        'Person',
        'PhoneNumber',
        'PoliticalEvent',
        'Position',
        'Product',
        'ProgrammingLanguage',
        'ProvinceOrState',
        'PublishedMedium',
        'RadioProgram',
        'RadioStation',
        'Region',
        'SportsEvent',
        'SportsGame',
        'SportsLeague',
        'Technology',
        'TVShow',
        'TVStation',
        'URL',
        'NaturalDisaster',
        'PoliticalEvent',
    ];

    private static $db = [
        'Name' => 'Enum(array("Anniversary","City","Company","Continent","Country","Currency","EmailAddress",'
            . '"EntertainmentAwardEvent","Facility","FaxNumber","Holiday","IndustryTerm","MarketIndex",'
            . '"MedicalCondition","MedicalTreatment","Movie","MusicAlbum","MusicGroup","NaturalDisaster",'
            . '"NaturalFeature","OperatingSystem","Organization","Person","PhoneNumber","PoliticalEvent","Position",'
            . '"Product","ProgrammingLanguage","ProvinceOrState","PublishedMedium","RadioProgram","RadioStation",'
            . '"Region","SportsEvent","SportsGame","SportsLeague","Technology","TVShow","TVStation","URL",'
            . '"NaturalDisaster","PoliticalEvent"))',
        'Value' => 'Varchar(255)'
    ];

    /**
     * @var array An entity can have many dataobjects
     */
    private static $belongs_many_many = [
        'DataObjects' => DataObject::class,
    ];

    private static $table_name = 'Entity';

}
