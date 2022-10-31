<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
  /**
   * @Route("/checkin", name="checkin", methods={"POST"})
   */
  public function checkin(ValidatorInterface $validator, Request $request): JsonResponse
  {
    $entityManager = $this->getDoctrine()->getManager();
    $ticketRepository = $entityManager->getRepository(Ticket::class);

    $data = json_decode($request->getContent(), true);

    if (empty($data['ticketCode']) || empty($data['scanTimestamp'])) {
      return $this->json(['success' => -2, 'error' => 'Expecting mandatory parameters']);
    }

    $ticket = $ticketRepository->findOneBy(['ticketCode' => $data['ticketCode']]);

    if ($ticket) {
      return $this->json(['success' => -1, 'scanTimestamp' => $ticket->getScanTimestamp()]);
    }

    $newTicket = new Ticket();
    $newTicket->setTicketCode($data['ticketCode']);
    $newTicket->setScanTimestamp($data['scanTimestamp']);

    $errors = $validator->validate($newTicket);

    if (count($errors) > 0) {
      $errorsString = (string) $errors;

      return $this->json(['success' => -3, 'error' => $errorsString]);
    }

    $ticketRepository->add($newTicket,true);

    return $this->json(['success' => true]);
  }
}