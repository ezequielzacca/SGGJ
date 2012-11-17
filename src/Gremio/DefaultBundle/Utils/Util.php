<?php

namespace Gremio\DefaultBundle\Utils;

Class Util{
    private $doctrine;
    
    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function getMargen($socio){
        $em = $this->doctrine->getEntityManager();
        
        $margen = $em->getRepository('GremioAbmBundle:Socio')->calcularMargen($socio->getId());
        
            
            $margen = $margen[0]['margen'];
            if(!$margen){
                $margen = $socio->getMargen();
            }
        
        return $margen;
        
    }
    
    /**
     * Modifies a string to remove all non ASCII characters and spaces.
     */
    static public function slugify($text)
    {
    	// replace non letter or digits by -
    	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    
    	// trim
    	$text = trim($text, '-');
    
    	// transliterate
    	if (function_exists('iconv'))
    	{
    		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    	}
    
    	// lowercase
    	$text = strtolower($text);
    
    	// remove unwanted characters
    	$text = preg_replace('~[^-\w]+~', '', $text);
    
    	if (empty($text))
    	{
    		return 'n-a';
    	}
    
    	return $text;
    }
    
    
}


