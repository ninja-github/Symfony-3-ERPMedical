<?php
/* Indicamos el namespace del Bundle **************************************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Session\Session; // Permite usar sesiones
/**************************************************************************************************************/
class AdminController extends Controller {
/* CONSTRUCTOR ************************************************************************************************/
	/* OBJETO SESSIÓN Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session().
	/* No olvidar dar acceso al componenete de Symfony Session(), que permitirá usar los mensajes FLASHBAG
	/* use Symfony\Component\HttpFoundation\Session\Session; */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR CONTENIDO ADMIN *************************************************************************/
	public function indexAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
        /******************************************************************************************************/			
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
        /******************************************************************************************************/			
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
        /******************************************************************************************************/			
		/* PERMISO ACCESO *************************************************************************************/
			$permissionDenied = false;	
			if($permissionLoggedUser->getAdminGeneralDataAccess() == false){ 
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para acceder a la zona de Administración General.'];
					// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;			
			}
			if ($permissionDenied == true){ return $this->redirectToRoute('homepage'); }
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$user_repo = $em->getRepository("BackendBundle:User");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/			
			$users_list = $user_repo->getListTenLastUsers();
			$clinics_list = $clinic_repo->getListTenLastClinics();	
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/ 					
			return $this->render('AppBundle:Admin:admin_Index.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'clinics_list'=>$clinics_list,
					'users_list'=>$users_list
				)
			);
		/******************************************************************************************************/ 			
	}
/**************************************************************************************************************/
}