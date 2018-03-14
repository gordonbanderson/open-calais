<?php
namespace Tests\Suilven\OpenCalais\Service;

$autoloader = require 'vendor/autoload.php';

error_log(print_r($autoloader, 1));

use Suilven\OpenCalais\Service\OpenCalaisContentParser;
use Tests\Suilven\OpenCalais\TestWithTextLoader;

class OpenCalaisContentParserTest extends TestWithTextLoader {
    /** @var OpenCalaisContentParser */
    private $parser;

    public function setUp()
    {
        $this->parser = new OpenCalaisContentParser();
    }

    public function tearDown()
    {
        $this->parser = null;
    }

	public function test_get_semantic_markup_raw() {
	    $content = $this->loadText('holmes.txt');
		$raw = $this->parser->getSemanticMarkupRaw($content);
		error_log($raw);
	}

	public function testGetSemanticMarkup() {
		$this->markTestSkipped('TODO');
	}

}

