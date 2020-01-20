<?php

namespace AppBundle\Controller;

use AppBundle\Events\MessagePostEvent;
use AppBundle\Events\PlatformEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\DoctrineListener\ApplicationMailer;
use AppBundle\Entity\Advert;
use AppBundle\Entity\Application;
use AppBundle\Entity\Image;
use AppBundle\Form\AdvertEditType;
use AppBundle\Form\AdvertType;
use AppBundle\Repository\AdvertRepository;
use AppBundle\Service\TwigExtension\Antispam;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdvertController extends Controller
{

    public function indexAction($page)
    {


        /*$applicationRepository = $entityManager->getRepository(Application::class);
        $applicationsByAdvert = $applicationRepository->findBy(['advert' => 4],['date' => 'DESC']);*/

        if ($page < 1) {
            throw new NotFoundHttpException("La Page " . $page . " est inexistante");
        }

        $perPage = $this->getParameter('perPage');
        $listAdverts = $this->getDoctrine()->getRepository(Advert::class)->getAdverts2($page, $perPage);

        /*
         * dans le cas ou on a utilisé la classe Paginator dans le repository
         * $pagesCount = ceil(count($listAdverts) / $perPage);
         * */

        $pagesCount = ceil($this->getDoctrine()->getRepository(Advert::class)->AdvertsCount() / $perPage);
        if ($page > $pagesCount) {
            throw new NotFoundHttpException("La Page " . $page . " est inexistante");
        }
        return $this->render('Advert/index.html.twig', compact('listAdverts', 'pagesCount', 'page'));
    }

    public function menuAction($limit)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $advertRepository = $entityManager->getRepository(Advert::class);
        /*$query = $advertRepository->createQueryBuilder('a')
            ->orderBy('a.date','DESC')
            ->setMaxResults($limit)
            ->getQuery();*/

        $listAdverts = $advertRepository->getLast($limit);
        return $this->render('Advert/menu.html.twig', ['listAdverts' => $listAdverts]);
    }

    public function viewAction(Request $request, $slug, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $advertRepository = $entityManager->getRepository('AppBundle:Advert');
        /*$advert = $advertRepository->find($id);*/

        /* foreach ($advert->getCategories() as $category){
                     dump($category);
          }
        die;*/


        $advert = $advertRepository->getOne($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id $id n'existe pas.");
        }
        if ($advert->getSlug() != $slug) {
            /*return $this->redirectToRoute('app_platform_view', [
                      'id' => $advert->getId()
                    , 'slug' => $advert->getSlug()
                ]
            );*/

            return new RedirectResponse($request->getBaseUrl() . '/platform/advert/' . $advert->getSlug() . '/' . $advert->getId());
        }
        return $this->render('Advert/view.html.twig', ['advert' => $advert]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(
        FormFactoryInterface $formFactory,
        Request $request,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        ValidatorInterface $validator,
        EventDispatcherInterface $dispatcher,
        TokenStorageInterface $tokenStorage
    )
    {
        //$token = $this->get('security.token_storage')->getToken();
        //$user = $token->getUser();
        $advert = new Advert();
        $advert->setUser($tokenStorage->getToken()->getUser());
        //$formFactory->create(AdvertType::class,$advert);
        $form = $this->createForm(AdvertType::class, $advert);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                //$advert->getImage()->upload();
                $event = new MessagePostEvent($advert->getContent(), $advert->getUser());
                $dispatcher->dispatch(PlatformEvents::POST_MESSAGE, $event);
                $entityManager->persist($advert);
                $entityManager->flush();
                $flashBag->add('notice', 'Annonce bien enregistrée');
                return $this->redirectToRoute('app_platform_view', [
                        'id' => $advert->getId(),
                        'slug' => $advert->getSlug()
                    ]
                );
            } else {
                //$validator = $this->get('validator');
                $listErrors = $validator->validate($advert);
                return $this->render('Advert/add.html.twig', [
                        'form' => $form->createView(),
                        'listErrors' => $listErrors
                    ]
                );
            }
        }
        return $this->render('Advert/add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction(
        $id,
        Request $request,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager
    )
    {
        $advert = $this->getDoctrine()->getRepository(Advert::class)->getOne($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'ID " . $id . " n'existe pas");
        }
        $form = $formFactory->create(AdvertEditType::class, $advert);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $entityManager->flush();
            $this->addFlash('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('app_platform_home');
        }
        return $this->render('Advert/edit.html.twig', ['form' => $form->createView()]);
    }

    public function deleteAction(FormFactoryInterface $formFactory, Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $advert = $entityManager->getRepository(Advert::class)->getOne($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'ID " . $id . " n'existe pas");
        }
        $form = $formFactory->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)) {
            $applications = $entityManager->getRepository(Application::class)->findBy(['advert' => $advert]);
            foreach ($applications as $application) {
                $entityManager->remove($application);
            }
            $entityManager->remove($advert);
            $entityManager->flush();
            $this->addFlash('notice', 'L\'annonce a été supprimée avec succés');
            return $this->redirectToRoute('app_platform_home');
        }
        return $this->render('Advert/delete.html.twig', [
                'advert' => $advert,
                'form' => $form->createView()
            ]
        );

    }

    public function viewSlugAction($year, $slug, $format)
    {
        return new Response("YEAR = $year , SLUG = $slug , FORMAT = $format");
    }


    public function transAction(string $name)
    {
        return $this->render('Advert/trans.html.twig', ['name' => $name]);
    }
}

