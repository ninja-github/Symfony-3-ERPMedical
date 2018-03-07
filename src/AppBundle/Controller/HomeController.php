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
	use BackendBundle\Entity\Payment;        	// Da acceso a la Entidad Historia Médica
/**************************************************************************************************************/
class HomeController extends Controller {
/* CONSTRUCTOR ************************************************************************************************/
	/* OBJETO SESSIÓN Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session().
	/* No olvidar dar acceso al componenete de Symfony Session(), que permitirá usar los mensajes FLASHBAG
	/* use Symfony\Component\HttpFoundation\Session\Session; */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* INDEX ******************************************************************************************************/
	public function indexAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
		$em = $this->getDoctrine()->getManager();
		$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* USUARIO ACTIVO? ************************************************************************************/
		if($userlogged->getIsActive() == false){
			$status = ['type'=>'danger','description'=>'Usuario Bloqueado'];
			$this->session->getFlashBag()->add("status", $status);
			return $this->redirect('login');
		}
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
		$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
		$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* Correccion tablas **********************************************************************************/
		$clinicUser_repo = $em->getRepository("BackendBundle:ClinicUser");
		$idUserlogged = $userlogged->getId();
		$clinicUserlogged = $clinicUser_repo->getDataClinicUserSession($idUserlogged);
		//extraemos el resultado de la $query
		$session = $request->getSession();
		$session->set('clinicUserlogged', $clinicUserlogged);
		/******************************************************************************************************/
		return $this->render('AppBundle:Home:home.html.twig',
			array (
				'permissionLoggedUser'=>$permissionLoggedUser,
				'request'=>$request
			)
		);
	}
/**************************************************************************************************************/
}