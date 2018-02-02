<?php
namespace BackendBundle\Repository;
/*
 * Un EntityRepository sirve como un repositorio para entidades con métodos genéricos y
 * específicos del negocio para recuperar entidades.
 * Esta clase está diseñada para herencia y los usuarios pueden clasificar esta clase para
 * escribir sus propios repositorios con métodos específicos de negocios para ubicar entidades.
 */
use Doctrine\ORM\EntityRepository;
/*
 * REPOSITORY
 * Es necesario definir el repositorio dentro del ORM, en este caso en
 * src/BackendBundle/Resources/config/doctrine/AddressCity.orm.yml con la siguiente línea:
 * BackendBundle\Entity\AddressCity:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\AddressCityRepository
 */
class AddressCityRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE TODA LA INFORMACIÓN DE CIUDAD A PARITR DEL ID *****************************************/
	public function extractCity($cityId){
		$em=$this->getEntityManager()->getConnection();
		$query="SELECT *
				FROM `address_city`
				INNER JOIN `address_province` ON address_city.id_address_province = address_province.id
				INNER JOIN `address_ccaa` ON address_province.id_address_ccaa = address_ccaa.id
				WHERE address_city.id=$cityId
				ORDER BY address_city.cp";
		/*$query="SELECT address_city.id, address_city.cp , address_city.city, address_province.province, address_ccaa.ccaa FROM `address_city` INNER JOIN `address_province` ON address_city.id_address_province = address_province.id INNER JOIN `address_ccaa` ON address_province.id_address_ccaa = address_ccaa.id WHERE address_city.id=$cityId ORDER BY address_city.cp";*/
		$stmt = $em->prepare($query);
		$params = array();
		$stmt->execute($params);
		$qb = $stmt->fetchAll();
		return $qb;
	}
/*************************************************************************************************/
/* OBTIENE TODA LA INFORMACIÓN DE CIUDAD A PARTIR DEL ID *****************************************/
	public function extractAllCities($cityId){
		$em=$this->getEntityManager()->getConnection();
		$query="SELECT address_city.id, address_city.cp , address_city.city, address_province.province, address_ccaa.ccaa
				FROM `address_city`
				INNER JOIN `address_province` ON address_city.id_address_province = address_province.id
				INNER JOIN `address_ccaa` ON address_province.id_address_ccaa = address_ccaa.id
				WHERE address_city.id =:cityId
				ORDER BY address_city.cp";
		$stmt = $em->prepare($query);
		$params = array('cityId'=>$addressCity);
		$stmt->execute($params);
		$po=$stmt->fetchAll();
		return $po;
	}
/*************************************************************************************************/
/* OBTIENE EL ID DE LA CIUDAD A PARTIR DE TODA LA INFORMACIÓN ************************************/
	public function idCityExtractAllInformation($allInformationCity){
		$allInformationCity = trim($allInformationCity);
		if($allInformationCity != ""){
			$array = explode(", ", $allInformationCity);
			$numData = count($array);
			if($numData === 3){
				$cp = $array[0];
				$city = $array[1];
				$province = $array[2];
				$id=NULL;
			}else {
				$id=NULL;
			}
			$em=$this->getEntityManager()->getConnection();
			$query="SELECT address_city.id FROM `address_city` WHERE address_city.cp =:cp AND address_city.city =:city";
			$stmt = $em->prepare($query);
			if ( isset($cp) && isset($city) ){
				$params = array('cp'=>$cp,'city'=>$city );
				$stmt->execute($params);
				$id=$stmt->fetchAll();
				return $id[0]['id'];
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
/*************************************************************************************************/
/* EXTRAE TODAS LAS COINCIDENCIAS DENTRO DE LA BASE DE DATOS *************************************/
	public function searchCity($cityInformation){
		$em = $this->getEntityManager()->getConnection();
		$query = "SELECT address_city.id, address_city.cp , address_city.city, address_province.province
				FROM `address_city`
				INNER JOIN `address_province` ON address_city.province = address_province.id
				WHERE address_city.cp
				LIKE :city
				OR address_city.city
				LIKE :city
				OR address_province.province
				LIKE :city
				ORDER BY address_city.cp";
		$stmt = $em->prepare($query);
		$params = array('city'=> "%".$cityInformation."%");
		$stmt->execute($params);
		$result = $stmt->fetchAll();
		$newResult = array();
		foreach($result as $city => $data) {
			$newResult[$city] = $data['cp'].', '.$data['city'].', '.$data['province'];
		}
/*		$list = '<ul id="city-list" style="width:80%;z-index:3;top:37px;">';
	  	foreach($result as $city) {
	  		$data = $city['cp'].', '.$city['city'].', '.$city['province'];
	  		$list = $list .'<li>'.$data.'</li>';
	  	}
	  	$list = $list .'</ul>';
*/
		// Para usar el método response es necesario cargar el componente
		return $newResult ;
	}
/*************************************************************************************************/
}