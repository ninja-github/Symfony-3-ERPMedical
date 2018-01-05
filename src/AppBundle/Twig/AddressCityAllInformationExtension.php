<?php
/* IMPORTANTE !!!!!!
 * No olvidar incluir la extensión de TWIG dentro de 'app\config\services.yml'
 */
	namespace AppBundle\Twig;
// Activo 'RegistryInterface' para poder usar Doctrine
	use Symfony\Bridge\Doctrine\RegistryInterface;

class AddressCityAllInformationExtension extends \Twig_Extension{
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
		 * indicamos como llamaremos al filtro `AddressCityAllInformation'
		 * y que función ejecutará el filtro `getAddressCityAllInformationFilter`
		 */
		new \Twig_SimpleFilter('AddressCityAllInformation', array($this, 'getAddressCityAllInformationFilter'))
		);
	}
/**********************************************************************************/
/* FUNCIÓN FILTRO *****************************************************************/
	public function getAddressCityAllInformationFilter($AddressCityInputWithId){
		$findmeInput = "input";
		$valueInput = 'value="';
		$finalValueInput = '" />';
		if( strpos($AddressCityInputWithId,$findmeInput) && strpos($AddressCityInputWithId,$valueInput) ){
			// Extraigo el IdCity
			$valueInputLength = strlen($valueInput);
			$finalValueInputLength = strlen($finalValueInput);
			$positionInitValueInput = strpos($AddressCityInputWithId, $valueInput);
			$valueCityInput = substr($AddressCityInputWithId, $positionInitValueInput + $valueInputLength, -$finalValueInputLength);
			if( strpos($valueCityInput,',') ) {
				echo $AddressCityInputWithId;
			}else{
				// Obtengo Cp + City + Province
				$addressCity_repo = $this->doctrine->getRepository("BackendBundle:AddressCity");
				$addressCityInput = $addressCity_repo->findOneById($idCityInput);
				$cpInput = $addressCityInput->getCp();
				$cityInput = $addressCityInput->getCity();
				$provinceInput = $addressCityInput->getIdAddressProvince();
				$CityAllInformationWithOutInput = $cpInput.", ".$cityInput.", ".$provinceInput;
				$newInput = str_replace ( $idCityInput , $CityAllInformationWithOutInput , $AddressCityInputWithId );
				echo $newInput;
			}
		}elseif(strpos($AddressCityInputWithId,$findmeInput) && !strpos($AddressCityInputWithId,$valueInput)){
			echo $AddressCityInputWithId;
		}else{
			// Obtengo Cp + City + Province
			$idCityInput = $AddressCityInputWithId;
			$addressCity_repo = $this->doctrine->getRepository("BackendBundle:AddressCity");
			$addressCityInput = $addressCity_repo->findOneById($idCityInput);
			$cpInput = $addressCityInput->getCp();
			$cityInput = $addressCityInput->getCity();
			$provinceInput = $addressCityInput->getIdAddressProvince();
			$CityAllInformationWithOutInput = $cpInput.", ".$cityInput.", ".$provinceInput;
			echo $CityAllInformationWithOutInput;
		}
	}
  /*  public function getAddressCityAllInformationFilter($AddressCityInputWithId){
    $findmeInput = "input";
    $valueInput = 'value="';
    $finalValueInput = '" />';
    if( strpos($AddressCityInputWithId,$findmeInput) && strpos($AddressCityInputWithId,$valueInput) ){
      // Extraigo el IdCity
      $valueInputLength = strlen($valueInput);
      $finalValueInputLength = strlen($finalValueInput);
      $positionInitValueInput = strpos($AddressCityInputWithId, $valueInput);
      $idCityInput = substr($AddressCityInputWithId, $positionInitValueInput + $valueInputLength, -$finalValueInputLength);
      // Obtengo Cp + City + Province
      $addressCity_repo = $this->doctrine->getRepository("BackendBundle:AddressCity");
      $addressCityInput = $addressCity_repo->findOneById($idCityInput);
      $cpInput = $addressCityInput->getCp();
      $cityInput = $addressCityInput->getCity();
      $provinceInput = $addressCityInput->getIdAddressProvince();
      $CityAllInformationWithOutInput = $cpInput.", ".$cityInput.", ".$provinceInput;
      $newInput = str_replace ( $idCityInput , $CityAllInformationWithOutInput , $AddressCityInputWithId );
      echo $newInput;
    }else{
      echo $AddressCityInputWithId;
    }

  }
  */
/**********************************************************************************/
/* DEFINIMOS LA FUNCIÓN ***********************************************************/
  public function getName(){
    return 'address_city_all_information_extension';
  }
/**********************************************************************************/
}