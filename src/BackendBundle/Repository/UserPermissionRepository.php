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
 * src\BackendBundle\Resources\config\doctrine\User.orm.yml con la siguiente línea:
 * BackendBundle\Entity\User:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\UserRepository
 */
class UserPermissionRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LOS PERMISOS DEL USUARIO **************************************************************/
	public function getUserPermissionQuery($userName){
		$em=$this->getEntityManager();
		$userPermission = $this->createQueryBuilder('uP')
				->select(
					'u.userName',
					'uP.userDumpView',
					'uP.userPermission',
					'uP.medicalHistoryRegistrationDateEdit',
					'uP.medicalHistoryIdUserRegistererEdit',
					'uP.medicalHistoryModificationDateEdit',
					'uP.medicalHistoryIdUserModifierEdit',
					'uP.orthopodologyHistoryRegistrationDateEdit',
					'uP.orthopodologyHistoryIdUserRegistererEdit',
					'uP.orthopodologyHistoryModificationDateEdit',
					'uP.orthopodologyHistoryIdUserModifierEdit'
				)
				->innerJoin('uP.idUser', 'u', 'u.id = uP.idUser')
				->where('u.userName =:userName')
				->setParameter('userName', $userName)
				->getQuery()
				->getSingleResult();
		return $userPermission;
	}
/*************************************************************************************************/
}

