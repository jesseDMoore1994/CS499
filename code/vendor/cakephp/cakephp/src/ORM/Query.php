<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\ORM;

use ArrayObject;
use Cake\Database\ExpressionInterface;
use Cake\Database\Query as DatabaseQuery;
use Cake\Database\ValueBinder;
use Cake\Datasource\QueryInterface;
use Cake\Datasource\QueryTrait;
use JsonSerializable;
use RuntimeException;

/**
 * Extends the base Query class to provide new methods related to association
 * loading, automatic fields selection, automatic type casting and to wrap results
 * into a specific iterator that will be responsible for hydrating results if
 * required.
 *
 */
class Query extends DatabaseQuery implements JsonSerializable, QueryInterface {

	use QueryTrait {
		cache as private _cache;
		all as private _all;
		_decorateResults as private _applyDecorators;
		__call as private _call;
	}

	/**
	 * Indicates that the operation should append to the list
	 *
	 * @var int
	 */
	const APPEND = 0;

	/**
	 * Indicates that the operation should prepend to the list
	 *
	 * @var int
	 */
	const PREPEND = 1;

	/**
	 * Indicates that the operation should overwrite the list
	 *
	 * @var bool
	 */
	const OVERWRITE = true;

	/**
	 * Whether the user select any fields before being executed, this is used
	 * to determined if any fields should be automatically be selected.
	 *
	 * @var bool
	 */
	protected $_hasFields;

	/**
	 * Tracks whether or not the original query should include
	 * fields from the top level table.
	 *
	 * @var bool
	 */
	protected $_autoFields;

	/**
	 * Whether to hydrate results into entity objects
	 *
	 * @var bool
	 */
	protected $_hydrate = true;

	/**
	 * A callable function that can be used to calculate the total amount of
	 * records this query will match when not using `limit`
	 *
	 * @var callable
	 */
	protected $_counter;

	/**
	 * Instance of a class responsible for storing association containments and
	 * for eager loading them when this query is executed
	 *
	 * @var \Cake\ORM\EagerLoader
	 */
	protected $_eagerLoader;

	/**
	 * True if the beforeFind event has already been triggered for this query
	 *
	 * @var bool
	 */
	protected $_beforeFindFired = false;

	/**
	 * The COUNT(*) for the query.
	 *
	 * When set, count query execution will be bypassed.
	 *
	 * @var int
	 */
	protected $_resultsCount;

	/**
	 * Constructor
	 *
	 * @param \Cake\Database\Connection $connection The connection object
	 * @param \Cake\ORM\Table $table The table this query is starting on
	 */
	public function __construct($connection, $table) {
		parent::__construct($connection);
		$this->repository($table);

		if ($this->_repository) {
			$this->addDefaultTypes($this->_repository);
		}
	}

	/**
	 * {@inheritDoc}
	 *
	 * If you pass an instance of a `Cake\ORM\Table` or `Cake\ORM\Association` class,
	 * all the fields in the schema of the table or the association will be added to
	 * the select clause.
	 *
	 * @param array|ExpressionInterface|string|\Cake\ORM\Table|\Cake\ORM\Association $fields fields
	 * to be added to the list.
	 * @param bool $overwrite whether to reset fields with passed list or not
	 */
	public function select($fields = [], $overwrite = false) {
		if ($fields instanceof Association) {
			$fields = $fields->target();
		}

		if ($fields instanceof Table) {
			$fields = $this->aliasFields($fields->schema()->columns(), $fields->alias());
		}

		return parent::select($fields, $overwrite);
	}

	/**
	 * Hints this object to associate the correct types when casting conditions
	 * for the database. This is done by extracting the field types from the schema
	 * associated to the passed table object. This prevents the user from repeating
	 * himself when specifying conditions.
	 *
	 * This method returns the same query object for chaining.
	 *
	 * @param \Cake\ORM\Table $table The table to pull types from
	 * @return $this
	 */
	public function addDefaultTypes(Table $table) {
		$alias = $table->alias();
		$map = $table->schema()->typeMap();
		$fields = [];
		foreach ($map as $f => $type) {
			$fields[$f] = $fields[$alias . '.' . $f] = $type;
		}
		$this->typeMap()->addDefaults($fields);

		return $this;
	}

