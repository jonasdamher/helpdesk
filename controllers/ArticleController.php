<?php

declare(strict_types=1);

class ArticleController extends Controller
{

    public function __construct()
    {
        Auth::access();
        $this->loadModels(['generalArticle', 'article']);
    }

    public function index()
    {
        $table = $this->model('generalArticle')->readAll();
        $pagination = $this->model('generalArticle')->paginations();
        Head::title('Artículos');
        include View::render('article');
    }

    public function details()
    {

        // GENERAL ARTICLE
        $this->model('generalArticle')->setId($_GET['id']);
        $generalArticle = $this->model('generalArticle')->getDetails();

        // ARTICLE ONLY
        $this->model('article')->setIdArticle($_GET['id']);
        $articles = $this->model('article')->readAll();
        $pagination = $this->model('article')->paginations();
        $articleOnlyStatus = $this->model('article')->getStatus();

        $articlesTotalBorrowed = $this->model('article')->totalBorrowed();

        include View::render('article', 'details');
    }

    public function new()
    {

        $types = $this->model('generalArticle')->getArticlesTypes();
        $providers = $this->model('generalArticle')->getProviders();

        if ($this->submitForm()) {

            $validator = $this->model('generalArticle')->formValidate('all');

            if ($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('generalArticle')->setName($schema['name']);
                $this->model('generalArticle')->setDescription($schema['description']);
                $this->model('generalArticle')->setBarcode($schema['barcode']);
                $this->model('generalArticle')->setCost($schema['cost']);
                $this->model('generalArticle')->setPvp($schema['pvp']);
                $this->model('generalArticle')->setIdProvider($schema['id_provider']);
                $this->model('generalArticle')->setIdType($schema['id_type']);
                $this->model('generalArticle')->setImage('image');

                $this->setResponseMessage($this->model('generalArticle')->create());
            } else {
                $this->setResponseMessage($validator['errors']);
            }
        }

        include View::render('article', 'new');
    }

    public function update()
    {

        $this->model('generalArticle')->setId($_GET['id']);

        $article = $this->model('generalArticle')->read();

        $types = $this->model('generalArticle')->getArticlesTypes();
        $providers = $this->model('generalArticle')->getProviders();

        if ($this->submitForm()) {

            $validator = $this->model('generalArticle')->formValidate('all');

            if ($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('generalArticle')->setName($schema['name']);
                $this->model('generalArticle')->setDescription($schema['description']);
                $this->model('generalArticle')->setBarcode($schema['barcode']);
                $this->model('generalArticle')->setCost($schema['cost']);
                $this->model('generalArticle')->setPvp($schema['pvp']);
                $this->model('generalArticle')->setIdProvider($schema['id_provider']);
                $this->model('generalArticle')->setIdType($schema['id_type']);
                $this->model('generalArticle')->setImage('image');

                $this->setResponseMessage($this->model('generalArticle')->update());
            } else {
                $this->setResponseMessage($validator['errors']);
            }
        }

        include View::render('article', 'update');
    }
}
