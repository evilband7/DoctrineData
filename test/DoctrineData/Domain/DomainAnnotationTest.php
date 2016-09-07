<?php
namespace DoctrineData\Domain;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
class DomainAnnotationTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAnnotation(){
        define('MK_DOCTRINE_SPRING_DATA\AUDITABLE\USER_CLASS', 'user');
        define('MK_DOCTRINE_SPRING_DATA\AUDITABLE\USER_ID', 'user_id');
        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();
        $clazz = new \ReflectionClass(AbstractAuditable::class);
        $properties = $clazz->getProperties();
        foreach ($properties as $property){
            $reader->getPropertyAnnotations($property);
        }
    }
}

?>