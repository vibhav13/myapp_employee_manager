<?php  
namespace Employee\Model;  
use Zend\Db\TableGateway\TableGatewayInterface;  
class EmployeeTable { 
   protected $tableGateway; 
   public function __construct(TableGatewayInterface $tableGateway) { 
      $this->tableGateway = $tableGateway; 
   }
   public function fetchAll() { 
      $resultSet = $this->tableGateway->select();  
      return $resultSet; 
   }
   public function getEmployee($id) { 
   $id  = (int) $id; 
   $rowset = $this->tableGateway->select(array('id' => $id)); 
   $row = $rowset->current();  
   if (!$row) { 
      throw new \Exception("Could not find row $id"); 
   }
   return $row; 
}  
   public function saveEmployee(Employee $employee) { 
	   $data = array (  
	      'emp_name' => $employee->emp_name, 
	      'emp_job'  => $employee->emp_job, 
	   );  
	   $id = (int) $employee->id; 
	   if ($id == 0) { 
	      $this->tableGateway->insert($data); 
	   } else { 
	      if ($this->getEmployee($id)) { 
	         $this->tableGateway->update($data, array('id' => $id)); 
	      } else { 
	         throw new \Exception('Employee id does not exist'); 
	      } 
	   } 
    }
    public function deleteEmployee($id) { 
 	  $this->tableGateway->delete(['id' => (int) $id]); 
	} 
}    