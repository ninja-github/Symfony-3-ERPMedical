<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Session\Session; // Permite usar sesiones
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\User;                // Da acceso a la Entidad Usuario
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\RegisterType;              // Da acceso al Formulario RegisterType
	use AppBundle\Form\UserType;                  // Da acceso al Formulario UserType
	use AppBundle\Form\UserPermissionType;        // Da acceso al Formulario UserType
/**************************************************************************************************************/
class UserController extends Controller{
/* CONSTRUCTOR ************************************************************************************************/
	/* OBJETO SESSIÓN Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session().
	/* No olvidar dar acceso al componenete de Symfony Session(), que permitirá usar los mensajes FLASHBAG
	/* use Symfony\Component\HttpFoundation\Session\Session; */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA EDITAR DATOS DEL PERFIL DE USUARIO *************************************************************/
	public function userViewAction(Request $request, $userName=NULL){
		/* CARGA INICIAL **************************************************************************************/
		$em = $this->getDoctrine()->getManager();
		$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
		$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
		$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		$permissionDescription = $em->getRepository("BackendBundle:UserPermissionDefinition")->findOneById(1);
		if($userName == NULL){ $userName = $userlogged->getUserName();
		}
		$user = $em->getRepository("BackendBundle:User")->findOneByUserName($userName);
		$userImage = $user->getImage();	// cargo la imagen del usuario
		/******************************************************************************************************/
		// Creamos el formulario
		$formUserEdit = $this->createForm(UserType::class, $user);
		// Enlazamos la información de la request cuando nosotros enviamos el formulario sobreescribiendo el objeto $user
		$formUserEdit->handleRequest($request);
		// Si el formulairo se ha enviado y es válido
		if($formUserEdit->isSubmitted()){
			if($formUserEdit->isValid()){
				$em = $this->getDoctrine()->getManager();
				// Hacemos la consulta
				$user_isset = $em->getRepository("BackendBundle:User")->findBy(
					array('email'=>$formUserEdit->get("email")->getData(),'userName'=>$formUserEdit->get("userName")->getData()));
				// Si el email Y el nick del usuario seteados son iguales a los existentes O No hay ningun usuario con ese email y nick entonces...
				if( ( count($user_isset) == 0) || ($user->getEmail() == $user_isset[0]->getEmail() && $user->getUserName() == $user_isset[0]->getUserName() ) ){
					// si el usuario no existe
					$factory = $this->get("security.encoder_factory");
					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword( $formUserEdit->get("password")->getData(), $user->getSalt());
					// Upload file
					$file = $formUserEdit["image"]->getData();
					if(!empty($file) && $file !=null){
						// extraemos la extensión del fichero
						$ext = $file->guessExtension();
						if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){
							// renombramos el archivo con el idUser+fecha+extensión
							$file_name = $user->getId().time().'.'.$ext;
							// movemos el fichero
							$file->move("uploads/users",$file_name);
							$user->setImage($file_name);
						}
					}else{
						$user->setImage($userImage);
					}
					// subimos los datos usando los setters
					$user->setPassword($password);
					$user->setModificationDate(new \DateTime("now"));
					$user->setUserModifier($this->getUser());
					// persistimos los datos dentro de Doctirne
					$em->persist($user);
					// guardamos los datos persistidos dentro de la BD
					$flush = $em->flush();
					// Si se guardan correctamente los datos en la BD
					if($flush == null){
						$status = "Has modificado tus datos correctamente!";
					}else{
						$status = "No has modificado tus datos correctamente";
					}
				}else{
					// si el usuario existe
					$status = "El usuario ya existe!!";
				}
			}else{
				$status = "No se han actualizado tus datos correctamente";
			}
			// generamos los mensajes FLASH (necesario activar las sesiones)
			// $this->session->getFlashBag()->add("status", $status);
			if($request->getPathInfo() == '/my-data'){
				return $this->redirect('my-data');
			}
		}
		/******************************************************************************************************/
		$userPermission_repo = $em->getRepository("BackendBundle:UserPermission");
		$userPermission = $userPermission_repo->findOneByUser($user);
		/******************************************************************************************************/
		$userPermissionForm = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($user);
		// Creamos el formulario
		$formUserPermission = $this->createForm(UserPermissionType::class, $userPermissionForm);
		// Enlazamos la información de la request cuando nosotros enviamos el formulario sobreescribiendo el objeto $user
		$formUserPermission->handleRequest($request);
		// Si el formulairo se ha enviado y es válido
		if($formUserPermission->isSubmitted()){
			if($formUserPermission->isValid()){
				$em = $this->getDoctrine()->getManager();
				// subimos los datos usando los setters
				$userPermissionForm->setUserDumpView($formUserPermission->get("userDumpView")->getData());
				$userPermissionForm->setUserPermission($formUserPermission->get("userPermission")->getData());
				$userPermissionForm->setMedicalHistoryRegistrationDateEdit($formUserPermission->get("medicalHistoryRegistrationDateEdit")->getData());
				$userPermissionForm->setMedicalHistoryUserRegistererEdit($formUserPermission->get("medicalHistoryUserRegistererEdit")->getData());
				$userPermissionForm->setMedicalHistoryModificationDateEdit($formUserPermission->get("medicalHistoryModificationDateEdit")->getData());
				$userPermissionForm->setMedicalHistoryUserModifierEdit($formUserPermission->get("medicalHistoryUserModifierEdit")->getData());
				// persistimos los datos dentro de Doctirne
				$em->persist($userPermissionForm);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();
				// Si se guardan correctamente los datos en la BD
				if($flush == null){
					$status = "Has modificado tus datos correctamente!";
				}else{
					$status = "No has modificado tus datos correctamente";
				}
			}else{
				$status = "No se han actualizado tus datos correctamente";
			}
			// generamos los mensajes FLASH (necesario activar las sesiones)
			// $this->session->getFlashBag()->add("status", $status);
			if($request->getPathInfo() == '/my-data'){
				return $this->redirect('my-data');
			}
		}
		/******************************************************************************************************/
			$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
			$scheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array('user'=>$user));
			if( $scheduleGoogleCalendar != NULL){
				$refreshToken = $scheduleGoogleCalendar->getRefreshToken();
				$request = $this->get('request_stack')->getMasterRequest();
				$googleCalendar = $this->get('fungio.google_calendar');
				$googleCalendar->setRefreshToken($refreshToken);
				$client = $googleCalendar->getClient();
				$listCalendars = $googleCalendar->listCalendars();				
			}
		// Enviamos el formulario y su vista a la plantilla TWIG
		return $this->render('AppBundle:User:user_View.html.twig',
			array(
				'permissionDescription'=> $permissionDescription,
				'permissionLoggedUser'=>$permissionLoggedUser,
				'formUserPermission'=>$formUserPermission->createView(),
				'formUserEdit'=>$formUserEdit->createView(),
				'userPermission'=>$userPermission,
				'user'=>$user,
				'pathInfo'=> $request->getPathInfo() == '/my-data' ?  false:true,
				//'listCalendars'=>$listCalendars
			)
		);
	}
