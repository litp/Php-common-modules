<?php
/**
 * Created by PhpStorm.
 * User: tianpeng
 * Date: 24/5/16
 * Time: 11:26 PM
 */
require '../../Autoloader.php';

class AutoloaderTest extends PHPUnit_Framwork_TestCase
{
    public function testLoadAuroraFrameworkClass()
    {
        $collection = new Collection();
        
        $this->assertInstanceOf('Collection', $collection);
    }
    
    public function testLoadSrcDirectoryClass()
    {
        $reg = new Registration();
        
        $this->assertInstanceOf('Registration', $reg);
    }
}