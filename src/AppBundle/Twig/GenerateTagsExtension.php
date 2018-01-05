<?php
/* IMPORTANTE !!!!!!
 * No olvidar incluir la extensión de TWIG dentro de 'app\config\services.yml'
 */
namespace AppBundle\Twig;
// Activo 'RegistryInterface' para poder usar Doctrine
use Symfony\Bridge\Doctrine\RegistryInterface;

class GenerateTagsExtension extends \Twig_Extension{
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
      new \Twig_SimpleFilter('GenerateTags', array($this, 'generateTagsFilter'))
    );
  }
/**********************************************************************************/
/* FUNCIÓN FILTRO *****************************************************************/
  public function generateTagsFilter($arrayTags){
    $listTags ="";
    if( isset($arrayTags) ){
      foreach ($arrayTags as $idTag => $tag ){
        $listTags = $listTags.'<span class="tag " style="background:red;" >'.$tag.'</span>';
      }
      echo $listTags;
    }else{
      echo NULL;
    }
    
  }
/**********************************************************************************/
/* DEFINIMOS LA FUNCIÓN ***********************************************************/
  public function getName(){
    return 'generate_tags_extension';
  }
/**********************************************************************************/
}