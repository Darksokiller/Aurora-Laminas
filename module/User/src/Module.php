<?php
namespace User;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
use Laminas\Db\Sql\Sql;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use User\Model\User;
use User\Model\UserTable;
use User\Model\Profile;
use User\Model\ProfileTable;
use Application\Event\LogEvents;
use User\Model\UserRowGateway as RowGateway;


class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function onBootstrap($e) {}
    public function getServiceConfig()
    {
       
        return [
            'factories' => [
                Model\UserTable::class => function($container) {
                    //$tableGateway = $container->get(Model\UserTableGateway::class);
                    $dbAdapter = $container->get(AdapterInterface::class);
                   // $logger = $container->get('Laminas\Log\Logger');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\User($dbAdapter));
                   // return new Model\UserTable('user', $dbAdapter, new RowGatewayFeature('id'));
                    return new Model\UserTable('user', $dbAdapter, null, $resultSetPrototype);
                },
//                 Model\UserTableGateway::class => function ($container) {
//                     $dbAdapter = $container->get(AdapterInterface::class);
//                     $resultSetPrototype = new ResultSet();
//                     $resultSetPrototype->setArrayObjectPrototype(new Model\User());
//                     return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
//                 },
                Model\ProfileTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProfileTableGateway::class);
                    return new Model\ProfileTable($tableGateway, null, $container->get('Laminas\Log\Logger'));
                },
                Model\ProfileTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Profile());
                    return new TableGateway('user_profile', $dbAdapter, null, $resultSetPrototype);
                },
                ],
                ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\UserController::class => function($container) {
                    return new Controller\UserController(
                        $container->get(Model\UserTable::class)
                        );
                },
                Controller\ProfileController::class => function($container) {
                    return new Controller\ProfileController(
                        $container->get(Model\UserTable::class)
                        );
                },
                Controller\RegisterController::class => function($container) {
                    return new Controller\RegisterController(
                        $container->get(Model\UserTable::class)
                        );
                },
                Controller\AdminController::class => function($container) {
                    return new Controller\AdminController(
                        $container->get(Model\UserTable::class)
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