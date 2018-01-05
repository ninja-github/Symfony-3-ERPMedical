<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Spipu\Html2Pdf\Html2Pdf;    // Objeto Base de Html2Pdf
	use Symfony\Component\HttpFoundation\RedirectResponse;

class PruebasController extends Controller {
	public function pdfAction(Request $request){
		$html = $this->renderView(
			// src/AppBundle/Resources/views/Pruebas/pruebas_View_pdf.html.twig			
			'AppBundle:MedicalHistory:medicalHistory_View_pdf.html.twig',
			// indicamos las variables de entrada a la plantilla
			array('title'=>'awesome PDF')
		);
		$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
		$html2pdf->writeHTML($html);
//		$pdf->writeHTML("<h1>HolaMundo</h1>");
		$html2pdf->Output('PdfGeneradoPHP.pdf');
		var_dump($html2pdf);die();
	}
	public function googleCalendarAction(Request $request){
		$request = $this->get('request_stack')->getMasterRequest();

		$googleCalendar = $this->get('fungio.google_calendar');
		$googleCalendar->setRedirectUri($redirectUri);

		if ($request->query->has('code') && $request->get('code')) {
		    $client = $googleCalendar->getClient($request->get('code'));
		} else {
		    $client = $googleCalendar->getClient();
		}
		if (is_string($client)) {
		    return new RedirectResponse($client);
		}
		$events = $googleCalendar->getEventsForDate('primary', new \DateTime('today'));
		var_dump($events);die();
	}	
}