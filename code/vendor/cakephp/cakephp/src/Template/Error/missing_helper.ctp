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
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Core\Configure;

$namespace = Configure::read('App.namespace');
if (!empty($plugin)) {
	$namespace = str_replace('/', '\\', $plugin);
}

$pluginPath = Configure::read('App.paths.plugins.0');
$pluginDot = empty($plugin) ? null : $plugin . '.';
if (empty($plugin)) {
	$filePath = APP_DIR . DS;
}
if (!empty($plugin) && Plugin::loaded($plugin)) {
	$filePath = Plugin::classPath($plugin);
}
if (!empty($plugin) && !Plugin::loaded($plugin)) {
	$filePath = $pluginPath . h($plugin) . DS . 'src' . DS;
}

$this->layout = 'dev_error';
$this->assign('title', 'Missing Helper');
$this->assign('templateName', 'missing_helper.ctp');

$this->start('subheading');
?>
<strong>Error: </strong>
<em><?= h($pluginDot . $class) ?></em> could not be found.
<?= $this->element('plugin_class_error', ['pluginPath' => $pluginPath]) ?>
<?php $this->end() ?>

<?php $this->start('file') ?>
<p class="error">
	<strong>Error: </strong>
	<?= sprintf('Create the class <em>%s</em> below in file: %s', h($class), $filePath . 'View' . DS . 'Helper' . DS . h($class) . '.php'); ?>
</p>
<?php
$code = <<<PHP
<?php
namespace {$namespace}\View\Helper;

use Cake\View\Helper;

class {$class} extends Helper
{

}
PHP;
?>
<div class="code-dump"><?php highlight_string($code) ?></div>
<?php $this->end() ?>
