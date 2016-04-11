<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/[page/:page]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                        'module'     => 'application',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        'controller'    => 'Index',
                        'action'        => 'index',
                        '__NAMESPACE__' => 'Application\Controller',
                        'module'     => 'application'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array( //permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'Doctrine\ORM\EntityManager' => function($sm) {
				$config = $sm->get('Configuration');
				$doctrineConfig = new \Doctrine\ORM\Configuration();
				$cache = new $config['doctrine']['driver']['cache'];
				$doctrineConfig->setQueryCacheImpl($cache);
				$doctrineConfig->setProxyDir('/tmp');
				$doctrineConfig->setProxyNamespace('EntityProxy');
				$doctrineConfig->setAutoGenerateProxyClasses(true);
				$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
					new \Doctrine\Common\Annotations\AnnotationReader(),
					array($config['doctrine']['driver']['paths'])
				);
				$doctrineConfig->setMetadataDriverImpl($driver);
				$doctrineConfig->setMetadataCacheImpl($cache);
				\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
					getenv('PROJECT_ROOT'). '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
				);
				$em = \Doctrine\ORM\EntityManager::create(
					$config['doctrine']['connection'],
					$doctrineConfig
				);
				return $em;
		
			},
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index'     => 'Application\Controller\IndexController',
            'Application\Controller\Questao'   => 'Application\Controller\QuestaoController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'strategies' => array(
            'ViewJsonStrategy',
    ),
    'doctrine' => array(
		'driver' => array(
			'cache' => 'Doctrine\Common\Cache\ArrayCache',
			'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Model')
		),
	)
);
