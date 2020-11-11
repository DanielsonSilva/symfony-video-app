<?php 

namespace App\Utils\AbstractClasses;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract
{
    
    public $categoriesFromDb;
    public $categoriesHTMLString;
    protected static $dbConnection;
    
    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $ug)
    {
        $this->entityManager = $em;
        $this->urlGenerator = $ug;
        $this->categoriesFromDb = $this->getCategories();
    }
    
    abstract function getCategoriesList(array $categoriesList);
    
    public function buildTree(int $parent_id = null): array
    {
        $subcategory = [];
        foreach($this->categoriesFromDb as $category)
        {
            if ($category['parent_id'] == $parent_id) {
                $children = $this->buildTree($category['id']);
                if ($children)
                {
                    $category['children'] = $children;
                }
                $subcategory[] = $category;
            }
        }
        return $subcategory;
    }
    
    private function getCategories()
    {
        if (self::$dbConnection) {
            return self::$dbConnection;
        } else {
            $conn = $this->entityManager->getConnection();
            $sql = "SELECT * FROM categories";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return self::$dbConnection = $stmt->fetchAllAssociative();
        }
    }
    
}

