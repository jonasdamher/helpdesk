<?php 

require_once 'BaseController.php';

class IncidenceController extends BaseController {

    public function __construct() {
        $this->permission([1, 2]);
        parent::__construct(['incidence', 'Article', 'ArticlePointOfSale', 'ArticleBorrowed']);
    }

    public function index() {   

        $incidences = $this->model('incidence')->readAll();
        $pagination = $this->model('incidence')->paginations();

        include $this->view('incidence/index');
    }
    
    public function new() {
   
        $pointsOfSales = $this->model('incidence')->getPointOfSales();
        $users = $this->model('incidence')->getUsers();
        $priorities = $this->model('incidence')->getPriorities();
        $status = $this->model('incidence')->getStatus();
        $types = $this->model('incidence')->getType();
        
        if($this->submitForm() ) {

            $validator = $this->model('incidence')->formValidate('all');

            if($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('incidence')->setSubject($schema['subject']);
                $this->model('incidence')->setDescription($schema['description']);
                $this->model('incidence')->setIdPtoOfSales($schema['id_pto_of_sales']);
                $this->model('incidence')->setIdAttended($schema['id_attended']);
                $this->model('incidence')->setIdPriority($schema['id_priority']);
                $this->model('incidence')->setIdStatus($schema['id_status']);
                $this->model('incidence')->setIdType($schema['id_type']);

                $this->setResponseMessage($this->model('incidence')->create());

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
        }
        
        include $this->view('incidence/new');
    }

    public function update() {

        $this->model('incidence')->setId($_GET['id']);

        $incidence = $this->model('incidence')->read();

        $pointsOfSales = $this->model('incidence')->getPointOfSales();
        $users = $this->model('incidence')->getUsers();
        $priorities = $this->model('incidence')->getPriorities();
        $status = $this->model('incidence')->getStatus();
        $types = $this->model('incidence')->getType();
        
        if($this->submitForm() ) {

            $validator = $this->model('incidence')->formValidate('all');

            if($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('incidence')->setSubject($schema['subject']);
                $this->model('incidence')->setDescription($schema['description']);
                $this->model('incidence')->setIdPtoOfSales($schema['id_pto_of_sales']);
                $this->model('incidence')->setIdAttended($schema['id_attended']);
                $this->model('incidence')->setIdPriority($schema['id_priority']);
                $this->model('incidence')->setIdStatus($schema['id_status']);
                $this->model('incidence')->setIdType($schema['id_type']);

                $this->setResponseMessage($this->model('incidence')->update());

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
        }
        
        include $this->view('incidence/update');
    }

    public function assigned() {   

        $this->model('incidence')->setIdAttended($_SESSION['user_init']);
        $this->index();
    }

    public function details() {

        $this->model('incidence')->setId($_GET['id']);
        $incidence = $this->model('incidence')->getDetails();

        // ARTICLES POINT OF SALE
        $this->model('ArticlePointOfSale')->setIdIncidence($_GET['id']);
        
        $articles = $this->model('ArticlePointOfSale')->articlesIncidence();
        $countArticles = count($articles);

        // ARTICLES BORROWED
        $this->model('ArticleBorrowed')->setIdIncidence($_GET['id']);
        
        $articlesBorrowed = $this->model('ArticleBorrowed')->articlesIncidence();
        $countArticlesBorrowed = count($articlesBorrowed);
        include $this->view('incidence/details');
    }

    public function collected() {

        // INCINDENCE
        $this->model('incidence')->setId($_GET['id']);
        $incidence = $this->model('incidence')->getDetails();
        
        // ARTICLE ONLY POINT OF SALE
        $this->model('ArticlePointOfSale')->setIdIncidence($_GET['id']);
        $articlePointOfSale = $this->model('ArticlePointOfSale')->readAll();
        $pagination = $this->model('ArticlePointOfSale')->paginations();
        $typesArticle = $this->model('ArticlePointOfSale')->getTypes();
       
        include $this->view('incidence/collected');
    }

    public function borrowed() {

        // INCINDENCE
        $this->model('incidence')->setId($_GET['id']);
        $incidence = $this->model('incidence')->getDetails();
        
        // ARTICLE BORROWED POINT OF SALE
        $this->model('ArticleBorrowed')->setIdIncidence($_GET['id']);
        $articlesBorrowed = $this->model('ArticleBorrowed')->readAll();
        $pagination = $this->model('ArticleBorrowed')->paginations();
        $articles = $this->model('Article')->getNotBorrowed();
        $borroweStatus = $this->model('ArticleBorrowed')->getborrowedStatus();

        include $this->view('incidence/borrowed');
    }
}

?>