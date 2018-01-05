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
 * src\BackendBundle\Resources\config\doctrine\Clinic.orm.yml con la siguiente línea:
 * BackendBundle\Entity\Clinic:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\ClinicRepository
 */
class ClinicRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LAS ÚLTIMAS DIEZ CLÍNICAS *************************************************************/
	public function getListTenLastClinics(){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('cl')
				->orderBy('cl.modificationDate', 'DESC')
				->setMaxResults(10)
				->getQuery();
		$listTenLastClinics = $query->getResult();
		return $listTenLastClinics;
	}
/*************************************************************************************************/
}