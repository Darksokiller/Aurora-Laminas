<?php
namespace User;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
// use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
// use Laminas\Db\Sql\Sql;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use User\Model\User;
use User\Model\UserTable;
use User\Model\Profile;
use User\Model\ProfileTable;
use User\Model\RolesTable;
use Application\Event\LogEvents;
use Application\Model\RowGateway\ApplicationRowGateway;



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
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User('id','user', $dbAdapter));
                    return new Model\UserTable('user', $dbAdapter, null, $resultSetPrototype);
                },
                Model\ProfileTable::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Profile('id', 'user_profile', $dbAdapter));
                    return new Model\ProfileTable('user_profile', $dbAdapter, null, $resultSetPrototype);
                },
                Model\RolesTable::class => function($container) {
                  $dbAdapter = $container->get(AdapterInterface::class);
                  $resultSetPrototype = new ResultSet();
                  $resultSetPrototype->setArrayObjectPrototype(new ApplicationRowGateway('id', 'user_roles', $dbAdapter));
                  return new Model\RolesTable('user_roles', $dbAdapter, null, $resultSetPrototype);
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