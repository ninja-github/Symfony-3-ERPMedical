<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Response;			// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session;	// Permite usar sesiones, usado en FLASHBAG
	use Symfony\Component\Validator\Constraints\DateTime;
/* Añadimos las ENTIDADES que usaremos ************************************************************************/	

/* Añadimos los FORMULARIOS que usaremos **********************************************************************/

/**************************************************************************************************************/
class InvoiceController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR INFORMES ********************************************************************************/
	public function invoiceListAction(Request $request, $clinicNameUrl = null){
		/* si existe el objeto User nos rediriges a home            */
		if( !is_object($this->getUser()) ){ return $this->redirect('home'); }
		/******************************************************************************************************/
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('homepage');
			};
			// El usuario puede listar informes
			if( $permissionLoggedUser->getInvoiceList() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede listar facturas.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				return $this->redirectToRoute('homepage');
			};
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$invoice_repo = $em->getRepository("BackendBundle:Invoice");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$invoiceList = $invoice_repo->getInvoiceListOfClinic($clinicNameUrl);
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:Invoice:invoice_List.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'invoiceList'=>$invoiceList
				)
			);
		/******************************************************************************************************/		
	}
/**************************************************************************************************************/
}