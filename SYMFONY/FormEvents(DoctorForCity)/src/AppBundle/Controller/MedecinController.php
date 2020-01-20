<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Medecin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Medecin controller.
 *
 */
class MedecinController extends Controller
{
    /**
     * Lists all medecin entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $medecins = $em->getRepository('AppBundle:Medecin')->findAllWithRegion();

        return $this->render('medecin/index.html.twig', array(
            'medecins' => $medecins,
        ));
    }

    /**
     * Creates a new medecin entity.
     *
     */
    public function newAction(Request $request)
    {
        $medecin = new Medecin();
        $form = $this->createForm('AppBundle\Form\MedecinType', $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medecin);
            $em->flush();

            return $this->redirectToRoute('medecin_show', array('id' => $medecin->getId()));
        }

        return $this->render('medecin/new.html.twig', array(
            'medecin' => $medecin,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a medecin entity.
     *
     */
    public function showAction(Request $request)
    {
        $medecin = $this->getDoctrine()->getRepository(Medecin::class)->findWithRegion($request->get('id'));
        $deleteForm = $this->createDeleteForm($medecin);

        return $this->render('medecin/show.html.twig', array(
            'medecin' => $medecin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing medecin entity.
     *
     */
    public function editAction(Request $request)
    {
        $medecin = $this->getDoctrine()->getRepository(Medecin::class)->findWithRegion($request->get('id'));
        $deleteForm = $this->createDeleteForm($medecin);
        $editForm = $this->createForm('AppBundle\Form\MedecinType', $medecin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/edit.html.twig', array(
            'medecin' => $medecin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a medecin entity.
     *
     */
    public function deleteAction(Request $request, Medecin $medecin)
    {
        $form = $this->createDeleteForm($medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medecin);
            $em->flush();
        }

        return $this->redirectToRoute('medecin_index');
    }

    /**
     * Creates a form to delete a medecin entity.
     *
     * @param Medecin $medecin The medecin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medecin $medecin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medecin_delete', array('id' => $medecin->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
