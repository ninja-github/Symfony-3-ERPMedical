<?php
/* Indicamos el namespace del Bundle **************************************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Response;			// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session;	// Permite usar sesiones, usado en FLASHBAG
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
/**************************************************************************************************************/
class ClinicDocController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO EJECUCIÓN AJAX PARA ELIMINAR DOCUMENTO **************************************************************/
	public function clinicDocListAction( Request $request, $clinicNameUrl ) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
        /******************************************************************************************************/			
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$permissionDenied = false;			
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userLogged));
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para VER DOCUMENTOS ajenos a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionLoggedUser->getClinicDocList()){
				$status = [	'type'=>'danger','description'=>'No dispones de permisos suficientes para eliminar el documento.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$typeContentDoc_repo =  $em->getRepository("BackendBundle:TypeContentDoc");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/				
			$typeContentDocList =  $typeContentDoc_repo->findAll();
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:Clinic:clinicDoc_List.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'clinicView'=>$clinicView,
					'typeContentDocList'=>$typeContentDocList
				)
			);
		/******************************************************************************************************/ 
	}
}