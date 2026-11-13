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
		$engine->addFilter('group', [$this, 'group']);
	}



	function getFilters(): array
	{
		return [
			'filter' => [$this, 'filter'],
			'group' => [$this, 'group'],
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



	/**
	 * Groups elements by the element indices and preserves the key association and order.
	 * @template K
	 * @template V
	 * @param  iterable<K, V>  $data
	 * @param  string|int|\Closure  $by
	 * @return PairsIterator<mixed, PairsIterator<K, V>>
	 */
	function group(iterable $data, $by): PairsIterator
	{
		$fn = $by instanceof \Closure
			? $by
			: function ($a) use ($by) {
				return is_array($a) ? $a[$by] : $a->$by;
			};
		$keys = $groups = [];
		$prevKey = null;

		foreach ($data as $k => $v) {
			$groupKey = $fn($v, $k);
			if (!$groups || $prevKey !== $groupKey) {
				$index = array_search($groupKey, $keys, true);
				if ($index === false) {
					$index = count($keys);
					$keys[$index] = $groupKey;
				}
				$prevKey = $groupKey;
			}
			$groups[$index][] = [$k, $v];
		}

		$pairs = [];
		foreach ($keys as $i => $key) {
			$pairs[] = [$key, new PairsIterator($groups[$i])];
		}
		return new PairsIterator($pairs);
	}

}



/**
 * Iterates over key-value pairs (keys may be of any type).
 * @internal
 * @template K
 * @template V
 * @implements \IteratorAggregate<K, V>
 */
final class PairsIterator implements \IteratorAggregate, \Countable
{

	/** @var array<array{K, V}> */
	private $pairs;


	/**
	 * @param  array<array{K, V}>  $pairs
	 */
	function __construct(array $pairs)
	{
		$this->pairs = $pairs;
	}



	/**
	 * @return \Generator<K, V>
	 */
	function getIterator(): \Generator
	{
		foreach ($this->pairs as [$key, $value]) {
			yield $key => $value;
		}
	}



	function count(): int
	{
		return count($this->pairs);
	}

}
