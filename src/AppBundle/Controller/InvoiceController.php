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
	use Symfony\Component\Validator\Constraints\DateTime;
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\Documents;				// Da acceso a la Entidad Documents
	use BackendBundle\Entity\InvoiceReceived;		// Da acceso a la Entidad InvoiceReceived
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\DocumentsType;				// Da acceso al Formulario DocumentsType
	use AppBundle\Form\InvoiceReceivedType;			// Da acceso al Formulario InvoiceReceivedType	
/**************************************************************************************************************/
class InvoiceController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR FACTURAS ********************************************************************************/
	public function invoiceListAction(Request $request, $clinicNameUrl, $year = null ){
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
			$permissionDenied = false;	
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede listar facturas
			if( $permissionLoggedUser->getInvoiceIssuedList() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede listar facturas Emitidas.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
			};
			if( $permissionLoggedUser->getInvoiceReceivedList() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede listar facturas Recibidas.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
			};
			if( $permissionLoggedUser->getInvoiceIssuedList() == false and $permissionLoggedUser->getInvoiceReceivedList() == false ){
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
            $invoiceIssued_repo = $em->getRepository("BackendBundle:InvoiceIssued");
            $invoiceReceived_repo = $em->getRepository("BackendBundle:InvoiceReceived");
            $typeDoc_repo = $em->getRepository("BackendBundle:TypeDoc");
            $typeContentDoc_repo = $em->getRepository("BackendBundle:TypeContentDoc");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			if( $year == null ){
				$today = new \DateTime("today");
				$year = $today->format("Y");
			}
			$invoiceIssuedList = $invoiceIssued_repo->getInvoiceIssuedListForYear( $clinicNameUrl, $year );
			$invoiceReceivedList = $invoiceReceived_repo->getInvoiceIssuedListForYear( $clinicNameUrl, $year );
            $yearList = array();
            foreach($clinicView->getInvoiceIssuedList() as $key=>$value){
                array_push( $yearList, $value->getRegistrationDate()->format("Y") );
            }
            foreach($clinicView->getInvoiceReceivedList() as $key=>$value){
                array_push( $yearList, $value->getRegistrationDate()->format("Y") );
            }
            $yearList = array_reverse (array_unique($yearList));
            $clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
		/******************************************************************************************************/
		/* FORMULARO NUEVA FACTURA ****************************************************************************/
			$invoiceReceivedNew = new InvoiceReceived();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'userLoggedId'=>$userlogged->getId());
			$form_invoiceReceivedNew = $this->createForm(InvoiceReceivedType::class, $invoiceReceivedNew,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form_invoiceReceivedNew->handleRequest($request);
			if($form_invoiceReceivedNew->isSubmitted()){
				if($form_invoiceReceivedNew->isValid()){
					$em = $this->getDoctrine()->getManager();
					// Revisamos la extensión y el archivo
					$file = $form_invoiceReceivedNew["invoiceNumber"]->getData();
					$title = str_replace( " ", "_", strtolower( $request->request->get("title") ) );
					$business = $form_invoiceReceivedNew["business"]->getData();
					// extraemos la extensión del fichero
					$ext = $file->guessExtension();
					if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif' || $ext=='pdf'){
						if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){
							$typeDoc = $typeDoc_repo->findOneByType("image");
						}else{
							$typeDoc = $typeDoc_repo->findOneByType("pdf");
						}
						// renombramos el archivo con el idUser+fecha+extensión
						$file_name = $title.'.'.$ext;
						// movemos el fichero
						$file->move('uploads/clinics/'.$clinicNameUrl.'/documents/invoice_received/'.$business->getNameUrl().'/',$file_name);
						/* Subimos los datos del documento ****************************************************/
							$document = new Documents();
							$document->setClinic($clinic);
							$document->setBusiness($business);
							$document->setMedicalHistory(null);
							$document->setOrthopodologyHistory(null);
							$document->setDoc($file_name);
							$document->setTitle($title);
							$document->setDescription($form_invoiceReceivedNew["note"]->getData());
							$document->setTypeContentDoc($typeContentDoc_repo->findOneByType('invoice'));
							$document->setTypeDoc($typeDoc);
							$document->setUserRegisterer($this->getUser());
							$document->setRegistrationDate($form_invoiceReceivedNew["registrationDate"]->getData());
							$document->setUserModifier($this->getUser());
							$document->setModificationDate($form_invoiceReceivedNew["registrationDate"]->getData());						
							// persistimos los datos dentro de Doctirne
							$em->persist($document);
							// guardamos los datos persistidos dentro de la BD
							$flush = $em->flush();
							// Si se guardan correctamente los datos en la BD
						/**************************************************************************************/
						/* Subimos los datos de la factura ****************************************************/
							$invoiceReceivedNew->setClinic($clinic);
							$invoiceReceivedNew->setDocuments($document);
							$invoiceReceivedNew->setBusiness($business);
							$invoiceReceivedNew->setInvoiceNumber( $request->request->get("title") );
							$invoiceReceivedNew->setTaxBase($form_invoiceReceivedNew["taxBase"]->getData());
							$invoiceReceivedNew->setIva($form_invoiceReceivedNew["iva"]->getData());
							$invoiceReceivedNew->setRe($form_invoiceReceivedNew["re"]->getData());
							$invoiceReceivedNew->setPaidOut(false);
							$invoiceReceivedNew->setNote($form_invoiceReceivedNew["note"]->getData());
							$invoiceReceivedNew->setUserRegisterer($this->getUser());
							$invoiceReceivedNew->setRegistrationDate($form_invoiceReceivedNew["registrationDate"]->getData());
							// persistimos los datos dentro de Doctirne
							$em->persist($invoiceReceivedNew);
							// guardamos los datos persistidos dentro de la BD
							$flush = $em->flush();
							// Si se guardan correctamente los datos en la BD
						/**************************************************************************************/				
						$status = ['type'=>'success','description'=>'Se ha subido el documento correctamente'];
						$this->session->getFlashBag()->add("status", $status);
					}else{
						$status = [	'type'=>'danger','description'=>'No se ha subido el documento correctamente. Por favor, revisa la extensión del documento'];
						$this->session->getFlashBag()->add("status", $status);
					}
				}else{
					$status = [	'type'=>'danger','description'=>'No se ha subido el documento correctamente'];
					$this->session->getFlashBag()->add("status", $status);
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				return $this->redirectToRoute('invoice_list_year',
					array('clinicNameUrl'=>$clinicNameUrl, 'year'=>$year ));
			}			
		/******************************************************************************************************/				
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			return $this->render('AppBundle:Invoice:invoice_List.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'invoiceIssuedList'=>$invoiceIssuedList,
                    'invoiceReceivedList'=>$invoiceReceivedList,
                    'form_invoiceReceivedNew'=>$form_invoiceReceivedNew->createView(),
                    'yearList'=>$yearList
				)
			);
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
}