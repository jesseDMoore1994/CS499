<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\View;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Cake\View\ViewBuilder;

/**
 * View builder test case.
 */
class ViewBuilderTest extends TestCase {
	/**
	 * data provider for string properties.
	 *
	 * @return array
	 */
	public function stringPropertyProvider() {
		return [
			['layoutPath', 'Admin/'],
			['templatePath', 'Admin/'],
			['plugin', 'TestPlugin'],
			['layout', 'admin'],
			['theme', 'TestPlugin'],
			['template', 'edit'],
			['name', 'Articles'],
			['autoLayout', true],
			['className', 'Cake\View\JsonView'],
		];
	}

	/**
	 * data provider for array properties.
	 *
	 * @return array
	 */
	public function arrayPropertyProvider() {
		return [
			['helpers', ['Html', 'Form']],
			['options', ['key' => 'value']],
		];
	}

	/**
	 * Test string property accessor/mutator methods.
	 *
	 * @dataProvider stringPropertyProvider
	 * @return void
	 */
	public function testStringProperties($property, $value) {
		$builder = new ViewBuilder();
		$this->assertNull($builder->{$property}(), 'Default value should be null');
		$this->assertSame($builder, $builder->{$property}($value), 'Setter returns this');
		$this->assertSame($value, $builder->{$property}(), 'Getter gets value.');
	}

	/**
	 * Test array property accessor/mutator methods.
	 *
	 * @dataProvider arrayPropertyProvider
	 * @return void
	 */
	public function testArrayProperties($property, $value) {
		$builder = new ViewBuilder();
		$this->assertSame([], $builder->{$property}(), 'Default value should be empty list');
		$this->assertSame($builder, $builder->{$property}($value), 'Setter returns this');
		$this->assertSame($value, $builder->{$property}(), 'Getter gets value.');
	}

	/**
	 * Test array property accessor/mutator methods.
	 *
	 * @dataProvider arrayPropertyProvider
	 * @return void
	 */
	public function testArrayPropertyMerge($property, $value) {
		$builder = new ViewBuilder();
		$builder->{$property}($value);

		$builder->{$property}(['Merged'], true);
		$this->assertSame(array_merge($value, ['Merged']), $builder->{$property}(), 'Should merge');

		$builder->{$property}($value, false);
		$this->assertSame($value, $builder->{$property}(), 'Should replace');
	}

	/**
	 * test building with all the options.
	 *
	 * @return void
	 */
	public function testBuildComplete() {
		$request = $this->getMock('Cake\Network\Request');
		$response = $this->getMock('Cake\Network\Response');
		$events = $this->getMock('Cake\Event\EventManager');

		$builder = new ViewBuilder();
		$builder->name('Articles')
			->className('Ajax')
			->template('edit')
			->layout('default')
			->templatePath('Articles/')
			->helpers(['Form', 'Html'])
			->layoutPath('Admin/')
			->theme('TestTheme')
			->plugin('TestPlugin');
		$view = $builder->build(
			['one' => 'value'],
			$request,
			$response,
			$events
		);
		$this->assertInstanceOf('Cake\View\AjaxView', $view);
		$this->assertEquals('edit', $view->view);
		$this->assertEquals('default', $view->layout);
		$this->assertEquals('Articles/', $view->viewPath);
		$this->assertEquals('Admin/', $view->layoutPath);
		$this->assertEquals('TestPlugin', $view->plugin);
		$this->assertEquals('TestTheme', $view->theme);
		$this->assertSame($request, $view->request);
		$this->assertSame($response, $view->response);
		$this->assertSame($events, $view->eventManager());
		$this->assertSame(['one' => 'value'], $view->viewVars);
		$this->assertInstanceOf('Cake\View\Helper\HtmlHelper', $view->Html);
		$this->assertInstanceOf('Cake\View\Helper\FormHelper', $view->Form);
	}

	/**
	 * Test that the default is AppView.
	 *
	 * @return void
	 */
	public function testBuildAppViewMissing() {
		Configure::write('App.namespace', 'Nope');
		$builder = new ViewBuilder();
		$view = $builder->build();
		$this->assertInstanceOf('Cake\View\View', $view);
	}

	/**
	 * Test that the default is AppView.
	 *
	 * @return void
	 */
	public function testBuildAppViewPresent() {
		Configure::write('App.namespace', 'TestApp');
		$builder = new ViewBuilder();
		$view = $builder->build();
		$this->assertInstanceOf('TestApp\View\AppView', $view);
	}

	/**
	 * test missing view class
	 *
	 * @expectedException \Cake\View\Exception\MissingViewException
	 * @expectedExceptionMessage View class "Foo" is missing.
	 * @return void
	 */
	public function testBuildMissingViewClass() {
		$builder = new ViewBuilder();
		$builder->className('Foo');
		$builder->build();
	}

	/**
	 * testJsonSerialize()
	 *
	 * @return void
	 */
	public function testJsonSerialize() {
		$builder = new ViewBuilder();

		$builder
			->template('default')
			->layout('test')
			->helpers(['Html'])
			->className('JsonView');

		$result = json_decode(json_encode($builder), true);

		$expected = [
			'_template' => 'default',
			'_layout' => 'test',
			'_helpers' => ['Html'],
			'_className' => 'JsonView',
		];
		$this->assertEquals($expected, $result);

		$result = json_decode(json_encode(unserialize(serialize($builder))), true);
		$this->assertEquals($expected, $result);
	}

	/**
	 * testCreateFromArray()
	 *
	 * @return void
	 */
	public function testCreateFromArray() {
		$builder = new ViewBuilder();

		$builder
			->template('default')
			->layout('test')
			->helpers(['Html'])
			->className('JsonView');

		$result = json_encode($builder);

		$builder = new ViewBuilder();
		$builder->createFromArray(json_decode($result, true));

		$this->assertEquals('default', $builder->template());
		$this->assertEquals('test', $builder->layout());
		$this->assertEquals(['Html'], $builder->helpers());
		$this->assertEquals('JsonView', $builder->className());
	}
}
