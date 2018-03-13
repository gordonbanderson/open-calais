<?php
namespace Suilven\OpenCalais\Task;

use SilverStripe\Control\Director;
use Suilven\OpenCalais\Service\OpenCalaisContentParser;

class OpenCalaisParseTask extends \SilverStripe\Dev\BuildTask
{
    protected $title = 'Open Calais Parser for DataObjects';
    protected $description = 'Parse a page for entity or entities using OpenCalais';
    protected $enabled = true;

    private static $segment = 'OpenCalais_Parse';


    public function run($request) {
        #Session::set("loggedInAs",1);
        echo 'Running task';
        $canAccess = ( Director::isDev() || Director::is_cli() || Permission::check( "ADMIN" ) );
        if ( !$canAccess ) {
            return Security::permissionFailure( $this );
        }

        $page_id = $_GET['page'];
        $page = \Page::get_by_id('Page', $page_id);
        echo $page->Content;

        $parser = new OpenCalaisContentParser();
       # $entities = $parser->getSemanticMarkupRaw($page->Content);
      #  echo print_r($entities, 1);

        echo 'Saving';
        $page = \Page::get_by_id('\Page', $page_id);
        $page->updateSemanticMarkup();
    }
}
