<?php
namespace Czim\DataStore\Contracts\Stores;

use Czim\DataStore\Contracts\Resource\ResourceAdapterInterface;
use Czim\DataStore\Contracts\Stores\Filtering\FilterHandlerInterface;
use Czim\DataStore\Contracts\Stores\Includes\IncludeDecoratorInterface;
use Czim\DataStore\Contracts\Stores\Includes\IncludeResolverInterface;
use Czim\DataStore\Contracts\Stores\Manipulation\DataManipulatorInterface;

/**
 * Interface DataStoreInterface
 *
 * The DataStore adapter layer servers as an abstraction to retrieve
 * requested data ready for encoding.
 */
interface DataStoreInterface extends DataStoreRetrieveInterface, DataStoreUpdateInterface
{

    /**
     * Sets the resource adapter.
     *
     * @param ResourceAdapterInterface $resourceAdapter
     * @return $this
     */
    public function setResourceAdapter(ResourceAdapterInterface $resourceAdapter);

    /**
     * Sets the include resolver.
     *
     * @param IncludeResolverInterface $resolver
     * @return $this
     */
    public function setIncludeResolver(IncludeResolverInterface $resolver);

    /**
     * Sets the include decorator instance.
     *
     * @param IncludeDecoratorInterface $decorator
     * @return $this
     */
    public function setIncludeDecorator(IncludeDecoratorInterface $decorator);

    /**
     * Sets the filter handlers.
     *
     * @param FilterHandlerInterface $filter
     * @return $this
     */
    public function setFilterHandler(FilterHandlerInterface $filter);

    /**
     * Returns the filter handler.
     *
     * @return FilterHandlerInterface|null
     */
    public function getFilterHandler();

    /**
     * Sets the database strategy driver key.
     *
     * @param string $driver
     * @return $this
     */
    public function setStrategyDriver($driver);

    /**
     * Sets the manipulator to use, if any.
     *
     * If no manipulator is set, record manipulation is not supported.
     *
     * @param DataManipulatorInterface|null $manipulator
     * @return $this
     */
    public function setManipulator(DataManipulatorInterface $manipulator = null);

    /**
     * Sets the default page size to use if none specified.
     *
     * @param int $size
     * @return $this
     */
    public function setDefaultPageSize($size);

}