	/**
	 * Sets the instance of the eager loader class to use for loading associations
	 * and storing containments. If called with no arguments, it will return the
	 * currently configured instance.
	 *
	 * @param \Cake\ORM\EagerLoader $instance The eager loader to use. Pass null
	 *   to get the current eagerloader.
	 * @return \Cake\ORM\EagerLoader|$this
	 */
	public function eagerLoader(EagerLoader $instance = null) {
		if ($instance === null) {
			if ($this->_eagerLoader === null) {
				$this->_eagerLoader = new EagerLoader;
			}
			return $this->_eagerLoader;
		}
		$this->_eagerLoader = $instance;
		return $this;
	}

	/**
	 * Sets the list of associations that should be eagerly loaded along with this
	 * query. The list of associated tables passed must have been previously set as
	 * associations using the Table API.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring articles' author information
	 *  $query->contain('Author');
	 *
	 *  // Also bring the category and tags associated to each article
	 *  $query->contain(['Category', 'Tag']);
	 * ```
	 *
	 * Associations can be arbitrarily nested using dot notation or nested arrays,
	 * this allows this object to calculate joins or any additional queries that
	 * must be executed to bring the required associated data.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Eager load the product info, and for each product load other 2 associations
	 *  $query->contain(['Product' => ['Manufacturer', 'Distributor']);
	 *
	 *  // Which is equivalent to calling
	 *  $query->contain(['Products.Manufactures', 'Products.Distributors']);
	 *
	 *  // For an author query, load his region, state and country
	 *  $query->contain('Regions.States.Countries');
	 * ```
	 *
	 * It is possible to control the conditions and fields selected for each of the
	 * contained associations:
	 *
	 * ### Example:
	 *
	 * ```
	 *  $query->contain(['Tags' => function ($q) {
	 *      return $q->where(['Tags.is_popular' => true]);
	 *  }]);
	 *
	 *  $query->contain(['Products.Manufactures' => function ($q) {
	 *      return $q->select(['name'])->where(['Manufactures.active' => true]);
	 *  }]);
	 * ```
	 *
	 * Each association might define special options when eager loaded, the allowed
	 * options that can be set per association are:
	 *
	 * - foreignKey: Used to set a different field to match both tables, if set to false
	 *   no join conditions will be generated automatically. `false` can only be used on
	 *   joinable associations and cannot be used with hasMany or belongsToMany associations.
	 * - fields: An array with the fields that should be fetched from the association
	 * - queryBuilder: Equivalent to passing a callable instead of an options array
	 *
	 * ### Example:
	 *
	 * ```
	 * // Set options for the hasMany articles that will be eagerly loaded for an author
	 * $query->contain([
	 *   'Articles' => [
	 *     'fields' => ['title', 'author_id']
	 *   ]
	 * ]);
	 * ```
	 *
	 * When containing associations, it is important to include foreign key columns.
	 * Failing to do so will trigger exceptions.
	 *
	 * ```
	 * // Use special join conditions for getting an Articles's belongsTo 'authors'
	 * $query->contain([
	 *   'Authors' => [
	 *     'foreignKey' => false,
	 *     'queryBuilder' => function ($q) {
	 *       return $q->where(...); // Add full filtering conditions
	 *     }
	 *   ]
	 * ]);
	 * ```
	 *
	 * If called with no arguments, this function will return an array with
	 * with the list of previously configured associations to be contained in the
	 * result.
	 *
	 * If called with an empty first argument and $override is set to true, the
	 * previous list will be emptied.
	 *
	 * @param array|string $associations list of table aliases to be queried
	 * @param bool $override whether override previous list with the one passed
	 * defaults to merging previous list with the new one.
	 * @return array|$this
	 */
	public function contain($associations = null, $override = false) {
		$loader = $this->eagerLoader();
		if ($override === true) {
			$loader->clearContain();
			$this->_dirty();
		}

		if ($associations === null) {
			return $loader->contain();
		}

		$result = $loader->contain($associations);
		$this->_addAssociationsToTypeMap($this->repository(), $this->typeMap(), $result);
		return $this;
	}

