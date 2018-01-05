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
	use Symfony\Component\Form\Extension\Core\Type\CollectionType;
	use Symfony\Component\Form\Extension\Core\Type\DateType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\HiddenType;
/**************************************************************************************************************/
class TracingType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		// Usamos la propiedad 'allow_extra_fields' pasar las variables
		$userPermission = $options['allow_extra_fields'];
		$clinicNameUrl = $options['attr']['clinicNameUrl'];
		$idTracing = $options['attr']['idTracing'];
		$builder
			->add('date', DateType::class, array(
					'required'=>false,
					'widget' => 'single_text',
					'format'=>'dd/MM/yyyy',
					'html5' => false,
					'attr'=>array('class' => 'form-control')))
            ->add('tracing', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px; height: 150px;')));
		if($idTracing != NULL){
			$builder
				->add('id', HiddenType::class, array(
					'required'=>false,
					'attr'=>array('class' => 'form-control')));
		}
/*
		$builder
            ->add('idUser', EntityType::class,array(
				'class' => 'BackendBundle:User',
				'choice_label' => 'user',
				'query_builder' => function($er) use($clinicNameUrl) {
					return $er->getUserListOfClinic($clinicNameUrl);
               	},
               	'label' => 'userName',
				'expanded' => false,		// Muestra todas las opciones (radio buttons O checkboxes)
				'multiple' => false,		// Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
				'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
				))
            ->add('idTypeTracing', EntityType::class, array(
                'class' => 'BackendBundle:TypeTracing',
                'query_builder' => function ( $er) { return $er->createQueryBuilder('TT'); },
                'choice_label' => 'translate', //columna que se mostrará
                'expanded'     => false,       // Muestra todas las opciones (radio buttons O checkboxes)
                'multiple'     => false,      // Multiple seleccion ( select tag     O select tag (with multiple attribute) )
                'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px') ))
        ->add('idOrthopodologyHistory')
        ->add('idMedicalHistory')
            ;
*/
//		if($idTracing == NULL){
			$builder
				->add('submit',SubmitType::class, array(
					'attr'=>array('class'=>'form-submit btn btn-success pull-right', 'style' => 'margin-bottom:13px, display:block')));
//		}            
		
    }
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver)    {
        $resolver->setDefaults(array('data_class' => 'BackendBundle\Entity\Tracing'));
    }
/**************************************************************************************************************/
}