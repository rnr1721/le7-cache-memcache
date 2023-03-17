<?php

use Psr\SimpleCache\CacheInterface;
use Core\Cache\SCFactoryMemcache;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class CacheTest extends PHPUnit\Framework\TestCase
{

    private SCFactoryMemcache $factory;

    protected function setUp(): void
    {
        $this->factory = new SCFactoryMemcache();
    }

    public function testMemcache()
    {
        $cache = $this->factory->getMemcache();
        $this->process($cache);
    }

    public function testMemcached()
    {
        $cache = $this->factory->getMemcached();
        $this->process($cache);
    }
    
    public function process(CacheInterface $cache)
    {
        $cache->clear();

        // Try to get empty
        $testEmpty = $cache->get('not_exists');
        $this->assertNull($testEmpty);

        $testEmptyDefault = $cache->get('not_exists', '');
        $this->assertEquals($testEmptyDefault, '');

        // Set to cache
        $cache->set('test_item', '12345');
        $this->assertEquals($cache->get('test_item'), '12345');
        $cache->delete('test_item');
        $this->assertNull($cache->get('test_item'));

        $cache->set('test_item', '1234567', 2);
        $this->assertEquals($cache->get('test_item'), '1234567');
        sleep(2);
        $this->assertNull($cache->get('test_item'));

        //setMultiple
        $data = [
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => '1111'
        ];

        $cache->setMultiple($data);

        $this->assertEquals($cache->get('one'), 1);
        $this->assertEquals($cache->get('two'), 2);
        $this->assertEquals($cache->get('three'), 3);
        $this->assertEquals($cache->get('four'), '1111');

        $titles = ['one', 'two', 'three', 'four'];

        $multiple = $cache->getMultiple($titles);

        $this->assertEquals($multiple['one'], 1);
        $this->assertEquals($multiple['two'], 2);

        $cache->deleteMultiple($titles);

        $this->assertNull($cache->get('one'));
        $this->assertNull($cache->get('two'));
        $this->assertNull($cache->get('three'));
        $this->assertNull($cache->get('four'));

        $cache->setMultiple($data);

        $deleteSomething = ['one', 'two'];
        $cache->deleteMultiple($deleteSomething);

        $this->assertNull($cache->get('one'));
        $this->assertNull($cache->get('two'));
        $this->assertEquals($cache->get('three'), 3);
        $this->assertEquals($cache->get('four'), '1111');

        // Clear all cache items
        $cache->clear();
        $this->assertNull($cache->get('one'));
        $this->assertNull($cache->get('two'));
        $this->assertNull($cache->get('three'));
        $this->assertNull($cache->get('four'));
    }

}
