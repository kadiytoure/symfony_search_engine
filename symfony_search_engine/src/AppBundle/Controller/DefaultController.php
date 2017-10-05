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

        
        $price = $request->request->get('appbundle_product')['price'];
        $name = $request->request->get('appbundle_product')['name'];
        
        $premium = false;
        if(isset($request->request->get('appbundle_product')['premium'])){
            $premium = $request->request->get('appbundle_product')['premium'];
        }

        $note = $request->request->get('appbundle_product')['note'];
        
        
        
        $query = $repository->createQueryBuilder('p');
        
        $query->where('p.enabled = 1');
                
        
        if($price > 0) {
            $query->andWhere('p.price > :price')
                  ->setParameter('price', $price);
        }
        
        if($premium == true){
            $query->andWhere('p.premium = 1');
        }
        
        if($name != '') {
            $query->andWhere('p.name LIKE :name')
                  ->setParameter('name', '%'.$name.'%');
        }
        
        if($note > 0) {
            $query->andWhere('p.note > :note')
                  ->setParameter('note', $note);
        }
        
        
        $query = $query->orderBy('p.price', 'ASC')
              ->getQuery();
        
        $products = $query->getResult();
        
        return $this->render('default/search.html.twig', array(
            'products' => $products,
            'searchForm' => $form->createView()
        ));
        

    }
     
  
}
