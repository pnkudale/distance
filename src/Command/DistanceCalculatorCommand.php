<?php
namespace App\Command;

use App\DTO\{Location, LocationCollection};
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Location\{LocationProvider, LocationProcessor};

/**
 * Command 'distance:calculator' display distances between addresses.
 */
class DistanceCalculatorCommand extends Command
{
    /** @var LocationProvider */
    protected LocationProvider $locationProvider;

    /** @var LocationProcessor */
    protected LocationProcessor $locationProcessor;

    /**
     * Construct
     *
     * @param LocationProvider $locationProvider
     * @param LocationProcessor $locationProcessor
     */
    public function __construct(
        LocationProvider $locationProvider, 
        LocationProcessor $locationProcessor
    ) {
        parent::__construct();
        $this->locationProvider = $locationProvider;
        $this->locationProcessor = $locationProcessor;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configure() : void
    {
        $this->setName('distance:calculator')
            ->setDescription('Calculate distance from Headquarter to multiple places.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        list($headQuarter, $places) = $this->locationProvider->getLocationsInFile();
        $locations = $this->locationProcessor->processsLocations($headQuarter, $places);
        if (count($locations) <= 0) {
            return Command::FAILURE;
        }
        $this->writeResult($headQuarter, $locations, $input, $output);
        
        return Command::SUCCESS;
    }

    /**
     * Write distances.
     *
     * @param Location $headQuarter
     * @param LocationCollection $headQuarter
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    private function writeResult(Location $headQuarter, LocationCollection $locations, InputInterface $input, OutputInterface $output) : void
    {
        $titles = [ 'Sortnumber' , 'Distance', 'Name', 'Address'];
        $style = new SymfonyStyle($input, $output);
        $style->title('HeadQuarter Distances');
        $style->writeln('HeadQuarter');
        $style->table(['Name', 'Address'], [[$headQuarter->getName(), $headQuarter->getAddress()]]);
        $style->writeln('Places');
        $table = $style->createTable();
        $table->setHeaders($titles);

        $fileName = __DIR__ . '/../Data/distances.csv';
        $file = fopen($fileName, 'w');
        fputcsv($file, $titles);
        $counter=1;
        foreach ($locations as $location) {
            $locationData = [$counter, $location->getDistance() . ' km', $location->getName(), $location->getAddress()];
            $table->addRow($locationData);
            fputcsv($file, $locationData);
            $counter++;
        }

        $table->render();
        fclose($file);
    }
}