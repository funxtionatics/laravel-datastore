<?php

use Czim\DataStore\Enums\FilterStrategyEnum;
use Czim\DataStore\Enums\SortStrategyEnum;
use Czim\DataStore\Stores\Filtering\Strategies as FilterStrategies;
use Czim\DataStore\Stores\Sorting\Strategies as SortStrategies;
use Illuminate\Database\Eloquent\Relations;

return [

    /*
    |--------------------------------------------------------------------------
    | Drivers
    |--------------------------------------------------------------------------
    |
    | Abstraction configuration for different database drivers.
    |
    */

    'drivers' => [

        'datastore' => [
            'default' => 'model',

            'drivers' => [

                'model' => [
                    // Datastore class name
                    'datastore'           => Czim\DataStore\Stores\EloquentRepositoryDataStore::class,
                    // Data manipulator factory class name
                    'manipulator-factory' => Czim\DataStore\Stores\Manipulation\EloquentModelManipulatorFactory::class,
                    // Driver key for resource adapter (null for default)
                    'adapter'             => null,
                    // Driver key for database (null for default)
                    'database'            => null,
                ],

                'repository' => [
                    'datastore'           => Czim\DataStore\Stores\EloquentRepositoryDataStore::class,
                    'manipulator-factory' => Czim\DataStore\Stores\Manipulation\EloquentRepositoryManipulatorFactory::class,
                    'adapter'             => null,
                ],
            ],
        ],

        // The resource adaptor layer
        'adapter' => [
            'default' => 'jsonapi',

            'drivers' => [

                'jsonapi' => [
                    'factory' => Czim\DataStore\Resource\JsonApi\JsonApiResourceAdapterFactory::class,
                ],
            ],
        ],

        'database' => [
            'default' => 'mysql',

            'drivers' => [

                'mysql' => [
                ],

                'sqlite' => [
                ],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | DataStore Class Map
    |--------------------------------------------------------------------------
    |
    | Specific data store classes may be mapped based on the subject model
    | class for which the store is created.
    |
    */

    'store-mapping' => [

        // Default mapping
        'default' => [

            // YourSubjectClassName::class => YourDataStoreClass::class,
        ],

        // If a mapping is not set for a specific driver,
        // the above defined default mapping is used.
        'drivers' => [

            'model' => [

                // YourSubjectClassName::class => YourDataStoreClass::class,
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Includes
    |--------------------------------------------------------------------------
    |
    | Special include logic may be made configurable per model.
    |
    */

    'include' => [

        // Map instances of the IncludeDecoratorInterface
        'decorator' => [

            // The default decorator class to use
            'default' => null,

            // Per-model mapped decorators
            'model-map' => [
                // \YourModel\ClassName::class => \YourInclude\DecoratorClassName::class
            ],
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Filtering
    |--------------------------------------------------------------------------
    |
    | The strategies section defines the filter strategies to be used for model
    | attributes.
    | Strategies itself is keyed by model class name, and values for those keys
    | should be an associative array mapping attribute names to their
    | respective strategies. E.g:
    |
    |      'strategies' => [
    |          \YourModel\ClassName::class => [
    |              'attribute-name' => 'strategy-alias',
    |          ],
    |      ],
    |
    | Note that the data attribute keys here should refer to f.i. Eloquent
    | model attributes, *not* JSON-API data keys!
    |
    */

    'filter' => [

        // The top-level filter handling class may also be replaced or mapped,
        // independently of specific per key strategies.
        // Must implement Czim\Filter\Contracts\FilterInterface.
        'handler' => [
            'default' => \Czim\DataStore\Stores\Filtering\DefaultFilter::class,

            // Optionally mapped top-level filter class mapped per model FQN
            'model-map' => [
                //App\Models\YourModel::class => App\Filters\YourFilter::class,
            ],
        ],


        // If this prefix is detected before a filter property key,
        // and the interpretation of the key permits it, the filter is reversed
        // (ie. from inclusive to exclusive).
        'reverse-key-prefix' => '-',

        // The default / fallback strategy
        'default' => FilterStrategyEnum::LIKE_CASE_INSENSITIVE,

        // Default strategies per attribute key
        'default-strategies' => [
            'id'   => FilterStrategyEnum::EXACT,
            'slug' => FilterStrategyEnum::EXACT_CASE_INSENSITIVE,
        ],

        // Defaults to use for relation methods
        'default-relation-strategies' => [
            Relations\BelongsTo::class     => FilterStrategyEnum::RELATION_SINGULAR,
            Relations\BelongsToMany::class => FilterStrategyEnum::RELATION_PLURAL,
            Relations\HasMany::class       => FilterStrategyEnum::RELATION_PLURAL,
            Relations\HasOne::class        => FilterStrategyEnum::RELATION_SINGULAR,
            Relations\MorphMany::class     => FilterStrategyEnum::RELATION_PLURAL,
            Relations\MorphToMany::class   => FilterStrategyEnum::RELATION_PLURAL,
        ],

        // Strategies per model
        'strategies' => [
            //App\Models\YourModel::class => [
            //],
        ],

        // Class map for strategy enum values to strategy classes
        'class-map-default' => [
            FilterStrategyEnum::LIKE                   => FilterStrategies\LikeStrategy::class,
            FilterStrategyEnum::LIKE_CASE_INSENSITIVE  => FilterStrategies\LikeStrategy::class,
            FilterStrategyEnum::EXACT                  => FilterStrategies\ExactStrategy::class,
            FilterStrategyEnum::EXACT_CASE_INSENSITIVE => FilterStrategies\ExactStrategy::class,
            FilterStrategyEnum::EXACT_COMMA_SEPARATED  => FilterStrategies\ExactCommaSeparatedStrategy::class,

            FilterStrategyEnum::RELATION_SINGULAR => FilterStrategies\RelationKeyStrategy::class,
            FilterStrategyEnum::RELATION_PLURAL   => FilterStrategies\RelationKeyStrategy::class,
        ],

        // If a specific mapping for an enum value is not given for a specific driver,
        // the above defined default mapping is used.
        'class-map' => [

            'mysql' => [
            ],

            'postgres' => [
                FilterStrategyEnum::LIKE_CASE_INSENSITIVE  => FilterStrategies\Postgres\LikeCaseInsensitiveStrategy::class,
                FilterStrategyEnum::EXACT_CASE_INSENSITIVE => FilterStrategies\Postgres\ExactCaseInsensitiveStrategy::class,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    |
    | Defines the sort strategies to be used for model attributes.
    |
    | Strategies itself is keyed by model class name, and values for those keys should be
    | an associative array mapping attribute names to their respective strategies. E.g:
    |
    |      'strategies' => [
    |          \YourModel\ClassName::class => [
    |              'attribute-name' => 'strategy-alias',
    |          ],
    |      ],
    |
    | Note that the data attribute keys here should refer to f.i. Eloquent model attributes,
    | *not* JSON-API data keys!
    |
    */

    'sort' => [

        // The default / fallback strategy
        'default' => SortStrategyEnum::ALPHABETIC,

        // Default strategies per data attribute key
        'default-strategies' => [
            'id'         => SortStrategyEnum::NUMERIC,
            'active'     => SortStrategyEnum::NUMERIC,
            'position'   => SortStrategyEnum::NUMERIC,
            'created_at' => SortStrategyEnum::NUMERIC,
            'updated_at' => SortStrategyEnum::NUMERIC,
        ],

        // Strategies per model
        'strategies' => [

            //App\Models\YourModel::class => [
            //],
        ],

        // Class map for strategy enum values to strategy classes
        'class-map-default' => [
            SortStrategyEnum::ALPHABETIC => SortStrategies\AlphabeticStrategy::class,
            SortStrategyEnum::NUMERIC    => SortStrategies\AlphabeticStrategy::class,
        ],

        // If a specific mapping for an enum value is not given for a specific driver,
        // the above defined default mapping is used.
        'class-map' => [

            'mysql' => [
            ],

            'postgres' => [
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Manipulation
    |--------------------------------------------------------------------------
    |
    | Configuration and mapping for record manipulation.
    |
    */

    'manipulation' => [

        // Manipulator class to use per class/FQN (model or repository, for instance)
        // This may be used by the manipulator factory to build specific manipulators.
        'class' => [

            //App\Models\YourModel::class => App\DataStores\Manipulators\YourManipulator::class,
        ],

        'config' => [
            // Default configuration to use if not specific is mapped for the model
            'default' => [

            ],

            // Specific per model(FQN) defined configurations for manipulation
            'model' => [

                //App\Models\YourModel::class => [
                //],
            ],
        ],

        // Whether to-many relationship replaces are allowed
        'allow-relationship-replace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    */

    'pagination' => [

        // Default page size
        'size' => 10,

    ],

];
