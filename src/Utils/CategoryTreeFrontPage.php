<?php 

namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;
use App\Twig\AppExtension;

class CategoryTreeFrontPage extends CategoryTreeAbstract
{
    
    public function getCategoriesListAndParent(int $id)
    {
        $this->slugger = new AppExtension;
        $parentData = $this->getMainParent($id);
        $this->mainParentName = $parentData['name'];
        $this->mainParentId = $parentData['id'];
        $key = array_search($id, array_column($this->categoriesFromDb, 'id'));
        $this->currentCategoryName = $this->categoriesFromDb[$key]['name'];
        $categories_array = $this->buildTree($this->mainParentId);
        return $this->getCategoriesList($categories_array);
    }
    
    public function getCategoriesList(array $categoriesList)
    {
        $this->categoriesHTMLString .= '<ul>';
        foreach($categoriesList as $subcategory)
        {
            $categoryName = $this->slugger->slugify($subcategory['name']);
            $categoryId = $subcategory['id'];
            $url = $this->urlGenerator->generate('video_list', ['categoryname' => $categoryName, 'id' => $categoryId]);
            
            $this->categoriesHTMLString .= '<li><a href="' . $url . '">' . $categoryName . '</a></li>';
            
            if (!empty($subcategory['children'])) {
                $this->getCategoriesList($subcategory['children']);
            }
            $this->categoriesHTMLString .= '</li>';
        }
        $this->categoriesHTMLString .= '</ul>';
        return $this->categoriesHTMLString;
    }
    
    public function getMainParent($id)
    {
        $key = array_search($id, array_column($this->categoriesFromDb, 'id'));
        
        if ($this->categoriesFromDb[$key]['parent_id'] != null) {
            return $this->getMainParent($this->categoriesFromDb[$key]['parent_id']);
        }
        else
        {
            return $this->categoriesFromDb[$key];
        }
    }
}