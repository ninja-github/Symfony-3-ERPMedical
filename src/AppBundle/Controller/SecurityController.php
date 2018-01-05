<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Session\Session; // Permite usar sesiones
	use Symfony\Component\HttpFoundation\Response;        // Permite usar el método Response
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\User;                        // Da acceso a la Entidad Usuario
	use BackendBundle\Entity\TypeGender;                  // Da acceso a la Entidad TypeGender
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\UserType;                          // Da acceso al Formulario UserType
	use AppBundle\Form\RegisterType;                      // Da acceso al Formulario UserType
/**************************************************************************************************************/
class SecurityController extends Controller {
/* MÉTODO SESSION *********************************************************************************************/
	/*
	 * OBJETO SESSIÓN
	 * Para activar las sesiones inicializamos la variable e incluimos
	 * en ella el objeto Session()
	 * No olvidar dar acceso al componenete de Symfony
	 * Session() permitirá usar los mensajes FLASHBAG
	 */
	private $session;
	public function __construct(){
		$session = $this->session = new Session();
	}
/**************************************************************************************************************/
/* MÉTODO PARA EL LOGIN ***************************************************************************************/
	public function loginAction(Request $request){
		/* si existe el objeto User nos rediriges a home            */
		if( is_object($this->getUser()) ){
			return $this->redirect('home');
		}
		/*
		 * Realizo la consulta en la BD, ¿Hay usuarios registrados?
		 * No -> Redirijo a Register
		 * Si -> No redirijo a Register
		 */
		/******************************************************************************************************/
		$authenticationUtils = $this->get('security.authentication_utils');
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();
		return $this->render('AppBundle:Security:login.html.twig', array(
			'lastUsername'=>$lastUsername,
			'error'=>$error )
		);
	}
/**************************************************************************************************************/
/* MÉTODO PARA EL REGISTRO DE USUARIO *************************************************************************/
	public function registerAction(Request $request){
		/*
		 * Realizo la consulta en la BD, ¿Hay usuarios registrados?
		 * No -> Puedo registrarme
		 * Si -> No puedo acceder al REGISTRO
		 */
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery('SELECT u FROM BackendBundle:User u');
		$user_isset = $query->getResult();
		if(count($user_isset) > 0){
			return $this->redirect('login');
		};
		// Creamos un nuevo objeto User
		$user = new User();
		/*
		 * Creamos el formulario a partir de la clase RegisterType,
		 * le pasaremos la variable User
		 * hay que declarar la clase RegisterType arriba
		 */
		$form = $this->createForm(RegisterType::class, $user);
		$form->handleRequest($request);
		// Si se envía y es válido el formulario
		if($form->isSubmitted() && $form->isValid()){
			$em = $this->getDoctrine()->getManager();
			// $user_repo = $em->getTepository("BackendBundle:User");
			// hacemos la consulta
			$query = $em->createQuery('SELECT u FROM BackendBundle:User u WHERE u.userName = :userName')
				->setParameter('userName', $form->get("userName")->getData());
			//extraemos el resultado de la $query
			$user_isset = $query->getResult();
			// Si no hay ningun usuario con ese email y nick
			if(count($user_isset==0)){
				// si el usuario no existe
				$factory = $this->get("security.encoder_factory");
				$encoder = $factory->getEncoder($user);
				$password = $encoder->encodePassword( $form->get("password")->getData(), $user->getSalt());
				// Upload file
				// Declaramos la imagen que subimos al formulario
				$user_image=$user->getImage();
				$file = $form["image"]->getData();
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
					$user->setImage($user_image);
				}
				// subimos los datos usando los setters
				$user->setPassword($password);
				$user->setRole("ROLE_ADMIN");
				$user->setRegistrationDate(new \DateTime("now"));
				// persistimos los datos dentro de Doctirne
				$em->persist($user);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();
				// Si se guardan correctamente los datos en la BD
				if($flush == null){
					$status = "Te has registrado correctamente!";
				}else{
					$status = "No te has registrado correctamente";
				}
			}else{
				// si el usuario existe
				$status = "El usuario ya existe!!";
			}
		}else{
			$status = "No te has registrado correctamente !!";
		}
		if($form->isSubmitted()){
			// generamos los mensajes FLASH (necesario activar las sesiones)
			$this->session->getFlashBag()->add("status", $status);
			return $this->redirect("login");
		}
		// enviamos la vista con el html del formulario ($form)
		return $this->render('AppBundle:Security:register.html.twig', array(
			'form'=>$form->createView()
			)
		);
	}
/**************************************************************************************************************/
/* MÉTODO REDIRECCIONA A LOGIN O HOME SEGÚN ESTEMOS LOGUEADOS *************************************************/
	public function indexAction() {
		if( is_object($this->getUser()) ){
			/* si existe el objeto User logueado nos rediriges a home *****************************************/
			return $this->redirect('home');
		}else{
			/* si NO existe el objeto User logueado nos rediriges a home **************************************/
			return $this->redirect('login');
		}
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
}