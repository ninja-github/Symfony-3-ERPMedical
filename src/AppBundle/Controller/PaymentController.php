<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Response;  		// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session; 	// Permite usar sesiones, usado en FLASHBAG
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\TracingService;		// Da acceso a la Entidad Historia Médica
	use BackendBundle\Entity\Payment;		// Da acceso a la Entidad Historia Médica
/**************************************************************************************************************/
class PaymentController extends Controller{
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
/**************************************************************************************************************/
/* MÉTODO AJAX ELIMINAR PAYMENT *******************************************************************************/
	public function removePaymentAction(Request $request) {
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
			if($permissionLoggedUser->getPaymentRemove() == false ){
			$response =
				'<div class="alert alert-danger fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					No dispone de permisos
				</div>';
			}
		/******************************************************************************************************/
		if($permissionLoggedUser->getTracingServiceRemove() == true ){
			// Guardamos dentro de la variable $cityInformation el dato que nos llega por POST
			$idPayment = (integer) $request->get('id');
			// Busco dentro de la BD el dato
			$em = $this->getDoctrine()->getManager();
			$payment = $em->getRepository('BackendBundle:Payment')->findOneById($idPayment);
			$em->remove($payment);
			// persistimos la eliminación dentro de la bD
			$flush = $em->flush();
	//		return new Response(json_encode($result)); // codificamos la respuesta en JSON
			if($flush == null){
				$response =
					'<div class="alert alert-success fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						El servicio se ha eliminado
					</div>';
			}else{
				$response =
					'<div class="alert alert-success fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						El servicio no se ha eliminado
					</div>';
			}
		}
		return new Response($response);
	}
/**************************************************************************************************************/
/* MÉTODO AJAX AÑADIR NUEVO PAGO ******************************************************************************/
	public function addPaymentTracingServiceAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* GUARDAMOS LOS VALORES DE ENTRADA *******************************************************************/
			$idTracing = (integer) $request->get('id');
			$idTracingService = (integer) $request->get('tracingService');
			$valuePayment = (integer) $request->get('valuePayment');
			$idValuePaymentType =  (integer) $request->get('valuePaymentType');
		/******************************************************************************************************/
		/* CARGO REPOSITORIOS *********************************************************************************/					
			$tracing_repo = $em->getRepository('BackendBundle:Tracing');
			$tracingService_repo = $em->getRepository('BackendBundle:TracingService'); 
			$service_repo = $em->getRepository('BackendBundle:Service');
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS ******************************************************************************/				
			$tracing = $tracing_repo->findOneById($idTracing);
			$tracingServiceParent = $tracingService_repo->findOneById($idTracingService);
			$registrationDate = $tracing->getDate();
			$service = $service_repo->findOneById($idValuePaymentType);
		/******************************************************************************************************/
		/* Guardamos el pago **********************************************************************************/
			$payment = new Payment();
			$payment->setTracing($tracing);
			$payment->setService($service);
			$payment->setCountable(true);
			$payment->setConsolidated(false);
			$payment->setDescription(NULL);
			$payment->setPayment($valuePayment);
			$payment->setTracingService($tracingServiceParent);			
			$payment->setUser($userlogged);
			$payment->setDate($registrationDate);
			// persistimos los datos dentro de Doctirne
			$em->persist($payment);
			// guardamos los datos persistidos dentro de la BD
			$flush = $em->flush();
		/******************************************************************************************************/
		/******************************************************************************************************/		
		//		return new Response(json_encode($result)); // codificamos la respuesta en JSON
		if($flush == null){
			$response =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El pago se almacenó correctamente.
				</div>';
		}else{
			$response =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El pago NO se almacenó correctamente.
				</div>';
		}
		$result['alert'] = $response;
		$result['idPayment'] = $payment->getId();;
		return new Response(json_encode($result));
	}		
