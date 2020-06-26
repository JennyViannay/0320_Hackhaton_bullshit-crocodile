<?php

namespace App\Controller;

use App\Entity\Excuse;
use App\Entity\ExcuseLike;
use App\Form\ExcuseType;
use App\Repository\ExcuseLikeRepository;
use App\Repository\ExcuseRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/excuse")
 */
class ExcuseController extends AbstractController
{

    /**
     * @Route("/", name="excuse_list", methods={"GET"})
     */
    public function index(ExcuseRepository $excuseRepository)
    {
        return $this->render('excuse/index.html.twig', [
            'excuses' => $excuseRepository->findAll()
        ]);
    }

    /**
     * @Route("/like/{id}", name="excuse_like", methods={"GET"})
     */
    public function like(Excuse $excuse, ExcuseLikeRepository $excuseLikeRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if(!$user){
            //return $this->redirectToRoute('app_login');
            return $this->json(['message' => 'Unauthorized'], 403 );
        }

        if($excuse->isLikedByUser($user)){
            $like = $excuseLikeRepository->findOneBy(['excuse' => $excuse, 'user' => $user]);
            $em->remove($like);
            $em->flush();
            //return $this->redirectToRoute('post');
            return $this->json(['message' => 'Unliked', 'likes' => $excuseLikeRepository->count(['excuse' => $excuse])], 200 );
        }
        
        $like = new ExcuseLike();
        $like->setExcuse($excuse)->setUser($user);
        $like->setCreatedAt(new DateTime('now'));
        $em->persist($like);
        $em->flush();

        //return $this->redirectToRoute('post');
        return $this->json(['message' => 'Liked', 'likes' => $excuseLikeRepository->count(['excuse' => $excuse])], 200 );
    }

    /**
     * @Route("/new", name="excuse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $excuse = new Excuse();
        $form = $this->createForm(ExcuseType::class, $excuse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $excuse->setCreatedAt(new DateTime('now'));
            $excuse->setAuthor($this->getUser());
            $this->getUser()->addExcus($excuse);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($excuse);
            $entityManager->persist($this->getUser());
            $entityManager->flush();

            return $this->redirectToRoute('bet_history');
        }

        return $this->render('excuse/new.html.twig', [
            'excuse' => $excuse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="excuse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Excuse $excuse): Response
    {
        $form = $this->createForm(ExcuseType::class, $excuse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('excuse_index');
        }

        return $this->render('excuse/edit.html.twig', [
            'excuse' => $excuse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="excuse_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Excuse $excuse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$excuse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($excuse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('excuse_index');
    }
}
