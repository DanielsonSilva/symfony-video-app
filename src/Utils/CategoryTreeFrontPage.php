<?php 

namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract
{
    public function getCategoriesList(array $categoriesList)
    {
        $this->categoriesHTMLString .= '<ul>';
        foreach($categoriesList as $subcategory)
        {
            $categoryName = $subcategory['name'];
            $categoryId = $subcategory['id'];
            $url = $this->urlGenerator->generate('video_list', ['categoryname' => $categoryName, 'id' => $categoryId]);
            
            $this->categoriesHTMLString .= '<li><a href="' . $url . '">' . $categoryName . '</a></li>';
            
            if (!empty($subcategory['children'])) {
                $this->getCategoriesList($subcategory['children']);
            }
        }
        $this->categoriesHTMLString .= '</ul>';
        return $this->categoriesHTMLString;
    }
}


// <li><a href="#">Funny</a></li>
// <ul>
// <li><a href="#">Surprising</a></li>
// <li><a href="#">Exciting</a></li>
// <ul>
// <li><a href="#">Strange</a></li>
// <li><a href="#">Relaxing</a></li>
// </ul>
// </ul>