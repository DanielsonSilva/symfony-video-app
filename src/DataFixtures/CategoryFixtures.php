<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadMainCategories($manager);
    }
    
    private function loadMainCategories($manager)
    {
        foreach($this->getCategoriesData() as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            
            $manager->flush();
        }
    }
    
    private function getCategoriesData(): array
    {
        return [
            'Eletronics',
            'Books',
            'Toys',
            'Movies'
        ];
    }
    
    private function getCategoriesIds(): array
    {
        return [
            ['Eletronics', 1],
            ['Books', 2],
            ['Toys', 3],
            ['Movies', 4]
        ];
    }
}
