<?php

namespace AppBundle\Controller;

use AppBundle\Data\SearchData;
use AppBundle\Entity\Product;
use AppBundle\Form\SearchForm;
use AppBundle\FormHelper\FormError;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends Controller
{
    /**
     * @Route("/",name="product")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param ValidatorInterface $validator
     * @param FormError $formError
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(
        Request $request,
        PaginatorInterface $paginator,
        ValidatorInterface $validator,
        FormError $formError
    )
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchForm::class, $searchData);
        $form->handleRequest($request);

        /* $errors_list = $validator->validate($searchData);
         $error = [];
         foreach($errors_list as $error){
             $errors[$error->getPropertyPath()] = $error->getMessage();
         }*/

//        $errors = [];
//
//        if (!$form->isValid()) {
//            foreach ($form->getErrors(true, false) as $error) {
//                $errors[$error->getOrigin()->getName()] = $error->getMessage();
//            }
//        }


        $errors = $formError->getErrors($form);

        $query = $this->getDoctrine()->getRepository(Product::class)->findSearchQuery($searchData);

        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            15
        );

        list($min, $max) = $this->getDoctrine()->getRepository(Product::class)->findMinMax();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max,
            'errors' => $errors
        ]);
    }
}
