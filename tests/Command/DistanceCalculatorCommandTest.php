<?php 
namespace App\Tests\Command;

use App\DTO\Location;
use App\DTO\LocationCollection;
use App\Command\DistanceCalculatorCommand;
use App\Service\Location\LocationProvider;
use App\Service\Location\LocationProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test DistanceCalculatorCommand class
 */
final class DistanceCalculatorCommandTest extends KernelTestCase
{
    /**
     * Tests, command 'distance:calculator'
     *
     * @dataProvider locationProvider
     */
    public function testDistanceCalculatorCommand(Location $headquarter, LocationCollection $locationCollection): void
    {
        $locationProviderMock = $this->createMock(LocationProvider::class);
        $locationProviderMock->expects($this->once())
            ->method('getLocationsInFile')
            ->willReturn([$headquarter, $locationCollection]);
        $locationProcessorMock = $this->createMock(LocationProcessor::class);
        $locationProcessorMock->expects($this->once())
            ->method('processsLocations')
            ->with($headquarter, $locationCollection)
            ->willReturn($locationCollection);
        
        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add(new DistanceCalculatorCommand($locationProviderMock, $locationProcessorMock));
        $command = $application->find('distance:calculator');
        $commandTester = new CommandTester($command);
        $result = $commandTester->execute(['command'  => $command->getName()]);
        $this->assertEquals(Command::SUCCESS, $result);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('HeadQuarter Distances', $output);
        $this->assertStringContainsString('Sortnumber   Distance      Name            Address', $output);
        $this->assertStringContainsString('1            764.984 km    test name       test address', $output);
        $this->assertStringContainsString('2            948.4949 km   test name two   test address two', $output);
    }

    /**
     * Tests, command 'distance:calculator'
     *
     * @dataProvider locationProvider
     */
    public function testCommandForEmptyLocations(Location $headquarter, LocationCollection $locationCollection): void
    {
        $locationProviderMock = $this->createMock(LocationProvider::class);
        $locationProviderMock->expects($this->once())
            ->method('getLocationsInFile')
            ->willReturn([$headquarter, $locationCollection]);
        $locationProcessorMock = $this->createMock(LocationProcessor::class);
        $locationProcessorMock->expects($this->once())
            ->method('processsLocations')
            ->with($headquarter, $locationCollection)
            ->willReturn(new LocationCollection());

        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add(new DistanceCalculatorCommand($locationProviderMock, $locationProcessorMock));
        $command = $application->find('distance:calculator');
        $commandTester = new CommandTester($command);
        $result = $commandTester->execute(['command'  => $command->getName()]);
        $this->assertEquals(Command::FAILURE, $result);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function locationProvider() : array
    {
        $headquarter = new Location();
        $headquarter->setName('test name headquarter')
            ->setAddress('test address headquarter')
            ->setIsHeadQuarter(true);

        $locationOne = new Location();
        $locationOne->setName('test name')
            ->setAddress('test address')
            ->setDistance(764.984);

        $locationTwo = new Location();
        $locationTwo->setName('test name two')
            ->setAddress('test address two')
            ->setDistance(948.4949);
        
        $locationCollection = new LocationCollection([
            $locationOne,
            $locationTwo
        ]);

        return [
            [$headquarter, $locationCollection]
        ];
    }
}

namespace App\Command;

use PHPUnit\Framework\Assert;

function fopen($fileName)
{
    Assert::assertStringContainsString('distances.csv', $fileName);

    return 'fopen_file_stream';
}

function fputcsv($file, $titles)
{
    Assert::assertEquals('fopen_file_stream', $file);
}

function fclose($file)
{
    return true;
}
