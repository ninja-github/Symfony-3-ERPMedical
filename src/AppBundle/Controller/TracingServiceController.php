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
class TracingServiceController extends Controller{
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
	public function check_in_range($start_date, $end_date, $evaluame) {
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date);
		$user_ts = strtotime($evaluame);
		return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
	}
/* MÉTODO AJAX ELIMINAR SERVICIO DE SEGUIMIENTO ***************************************************************/
	public function removeTracingServiceAction(Request $request) {
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
			if($permissionLoggedUser->getTracingServiceRemove() == false ){
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
			$idTracingService = (integer) $request->get('id');
			// Busco dentro de la BD el dato
			$em = $this->getDoctrine()->getManager();
			$tracingService = $em->getRepository('BackendBundle:TracingService')->findOneById($idTracingService);
			$em->remove($tracingService);
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
/* MÉTODO AJAX GENERAR INPUT **********************************************************************************/
	public function generateFormAction(Request $request) {
		// Guardamos dentro de la variable $idTracing el dato que nos llega por POST
		$idTracing = (integer) $request->get('id');
		// Busco dentro de la BD el dato
		$em = $this->getDoctrine()->getManager();
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/		
			$tracing_repo = $em->getRepository('BackendBundle:Tracing');
			$tracingService_repo = $em->getRepository('BackendBundle:TracingService');
			$clinic_repo = $em->getRepository('BackendBundle:Clinic');
			$service_repo = $em->getRepository('BackendBundle:Service');
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/			
			$tracing = $tracing_repo->findOneById($idTracing);
			$medicalHistory = $tracing->getMedicalHistory();
			$medicalHistoryNumber = $medicalHistory->getMedicalHistoryNumber();
			$tracingDate = $tracing->getDate();
			$clinic = $tracing->getMedicalHistory()->getClinic();
			$clinicNameUrl = $clinic->getNameUrl();
			$servicesList = $service_repo->findBy(array('clinic'=>$clinic),array('weight'=>'DESC'));
		/* DATOS ECONÓMICOS PACIENTE **************************************************************************/
			$costEarnings = $tracing_repo->getCostEarnings($clinicNameUrl, $medicalHistoryNumber);
			$oweMoney = false;
			if ($costEarnings['cost']>$costEarnings['earnings']){
				$oweMoney = true;
			}
		/******************************************************************************************************/				
		/* Limpio la lista de servicios según fecha ***************************************************************/
			foreach($servicesList as $key=> $value){
				$range_date = $tracingDate >= $value->getRegistrationDate() && ( $tracingDate <= $value->getModificationDate() || $value->getModificationDate() == null);
				if( !$range_date){ unset($servicesList[$key]); }
			}
		/**********************************************************************************************************/
		/* Limpio la lista de servicios de pagos ******************************************************************/
			$paymentSystemList = array();
			foreach($servicesList as $key=> $value){
				$isService = true;
				if( $value->getTypeService() ){
					$isService = false;
					array_push($paymentSystemList,$value);
				}
				if( !$isService){ unset($servicesList[$key]); }
			}
		/**********************************************************************************************************/
		$paymentSystemResponse = 
			'<td class=" " style="padding:2px 2px;">
				<select class="select_group form-control" id="tracing_service['.$idTracing.'][service][paymentType]" name="tracing[service][paymentType]">';
		foreach($paymentSystemList as $key=>$serviceParent){
			$paymentSystemResponse = $paymentSystemResponse.'<option value="'.$serviceParent->getId().'" style="padding:0px;">';
			$service = $serviceParent->getName();
			if($service == 'PAGO EFECTIVO'){
				$service = 'Efectivo';
			}elseif($service == 'PAGO TARJETA'){
				$service = 'Tarjeta';
			}
			$paymentSystemResponse = $paymentSystemResponse.$service.'</option>';
		}
		$paymentSystemResponse = $paymentSystemResponse.'</select></td>';					
		$response =
			'<td class=" " style = "padding:2px 2px;">
				<select class="select_group form-control" id="tracing_service['.$idTracing.'][service][service]" name="tracing[service][service]">
					<option value="0"> </option>';
		foreach($servicesList as $keyServiceParent=>$serviceParent){
			if ( empty( $serviceParent->getParent() ) && count ($serviceParent->getChildren() ) == 0 ){
					$response = $response.'<option value="'.(string) $serviceParent->getId().'"><p class="text-left">'.(string)$serviceParent->getName().'</p> <p class="text-right">( '.$serviceParent->getMaximumPrice().' € ) </p></option>';
			}elseif( empty( $serviceParent->getParent() ) && count ($serviceParent->getChildren() ) >= 1 ){
				$response = $response.'<optgroup label="'.$serviceParent->getName().'">';
				foreach($servicesList as $keyServiceChildren=>$serviceChildren){
					if( $serviceChildren->getParent()!=null && $serviceParent->getId() == $serviceChildren->getParent()->getId() && count ($serviceChildren->getChildren())==0){
						$response = $response.'<option value="'.$serviceChildren->getId().'">'.$serviceChildren->getName().' ( '.$serviceChildren->getMaximumPrice().' € ) </option>';
					}elseif( $serviceChildren->getParent()!=null && $serviceParent->getId() == $serviceChildren->getParent()->getId() && count ($serviceChildren->getChildren())>=1){
						if($serviceChildren->getMaximumPrice() == null ){
							$response = $response.'<optgroup label="'.'&nbsp;&nbsp;&nbsp;&nbsp;'.$serviceChildren->getName().'">';
							foreach($servicesList as $keyServiceGrandChildren=>$serviceGrandChildren){
								if(	count($serviceGrandChildren->getParent())>=1 && $serviceChildren->getId() == $serviceGrandChildren->getParent()->getId() ){
									$response = $response.'<option value="'.$serviceGrandChildren->getId().'">&nbsp;&nbsp;&nbsp;&nbsp;'.$serviceGrandChildren->getName().' ( '.$serviceGrandChildren->getMaximumPrice().' € ) </option>';
								}
							}
							$response = $response.'</optgroup>';
						}elseif($serviceChildren->getMaximumPrice() != null){
							$response = $response.'<option value="'.$serviceChildren->getId().'">&nbsp;&nbsp;&nbsp;&nbsp;'.$serviceChildren->getName().' ( '.$serviceChildren->getMaximumPrice().' € ) </option>';
							foreach($servicesList as $keyServiceGrandChildren=>$serviceGrandChildren){
								if(	count($serviceGrandChildren->getParent())>=1 && $serviceChildren->getId() == $serviceGrandChildren->getParent()->getId() ){
									$response = $response.'<option value="'.$serviceGrandChildren->getId().'">&nbsp;&nbsp;&nbsp;&nbsp;'.$serviceGrandChildren->getName().' ( '.$serviceGrandChildren->getMaximumPrice().' € ) </option>';
								}
							}
						}
					}
				}
				$response = $response.'</optgroup>';
			}
		}
		$response = $response.
				'</select>
			</td>
			<td class=" " style="padding:2px 2px;"><input type="text" class="form-control" id="tracing_service['.$idTracing.'][service][description]" name="tracing[service][description]"></td>
			<td class=" " style="padding:2px 2px;width:40px;"><input type="text" class="form-control" id="tracing_service['.$idTracing.'][service][price]" name="tracing[service][price]"></td>';
		$response = $response.
			'<td class=" " style="padding:2px 2px;width:40px;"><input type="text" class="form-control" id="tracing_service['.$idTracing.'][service][payment]" name="tracing[service][payment]"></td>';
		$response = $response.$paymentSystemResponse.
			'<td class=" " style="text-align: center;">
				<i class="fa fa-save m-right-xs" onclick="send_tracing_service('.$idTracing.');"></i>
			</td>';
		return new Response($response);
	}
/**************************************************************************************************************/
/* MÉTODO AJAX AÑADIR NUEVO SERVICIO **************************************************************************/
	public function addTracingServiceAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
			$idTracing = (integer) $request->get('id');
			$idValueService = (integer) $request->get('valueService');
			$valueDescription = (string) $request->get('valueDescription');
			if($valueDescription == ""){
				$valueDescription = NULL;
			}
			$valuePrice = (integer)$request->get('valuePrice');
			// Busco dentro de la BD el dato
			$tracing = $em->getRepository('BackendBundle:Tracing')->findOneById($idTracing);
			$registrationDate = $tracing->getDate();
			if($idTracing > 0){
				$service = $em->getRepository('BackendBundle:Service')->findOneById($idValueService);
			}else{
				$service = NULL;
			}
			$idPaymentType = (integer)$request->get('valuePaymentType');
			$servicePaymentType = $em->getRepository('BackendBundle:Service')->findOneById($idPaymentType);
			if($servicePaymentType == NULL){
				$servicePaymentType = $em->getRepository('BackendBundle:Service')->findOneBy(array('TypeService'=>true));
			}
			$valuePayment = (integer)$request->get('valuePayment');
		/******************************************************************************************************/
		/* Guardamos el servicio ******************************************************************************/
			$tracingService = new TracingService();
			$tracingService->setTracing($tracing);
			$tracingService->setService($service);
			$tracingService->setCountable(false);
			$tracingService->setConsolidated(false);
			$tracingService->setDescription($valueDescription);
			if($valuePrice == "" && $service != NULL){
				$valuePrice = $service->getMaximumPrice();
			}elseif($valuePrice == NULL && $service == NULL ){
				$valuePrice = 0;
			}
			$tracingService->setPrice($valuePrice);
			$tracingService->setRegistrationDate($registrationDate);
			$tracingService->setUserRegisterer($userlogged);
			// persistimos los datos dentro de Doctirne
			$em->persist($tracingService);
			// guardamos los datos persistidos dentro de la BD
			$flush = $em->flush();
		/******************************************************************************************************/
		/* Guardamos el pago **********************************************************************************/		
			$payment = new Payment();
			$payment->setTracing($tracing);
			$payment->setService($servicePaymentType);
			$payment->setCountable(false);
			$payment->setConsolidated(false);
			$payment->setTracingService($tracingService);
			$payment->setDescription(null);
			if($valuePayment === ""){
				$valuePayment = $valuePrice;
			}
			$payment->setPayment($valuePayment);
			$payment->setUser($userlogged);
			$payment->setDate($registrationDate);
			// persistimos los datos dentro de Doctirne
			$em->persist($payment);
			// guardamos los datos persistidos dentro de la BD
			$flush = $em->flush();			
		/******************************************************************************************************/		
		//		return new Response(json_encode($result)); // codificamos la respuesta en JSON
		if($flush == null){
			$response =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El servicio se almacenó correctamente.'.$request->get('valuePayment').'
				</div>';
		}else{
			$response =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El servicio NO se almacenó correctamente.
				</div>';
		}
		$result['alert'] = $response;
		$result['idTracingService'] = $em->getRepository('BackendBundle:TracingService')->findOneByTracing(['tracing'=>$tracing],['id'=>'DESC'])->getId();
		return new Response(json_encode($result));
	}
/**************************************************************************************************************/	
}