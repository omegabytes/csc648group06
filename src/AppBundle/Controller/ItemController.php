<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Item;
use AppBundle\Entity\Posts;

use AppBundle\Form\ItemType;
use AppBundle\Form\PostsType;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends Controller
{

	/**
	 * @Route("/post/{item}", name="post")
	 */
	public function  postingAction($item) 
	{
		$repository = $this->getDoctrine()
				->getRepository('AppBundle:Item');
		$items = $repository->find($item);

		return $this->render('default/posting.html.twig', array('items' => $items));
	}

		/**
		 * @Route("/listings", name="listings")
		 */
		public function listingsAction(Request $request)
		{
				$repository = $this->getDoctrine()
						->getRepository('AppBundle:Item');

        $items = $repository->findAll();
 				return self::listItems($items, $request);
    }

    /**
     * @Route("/openOrders", name="openOrders")
     */
    public function openOrdersAction()
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $user = $user->getId();

        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $query = $repository->createQueryBuilder('item')
            ->where('item.userId = :id')
            ->setParameter('id', $user)
            ->getQuery();

        $items = $query->getResult();
				foreach ($items as $item) 
				{
					$item->getImage()->setUpdatedAt( date_format($item->getImage()->getUpdatedAt(), 'm-d-Y') );
				}
        return $this->render('default/openOrders.html.twig', array('items' => $items));
    }

    /**
     * @Route("/books", name="books")
     */
    public function booksAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $query = $repository->createQueryBuilder('item')
            ->where('item.category = :category')
            ->setParameter('category', 'book')
            ->getQuery();

        $books = $query->getResult();

        return $this->render('default/books.html.twig', array('books' => $books));
    }

    /**
     * @Route("/clothes", name="clothes")
     */
    public function clothesAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $query = $repository->createQueryBuilder('item')
            ->where('item.category = :category')
            ->setParameter('category', 'clothes')
            ->getQuery();

        $clothes= $query->getResult();

        return $this->render('default/clothes.html.twig', array('clothes' => $clothes));
    }

    /**
     * @Route("/tech", name="tech")
     */
    public function techAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $query = $repository->createQueryBuilder('item')
            ->where('item.category = :category')
            ->setParameter('category', 'tech')
            ->getQuery();

        $techs= $query->getResult();

        return $this->render('default/tech.html.twig', array('techs' => $techs));
    }
    
    /**
     * @Route("/service", name="service")
     */
    public function serviceAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $query = $repository->createQueryBuilder('item')
            ->where('item.category = :category')
            ->setParameter('category', 'service')
            ->getQuery();

        $service = $query->getResult();

        return $this->render('default/service.html.twig', array('service' => $service));
    }

    /**
     * @Route("/other", name="other")
     */
    public function otherAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $query = $repository->createQueryBuilder('item')
            ->where('item.category = :category')
            ->setParameter('category', 'other')
            ->getQuery();

        $other = $query->getResult();

        return $this->render('default/other.html.twig', array('other' => $other));
    }

    /**
     * @Route("/search", name="search")
     */
		public function searchAction(Request $request)
		{
				//get items from items table
				$repository = $this->getDoctrine()
						->getRepository('AppBundle:Item');

				$searchTerm = $_GET['searchTerm'];
				$category = $_GET['categoryFilter'];

				//        $search = $repository->createQueryBuilder('item')
				//            ->where('item.title LIKE :title')
				//            ->setParameter('title', '%'.$searchTerm.'%')
				//            ->getQuery()
				//            ->getResult();

				$search = $repository->createQueryBuilder('item');
        if ($searchTerm == null && $category == 'all') {
            $search = $this->getDoctrine()->getRepository('AppBundle:Item')
												->findAll();
            //if search category is defined and search term is defined
        } else if ($searchTerm == null && $category != null) {
            //Run query to find that is matching with given category field
            $search = $repository->createQueryBuilder('item')
                ->where('item.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getResult();
            //if search category is 'All' or is not defined and search term is defined
        } else if ($searchTerm != null && $category != null) {
            $search = $repository->createQueryBuilder('item')
                ->where('item.category = :category')
                ->andWhere('item.title LIKE :search_term')
                ->setParameter('category', $category)
                ->setParameter('searchTerm', "%" . $searchTerm . "%")
                ->getQuery()
                ->getResult();
        }

				return self::listItems($search, $request);

    }

		public function listItems($items, $request)
		{
				$posts = new Posts();
				foreach ($items as $item) 
				{
						$posts->getItem()->add($item);
				}

				$form = $this->createForm(PostsType::Class, $posts);
				$form->handleRequest($request);

				if ($form->isSubmitted() && $form->isValid()) 
				{

					$a = $form->getData()->getItem();
					$i = 0;
					foreach ($a as $b)
					{
						if ($a->get($i) == null)
						$i++;
					}

					$txt = new TextController(); 
					//$txt->textAction('14156598475','hello');

					return $this->render('default/home.html.twig');
				}

				return $this->render('default/listings.html.twig', array('items' => $items, 'forms' => $form->createView()));
		}

}