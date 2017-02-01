<?php

namespace PostBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;

class DeployCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('tounsia:deploy')
            ->setDescription('Deploys tounsia installation.\nThis command must be called after deployment in prod or intranet environments.');
    }

    protected function clearCache($output, $application) {
        try {
            $command = $application->find('cache:clear');
            $input = new ArrayInput(array("command" => 'cache:clear'));
            $command->run($input, $output);
            sleep(3);
        } catch (\Exception $e) {
            echo "Error while clearing cache => ".$e->getMessage()."\n";
            echo "** Please clear the directory app/cache manually and relaunch the command **\n";
        }
    }

    protected function recurse_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();

        //Clearing caches
        $this->clearCache($output, $application);
        //Assets install
        $command = $application->find('assets:install');
        $input = new ArrayInput(array("command" => 'assets:install'));
        $command->run($input, $output);
        //Assets dump: Create and run the command of assetic
        $command = $application->find('assetic:dump');
        $input = new ArrayInput(array("command" => 'assetic:dump'));
        $command->run($input, $output);
    }

}
