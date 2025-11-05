<?php

namespace Tests;

use App\Infrastucture\FileStorage\FileStorage;
use App\Publisher\EventDataPublisher;
use App\Publisher\PublisherEventHandler;
use PHPUnit\Framework\TestCase;

class PublisherEventHandlerTest extends TestCase
{
    private string $testFile;
    private string $testStatsFile;
    
    protected function setUp(): void
    {
        $this->testFile = sys_get_temp_dir() . '/test_events_' . uniqid() . '.txt';
        $this->testStatsFile = sys_get_temp_dir() . '/test_stats_' . uniqid() . '.txt';
    }
    
    protected function tearDown(): void
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
        if (file_exists($this->testStatsFile)) {
            unlink($this->testStatsFile);
        }
    }
    
    public function testHandleEvent(): void
    {
        $storage = $this->createMock(FileStorage::class);
        $eventDataPublisher = $this->createMock(EventDataPublisher::class);
        $handler = new PublisherEventHandler($eventDataPublisher, $storage);

        $eventData = [
            'type' => 'goal',
            'player' => 'John Doe',
            'minute' => 23,
            'second' => 34
        ];
        
        $result = $handler->handleEvent($eventData);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('goal', $result['event']['type']);
        $this->assertArrayHasKey('timestamp', $result['event']);
    }

    public function testEventIsSavedToFile(): void
    {
        $storage = new FileStorage($this->testFile);
        $eventDataPublisher = $this->createMock(EventDataPublisher::class);
        $handler = new PublisherEventHandler($eventDataPublisher, $storage);
        
        $eventData = [
            'type' => 'goal',
            'player' => 'Jane Smith'
        ];
        
        $handler->handleEvent($eventData);
        
        $this->assertFileExists($this->testFile);
        $savedEvents = $storage->getAll();
        $this->assertCount(1, $savedEvents);
        $this->assertEquals('goal', $savedEvents[0]['type']);
    }
}
