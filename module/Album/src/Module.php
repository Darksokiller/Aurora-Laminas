<?php
namespace Album;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Filter\FilterProviderInterface;
// testing 
use Laminas\Db\TableGateway\Feature\FeatureSet;
use Laminas\Db\TableGateway\Feature\RowGatewayFeature;


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
                Model\AlbumTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    //$featureSet = new \Laminas\Db\RowGateway\Feature\FeatureSet();
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                    //return new TableGateway('album', $dbAdapter, new RowGatewayFeature('id'));
                },
                ],
                ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function($container) {
                    return new Controller\AlbumController(
                        $container->get(Model\AlbumTable::class)
                        );
                },
                ],
                ];
    }
    public function getFilterConfig()
    {
        return [
            'factories' => [
                Filter\PasswordFilter::class => function($container) {
                    return new Filter\PasswordFilter(
                        $container->get(Filter\PasswordFilter::class)
                        );
                },
                ],
                ];
    }
}