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
        $this->loadSubCategories($manager, 'Eletronics', 1);
        $this->loadSubCategories($manager, 'Computers', 6);
        $this->loadSubCategories($manager, 'Laptops', 9);
        $this->loadSubCategories($manager, 'Books', 2);
        $this->loadSubCategories($manager, 'Movies', 4);
        $this->loadSubCategories($manager, 'Romance', 19);
    }
    
    private function loadMainCategories($manager)
    {
        foreach($this->getCategoriesData() as [$name]) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            
            $manager->flush();
        }
    }
    
    private function loadSubCategories($manager, $category_name, $parent_id)
    {
        $parent = $manager->getRepository(Category::class)->find($parent_id);
        $method = "get{$category_name}Data";
        
        foreach($this->$method() as [$name]) {
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
            
            $manager->flush();
        }
    }
    
    private function getCategoriesData(): array
    {
        return [
            ['Eletronics', 1],
            ['Books', 2],
            ['Toys', 3],
            ['Movies', 4]
        ];
    }
    
    private function getEletronicsData(): array
    {
        return [
            ['Cameras', 5],
            ['Computers', 6],
            ['Cellphones', 7],
            ['Videogames', 8]
        ];
    }
    
    private function getComputersData(): array
    {
        return [
            ['Laptops', 9],
            ['Desktops', 10]
        ];
    }
    
    private function getLaptopsData(): array
    {
        return [
            ['Apple', 11],
            ['Asus', 12],
            ['Dell', 13],
            ['Lenovo', 14],
            ['HP', 15]
        ];
    }
    
    private function getBooksData(): array
    {
        return [
            ['Children', 16],
            ['Kindle', 17]
        ];
    }
    
    private function getMoviesData(): array
    {
        return [
            ['Family', 18],
            ['Romance', 19]
        ];
    }
    
    private function getRomanceData(): array
    {
        return [
            ['Romantic Comedy', 20],
            ['Romantic Drama', 21]
        ];
    }
}