/**************************************************************************************************************/
/* MÉTODO PARA CONFIGURAR PERMISOS DEL  USUARIO ***************************************************************/
	public function userPermissionEditAction(Request $request, $userName=NULL){
		$em = $this->getDoctrine()->getManager();
		$user_repo = $em->getRepository("BackendBundle:User");
		$user = $user_repo->findOneByUserName($userName);
		// cargo los permisos existentes
		$userPermission_repo = $em->getRepository("BackendBundle:UserPermission");
		$userPermission = $userPermission_repo->getUserPermission($userName);
		$userPermissionForm = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($user);
		// Creamos el formulario
		$formUserPermission = $this->createForm(UserPermissionType::class, $userPermissionForm);
		// Enlazamos la información de la request cuando nosotros enviamos el formulario sobreescribiendo el objeto $user
		$formUserPermission->handleRequest($request);
		// Si el formulairo se ha enviado y es válido
		if($form->isSubmitted()){
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				// subimos los datos usando los setters
				$userPermissionForm->setUserDumpView($form->get("userDumpView")->getData());
				$userPermissionForm->setUserPermission($form->get("userPermission")->getData());
				$userPermissionForm->setMedicalHistoryRegistrationDateEdit($form->get("medicalHistoryRegistrationDateEdit")->getData());
				$userPermissionForm->setMedicalHistoryUserRegistererEdit($form->get("medicalHistoryUserRegistererEdit")->getData());
				$userPermissionForm->setMedicalHistoryModificationDateEdit($form->get("medicalHistoryModificationDateEdit")->getData());
				$userPermissionForm->setMedicalHistoryUserModifierEdit($form->get("medicalHistoryUserModifierEdit")->getData());
				// persistimos los datos dentro de Doctirne
				$em->persist($userPermissionForm);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();
				// Si se guardan correctamente los datos en la BD
				if($flush == null){
					$status = "Has modificado tus datos correctamente!";
				}else{
					$status = "No has modificado tus datos correctamente";
				}
			}else{
				$status = "No se han actualizado tus datos correctamente";
			}
			// generamos los mensajes FLASH (necesario activar las sesiones)
			// $this->session->getFlashBag()->add("status", $status);
			if($request->getPathInfo() == '/my-data'){
				return $this->redirect('my-data');
			}
		}
		// Enviamos el formulario y su vista a la plantilla TWIG
		return $this->render('AppBundle:User:userPermission_Edit.html.twig',
			array(
				'formUserPermission'=>$form->createView(),
				'userPermission'=>$userPermission,
				'user'=>$user,
				'pathInfo'=> $request->getPathInfo() == '/my-data' ?  false:true
			)
		);
	}
/**************************************************************************************************************/
}