	/**
	 * Used to recursively add contained association column types to
	 * the query.
	 *
	 * @param \Cake\ORM\Table $table The table instance to pluck associations from.
	 * @param \Cake\Database\TypeMap $typeMap The typemap to check for columns in.
	 *   This typemap is indirectly mutated via Cake\ORM\Query::addDefaultTypes()
	 * @param array $associations The nested tree of associations to walk.
	 * @return void
	 */
	protected function _addAssociationsToTypeMap($table, $typeMap, $associations) {
		foreach ($associations as $name => $nested) {
			$association = $table->association($name);
			if (!$association) {
				continue;
			}
			$target = $association->target();
			$primary = (array)$target->primaryKey();
			if (empty($primary) || $typeMap->type($target->aliasField($primary[0])) === null) {
				$this->addDefaultTypes($target);
			}
			if (!empty($nested)) {
				$this->_addAssociationsToTypeMap($target, $typeMap, $nested);
			}
		}
	}

	/**
	 * Adds filtering conditions to this query to only bring rows that have a relation
	 * to another from an associated table, based on conditions in the associated table.
	 *
	 * This function will add entries in the `contain` graph.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring only articles that were tagged with 'cake'
	 *  $query->matching('Tags', function ($q) {
	 *      return $q->where(['name' => 'cake']);
	 *  );
	 * ```
	 *
	 * It is possible to filter by deep associations by using dot notation:
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring only articles that were commented by 'markstory'
	 *  $query->matching('Comments.Users', function ($q) {
	 *      return $q->where(['username' => 'markstory']);
	 *  );
	 * ```
	 *
	 * As this function will create `INNER JOIN`, you might want to consider
	 * calling `distinct` on this query as you might get duplicate rows if
	 * your conditions don't filter them already. This might be the case, for example,
	 * of the same user commenting more than once in the same article.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring unique articles that were commented by 'markstory'
	 *  $query->distinct(['Articles.id'])
	 *  ->matching('Comments.Users', function ($q) {
	 *      return $q->where(['username' => 'markstory']);
	 *  );
	 * ```
	 *
	 * Please note that the query passed to the closure will only accept calling
	 * `select`, `where`, `andWhere` and `orWhere` on it. If you wish to
	 * add more complex clauses you can do it directly in the main query.
	 *
	 * @param string $assoc The association to filter by
	 * @param callable $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 */
	public function matching($assoc, callable $builder = null) {
		$this->eagerLoader()->matching($assoc, $builder);
		$this->_dirty();
		return $this;
	}

	/**
	 * Creates a LEFT JOIN with the passed association table while preserving
	 * the foreign key matching and the custom conditions that were originally set
	 * for it.
	 *
	 * This function will add entries in the `contain` graph.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Get the count of articles per user
	 *  $usersQuery
	 *      ->select(['total_articles' => $query->func()->count('Articles.id')])
	 *      ->leftJoinWith('Articles')
	 *      ->group(['Users.id'])
	 *      ->autoFields(true);
	 * ```
	 *
	 * You can also customize the conditions passed to the LEFT JOIN:
	 *
	 * ```
	 *  // Get the count of articles per user with at least 5 votes
	 *  $usersQuery
	 *      ->select(['total_articles' => $query->func()->count('Articles.id')])
	 *      ->leftJoinWith('Articles', function ($q) {
	 *          return $q->where(['Articles.votes >=' => 5]);
	 *      })
	 *      ->group(['Users.id'])
	 *      ->autoFields(true);
	 * ```
	 *
	 * This will create the following SQL:
	 *
	 * ```
	 *  SELECT COUNT(Articles.id) AS total_articles, Users.*
	 *  FROM users Users
	 *  LEFT JOIN articles Articles ON Articles.user_id = Users.id AND Articles.votes >= 5
	 *  GROUP BY USers.id
	 * ```
	 *
	 * It is possible to left join deep associations by using dot notation
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Total comments in articles by 'markstory'
	 *  $query
	 *   ->select(['total_comments' => $query->func()->count('Comments.id')])
	 *   ->leftJoinWith('Comments.Users', function ($q) {
	 *      return $q->where(['username' => 'markstory']);
	 *  )
	 *  ->group(['Users.id']);
	 * ```
	 *
	 * Please note that the query passed to the closure will only accept calling
	 * `select`, `where`, `andWhere` and `orWhere` on it. If you wish to
	 * add more complex clauses you can do it directly in the main query.
	 *
	 * @param string $assoc The association to join with
	 * @param callable $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 */
	public function leftJoinWith($assoc, callable $builder = null) {
		$this->eagerLoader()->matching($assoc, $builder, [
			'joinType' => 'LEFT',
			'fields' => false
		]);
		$this->_dirty();
		return $this;
	}

