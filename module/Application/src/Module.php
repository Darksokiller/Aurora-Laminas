<?php

declare(strict_types=1);

namespace Application;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Session;
class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
//     public function getServiceConfig()
//     {
//         return array(
//             'factories' => array(                                
//                     'SessionManager::class' => function ($container) {
//                     $config = $container->get('config');
//                     $session = $config['session'];
//                     $sessionConfig = new $session['config']['class']();
//                     $sessionConfig->setOptions($session['config']['options']);
//                     $sessionManager = new Session\SessionManager(
//                         $sessionConfig,
//                         new $session['storage'](),
//                         null
//                         );
//                     \Laminas\Session\Container::setDefaultManager($sessionManager);
                    
//                     return $sessionManager;
//                 },
                
//                 )
//             );
//     }
    
//     public function onBootstrap($e)
//     {
//         $this->bootstrapSession($e);
//     }
    
//     public function bootstrapSession($e)
//     {
//         $serviceManager = $e->getApplication()->getServiceManager();
//         $session = $serviceManager->get(SessionManager::class);
        
//         try {
//             $session->start();
//             $container = new Session\Container('initialized');
//         } catch (\Laminas\Session\Exception\RuntimeException $e) {
//             //session has expired
//             return;
//         }
        
//         //let�s check if our session is not already created (for the guest or user)
//         if (isset($container->init)) {
//             return;
//         }
        
//         //new session creation
//         $request = $serviceManager->get('Request');
//         $session->regenerateId(true);
//         $container->init = 1;
//         $container->remoteAddr = $request->getServer()->get('REMOTE_ADDR');
//         $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
//         $config = $serviceManager->get('Config');
//         $sessionConfig = $config['session'];
//         $chain = $session->getValidatorChain();
        
//         foreach ($sessionConfig['validators'] as $validator) {
//             switch ($validator) {
//                 case Validator\HttpUserAgent::class:
//                     $validator = new $validator($container->httpUserAgent);
//                     break;
//                 case Validator\RemoteAddr::class:
//                     $validator = new $validator($container->remoteAddr);
//                     break;
//                 default:
//                     $validator = new $validator();
//             }
//             $chain->attach('session.validate', array($validator, 'isValid'));
//         }
//     }
}
