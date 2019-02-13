<?php

/**
 * @package Framework
 *
 * Foreach glob & require each file in the functions/ directory
 */
foreach (glob(dirname(__FILE__) . '/functions/*.php') as $filename) {
    require $filename;
}
