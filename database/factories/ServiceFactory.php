<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        $title = $this->faker->randomElement([
            'Laravel Web Development',
            'React Frontend Development', 
            'PHP Custom Solutions',
            'WordPress Development',
            'E-commerce Solutions',
            'SEO Optimization',
            'Digital Marketing',
            'Mobile App Development',
            'UI/UX Design',
            'Database Design'
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'image' => 'default-service.jpg',
            'short_description' => $this->faker->sentence(12),
            'description' => $this->faker->paragraphs(3, true),
            'meta_title' => $title . ' | SolutionsForYou',
            'meta_description' => $this->faker->sentence(15),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
        ];
    }
}