<?php

namespace Tests\Feature\Job\ProcessCsv;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Jobs\ProcessCsv;
use App\Models\Student;
use Exception;

class HandleTest extends TestCase
{
    public function testSuccessOnValidResponse(): void
    {
        Student::query()->truncate();
        $this->artisan('csv:generate 1');
        ProcessCsv::dispatch();
        $this->assertDatabaseCount(Student::class, 1);
    }

    public function testSuccessOnFileNotFound(): void
    {
        Student::query()->truncate();
        unlink(public_path('files/download.csv'));
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Csv not found');
        $job = ProcessCsv::dispatchSync();
    }
}