/**************************************************************************************************************/
/* MÉTODO AJAX CAMBIAR ESTADO CONTABLE ************************************************************************/
	public function changeCountableStatePaymentAction(Request $request) {
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
			if($permissionLoggedUser->getTracingServiceChangeCountableStatus() == false ){
			$response =
				'<div class="alert alert-danger fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					No dispone de permisos para cambiar el estado contable.
				</div>';
			}
		/******************************************************************************************************/
		/******************************************************************************************************/
		// Guardamos dentro de la variable $idPayment el dato que nos llega por POST
			$idPayment = (integer) $request->get('id');
		/* Cargo los repositorios necesarios ******************************************************************/
			$payment_repo = $em->getRepository("BackendBundle:Payment");
			$invoiceService_repo = $em->getRepository("BackendBundle:InvoiceService");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
		/******************************************************************************************************/
		/* Realizo las consultas ******************************************************************************/			
			$payment = $payment_repo->findOneById($idPayment);
			$clinicNameUrl = $payment->getTracing()->getMedicalHistory()->getClinic()->getNameUrl();
		/******************************************************************************************************/
		/* Cambio el estado contable **************************************************************************/			
			$countable = $payment->getCountable();
			if($countable){ $countable = false; }else{ $countable = true; }
			$payment->setCountable($countable);
			// persistimos los datos dentro de Doctirne
			$em->persist($payment);
			// guardamos los datos persistidos dentro de la BD
			$flush = $em->flush();			
		/******************************************************************************************************/
		/* Extraigo datos contables mes ***********************************************************************/
			$response = array();
			$date = $payment->getTracing()->getDate();
			$year = $date->format('Y');
			$month = $date->format('m');
			$day = $date->format('Y-m-d');
			$monthYear = $month."/".$year;
			$accountingTotal = $payment_repo->getAccountingTotal($clinicNameUrl,$day);
			$response ['countable'] =  $accountingTotal[$month]['countable'];
			$response ['monthYear'] = $monthYear;
		//		return new Response(json_encode($result)); // codificamos la respuesta en JSON
		if($flush == null){
			$status =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El servicio se modificó correctamente.
				</div>';
		}else{
			$status =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El servicio NO se modificó correctamente.
				</div>';
		}
		$response ['status'] = $status;
		return new Response(json_encode($response));
	}
/**************************************************************************************************************/
/* MÉTODO AJAX CAMBIAR ESTADO CONSOLIDADO *********************************************************************/
	public function changeConsolidatedTracingServiceAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
				$permission = $permissionLoggedUser->getTracingServiceChangeConsolidatedStatus();
		/* PERMISO ACCESO *************************************************************************************/
			if($permission == false ){
				$status =
					'<div class="alert alert-danger fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						No dispone de permisos para cambiar el estado consolidado.
					</div>';

			}
		/******************************************************************************************************/
		/******************************************************************************************************/
			if($permission == true ){		
			// Guardamos dentro de la variable $cityInformation el dato que nos llega por POST
				$idPayment = (integer) $request->get('id');
				$tracing_repo = $em->getRepository("BackendBundle:Tracing");
				$payment_repo = $em->getRepository("BackendBundle:Payment");
				$invoiceService_repo = $em->getRepository("BackendBundle:InvoiceService");
				$payment = $payment_repo->findOneById($idPayment);
				$clinicNameUrl = $payment->getTracing()->getMedicalHistory()->getClinic()->getNameUrl();
				$consolidated = $payment->getConsolidated();
				if($consolidated){
					$consolidated = false;
				}else{
					$consolidated = true;
				}
				$payment->setConsolidated($consolidated);
				// persistimos los datos dentro de Doctirne
				$em->persist($payment);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();			
			/******************************************************************************************************/
				if($flush == null){
					$status =
						'<div class="alert alert-success fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							El servicio modificó correctamente su estado consolidado.
						</div>';
				}else{
					$status =
						'<div class="alert alert-success fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							El servicio NO se modificó correctamente su estado consolidado.
						</div>';
				}
			}
		$response = [
			'permission'=>$permission,
			'status'=>$status
		];
		return new Response(json_encode($response));
	}
/**************************************************************************************************************/
}