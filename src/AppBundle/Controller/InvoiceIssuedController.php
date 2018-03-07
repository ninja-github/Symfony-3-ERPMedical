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
class InvoiceIssuedController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA VER FACTURAS ***********************************************************************************/
	public function invoiceIssuedViewAction(Request $request, $clinicNameUrl, $invoiceIssuedNumber){
		/* si existe el objeto User nos rediriges a home            */
		if( !is_object($this->getUser()) ){ return $this->redirect('home'); }
		/******************************************************************************************************/
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
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
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede ver informes
			if( $permissionLoggedUser->getInvoiceIssuedView() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede ver facturas'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				$permissionDenied = true;
			};
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$invoiceIssued_repo = $em->getRepository("BackendBundle:InvoiceIssued");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrl));
			$invoiceIssued = $invoiceIssued_repo->findOneBy(array('clinic'=>$clinic, 'invoiceNumber'=>$invoiceIssuedNumber));
		/******************************************************************************************************/
		/* ARRAY TIPOS DE IVAS ********************************************************************************/
			$invoiceServiceList = $invoiceIssued->getInvoiceServiceList();
			$invoiceIssuedList = $invoiceIssued_repo->getInvoiceListOfClinic($clinicNameUrl);			
			$totalTaxService = array();
			foreach($invoiceServiceList as $invoiceService_key => $value){
				// calculos impuestos
				$idTax = $value->getTypeTaxService()->getId();
				if(!isset ($totalTaxService[$idTax]) ){
					$totalTaxService[$idTax]['percent'] = $value->getTypeTaxService()->getPercent();
					$totalTaxService[$idTax]['total'] = $value->getPrice();
				}else{
					$totalTaxService[$idTax]['total'] = $totalTaxService[$idTax]['total'] + $value->getPrice();
				}
			}
			foreach($invoiceIssuedList as $invoiceIssued_key => $value){
				// sistema next before
				$invoiceIssuedBeforeNext['clinicNameUrl'] = $clinicNameUrl;
				$next = $invoiceIssued_key + 1;
				$before = $invoiceIssued_key - 1;
				if($invoiceIssued->getId() == $value->getId() ){
					if( isset ($invoiceIssuedList[$next]) ){
						$invoiceIssuedBeforeNext['next']['invoiceIssuedNumber'] = $invoiceIssuedList[$next]->getInvoiceNumber();
					}
					if( isset($invoiceIssuedList[$before]) ){
						$invoiceIssuedBeforeNext['before']['invoiceIssuedNumber'] = $invoiceIssuedList[$before]->getInvoiceNumber();
					}
				}
			}
		/******************************************************************************************************/		
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:Invoice:invoiceIssued_View.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'invoiceIssued'=>$invoiceIssued,
					'totalTaxService'=>$totalTaxService,
					'invoiceIssuedBeforeNext'=>$invoiceIssuedBeforeNext,
					'invoiceIssuedList'=>$invoiceIssuedList
				)
			);
		/******************************************************************************************************/
	}		
/**************************************************************************************************************/
}