<?php
namespace Tests\Suilven\OpenCalais;

use SilverStripe\Dev\SapphireTest;

class TestWithTextLoader extends SapphireTest {
	public function loadText($filename)
    {
        return file_get_contents(__FILE__ . '/../data/' . $filename, FILE_USE_INCLUDE_PATH);
    }

}
