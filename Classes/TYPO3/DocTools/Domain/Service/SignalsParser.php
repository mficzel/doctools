<?php
namespace TYPO3\DocTools\Domain\Service;

/*                                                                        *
 * This script belongs to the Flow package "TYPO3.DocTools".              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * TYPO3.DocTools parser for signals in classes
 */
class SignalsParser extends AbstractClassParser {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Reflection\ReflectionService
	 */
	protected $reflectionService;

	/**
	 * @return string
	 */
	protected function parseTitle() {
		return substr($this->className, strrpos($this->className, '\\') + 1) . ' (``' . $this->className . '``)';
	}

	/**
	 * @return array
	 */
	protected function parseDescription() {
		$description = 'This class contains the following signals.' . chr(10). chr(10);
		$methodReflections = $this->classReflection->getMethods();
		foreach ($methodReflections as $methodReflection) {
			/** @var \TYPO3\Flow\Reflection\MethodReflection $methodReflection */
			if ($this->reflectionService->isMethodAnnotatedWith($this->className, $methodReflection->getName(), \TYPO3\Flow\Annotations\Signal::class)) {
				$signalName = lcfirst(preg_replace('/^emit/', '', $methodReflection->getName()));
				$description .= $signalName;
				$description .= chr(10) . str_repeat('^', strlen($signalName));
				$description .= chr(10) . chr(10) . $methodReflection->getDescription() . chr(10) . chr(10);
			}
		}

		return $description;
	}

	/**
	 * @return array<\TYPO3\DocTools\Domain\Model\ArgumentDefinition>
	 */
	protected function parseArgumentDefinitions() {
		return array();
	}

	/**
	 * @return array<\TYPO3\DocTools\Domain\Model\CodeExample>
	 */
	protected function parseCodeExamples() {
		return array();
	}
}
