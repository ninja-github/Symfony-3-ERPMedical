<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Form;
/**************************************************************************************************************/
	use Symfony\Component\Form\AbstractType;                // Clase necesario para AbstractType
	use Symfony\Component\Form\FormBuilderInterface;        // Clase necesario para AbstractType
	use Symfony\Component\OptionsResolver\OptionsResolver;  // Clase necesario para AbstractType
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
  /*
   * EntityType permite mostrar en el formulario un listado de opciones procedente
   * de otro formulario
   */
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;     // Campo Tipo EntityType
/**************************************************************************************************************/
	use Doctrine\ORM\EntityRepository;
/* Añadimos los componentes que permitirán el uso de EntityField **********************************************/
	/*
	 * EntityType permite mostrar en el formulario un listado de opciones procedente
	 * de otro formulario
	 */
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
	use Symfony\Component\Form\Extension\Core\Type\DateType;
	use Symfony\Component\Form\Extension\Core\Type\NumberType;
	use Symfony\Component\Form\Extension\Core\Type\SearchType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
	use Symfony\Component\Form\Extension\Core\Type\CollectionType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**************************************************************************************************************/
class MedicalHistoryType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		// Usamos la propiedad 'allow_extra_fields' pasar las variables
		$permissionLoggedUser = $options['allow_extra_fields'];
		$clinicNameUrl = $options['attr']['clinicNameUrl'];
		$userLoggedId = $options['attr']['userLoggedId'];
		$builder
			->add('name', TextType::class, array(
				'required'=>true,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('surname', TextType::class, array(
				'required'=>true,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('nickname', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('dni', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('phoneHome', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('phoneMobile', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('email', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('address', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			/**************************************************************************************************/
		 	->add('city', TextType::class, array(
		 		'required'=>false,
		 		'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:0px', 'id'=>'search-box')))
			/**************************************************************************************************/
			->add('height', NumberType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('weight', NumberType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('gender', EntityType::class,array(
				'required'=>true,
				'class' => 'BackendBundle:TypeGender',
				'choice_label' => 'type',
				'query_builder' => function($er) {
					return $er->createQueryBuilder('u');
				},
				'label' => 'Sexo',
				/***********************************************************************************************/
				//'expanded'     => true,       // Muestra todas las opciones (radio buttons O checkboxes)
				'expanded'     => false,       // Muestra todas las opciones (radio buttons O checkboxes)
				'multiple'     => false,      // Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
				'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
			))
			->add('birthday', DateType::class, array(
				'required'=>false,
				'widget' => 'single_text',
				'format'=>'dd/MM/yyyy',
				//'format'=>'yyyy-MM-dd',
				// do not render as type='date', to avoid HTML5 date pickers
				'html5' => false,
				// add a class that can be selected in JavaScript
				'attr'=>array('class'=>'form-control', 'style' => 'z-index:0;')
				))
			/**************************************************************************************************/
/*			->add('patientRisk', CollectionType::class, array(
				'required'=>false,
				'entry_type'   => TextType::class,'attr'=>array('class'=>'form-control tagsinput', 'style' => 'margin-bottom:13px'),
				'entry_options'  => array(
        			'attr'      => array('class' => 'tags')
        		)))

			/**************************************************************************************************/
			->add('reasonConsultation', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('background', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('allergicDiseases', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('treatmentDiseases', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('patologies', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('supplementaryTest', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('diagnostic', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('treatment', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('note', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('insuranceCarrier', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')));			
			if($permissionLoggedUser->getMedicalHistoryUserRegistererEdit() == true){
				$builder
				->add('userRegisterer', EntityType::class,array(
					'class' => 'BackendBundle:User',
					'choice_label' => 'user',
					'query_builder' => function($er) use( $clinicNameUrl, $userLoggedId ) {
						return $er->getUserDoctorListOfClinic($clinicNameUrl, $userLoggedId);
                	},
                	'label' => 'userName',
					'expanded' => false,		// Muestra todas las opciones (radio buttons O checkboxes)
					'multiple' => false,		// Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
					'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
				));
			}
			if($permissionLoggedUser->getMedicalHistoryRegistrationDateEdit() == true){
				$builder
				->add('registrationDate', DateType::class, array(
					'required'=>false,
					'widget' => 'single_text',
					'format'=>'dd/MM/yyyy',
					'html5' => false,
					'attr'=>array('class' => 'form-control')
				));
			}
			if($permissionLoggedUser->getMedicalHistoryUserModifierEdit() == true){
				$builder
				->add('userModifier', EntityType::class,array(
					'class' => 'BackendBundle:User',
					'choice_label' => 'user',
					'query_builder' => function($er) use( $clinicNameUrl, $userLoggedId ) {
						return $er->getUserDoctorListOfClinic($clinicNameUrl, $userLoggedId);
                	},
                	'label' => 'userName',
					'expanded'     => false,       // Muestra todas las opciones (radio buttons O checkboxes)
					'multiple'     => false,      // Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
					'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
				));
			}
			if($permissionLoggedUser->getMedicalHistoryModificationDateEdit() == true){
				$builder
				->add('modificationDate', DateType::class, array(
					'required'=>false,
					'widget' => 'single_text',
					'format'=>'dd/MM/yyyy',
					'html5' => false,
					'attr'=>array('class' => 'form-control'),
					'data' => new \DateTime("now")
				));
			}
			$builder
			->add('Actualizar',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success', 'style' => 'margin-bottom:13px, display:block')));
    }
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver)    {
        $resolver->setDefaults(array('data_class' => 'BackendBundle\Entity\MedicalHistory'));
    }
/**************************************************************************************************************/
}
