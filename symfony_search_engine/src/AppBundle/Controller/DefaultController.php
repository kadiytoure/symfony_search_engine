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
    public function show(Request $request)
    {
        
        $form = $this->createForm(productType::class);
        
        $repository = $this->getDoctrine()->getRepository(product::class);
        //$products = $repository->findAll();
        //$request->request->get('form');
        $price = $request->request->get('form')['price'];
        $name = $request->request->get('form')['name'];
        $premium = $request->request->get('form')['premium'];
        $note = $request->request->get('form')['note'];
        
        
        
        $query = $repository->createQueryBuilder('p');
                
        
        
        if($price > 0) {
            $query->where('p.price > :price')
                  ->setParameter('price', $price);
        }
        
        if($name) {
            $query->where('p.name == :name')
                  ->setParameter('name', $name);
        }
        
         if($premium) {
            $query->where('p.premium == :premium')
                  ->setParameter('premium', $premium);
        }
        
         if($note) {
            $query->where('p.note == :note')
                  ->setParameter('note', $note);
        }
        
        
        $query = $query->orderBy('p.price', 'ASC')
              ->getQuery();
        
        $products = $query->getResult();
        
        return $this->render('default/search.html.twig', array(
            'products' => $products,
            'searchForm' => $form->createView()
        ));
        
       
        /*
        $name = $request->request->get('name');
        
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$name) {
            throw $this->createNotFoundException(
                    'No products found for' .$name);
        }
        
        $description = $request->request->get('description');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$description);
        }
        
        $ref = $request->request->get('ref');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$ref);
        }
        
         $ref = $request->request->get('ref');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$ref);
        }
        
        $enabled = $request->request->get('enabled');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$enabled);
        }
        
          $premium = $request->request->get('premium');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$premium);
        }
        
        $note = $request->request->get('note');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$note);
        }
        
        $created = $request->request->get('created');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$created);
        }
        
        $updated = $request->request->get('updated');
        $repository = $this->getDoctrine()->getRepository(product::class);
        $query = $repository->createQueryBuilder('p');
        if (!$description) {
            throw $this->createNotFoundException(
                    'No products found for' .$updated);
        }
        
        $products = $query->getResult();
       */ 
    }
     
  
}
