<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerQ5MT6hI\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerQ5MT6hI/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerQ5MT6hI.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerQ5MT6hI\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerQ5MT6hI\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'Q5MT6hI',
    'container.build_id' => 'f97db214',
    'container.build_time' => 1575554388,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerQ5MT6hI');
