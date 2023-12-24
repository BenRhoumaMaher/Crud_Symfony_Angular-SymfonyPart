<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    #[Route('/authenticate', name: 'app_user')]
    public function authenticate(Request $request, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $userRepository->findOneBy(['UserName' => $data['UserName']]);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        if (!password_verify($data['Password'], $user->getPassword())) {
            throw $this->createAccessDeniedException('Invalid username or password');
        }

        $response = [
            'id' => $user->getId(),
            'UserName' => $user->getUsername(),
            'Password' => $user->getPassword()
        ];

        $response = $this->json($data);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}