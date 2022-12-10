<?php

namespace Tests\Unit\Console\Commands\GenrateCsv;

use App\Jobs\ProcessCsv;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

/**
 * @covers \App\Console\Commands\GenrateCsv::handle
 */
class HandleTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \Symfony\Component\Console\Exception\RuntimeException
     */
    public function testSuccessOnNoArguments()
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
        /** @var \Illuminate\Testing\PendingCommand */
        $command = $this->artisan('csv:generate');
        $command->assertExitCode(1)
        ->expectsOutput('Num of rows need to specify rows.')
        ->excute();
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSuccessOnRunCommand(): void
    {
        /** @var \Illuminate\Testing\PendingCommand */
        $command = $this->artisan('csv:generate 1');
        $command->assertExitCode(0)
        ->expectsOutput('Command Run Successfully.')
        ->execute();
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSuccessOnUnValidArgument(): void
    {
        /** @var \Illuminate\Testing\PendingCommand */
        $command = $this->artisan('csv:generate a');
        $command->assertExitCode(1)
            ->expectsOutput('Num of rows should only integer.')
            ->execute();
    }
}
