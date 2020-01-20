<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{id}", name="homepage")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(int $id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
        $experiences = new ArrayCollection();
        foreach ($user->getExperiences() as $experience) {
            $experiences->add($experience);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            foreach ($experiences as $experience) {
                if ($user->getExperiences()->contains($experience) === false) {
                    $em->remove($experience);
                }
            }
            $em->persist($user);
            $em->flush();
        }
        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
