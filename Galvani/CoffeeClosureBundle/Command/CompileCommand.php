<?php

namespace Galvani\CoffeeClosureBundle\Command;

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Bundle\FrameworkBundle\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of CompileCommand
 *
 * @author jan kozak <galvani78@gmail.com>
 */
class CompileCommand extends Command\ContainerAwareCommand {

	protected function configure() {
		$this
				->setName('coffeeclosure:compile')
				->addOption("watch", null, InputOption::VALUE_NONE)
				->setDescription('Compiles Coffee Script in Closure mode')
		;

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$exec = array(); $bundlePaths = array();

		//	Get configuration
		$yaml = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->getContainer()->get('kernel')->getRootDir() .'/config/config.yml'));
		$this->config = $yaml['coffee_closure'];

		//	Get bundles paths
		foreach ($this->config['bundles'] as $bundle) {
			$bundlePath = $this->getContainer()->get('kernel')->getBundle($bundle)->getPath();
			$relativePath = str_repeat('../',substr_count($bundlePath,'/')-3);
			if (!$input->getOption('watch')) {
				$exec[] = "vendor/bolinfest/coffee-script/bin/coffee --output ".$bundlePath."/Resources/public/js/ --compile --lint --bare --require ./".$this->config['closure']."/closure/goog/base.js --google ".$bundlePath."/Resources/public/coffee/";
			}
			$exec[] = $this->config['closure'].'/closure/bin/build/depswriter.py --root_with_prefix="'.$bundlePath.'/Resources/public/js '.$relativePath.'js/" >'.$bundlePath.'/Resources/public/js/deps.js';
		}

		$exec[] = "cache:clear";

		if ($input->getOption('watch')) {
			$output->writeln("<comment>Watching last bundle only ".$bundle."</comment>");
			$exec[] = $exec[] = "vendor/bolinfest/coffee-script/bin/coffee --output ".$bundlePath."/Resources/public/js/ --compile --watch --lint --bare --require ./".$this->config['closure']."/closure/goog/base.js --google ".$bundlePath."/Resources/public/coffee/";
		}

		foreach ($exec as $command) {
			if ($command=='cache:clear') {
				$command = $this->getApplication()->find('cache:clear');
				$returnCode = $command->run(new \Symfony\Component\Console\Input\ArgvInput(array_slice($_SERVER['argv'], 0, 2)), $output);
			} else {
				$output->writeln("<info>Running :" . $command . "</info>");
				passthru($command);
			}
		}


	}

}

?>
