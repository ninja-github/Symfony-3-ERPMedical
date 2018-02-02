<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Spipu\Html2Pdf\Html2Pdf;    // Objeto Base de Html2Pdf
	use Symfony\Component\Validator\Constraints\DateTime;


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
		//$pdf->writeHTML("<h1>HolaMundo</h1>");
		$html2pdf->Output('PdfGeneradoPHP.pdf');
		var_dump($html2pdf);die();
	}
	public function googleCalendarAction(Request $request){
		$request = $this->get('request_stack')->getMasterRequest();
		$googleCalendar = $this->get('fungio.google_calendar');
		if (isset($redirectUri)){
			$googleCalendar->setRedirectUri($redirectUri);
		}
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
	public function getDataEventAction(){
		$originalStart =  date_create_from_format('Y-m-d\TH:i:sP', "2018-01-01T11:30:00+01:00");
		$timeZone = date_format($originalStart, 'P');
		var_dump(date_format($originalStart, 'P'));
		echo "<br>";
		$calendarId = "podologiapriego@gmail.com";
		$eventId = "0k5308ah33eagqojv8bkon1hov";
		$request = $this->get('request_stack')->getMasterRequest();
		$googleCalendar = $this->get('fungio.google_calendar');
		$eventGoogleCalendar = $googleCalendar->getEvent($calendarId, $eventId);
		$startEventOriginal = $eventGoogleCalendar->getStart();
		$startEventOriginalString = $startEventOriginal->getDateTime();
		$originalStart =  date_create_from_format('Y-m-d\TH:i:sP', $startEventOriginalString);

		$timeZone = date_format($originalStart, 'P');
		$newDate = "01-01-2018 12:30:00".$timeZone;
		$newDate_ =  date_create_from_format('d-m-Y H:i:sP', $newDate);
		var_dump($timeZone );var_dump($newDate);var_dump($newDate_);
		//var_dump(date_format($eventGoogleCalendar->getStart(), 'P'));
		die();	
	}
	public function updateDataEventAction(){
		$originalStart =  date_create_from_format('Y-m-d\TH:i:sP', "2018-01-01T11:30:00+01:00");
		$timeZone = date_format($originalStart, 'P');
		var_dump(date_format($originalStart, 'P'));
		echo "<br>";
		$calendarId = "podologiapriego@gmail.com";
		$eventId = "0k5308ah33eagqojv8bkon1hov";
		$request = $this->get('request_stack')->getMasterRequest();
		$googleCalendar = $this->get('fungio.google_calendar');
		$eventGoogleCalendar = $googleCalendar->getEvent($calendarId, $eventId);
		$startEventOriginal = $eventGoogleCalendar->getStart();
		$startEventOriginalString = $startEventOriginal->getDateTime();
		$originalStart =  date_create_from_format('Y-m-d\TH:i:sP', $startEventOriginalString);
		$timeZone = date_format($originalStart, 'P');
		$StartDateTime = "01-01-2018 12:30:00".$timeZone;
		$EndDateTime = "01-01-2018 13:30:00".$timeZone;
		$StartDateTimeObject =  date_create_from_format('d-m-Y H:i:sP', $StartDateTime);
		$EndDateTimeObject =  date_create_from_format('d-m-Y H:i:sP', $EndDateTime);
			$eventSummary = "correct";$eventDescription="<a href='https://www.w3schools.com'>Visit W3Schools.com!</a>";			
			$eventAttendee = "";
			$location = $eventGoogleCalendar->getLocation();
			$eventDescription = $eventGoogleCalendar->getDescription();
			$optionalParams = ['paciente'];
			$allDay = false;
		var_dump($timeZone );
		$googleCalendar->updateEvent($calendarId, $eventId, $StartDateTimeObject, $EndDateTimeObject, $eventSummary, $eventDescription, $eventAttendee, $location, $optionalParams, $allDay);
		$eventupdate = $googleCalendar->getEvent($calendarId, $eventId);
		var_dump($eventupdate);
		//var_dump(date_format($eventGoogleCalendar->getStart(), 'P'));
		die();	
	}	
}