<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
{
    #[Route('/apip/user_connect', name: 'user_connect')]
    public function getUserByConnect(
        SerializerInterface $serializer, 
        UserRepository $userRepository): JsonResponse
    {

        $userConnected = $this->getUser();
        $user = $userRepository->find($userConnected);
        $context = (new ObjectNormalizerContextBuilder())
        ->withGroups('read_user')
        ->toArray();
        $jsonUser = $serializer->serialize($user, 'json', $context);

        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }
}
