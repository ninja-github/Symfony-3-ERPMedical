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
	public function removeAction(Request $request) {
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
		// Guardamos dentro de la variable $cityInformation el dato que nos llega por POST
		$idTracing = (integer) $request->get('id');
		// $clinicNameUrl = (string) $request->get('clinicNameUrl');
		// Busco dentro de la BD el dato
		$em = $this->getDoctrine()->getManager();
		$tracing_repo = $em->getRepository('BackendBundle:Tracing');
		$tracing = $tracing_repo->findOneById($idTracing);
		$tracingDate = $tracing->getDate();
		$clinic = $tracing->getMedicalHistory()->getClinic();
		$servicesList = $em->getRepository('BackendBundle:Service')->findByClinic($clinic);
		/* Limpio la lista de servicios según fecha ***************************************************************/
			foreach($servicesList as $key=> $value){
				$range_date = $tracingDate >= $value->getRegistrationDate() && ( $tracingDate <= $value->getModificationDate() || $value->getModificationDate() == null);
				if( !$range_date){ unset($servicesList[$key]); }
			}
		/**********************************************************************************************************/
		$response =
				'<td class=" " style = "padding:2px 2px;">
						<select class="select_group form-control" id="tracing_service" name="tracing[service][service]">
							<option value="0"> </option>';
		foreach($servicesList as $keyServiceParent=>$serviceParent){
			if ( empty( $serviceParent->getParent() ) && count ($serviceParent->getChildren() ) == 0 ){
					$response = $response.'<option value="'.(string) $serviceParent->getId().'"><p class="text-left">'.(string)$serviceParent->getService().'</p> <p class="text-right">( '.$serviceParent->getMaximumPrice().' € ) </p></option>';
			}elseif( empty( $serviceParent->getParent() ) && count ($serviceParent->getChildren() ) >= 1 ){
				$response = $response.'<optgroup label="'.$serviceParent->getService().'">';
				foreach($servicesList as $keyServiceChildren=>$serviceChildren){
					if( $serviceChildren->getParent()!=null && $serviceParent->getId() == $serviceChildren->getParent()->getId() && count ($serviceChildren->getChildren())==0){
						$response = $response.'<option value="'.$serviceChildren->getId().'">'.$serviceChildren->getService().' ( '.$serviceChildren->getMaximumPrice().' € ) </option>';
					}elseif( $serviceChildren->getParent()!=null && $serviceParent->getId() == $serviceChildren->getParent()->getId() && count ($serviceChildren->getChildren())>=1){
						$response = $response.'<option value="'.$serviceChildren->getId().'">'.$serviceChildren->getService().' ( '.$serviceChildren->getMaximumPrice().' € ) </option>';
						foreach($servicesList as $keyServiceGrandChildren=>$serviceGrandChildren){
							if(	count($serviceGrandChildren->getParent())>=1 && $serviceChildren->getId() == $serviceGrandChildren->getParent()->getId() ){
								$response = $response.'<option value="'.$serviceGrandChildren->getId().'">&nbsp;&nbsp;&nbsp;&nbsp;'.$serviceGrandChildren->getService().' ( '.$serviceGrandChildren->getMaximumPrice().' € ) </option>';
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
					<td class=" " style="padding:2px 2px;"><input type="text" class="form-control" name="tracing[service][description]"></td>
					<td class=" " style="padding:2px 2px;"><input type="text" class="form-control" name="tracing[service][price]"></td>
					<td class=" " style="text-align: center;">
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
		// Guardamos dentro de la variable $cityInformation el dato que nos llega por POST
		$idTracing = (integer) $request->get('id');
		$idValueService = (integer) $request->get('valueService');
		$valueDescription = (string) $request->get('valueDescription');
		$valuePrice = (integer)$request->get('valuePrice');
		// Busco dentro de la BD el dato
		$tracing = $em->getRepository('BackendBundle:Tracing')->findOneById($idTracing);
		if($idTracing > 0){
			$service = $em->getRepository('BackendBundle:Service')->findOneById($idValueService);
		}else{
			$service = NULL;
		}
		$tracingService = new TracingService();
		$tracingService->setTracing($tracing);
		$tracingService->setService($service);
		$tracingService->setDescription($valueDescription);
		if($valuePrice === NULL && $service != NULL){
			$valuePrice = $service->getMaximumPrice();
		}elseif($valuePrice === NULL && $service === NULL ){
			$valuePrice = 0;
		}
		$tracingService->setPrice($valuePrice);
		$tracingService->setRegistrationDate(new \DateTime("now"));
		$tracingService->setModificationDate(new \DateTime("now"));
		$tracingService->setUserRegisterer($userlogged);
		$tracingService->setUserModifier($userlogged);
		// persistimos los datos dentro de Doctirne
		$em->persist($tracingService);
		// guardamos los datos persistidos dentro de la BD
		$flush = $em->flush();
		//		return new Response(json_encode($result)); // codificamos la respuesta en JSON
		if($flush == null){
			$response =
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					El servicio se almacenó correctamente.
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


// <button type="submit"><i class="fa fa-save m-right-xs" onclick="send_tracing_service('.$idTracing.');"></i></button>









/* TWIG
	<!-- Modal - Añadir Servicios Seguimientos -->
		{% for tracingDay in medicalHistory.tracingList %}
			{% if tracingDay.typeTracing.type == 'medical_history' %}
				{# Renombro la variable ...#}
					{% set form_medicalHistoryTracing  = form_tracingMedicalHistoryList[tracingDay.id] %}
				{# ...Renombro la variable #}
				<div class="modal fade" id="tracingEdit_{{tracingDay.id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<!-- Modal Header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>
									<h4 class="modal-title" id="myModalLabel">Añadir Servicio</h4>
								</div>
							<!-- Modal Header -->
							<!-- Modal Body -->
								<div class="modal-body">
									<div class="row control-label form-horizontal form-label-left">
										{{ form_start(form_medicalHistoryTracing, { 'attr':{'class': 'form-horizontal form-label-left' }})}}
											<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
												<div class="form-group">
													<!-- Fecha -->
														<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12">Fecha de Seguimiento</label>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
															<div class='input-group date' id='datetimepicker1'>
																{{form_widget(form_medicalHistoryTracing.date)}}
																<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
																</span>
															</div>
														</div>
														<div class="clearfix"></div>
													<!-- /fecha -->
													<!-- Seguimiento -->
														<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12" >Seguimiento<span class="required">*</span>
														</label>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">{{form_widget(form_medicalHistoryTracing.tracing)}}</div>
													<!-- /seguimiento -->
													<!-- Servicios por Seguimiento -->
														{#............... Simplifico la variable extrayendola de la Historia Clínica - Clínica - Lista de Servicios #}
														{% set services = medicalHistory.clinic.servicesList %}
														{# Simplifico la variable extrayendola de la Historia Clínica - Clínica - Lista de Servicios............... #}
														<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12" >Servicio<span class="required">*</span>
														</label>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
															<select class="select2_group form-control" id="tracing_service" name="tracing[service][]">
																{% for serviceParent in services %}
																	{% if serviceParent.parent is empty and serviceParent.children is empty %}
																		<option value="{{serviceParent.id}}">{{serviceParent.service}}</option>
																	{% elseif  serviceParent.parent is empty and serviceParent.children is not empty %}
																		<optgroup label="{{serviceParent.service}}">
																			{% for serviceChildren in services %}
																				{% if serviceChildren.parent is not empty and serviceParent.id == serviceChildren.parent.id and serviceChildren.children is empty %}
																					<option value="{{serviceChildren.id}}">{{serviceChildren.service}}</option>
																				{% elseif serviceChildren.parent is not empty and serviceParent.id == serviceChildren.parent.id and serviceChildren.children is not empty %}
																					<option value="{{serviceChildren.id}}">{{serviceChildren.service}}</option>
																						{% for serviceGrandChildren in services %}
																							{% if serviceGrandChildren.parent is not empty and serviceChildren.id == serviceGrandChildren.parent.id %}
																								<option value="{{serviceGrandChildren.id}}">&nbsp;&nbsp;&nbsp;&nbsp;{{serviceGrandChildren.service}}</option>
																							{% endif %}
																						{% endfor %}
																				{% endif %}
																			{% endfor %}
																		</optgroup>
																	{% endif %}
																{% endfor %}
															</select>
														</div>
														<label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin:13px 0px;">Precio<span class="required">*</span>
														</label>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="margin:13px 0px;">
															<input type="text" id="tracing_price" name="tracing[price][]" class="form-control" value="{{tracingDay.id}}">
														</div>
														<div id="new_tracing_service">
														</div>
														<button class="btn btn-success" type="button"  onclick="new_tracing_service();">
															<i class="fa fa-plus-square m-right-xs"></i>
														</button>
														<div class="clearfix"></div>
														<div class="divider-dashed"></div>
													<!-- /servicios por Seguimiento -->
													<!-- Id Oculto -->
														{{form_widget(form_medicalHistoryTracing.id)}}
													<!-- /id Oculto -->
													<!-- Editar Seguimiento -->
														{{ form_row(form_medicalHistoryTracing.submit, { 'label': 'Editar Seguimiento' }) }}
													<!-- /editar Seguimiento -->
												</div>
											</div>
										{{ form_end(form_medicalHistoryTracing) }}
				            		</div>
				            	</div>
							<!-- Modal Body -->
							{#
							<!-- Modal Footer -->
								<div class="modal-footer"></div>
							<!-- Modal Footer -->
							#}
						</div>
					</div>
				</div>
			{% endif %}
		{% endfor %}
	<!-- /modal - Añadir Servicios Seguimientos -->
