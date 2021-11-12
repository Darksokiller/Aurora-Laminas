<?php
namespace Project;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;


class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
       
        return [
            'factories' => [
                Model\ProjectTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProjectTableGateway::class);
                    return new Model\ProjectTable($tableGateway);
                },
                Model\ProjectTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Project());
                    return new TableGateway('project', $dbAdapter, null, $resultSetPrototype);
                },
                ],
                ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController(
                        $container->get(Model\ProjectTable::class)
                        );
                },
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController(
                        $container->get(Model\ProjectTable::class)
                        );
                },
                ],
                ];
    }
}