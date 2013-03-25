<?php

namespace Galvani\CoffeeClosureBundle\Command;

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
		$output->writeln('<info>Compiling Coffee Script in closure mode</info>');

		$exec = array();

		//$exec[]="cache:clear";
		$exec[] = 'tools/closure-library/closure/bin/build/depswriter.py --root_with_prefix="./src/Liquidy/LiquidyBundle/Resources/public/js/liquidy ../../../../liquidy/js/liquidy" >./src/Liquidy/LiquidyBundle/Resources/public/js/deps.js';
		//$exec[] = 'tools/closure-library/closure/bin/calcdeps.py -i src/Liquidy/LiquidyBundle/Resources/public/js/app.js -p src/Galvani/CoffeeClosureBundle/Resources/public/js/closure -o deps >> src/Liquidy/LiquidyBundle/Resources/public/js/deps.js';
		//$exec[] = './tools/closure-library/closure/bin/build/closurebuilder.py --root=./tools/closure-library/ --output_mode=compiled --root=src/Liquidy/LiquidyBundle/Resources/public/js/ --namespace="liquidy.start" --output_file=src/Liquidy/LiquidyBundle/Resources/public/js/liquidy.js';


		$exec_row = array($this->getContainer()->getParameter('coffee_closure.bin.coffee'));
		$exec_row[] = str_replace('!options!', ( $input->getOption('watch') ? "--watch" : ""), $this->getContainer()->getParameter('coffee_closure.compile.command'));

		$exec[] = join(' ', $exec_row);

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