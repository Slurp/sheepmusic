<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     */
    public function indexAction()
    {
        /** var FOS\ElasticaBundle\Finder\MappedFinder */
        $finder = $this->container->get('fos_elastica.finder.app');

        // Returns a mixed array of any objects mapped
        $results = $finder->find('metallica');
        dump($results);
        return;
    }
}
