<?php
namespace Employee;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface {
   public function getConfig() {
      return include __DIR__ . '/../config/module.config.php';
   }
   public function getServiceConfig() {
      return [
         'factories' => [
            Model\EmployeeTable::class => function ($container) {
               $tableGateway = $container->get(Model\EmployeeTableGateway::class);
               $table = new Model\EmployeeTable($tableGateway);
               return $table;
            },
            Model\EmployeeTableGateway::class => function ($container) {
               $dbAdapter = $container->get(AdapterInterface::class);
               $resultSetPrototype = new ResultSet();
               $resultSetPrototype->setArrayObjectPrototype(new Model\Employee());
               return new TableGateway('employee', $dbAdapter, null, $resultSetPrototype);
            },
         ],
      ];
   }
}