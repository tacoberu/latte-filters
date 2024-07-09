<?php
/**
 * Copyright (c) since 2004 Martin Takáč
 * @author Martin Takáč <martin@takac.name>
 */

namespace Taco\Latte;

use Latte;


final class FilterLatteExtension extends Latte\Extension
{

	function install(Latte\Engine $engine): void
	{
		$engine->addFilter('filter', [$this, 'filter']);
	}



	function getFilters(): array
	{
		return [
			'filter' => [$this, 'filter'],
		];
	}



	/**
	 * Filters items that do not match the condition.
	 * @template K of array-key
	 * @template V
	 * @param  iterable<K, V>  $src
	 * @return array<K, V>
	 */
	function filter(iterable $src, \Closure $fn): array
	{
		$filtered = [];
		foreach ($src as $k => $v) {
			if ($fn($v, $k)) {
				$filtered[$k] = $v;
			}
		}
		return $filtered;
	}

}
