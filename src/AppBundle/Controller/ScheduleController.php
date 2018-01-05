<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* COMPONENTES SESSIÓN ****************************************************************************************/	
	use Symfony\Component\HttpFoundation\Session\Session;
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\UserSession;        // Da acceso a la Entidad Historia Médica
/**************************************************************************************************************/
class ScheduleController extends Controller {
	/* OBJETO SESSIÓN
	 * Para activar las sesiones inicializamos la variable e incluimos
	 * en ella el objeto Session()
	 * No olvidar dar acceso al componenete de Symfony
	 * Session() permitirá usar los mensajes FLASHBAG
	 */
	private $session;
	public function __construct(){
		$this->session = new Session();

	}
/*********************************************************************/
	public function homeAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/		
		/******************************************************************************************************/
		return $this->render('AppBundle:Schedule:schedule_Home.html.twig', 
			array (
				'request'=>$request,
				'permissionLoggedUser'=>$permissionLoggedUser
			)
		);
	}
}