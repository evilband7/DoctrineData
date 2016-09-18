# DoctrineData
Extends doctrine repository feature with pagination support. (Inspired from SpringData project.)

# Feature
- Create your own Repository class without implementation (Interface Only)
- Also support custom implementation. 
- Support Pagination with strong type pagination stubs (DoctrineData\Pagination\\*)
- Make Doctrine2 Repository more stronger.
- Didn't support Doctrine2 Magic Method by default (You need to define that method in an Interface. Because we focus on maintenance. how should people know which magic method currently used on a project.)

# Status
- Under development.
- Will be available soon.
- Feel free to fork and submit pull request. xD

# Basic Repository Interface
    
     interface EmployeeRepository extends DoctrineDataRepositoryInterface
     {
        /** @Query("select e from Employee e where e.name = ?1") */
        public function findByDepartmentId(int $departmentId, PageableInterface $pageable);
     }
     
     /* @var $repository EmployeeRepository */
     /* @var $page PageInterface */
     
     $pageRequest = new PageRequest(1,10);
     $repository = $em->getRepository(Employee::class);     
     $page = $repository->findByDepartmentId(1, $pageRequest);
     
     foreach($page as $emp){
        echo 'Name: ' . $emp->getName() ;
     }
     