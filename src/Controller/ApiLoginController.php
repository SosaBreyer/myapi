<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login")
     */
    public function index(): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = 'apiToken1234'; // somehow create an API token for $user

        $user->setApitoken($token);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
