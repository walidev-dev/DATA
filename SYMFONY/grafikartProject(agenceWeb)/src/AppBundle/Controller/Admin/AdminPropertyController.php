<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Property;
use AppBundle\Form\PropertyType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminPropertyController extends Controller
{
    public function indexAction(PaginatorInterface $paginator,Request $request)
    {
        $query = $this->getDoctrine()->getRepository(Property::class)->getAllQuery();
        $properties = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            12
        );
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    public function editAction(
        Property $property,
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        $form = $this->createForm(PropertyType::class, $property);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager->flush();
                $this->addFlash('success', 'Le bien a été modifié avec succés');
                return $this->redirectToRoute('admin_property_index');
            } else {
                $errors = $validator->validate($property);
                return $this->render('admin/property/edit.html.twig', [
                        'errors' => $errors,
                        'form' => $form->createView()
                    ]
                );
            }
        }
        return $this->render('admin/property/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function createAction(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager->persist($property);
                $entityManager->flush();
                $this->addFlash('success', 'Le nouveau bien a été ajouté avec succés');
                return $this->redirectToRoute('admin_property_index');
            } else {
                $errors = $validator->validate($property);
                return $this->render('admin/property/new.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errors
                ]);
            }
        }
        return $this->render('admin/property/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deleteAction(
        Property $property,
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
            $this->addFlash('success', 'Le bien a été supprimé avec succés');
            return $this->redirectToRoute('admin_property_index');
        }
    }
}
