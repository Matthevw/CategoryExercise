<?php

namespace M2M\CategoryExercise\Model\Sub;

use \Magento\Catalog\Model\CategoryFactory as CategoryModel;
use \Magento\Catalog\Model\ResourceModel\Category as CategoryResourceModel;
use \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollection;
use \Magento\Catalog\Model\CategoryRepository;
use M2M\Logger\Logger\Logger;

class Category 
{
    /**
     * @var CategoryModel
     */
    protected $categoryModel;

    /**
     * @var CategoryResourceModel
     */
    protected $categoryResourceModel;

    /**
     * @var CategoryCollection
     */
    protected $categoryCollection;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

     /**
     * @var Logger
     */
    protected $logger;

    public function __construct (
        CategoryModel $categoryModel,
        CategoryResourceModel $categoryResourceModel,
        CategoryCollection $categoryCollection,
        CategoryRepository $categoryRepository,
        Logger $logger,
    ) {
        $this->categoryModel = $categoryModel;
        $this->categoryResourceModel = $categoryResourceModel;
        $this->categoryCollection = $categoryCollection;
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    public function addCategory() {

        $collection = $this->categoryCollection->create()->addAttributeToFilter('name', ['eq' => 'Zwierzeta'])->getData();

        if(!$collection){
            $category = $this->categoryModel->create();

            $category->setName('Zwierzeta')
                ->setParentId(2) 
                ->setIsActive(true)
                ->setCustomAttributes([
                'description' => 'Rozne zwierzaki',
                'meta_title' => 'Rozne zwierzaki',
                'meta_keywords' => '',
                'meta_description' => '',
                ]);

            $this->categoryResourceModel->save($category);
        } else {
            $this->logger->info("OOPS, taka kategoria już istnieje");
        }
    }

    public function getCategory() {
        $collection = $this->categoryCollection->create()->addAttributeToSelect('*')->getData();

        print(print_r($collection,true));
    }

    public function getCategoryById() {
        $categoryId = "3";
        $category = $this->categoryRepository->get($categoryId)->getName();
        var_dump($category);
    }
}