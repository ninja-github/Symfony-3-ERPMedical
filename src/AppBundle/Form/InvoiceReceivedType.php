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
	use Symfony\Component\Form\Extension\Core\Type\DateType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\NumberType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**************************************************************************************************************/
class InvoiceReceivedType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		// Usamos la propiedad 'allow_extra_fields' pasar las variables
		$permissionLoggedUser = $options['allow_extra_fields'];
		$userLoggedId = $options['attr']['userLoggedId'];
		$clinicNameUrl = $options['attr']['clinicNameUrl'];
		$builder
			->add('taxBase', NumberType::class, array(
				'required'=>true,
				'attr'=>array('class'=>'form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Base Imponible')
			))
			->add('iva', NumberType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Iva')
			))
			->add('re', NumberType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', "style" => "margin-bottom:10px", 'placeholder'=>'RE')
			))
			->add('note', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Nota')
			))
			->add('business', EntityType::class,array(
				'class' => 'BackendBundle:Business',
				'query_builder' => function($er) use( $clinicNameUrl) {
					return $er->createQueryBuilder('b')
					->innerJoin('b.clinic', 'cl', 'cl.id = b.clinic')
					->where('cl.nameUrl=:clinicNameUrl')
					->setParameter('clinicNameUrl', $clinicNameUrl);
				},
				'choice_label' => 'name',
				'expanded' => false,		// Muestra todas las opciones (radio buttons O checkboxes)
				'multiple' => false,		// Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
				'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
			))
			->add('invoiceNumber', FileType::class, array(
				'label'=>'Foto',
				'required'=>true,
				'data_class'=>null, // campo independiente
				'multiple'=>false,
				'attr'=>array('class'=>'form-image form-control', "style" => "margin-bottom:10px")
			))
			->add('registrationDate', DateType::class, array(
					'required'=>false,
					'widget' => 'single_text',
					'format'=>'dd/MM/yyyy',
					'html5' => false,
					'attr'=>array('class' => 'form-control'),
					'data' => new \DateTime("now")
				))
			->add('add',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success')));			
	   }
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver)    {
        $resolver->setDefaults(array('data_class' => 'BackendBundle\Entity\InvoiceReceived'));
    }
/**************************************************************************************************************/
}			