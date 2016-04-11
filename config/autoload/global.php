<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
			),
		),
	'db' => array(
		'driver' => 'Pdo',
		'dsn' => 'mysql:dbname=quiz_coopavel;host=castanha.cnpso.embrapa.br',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),
	'doctrine' => array(
		'connection' => array(
			'driver' 	=> 'pdo_mysql',
            'charset'   => 'UTF8',
			'host'		=> 'castanha.cnpso.embrapa.br',
			'port'		=> '3306',
			'user'		=> 'root',
			'password'	=> 'temp10',
			'dbname'	=> 'quiz_coopavel'
		)
	),
	'acl' => array(
		'roles' => array(
			'guest' => null,
		),
		'resources' => array(
                    'Application\Controller\Index.index',
                    'Application\Controller\Questao.buscar',
		),
		'privilege' => array(
                    'guest' => array(
                        'allow' => array(
                            'Application\Controller\Index.index',
                    		'Application\Controller\Questao.buscar',
		)
                    ),
                )
            )
);
