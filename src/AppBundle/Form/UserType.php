<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Form;
/**************************************************************************************************************/
	use Symfony\Component\Form\AbstractType;                // Clase necesario para AbstractType
	use Symfony\Component\Form\FormBuilderInterface;        // Clase necesario para AbstractType
	use Symfony\Component\OptionsResolver\OptionsResolver;  // Clase necesario para AbstractType
	/*
	 * EntityType permite mostrar en el formulario un listado de opciones procedente
	 * de otro formulario
	 */
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;     // Campo Tipo EntityType
/**************************************************************************************************************/
/* Añadimos los componentes que permitirán el uso de EntityField **********************************************/
	/*
	 * EntityType permite mostrar en el formulario un listado de opciones procedente
	 * de otro formulario
	 */
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**************************************************************************************************************/
class UserType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		/*
		 * Usamos la propiedad 'empty_data' para pasar la variable
		 * ( viene de 'src\AppBundle\Controller\PrivateMessageController.php',
		 * 'src\AppBundle\form\PrivateMessageType.php',
		 * 'src\BackendBundle\Repository\UserRepository.php' y
		 * 'src\BackendBundle\Resources\config\doctrine\user.orm.yml')
		 */
		$builder
			// 'name' será el nombre de la columna de la base de datos
			->add('userName', TextType::class, array(
				'required'=>'required',
				'attr'=>array('class'=>'form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Nombre de Usuario')
			))
			->add('password', PasswordType::class, array(
				'label'=>'Contraseña',
				'required'=>false,
				'attr'=>array('class'=>'form-password form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Password')
			))
			->add('email', EmailType::class, array(
				'label'=>'Correo electrónico',
				'required'=>false,
				'attr'=>array('class'=>'form-email form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Email')
			))
			->add('image', FileType::class, array(
				'label'=>'Foto',
				'required'=>false,
				'data_class'=>null, // campo independiente
				'attr'=>array('class'=>'form-image form-control', "style" => "margin-bottom:10px")
			))
			->add('gender', EntityType::class,array(
				'class' => 'BackendBundle:TypeGender',
				'choice_label' => 'type',
				'query_builder' => function($er) {
					return $er->createQueryBuilder('u');
				},
				"label" => "Sexo",
				// Elegimos CheckBOX única selección
				//"expanded"     => true,       // Muestra todas las opciones (radio buttons O checkboxes)
				'expanded' => false,			// Muestra todas las opciones (radio buttons O checkboxes)
				'multiple' => false,			// Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
				'attr' =>array('class' => 'form-control', 'style' => 'margin-bottom:10px', 'data-toggle-class' => 'btn-primary')
			))
			->add('Actualizar',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success')));
	}
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
	public function configureOptions(OptionsResolver $resolver)    {
		$resolver->setDefaults(array('data_class' => 'BackendBundle\Entity\User'));
	}
/**************************************************************************************************************/
}

