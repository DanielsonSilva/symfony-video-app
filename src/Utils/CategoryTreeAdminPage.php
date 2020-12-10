<?php 
namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;
use App\Twig\AppExtension;

class CategoryTreeAdminPage extends CategoryTreeAbstract
{
    
    public function getCategoriesList(array $categoriesList)
    {
        $this->categoriesHTMLString .= '<ul class="fa-ul text-left">';
        foreach($categoriesList as $subcategory)
        {
            $urlEdit = $this->urlGenerator->generate('edit_category', ['id' => $subcategory['id']]);
            $urlDelete = $this->urlGenerator->generate('delete_category', ['id' => $subcategory['id']]);
            $categoryName = $subcategory['name'];
            $categoryId = $subcategory['id'];
            
            $this->categoriesHTMLString .= '<li><i class="fa-li fa fa-arrow-right"></i>' . $categoryName . '</li>';
            
            $this->categoriesHTMLString .= "<a href=\"$urlEdit\">Edit</a> ";
            $this->categoriesHTMLString .= "<a onclick=\"return Confirm('Are you sure?');\"";
            $this->categoriesHTMLString .= " href=\"$urlDelete\">Delete</a>";
            
            if (!empty($subcategory['children'])) {
                $this->getCategoriesList($subcategory['children']);
            }
            
            $this->categoriesHTMLString .= '</li>';
        }
        $this->categoriesHTMLString .= '</ul>';
        return $this->categoriesHTMLString;
    }
    
}