<?php

namespace Crowfeather\Contracts\Traverser;

interface Traverser
{
    /**
     * Array of traversable items.
     *
     * @var array
     */
    protected $traversables;

    /**
     * Single traversable item.
     *
     * @var mixed
     */
    protected $traversable;

    /**
     * Left/Right value.
     *
     * @var integer
     */
    protected $left;

    /**
     * The traversable attributes.
     *
     * @var array
     */
    protected $options;

    /**
     * The Root parent of all traversables.
     *
     * @var array
     */
    protected $root;

    /**
     * Sets the traversables.
     *
     * @param array $traversables
     */
    protected function set($traversables);

    /**
     * Gets the traversables.
     *
     * @return array
     */
    public function get();

    /**
     * Sorts the traversable tree,
     * adding parent-child relationship to the
     * traversables array.
     *
     * @param  array  $traversables
     * @param  string $parent
     * @param  array  $options
     * @return array
     */
    public function rechild($traversables, $parent = '', $options = []);

    /**
     * Prepares the traversable tree,
     * with children, siblings, parent relationship.
     *
     * @param  string  $parent
     * @param  integer $left    the starting left value
     * @param  array   $options options to pass
     * @return integer
     */
    public function prepare($parent = 'root', $left = 1, $options = []);

    /**
     * Gets the ancestors of a traversable
     * from a given left, right value.
     *
     * @param  integer $left
     * @param  integer $right
     * @return array|mixed
     */
    public function ancestors($left, $right);

    /**
     * Gets the descendants of a traversable
     * from a given left, right value.
     *
     * @param  integer $left
     * @param  integer $right
     * @return array|mixed
     */
    public function descendants($left, $right);

    /**
     * Gets the immediate parent of a given traversable.
     *
     * @param  string $child
     * @return array|mixed|null
     */
    public function parent($child = 'root');
}
