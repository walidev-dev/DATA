<?php

namespace AppBundle\Command;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Region;
use AppBundle\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CitiesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:cities')
            ->setDescription('read and save csv cities file')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        ini_set("memory_limit", "-1");
        //empty all tables;
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('ville', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('departement', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('region', true));
        $csv = dirname($this->getContainer()->get('kernel')->getRootDir()) . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'villes.csv';
        $lines = explode("\n", file_get_contents($csv));
        $regions = [];
        $departements = [];
        $villes = [];
        foreach ($lines as $k => $line) {
            $line = explode(";", $line);
            if (count($line) > 10 && $k > 0) {
                //on sauvgarde la region
                if (!key_exists($line[1], $regions)) {
                    $region = new Region();
                    $region->setCode($line[1]);
                    $region->setName($line[2]);
                    $regions[$line[1]] = $region;
                    $em->persist($region);
                } else {
                    $region = $regions[$line[1]];
                }
                // on sauvgarde le departement
                if (!key_exists($line[4], $departements)) {
                    $departement = new Departement();
                    $departement->setCode($line[4]);
                    $departement->setName($line[5]);
                    $departement->setRegion($region);
                    $departements[$line[4]] = $departement;
                    $em->persist($departement);
                } else {
                    $departement = $departements[$line[4]];
                }
                // on sauvgarde la ville
                if (!key_exists($line[6], $villes)) {
                    $ville = new Ville();
                    $ville->setName($line[6]);
                    $ville->setDepartement($departement);
                    $villes[$line[6]] = $ville;
                    $em->persist($ville);
                }
            }
        }
        $em->flush();

    }

}
