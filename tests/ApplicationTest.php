<?php

namespace Tests;

use App\Backend\Config;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testComposerAutoloadConstants()
    {
        $this->assertTrue(defined('HOST'));
        $this->assertTrue(defined('BASE_URL'));
    }

    public function testComposerAutoloadBootstrap()
    {
        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
        $this->assertEquals('Europe/Moscow', date_default_timezone_get());
    }

    public function testComposerAutoloadConfig()
    {
        $settings = \App\Safely\getSettings();

        $this->assertTrue(is_array($settings));
        $this->assertArrayHasKey('version', $settings);
        $this->assertNotEmpty($settings['version']);
        $this->assertTrue(is_string($settings['version']));
        $this->assertEquals('1.0.0', $settings['version']);

        $this->assertArrayHasKey('db_host', $settings);
        $this->assertArrayHasKey('db_name', $settings);
        $this->assertArrayHasKey('db_user', $settings);
        $this->assertArrayHasKey('db_pass', $settings);

        $this->assertNotEmpty($settings['db_host']);
        $this->assertNotEmpty($settings['db_name']);
        $this->assertNotEmpty($settings['db_user']);
        $this->assertNotEmpty($settings['db_pass']);

        $config = new Config();

        $this->assertEquals($settings['version'], $config->getVersion());
        $this->assertEquals($settings['db_host'], $config->geDbHost());
        $this->assertEquals($settings['db_name'], $config->geDbName());
        $this->assertEquals($settings['db_user'], $config->geDbUser());
        $this->assertEquals($settings['db_pass'], $config->geDbPass());
    }
}