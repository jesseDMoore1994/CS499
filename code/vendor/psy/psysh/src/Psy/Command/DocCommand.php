<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2015 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use Psy\Formatter\DocblockFormatter;
use Psy\Formatter\SignatureFormatter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Read the documentation for an object, class, constant, method or property.
 */
class DocCommand extends ReflectingCommand {
	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this
			->setName('doc')
			->setAliases(array('rtfm', 'man'))
			->setDefinition(array(
				new InputArgument('value', InputArgument::REQUIRED, 'Function, class, instance, constant, method or property to document.'),
			))
			->setDescription('Read the documentation for an object, class, constant, method or property.')
			->setHelp(
				<<<HELP
Read the documentation for an object, class, constant, method or property.

It's awesome for well-documented code, not quite as awesome for poorly documented code.

e.g.
<return>>>> doc preg_replace</return>
<return>>>> doc Psy\Shell</return>
<return>>>> doc Psy\Shell::debug</return>
<return>>>> \$s = new Psy\Shell</return>
<return>>>> doc \$s->run</return>
HELP
			);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		list($value, $reflector) = $this->getTargetAndReflector($input->getArgument('value'));

		$doc = $this->getManualDoc($reflector) ?: DocblockFormatter::format($reflector);
		$db = $this->getApplication()->getManualDb();

		$output->page(function ($output) use ($reflector, $doc, $db) {
			$output->writeln(SignatureFormatter::format($reflector));
			if (empty($doc) && !$db) {
				$output->writeln('');
				$output->writeln('<warning>PHP manual not found</warning>');
				$output->writeln('    To document core PHP functionality, download the PHP reference manual:');
				$output->writeln('    https://github.com/bobthecow/psysh#downloading-the-manual');
			} else {
				$output->writeln('');
				$output->writeln($doc);
			}
		});
	}

	private function getManualDoc($reflector) {
		switch (get_class($reflector)) {
			case 'ReflectionFunction':
				$id = $reflector->name;
				break;

			case 'ReflectionMethod':
				$id = $reflector->class . '::' . $reflector->name;
				break;

			default:
				return false;
		}

		if ($db = $this->getApplication()->getManualDb()) {
			return $db
				->query(sprintf('SELECT doc FROM php_manual WHERE id = %s', $db->quote($id)))
				->fetchColumn(0);
		}
	}
}
