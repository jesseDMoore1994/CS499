<?php
namespace Cake\Test\Fixture;

use Cake\TestSuite\TestCase;
use Exception;

/**
 * This class helps in testing the life-cycle of fixtures inside a CakeTestCase
 *
 */
class FixturizedTestCase extends TestCase {

	/**
	 * Fixtures to use in this test
	 * @var array
	 */
	public $fixtures = ['core.categories'];

	/**
	 * test that the shared fixture is correctly set
	 *
	 * @return void
	 */
	public function testFixturePresent() {
		$this->assertInstanceOf('Cake\TestSuite\Fixture\FixtureManager', $this->fixtureManager);
	}

	/**
	 * test that it is possible to load fixtures on demand
	 *
	 * @return void
	 */
	public function testFixtureLoadOnDemand() {
		$this->loadFixtures('Categories');
	}

	/**
	 * test that a test is marked as skipped using skipIf and its first parameter evaluates to true
	 *
	 * @return void
	 */
	public function testSkipIfTrue() {
		$this->skipIf(true);
	}

	/**
	 * test that a test is not marked as skipped using skipIf and its first parameter evaluates to false
	 *
	 * @return void
	 */
	public function testSkipIfFalse() {
		$this->skipIf(false);
	}

	/**
	 * test that a fixtures are unloaded even if the test throws exceptions
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function testThrowException() {
		throw new Exception();
	}
}
