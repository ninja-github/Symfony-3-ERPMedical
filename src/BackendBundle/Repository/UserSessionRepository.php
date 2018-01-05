<?php
namespace BackendBundle\Repository;
/*
 * Un EntityRepository sirve como un repositorio para entidades con métodos genéricos y
 * específicos del negocio para recuperar entidades.
 * Esta clase está diseñada para herencia y los usuarios pueden clasificar esta clase para
 * escribir sus propios repositorios con métodos específicos de negocios para ubicar entidades.
 */
use Doctrine\ORM\EntityRepository;
/* COMPONENTES SESSIÓN ****************************************************************************************/	
	use Symfony\Component\HttpFoundation\Session\Session;
/**************************************************************************************************************/
	use Symfony\Component\Validator\Constraints\DateTime;
/*
 * REPOSITORY
 * Es necesario definir el repositorio dentro del ORM, en este caso en
 * src\BackendBundle\Resources\config\doctrine\UserSession.orm.yml con la siguiente línea:
 * BackendBundle\Entity\UserSession:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\UserSessionRepository
 */
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\UserSession;        // Da acceso a la Entidad Historia Médica
/**************************************************************************************************************/
class UserSessionRepository extends \Doctrine\ORM\EntityRepository {
	public function getUserSessionList($createSession, $idUser){
		$em=$this->getEntityManager();
		$userSession_repo = $em->getRepository("BackendBundle:UserSession");
		$userSession = $userSession_repo->findOneBy(
			array(
				'datetime' => $createSession,
				'user' => $idUser
			)
		);
		return $userSession;
	}
/* CARGA EL INICIO DE SESSION EN LA BASE DE DATOS *************************************************************/
	public function setUserInformation($user, $request){
		$em=$this->getEntityManager();
		// Extraigo el DateTime de inicio de sessión, y lo convierto a fecha
		$createSession_unixFormat = $request->getSession()->getMetadataBag()->getCreated() ;
		$createSession_dateFormat_string = gmdate("Y-m-d H:i:s", $createSession_unixFormat);
		$createSession = new \DateTime( $createSession_dateFormat_string );
		$idUser= $user->getId();
		$userSession_repo = $em->getRepository("BackendBundle:UserSession");
		$userSession = $userSession_repo->getUserSessionList($createSession, $idUser);
		$userSession_isset = count ( $userSession );
		$userSession = new UserSession();
		$userSession->setUser($user);
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else { 
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		$userSession->setIp($ip);		
		if($userSession_isset == 0){ 
			$userSession->setDatetime($createSession);
			$userSession->setPathInfo('/login');
			$em->persist($userSession);
			$flush = $em->flush();
		}else{
			$lastUsedSession_unixFormat = $request->getSession()->getMetadataBag()->getLastUsed();
			$lastUsedSession_dateFormat_string = gmdate("Y-m-d H:i:s", $lastUsedSession_unixFormat);
			$lastUsedSession = new \DateTime( $lastUsedSession_dateFormat_string );
			$userSession->setDatetime($lastUsedSession);
			$pathInfo = $request->getPathInfo() ;
			//$controller = $request->attributes->get('_controller') ;
			$userSession->setPathInfo($pathInfo);					
		}
		// persistimos los datos dentro de Doctrine
		$em->persist($userSession);
		// guardamos los datos persistidos dentro de la BD
		$flush = $em->flush();
	}
/**************************************************************************************************************/
}
