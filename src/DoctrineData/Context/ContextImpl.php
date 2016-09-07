<?php
namespace DoctrineData\Context;

use Doctrine\Common\Cache\Cache;
use DoctrineData\Resolver\NamingResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use DoctrineData\Resolver\DefaultNamingResolver;
use DoctrineData\Repository\DoctrineDataRepositoryImpl;
use Doctrine\Common\Cache\ArrayCache;
use Zend\Stdlib\AbstractOptions;
class ContextImpl implements ContextInterface
{
    /**
     * @var ContextConfigOptions
     */
    private $config;
    
    /**
     * @var Cache
     */
    private $cache;
    
    private $isInitialize = false;
    
    /**
     * @var NamingResolverInterface
     */
    private $defaultNamingResover;
    
    public function __construct($config, $cache=null){
        if (! $config instanceof  ContextConfigOptions ) $config = new ContextConfigOptions($config);
        $this->config = config;
//         if ( !$cache instanceof Cache ) $cache = new ArrayCache();
//         $this->cache = $cache;
        $this->defaultNamingResover = new DefaultNamingResolver($config->getRepositoryInterfacePostfix(), $config->getRepositoryImplPostfix());
    }
    
    public function getRepository(EntityManagerInterface $entityManager, $entityName)
    {
        $clazz = $this->namingResolver->resolveRepositoryImplementationName($this->namingResolver->resolveRepositoryInterfaceName($entityName));
        if (class_exists($clazz)){
            $clazz = '\\'.$clazz;
            return new $clazz($entityManager, $entityManager->getClassMetadata($entityName));
        }else{
            return new DoctrineDataRepositoryImpl($entityManager, $entityManager->getClassMetadata($entityName));
        }        
    }

    
    
    /* public function initialize(){
        //TODO
        throw new \Exception('THis method is unimplemented or under development');
        if ($isInitialize) return;
        
        try{
            
            $repositoryDirectories = $this->config->getRepositoryDirectories();
            $moduleDirs = glob( $repositoryDirectories , GLOB_);
            
            $this->isInitialize = true;
        }catch (\Exception $e){
            throw $e;
        }
    } */
    
    /* private function xxx( array $repositoryDirectories){
        foreach ($repositoryDirectories as $dir){
            $dir = rtrim($dir, '/\\');
            $files = glob("/path/to/directory/*.{php}", GLOB_BRACE);
            foreach ($files as $file){
                if ( is_dir($file) ) continue;
                $namespaces = $this->getClassesInFile($file);
                foreach ($namespaces as $nsArray){
                    $ns = $nsArray['namespace'];
                    $classes = $nsArray['classes'];
                    foreach ($classes as $class){
                        
                    }
                }
            }
        }
    } */
    
     
    /**
     * 
     * Looks what classes and namespaces are defined in that file and returns the first found
     * @param String $file Path to file
     * @return Returns NULL if none is found or an array with namespaces and classes found in file
     */
    /* private function getClassesInFile($file)
    {

        $classes = $nsPos = $final = array();
        $foundNS = FALSE;
        $ii = 0;

        if (!file_exists($file)) return NULL;

        $er = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE);

        $php_code = file_get_contents($file);
        $tokens = token_get_all($php_code);
        $count = count($tokens);

        for ($i = 0; $i < $count; $i++) 
        {
            if(!$foundNS && $tokens[$i][0] == T_NAMESPACE)
            {
                $nsPos[$ii]['start'] = $i;
                $foundNS = TRUE;
            }
            elseif( $foundNS && ($tokens[$i] == ';' || $tokens[$i] == '{') )
            {
                $nsPos[$ii]['end']= $i;
                $ii++;
                $foundNS = FALSE;
            }
            elseif ($i-2 >= 0 && $tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) 
            {
                if($i-4 >=0 && $tokens[$i - 4][0] == T_ABSTRACT)
                {
                    $classes[$ii][] = array('name' => $tokens[$i][1], 'type' => 'ABSTRACT CLASS');
                }
                else
                {
                    $classes[$ii][] = array('name' => $tokens[$i][1], 'type' => 'CLASS');
                }
            }
            elseif ($i-2 >= 0 && $tokens[$i - 2][0] == T_INTERFACE && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING)
            {
                $classes[$ii][] = array('name' => $tokens[$i][1], 'type' => 'INTERFACE');
            }
        }
        error_reporting($er);
        if (empty($classes)) return NULL;

        if(!empty($nsPos))
        {
            foreach($nsPos as $k => $p)
            {
                $ns = '';
                for($i = $p['start'] + 1; $i < $p['end']; $i++)
                    $ns .= $tokens[$i][1];

                $ns = trim($ns);
                $final[$k] = array('namespace' => $ns, 'classes' => $classes[$k+1]);
            }
            $classes = $final;
        }
        return $classes;
    } */
    
}

?>