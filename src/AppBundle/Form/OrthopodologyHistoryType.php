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
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**************************************************************************************************************/
class OrthopodologyHistoryType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		// Usamos la propiedad 'allow_extra_fields' y 'attr' pasar las variables
		$permissionLoggedUser = $options['allow_extra_fields'];
		$medicalHistoryNumber = $options['attr']['medicalHistoryNumber'];
		$clinicNameUrl = $options['attr']['clinicNameUrl'];
		$userLoggedId = $options['attr']['userLoggedId'];
		if($medicalHistoryNumber == 'without_MedicalHistoryNumber' ){
			$builder
				->add('medicalHistory', EntityType::class,array(
					'class' => 'BackendBundle:MedicalHistory',
					'choice_label' => 'MedicalHistoryList',
					'query_builder' => function($er) use ($clinicNameUrl){
						return $er->createQueryBuilder('mH')
						->innerJoin('mH.clinic','c', 'c.id = mH.clinic')
						->where('c.nameUrl =:clinicNameUrl')
						->setParameter('clinicNameUrl', $clinicNameUrl);
					},
					'label' => 'userName',
					'expanded'     => false,       // Muestra todas las opciones (radio buttons O checkboxes)
					'multiple'     => false,      // Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
					'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
			));
		}
		$builder
			->add('shoeSize', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('height', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('weight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))								
			->add('reasonConsultation', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px;margin-top:3px;')))
			->add('background', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('articularExplorationRotaryPatternExternalLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px; text-align:center;')))
			->add('articularExplorationRotaryPatternExternalRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px; text-align:center;')))
			->add('articularExplorationRotaryPatternInternalLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px; text-align:center;')))
			->add('articularExplorationRotaryPatternInternalRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px; text-align:center;')))
			->add('articularExplorationHipLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationHipRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationKneeLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationKneeRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
        	->add('articularExplorationAnkleLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
        	->add('articularExplorationAnkleRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationRetroPieLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationRetroPieRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationBeforeFootLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationBeforeFootRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationFirstRadioLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationFirstRadioRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationFifthRadioLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationFifthRadioRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px;')))
			->add('articularExplorationCentralRadiosLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationCentralRadiosRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationFirstFingerLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationFirstFingerRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationSmallerFingersLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('articularExplorationSmallerFingersRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsFemoralLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsFemoralRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsGenusLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsGenusRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsAngleQLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsAngleQRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsTibialLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsTibialRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsHelbingLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('torsionsHelbingRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('dissimmetry', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('muscularExplorationDorsalFlexionLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationDorsalFlexionRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationPlantarFlexionLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationPlantarFlexionRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationEversionLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationEversionRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationReversalLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('muscularExplorationReversalRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100%; border: 0px; text-align:center;')))
			->add('dinamicExploration', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('signsFootprint', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('suplementaryTest', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('diagnostic', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('treatment', TextareaType::class, array(
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
			->add('submit',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success', 'style' => 'margin-bottom:13px, display:block')));
    }
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array( 'data_class' => 'BackendBundle\Entity\OrthopodologyHistory' ));
    }
/**************************************************************************************************************/
    public function getBlockPrefix() { return 'backendbundle_orthopodologyhistory'; }
}
