<?php
/* IMPORTANTE !!!!!!
 * No olvidar incluir la extensión de TWIG dentro de 'app\config\services.yml'
 */
namespace AppBundle\Twig;
// Activo 'RegistryInterface' para poder usar Doctrine
use Symfony\Bridge\Doctrine\RegistryInterface;

class JsonDecodeExtension extends \Twig_Extension{
/* CARGAMOS DOCTRINE **************************************************************/
  // Para usar 'Doctrine' necesiatmos de 'RegistryInterface'
  protected $doctrine;

  public function __construct(RegistryInterface $doctrine){
    $this->doctrine = $doctrine;
  }
/**********************************************************************************/
/* DEFINIMOS NOMBRE DEL FILTRO + FUNCIÓN FILTRO ***********************************/
  public function getFilters(){
    return array(
      /*
       * indicamos como llamaremos al filtro `GenerateTags'
       * y que función ejecutará el filtro `generateTagsFilter`
       */
      new \Twig_SimpleFilter('JsonDecode', array($this, 'JsonDecodeFilter'))
    );
  }
/**********************************************************************************/
/* FUNCIÓN FILTRO *****************************************************************/
  public function jsonDecodeFilter($jsonArray){
  	if(is_string($jsonArray)){
		$array = json_decode($jsonArray,true);
  	}else{
  		$array = null;
  	}
	return $array;
  }
/**********************************************************************************/
/* DEFINIMOS LA FUNCIÓN ***********************************************************/
  public function getName(){
    return 'json_decode_extension';
  }
/**********************************************************************************/
}