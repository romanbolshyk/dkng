<?php
$pluginDir = dirname(dirname(__FILE__));
$namespaceDirectories = [
    'Dkng\\Wp' => 'src'
];
spl_autoload_register(function ($class) use ($namespaceDirectories, $pluginDir) {
    foreach ($namespaceDirectories as $namespace => $directory) {
        if (strpos($class, $namespace) === 0) {
            $filePath = $pluginDir . '/' . str_replace([$namespace, '\\'], [$directory, '/'], $class) . '.php';
            require_once $filePath;
            break;
        }
    }
});