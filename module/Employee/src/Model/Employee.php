<?php  
namespace Employee\Model;  

// Add these import statements 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface;  

class Employee implements InputFilterAwareInterface { 
   public $id; 
   public $emp_name; 
   public $emp_job; 
   protected $inputFilter;                         
   public function exchangeArray($data) { 
      $this->id = (isset($data['id'])) ? $data['id'] : null;         
      $this->emp_name = (isset($data['emp_name'])) ? $data['emp_name'] : null;         
      $this->emp_job = (isset($data['emp_job']))  ? $data['emp_job'] : null; 
   }  
    
   // Add content to these methods:
   public function setInputFilter(InputFilterInterface $inputFilter) { 
      throw new \Exception("Not used"); 
   }  
   public function getInputFilter() { 
      if (!$this->inputFilter) { 
         $inputFilter = new InputFilter();  
         $inputFilter->add(array( 
            'name' => 'id', 
            'required' => true, 
            'filters' => array( 
               array('name' => 'Int'), 
            ), 
         ));  
         $inputFilter->add(array( 
            'name' => 'emp_name', 
            'required' => true, 
            'filters' => array( 
               array('name' => 'StripTags'), 
               array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
               array('name' => 'StringLength', 
                        'options' => array( 
                           'encoding' => 'UTF-8', 
                           'min' => 1, 
                           'max' => 50, 
                        ), 
                    ), 
                ), 
            ));
         $inputFilter->add(array( 
            'name' => 'emp_job', 
            'required' => true, 
            'filters' => array( 
               array('name' => 'StripTags'),  
               array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
               array('name' => 'StringLength', 
                  'options' => array( 
                     'encoding' => 'UTF-8', 
                     'min' => 1, 
                     'max' => 50, 
                  ), 
                  ), 
               ), 
         ));  
         $this->inputFilter = $inputFilter; 
      } 
      return $this->inputFilter; 
   } 
   public function getArrayCopy() { 
   	return get_object_vars($this); 
   }
}             