<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceQuestion;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Create sample services
        $services = [
            [
                'title' => 'Laravel Web Development',
                'short_description' => 'Professional Laravel web application development with modern features and best practices.',
                'description' => '<p>We provide comprehensive Laravel web development services including custom web applications, API development, and system integration.</p><p>Our Laravel experts deliver scalable, secure, and high-performance web solutions tailored to your business needs.</p>',
                'image' => 'laravel-service.jpg'
            ],
            [
                'title' => 'React Frontend Development', 
                'short_description' => 'Modern React.js frontend development for interactive and responsive user interfaces.',
                'description' => '<p>Build dynamic and interactive user interfaces with React.js. We create responsive, fast, and user-friendly frontend applications.</p><p>Our React development includes component architecture, state management, and modern development practices.</p>',
                'image' => 'react-service.jpg'
            ],
            [
                'title' => 'SEO Optimization',
                'short_description' => 'Complete SEO services to improve your website ranking and organic traffic.',
                'description' => '<p>Boost your online visibility with our comprehensive SEO services. We optimize your website for search engines and improve organic rankings.</p><p>Our SEO strategy includes keyword research, on-page optimization, technical SEO, and content optimization.</p>',
                'image' => 'seo-service.jpg'
            ],
            [
                'title' => 'E-commerce Solutions',
                'short_description' => 'Custom e-commerce development with secure payment integration and inventory management.',
                'description' => '<p>Build powerful e-commerce platforms with custom features, secure payment gateways, and inventory management systems.</p><p>We develop scalable online stores that drive sales and provide excellent user experience.</p>',
                'image' => 'ecommerce-service.jpg'
            ],
            [
                'title' => 'Mobile App Development',
                'short_description' => 'Cross-platform mobile app development for iOS and Android platforms.',
                'description' => '<p>Create engaging mobile applications for iOS and Android platforms using modern development frameworks.</p><p>Our mobile apps are optimized for performance, user experience, and platform-specific features.</p>',
                'image' => 'mobile-service.jpg'
            ],
            [
                'title' => 'UI/UX Design',
                'short_description' => 'Professional UI/UX design services for web and mobile applications.',
                'description' => '<p>Design beautiful and intuitive user interfaces that provide excellent user experience across all devices.</p><p>Our design process includes user research, wireframing, prototyping, and visual design.</p>',
                'image' => 'design-service.jpg'
            ]
        ];

        foreach ($services as $serviceData) {
            $service = Service::create([
                'title' => $serviceData['title'],
                'short_description' => $serviceData['short_description'],
                'description' => $serviceData['description'],
                'image' => $serviceData['image'],
                'meta_title' => $serviceData['title'] . ' | SolutionsForYou',
                'meta_description' => $serviceData['short_description'],
                'meta_keywords' => strtolower(str_replace(' ', ', ', $serviceData['title'])) . ', web development, solutionsforyou'
            ]);

            // Add sample questions for each service
            $questions = [
                'What is your project timeline?',
                'What is your budget range?', 
                'Do you have any specific requirements?'
            ];

            foreach ($questions as $question) {
                ServiceQuestion::create([
                    'service_id' => $service->id,
                    'question' => $question
                ]);
            }
        }
    }
}