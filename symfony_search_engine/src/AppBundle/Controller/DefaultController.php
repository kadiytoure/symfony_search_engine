<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\productType;
use AppBundle\Entity\product;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    
    /**
     * @Route("/search", name="product_search")
     */
    public function show()
    {
        $form = $this->createForm(productType::class);
        
        $repository = $this->getDoctrine()->getRepository(product::class);
        $products = $repository->findAll();
        
        
        return $this->render('default/search.html.twig', array(
            'products' => $products,
            'searchForm' => $form->createView()
        ));
    }
     
   
     
  
}
