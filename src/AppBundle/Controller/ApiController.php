<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("users")
 */
class ApiController extends Controller
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function indexAction(EntityManagerInterface $entityManagerInterface)
    {
        $userRepository = $entityManagerInterface->getRepository('AppBundle:User');

        return $this->json($userRepository->findAll(), 200);
    }

    /**
     * @Route("/", name="user_create", methods={"POST"})
     */
    public function createAction(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $entityManagerInterface,
                                ValidatorInterface $validatorInterface)
    {
        $userTemp = $request->getContent();

        try 
        {
            $user = $serializerInterface->deserialize($userTemp, User::class,  'json');

            $errors = $validatorInterface->validate($user);

            if (count($errors) > 0) {
                return $this->json([
                    'status' => 400,
                    'message'=> json_encode($errors)
                ], 400);
            }

            $entityManagerInterface->persist($user);

            $entityManagerInterface->flush();

        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message'=> $e->getMessage()
            ], 400);
        }

        return $this->json($user, 200);
    }

    /**
     * @Route("/{id}", name="user_edit", methods={"PUT"})
     */
    public function editAction(User $user, Request $request, SerializerInterface $serializerInterface, 
                            ValidatorInterface $validatorInterface, EntityManagerInterface $entityManagerInterface)
    {
        $userTemp = $request->getContent();

        try 
        {
            if (!$user) {
                return $this->json([
                    'status' => 400,
                    'message'=> "Cet utilisateur n'existe pas"
                ], 400);
            }

            $userTemp = $serializerInterface->deserialize($userTemp, User::class,  'json');

            $errors = $validatorInterface->validate($userTemp);

            if (count($errors) > 0) {
                return $this->json([
                    'status' => 400,
                    'message'=> json_encode($errors)
                ], 400);
            }

            $user->setFirstname($userTemp->getFirstname());
            $user->setLastname($userTemp->getLastname());

            $entityManagerInterface->flush();

        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message'=> $e->getMessage()
            ], 400);
        }
        
        return $this->json($user, 200);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteAction(User $user, EntityManagerInterface $entityManagerInterface)
    {
        if (!$user) {
            return $this->json([
                'status' => 400,
                'message'=> "Cet utilisateur n'existe pas"
            ], 400);
        }

        $entityManagerInterface->remove($user);
        $entityManagerInterface->flush();

        return $this->json($user, 200);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function showAction(User $user)
    {
        return $this->json($user, 200);
    }

}