	/**
	 * Creates an INNER JOIN with the passed association table while preserving
	 * the foreign key matching and the custom conditions that were originally set
	 * for it.
	 *
	 * This function will add entries in the `contain` graph.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring only articles that were tagged with 'cake'
	 *  $query->innerJoinWith('Tags', function ($q) {
	 *      return $q->where(['name' => 'cake']);
	 *  );
	 * ```
	 *
	 * This will create the following SQL:
	 *
	 * ```
	 *  SELECT Articles.*
	 *  FROM articles Articles
	 *  INNER JOIN tags Tags ON Tags.name = 'cake'
	 *  INNER JOIN articles_tags ArticlesTags ON ArticlesTags.tag_id = Tags.id
	 *    AND ArticlesTags.articles_id = Articles.id
	 * ```
	 *
	 * This function works the same as `matching()` with the difference that it
	 * will select no fields from the association.
	 *
	 * @param string $assoc The association to join with
	 * @param callable $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 * @see \Cake\ORM\Query::matching()
	 */
	public function innerJoinWith($assoc, callable $builder = null) {
		$this->eagerLoader()->matching($assoc, $builder, [
			'joinType' => 'INNER',
			'fields' => false
		]);
		$this->_dirty();
		return $this;
	}

	/**
	 * Adds filtering conditions to this query to only bring rows that have no match
	 * to another from an associated table, based on conditions in the associated table.
	 *
	 * This function will add entries in the `contain` graph.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring only articles that were not tagged with 'cake'
	 *  $query->notMatching('Tags', function ($q) {
	 *      return $q->where(['name' => 'cake']);
	 *  );
	 * ```
	 *
	 * It is possible to filter by deep associations by using dot notation:
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring only articles that weren't commented by 'markstory'
	 *  $query->notMatching('Comments.Users', function ($q) {
	 *      return $q->where(['username' => 'markstory']);
	 *  );
	 * ```
	 *
	 * As this function will create a `LEFT JOIN`, you might want to consider
	 * calling `distinct` on this query as you might get duplicate rows if
	 * your conditions don't filter them already. This might be the case, for example,
	 * of the same article having multiple comments.
	 *
	 * ### Example:
	 *
	 * ```
	 *  // Bring unique articles that were commented by 'markstory'
	 *  $query->distinct(['Articles.id'])
	 *  ->notMatching('Comments.Users', function ($q) {
	 *      return $q->where(['username' => 'markstory']);
	 *  );
	 * ```
	 *
	 * Please note that the query passed to the closure will only accept calling
	 * `select`, `where`, `andWhere` and `orWhere` on it. If you wish to
	 * add more complex clauses you can do it directly in the main query.
	 *
	 * @param string $assoc The association to filter by
	 * @param callable $builder a function that will receive a pre-made query object
	 * that can be used to add custom conditions or selecting some fields
	 * @return $this
	 */
	public function notMatching($assoc, callable $builder = null) {
		$this->eagerLoader()->matching($assoc, $builder, [
			'joinType' => 'LEFT',
			'fields' => false,
			'negateMatch' => true
		]);
		$this->_dirty();
		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * Populates or adds parts to current query clauses using an array.
	 * This is handy for passing all query clauses at once. The option array accepts:
	 *
	 * - fields: Maps to the select method
	 * - conditions: Maps to the where method
	 * - limit: Maps to the limit method
	 * - order: Maps to the order method
	 * - offset: Maps to the offset method
	 * - group: Maps to the group method
	 * - having: Maps to the having method
	 * - contain: Maps to the contain options for eager loading
	 * - join: Maps to the join method
	 * - page: Maps to the page method
	 *
	 * ### Example:
	 *
	 * ```
	 * $query->applyOptions([
	 *   'fields' => ['id', 'name'],
	 *   'conditions' => [
	 *     'created >=' => '2013-01-01'
	 *   ],
	 *   'limit' => 10
	 * ]);
	 * ```
	 *
	 * Is equivalent to:
	 *
	 * ```
	 *  $query
	 *  ->select(['id', 'name'])
	 *  ->where(['created >=' => '2013-01-01'])
	 *  ->limit(10)
	 * ```
	 */
	public function applyOptions(array $options) {
		$valid = [
			'fields' => 'select',
			'conditions' => 'where',
			'join' => 'join',
			'order' => 'order',
			'limit' => 'limit',
			'offset' => 'offset',
			'group' => 'group',
			'having' => 'having',
			'contain' => 'contain',
			'page' => 'page',
		];

		ksort($options);
		foreach ($options as $option => $values) {
			if (isset($valid[$option], $values)) {
				$this->{$valid[$option]}($values);
			} else {
				$this->_options[$option] = $values;
			}
		}

		return $this;
	}

	/**
	 * Creates a copy of this current query, triggers beforeFind and resets some state.
	 *
	 * The following state will be cleared:
	 *
	 * - autoFields
	 * - limit
	 * - offset
	 * - map/reduce functions
	 * - result formatters
	 * - order
	 * - containments
	 *
	 * This method creates query clones that are useful when working with subqueries.
	 *
	 * @return \Cake\ORM\Query
	 */
	public function cleanCopy() {
		$clone = clone $this;
		$clone->triggerBeforeFind();
		$clone->autoFields(false);
		$clone->limit(null);
		$clone->order([], true);
		$clone->offset(null);
		$clone->mapReduce(null, null, true);
		$clone->formatResults(null, true);
		return $clone;
	}

	/**
	 * Object clone hook.
	 *
	 * Destroys the clones inner iterator and clones the value binder, and eagerloader instances.
	 *
	 * @return void
	 */
	public function __clone() {
		parent::__clone();
		if ($this->_eagerLoader) {
			$this->_eagerLoader = clone $this->_eagerLoader;
		}
	}

	/**
	 * {@inheritDoc}
	 *
	 * Returns the COUNT(*) for the query. If the query has not been
	 * modified, and the count has already been performed the cached
	 * value is returned
	 */
	public function count() {
		if ($this->_resultsCount === null) {
			$this->_resultsCount = $this->_performCount();
		}

		return $this->_resultsCount;
	}

	/**
	 * Performs and returns the COUNT(*) for the query.
	 *
	 * @return int
	 */
	protected function _performCount() {
		$query = $this->cleanCopy();
		$counter = $this->_counter;
		if ($counter) {
			$query->counter(null);
			return (int)$counter($query);
		}

		$complex = (
			$query->clause('distinct') ||
			count($query->clause('group')) ||
			count($query->clause('union')) ||
			$query->clause('having')
		);

		if (!$complex) {
			// Expression fields could have bound parameters.
			foreach ($query->clause('select') as $field) {
				if ($field instanceof ExpressionInterface) {
					$complex = true;
					break;
				}
			}
		}

		if (!$complex && $this->_valueBinder !== null) {
			$order = $this->clause('order');
			$complex = $order === null ? false : $order->hasNestedExpression();
		}

		$count = ['count' => $query->func()->count('*')];

		if (!$complex) {
			$query->eagerLoader()->autoFields(false);
			$statement = $query
				->select($count, true)
				->autoFields(false)
				->execute();
		} else {
			$statement = $this->connection()->newQuery()
				->select($count)
				->from(['count_source' => $query])
				->execute();
		}

		$result = $statement->fetch('assoc')['count'];
		$statement->closeCursor();
		return (int)$result;
	}

	/**
	 * Registers a callable function that will be executed when the `count` method in
	 * this query is called. The return value for the function will be set as the
	 * return value of the `count` method.
	 *
	 * This is particularly useful when you need to optimize a query for returning the
	 * count, for example removing unnecessary joins, removing group by or just return
	 * an estimated number of rows.
	 *
	 * The callback will receive as first argument a clone of this query and not this
	 * query itself.
	 *
	 * If the first param is a null value, the built-in counter function will be called
	 * instead
	 *
	 * @param callable|null $counter The counter value
	 * @return $this
	 */
	public function counter($counter) {
		$this->_counter = $counter;
		return $this;
	}

	/**
	 * Toggle hydrating entities.
	 *
	 * If set to false array results will be returned
	 *
	 * @param bool|null $enable Use a boolean to set the hydration mode.
	 *   Null will fetch the current hydration mode.
	 * @return bool|$this A boolean when reading, and $this when setting the mode.
	 */
	public function hydrate($enable = null) {
		if ($enable === null) {
			return $this->_hydrate;
		}

		$this->_dirty();
		$this->_hydrate = (bool)$enable;
		return $this;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return $this
	 * @throws \RuntimeException When you attempt to cache a non-select query.
	 */
	public function cache($key, $config = 'default') {
		if ($this->_type !== 'select' && $this->_type !== null) {
			throw new RuntimeException('You cannot cache the results of non-select queries.');
		}
		return $this->_cache($key, $config);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \RuntimeException if this method is called on a non-select Query.
	 */
	public function all() {
		if ($this->_type !== 'select' && $this->_type !== null) {
			throw new RuntimeException(
				'You cannot call all() on a non-select query. Use execute() instead.'
			);
		}
		return $this->_all();
	}

	/**
	 * Trigger the beforeFind event on the query's repository object.
	 *
	 * Will not trigger more than once, and only for select queries.
	 *
	 * @return void
	 */
	public function triggerBeforeFind() {
		if (!$this->_beforeFindFired && $this->_type === 'select') {
			$table = $this->repository();
			$this->_beforeFindFired = true;
			$table->dispatchEvent('Model.beforeFind', [
				$this,
				new ArrayObject($this->_options),
				!$this->eagerLoaded()
			]);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function sql(ValueBinder $binder = null) {
		$this->triggerBeforeFind();

		$this->_transformQuery();
		$sql = parent::sql($binder);
		return $sql;
	}

	/**
	 * Executes this query and returns a ResultSet object containing the results.
	 * This will also setup the correct statement class in order to eager load deep
	 * associations.
	 *
	 * @return \Cake\ORM\ResultSet
	 */
	protected function _execute() {
		$this->triggerBeforeFind();
		if ($this->_results) {
			$decorator = $this->_decoratorClass();
			return new $decorator($this->_results);
		}
		$statement = $this->eagerLoader()->loadExternal($this, $this->execute());
		return new ResultSet($this, $statement);
	}

	/**
	 * Applies some defaults to the query object before it is executed.
	 *
	 * Specifically add the FROM clause, adds default table fields if none are
	 * specified and applies the joins required to eager load associations defined
	 * using `contain`
	 *
	 * @see \Cake\Database\Query::execute()
	 * @return void
	 */
	protected function _transformQuery() {
		if (!$this->_dirty) {
			return;
		}

		if ($this->_type === 'select') {
			if (empty($this->_parts['from'])) {
				$this->from([$this->_repository->alias() => $this->_repository->table()]);
			}
			$this->_addDefaultFields();
			$this->eagerLoader()->attachAssociations($this, $this->_repository, !$this->_hasFields);
		}
	}

	/**
	 * Inspects if there are any set fields for selecting, otherwise adds all
	 * the fields for the default table.
	 *
	 * @return void
	 */
	protected function _addDefaultFields() {
		$select = $this->clause('select');
		$this->_hasFields = true;

		if (!count($select) || $this->_autoFields === true) {
			$this->_hasFields = false;
			$this->select($this->repository()->schema()->columns());
			$select = $this->clause('select');
		}

		$aliased = $this->aliasFields($select, $this->repository()->alias());
		$this->select($aliased, true);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @see \Cake\ORM\Table::find()
	 */
	public function find($finder, array $options = []) {
		return $this->repository()->callFinder($finder, $this, $options);
	}

	/**
	 * Marks a query as dirty, removing any preprocessed information
	 * from in memory caching such as previous results
	 *
	 * @return void
	 */
	protected function _dirty() {
		$this->_results = null;
		$this->_resultsCount = null;
		parent::_dirty();
	}

	/**
	 * Create an update query.
	 *
	 * This changes the query type to be 'update'.
	 * Can be combined with set() and where() methods to create update queries.
	 *
	 * @param string|null $table Unused parameter.
	 * @return $this
	 */
	public function update($table = null) {
		$table = $table ?: $this->repository()->table();
		return parent::update($table);
	}

	/**
	 * Create a delete query.
	 *
	 * This changes the query type to be 'delete'.
	 * Can be combined with the where() method to create delete queries.
	 *
	 * @param string|null $table Unused parameter.
	 * @return $this
	 */
	public function delete($table = null) {
		$repo = $this->repository();
		$this->from([$repo->alias() => $repo->table()]);
		return parent::delete();
	}

	/**
	 * Create an insert query.
	 *
	 * This changes the query type to be 'insert'.
	 * Note calling this method will reset any data previously set
	 * with Query::values()
	 *
	 * Can be combined with the where() method to create delete queries.
	 *
	 * @param array $columns The columns to insert into.
	 * @param array $types A map between columns & their datatypes.
	 * @return $this
	 */
	public function insert(array $columns, array $types = []) {
		$table = $this->repository()->table();
		$this->into($table);
		return parent::insert($columns, $types);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \BadMethodCallException if the method is called for a non-select query
	 */
	public function __call($method, $arguments) {
		if ($this->type() === 'select') {
			return $this->_call($method, $arguments);
		}

		throw new \BadMethodCallException(
			sprintf('Cannot call method "%s" on a "%s" query', $method, $this->type())
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function __debugInfo() {
		$eagerLoader = $this->eagerLoader();
		return parent::__debugInfo() + [
			'hydrate' => $this->_hydrate,
			'buffered' => $this->_useBufferedResults,
			'formatters' => count($this->_formatters),
			'mapReducers' => count($this->_mapReduce),
			'contain' => $eagerLoader ? $eagerLoader->contain() : [],
			'matching' => $eagerLoader ? $eagerLoader->matching() : [],
			'extraOptions' => $this->_options,
			'repository' => $this->_repository
		];
	}

	/**
	 * Executes the query and converts the result set into JSON.
	 *
	 * Part of JsonSerializable interface.
	 *
	 * @return \Cake\Datasource\ResultSetInterface The data to convert to JSON.
	 */
	public function jsonSerialize() {
		return $this->all();
	}

	/**
	 * Get/Set whether or not the ORM should automatically append fields.
	 *
	 * By default calling select() will disable auto-fields. You can re-enable
	 * auto-fields with this method.
	 *
	 * @param bool|null $value The value to set or null to read the current value.
	 * @return bool|$this Either the current value or the query object.
	 */
	public function autoFields($value = null) {
		if ($value === null) {
			return $this->_autoFields;
		}
		$this->_autoFields = (bool)$value;
		return $this;
	}

	/**
	 * Decorates the results iterator with MapReduce routines and formatters
	 *
	 * @param \Traversable $result Original results
	 * @return \Cake\Datasource\ResultSetInterface
	 */
	protected function _decorateResults($result) {
		$result = $this->_applyDecorators($result);

		if (!($result instanceof ResultSet) && $this->bufferResults()) {
			$class = $this->_decoratorClass();
			$result = new $class($result->buffered());
		}

		return $result;
	}
}
