<?php

namespace Database\Seeders;

use App\Models\ClientLogo;
use App\Models\CompanySetting;
use App\Models\CounterStat;
use App\Models\PageSection;
use App\Models\PricingPlan;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Project;
use Illuminate\Database\Seeder;

class WebsiteContentSeeder extends Seeder
{
    public function run(): void
    {
        CompanySetting::instance()->update([
            'company_name' => 'Zeroxe Consulting',
            'phone' => '(+123) 1234 5678',
            'email' => 'hello@zeroxe.com',
            'address' => 'Jl. Sudirman No. 123, Jakarta, Indonesia',
            'footer_description' => 'Professional consulting services to help your business grow and succeed in today\'s competitive market.',
            'facebook_url' => '#',
            'linkedin_url' => '#',
            'twitter_url' => '#',
        ]);

        PageSection::updateOrCreate(['slug' => 'hero'], [
            'title' => 'Professional service provided by experts with specialized knowledge',
            'subtitle' => 'OPTIMIZE YOUR BUSINESS GROWTH',
            'content' => '<p>Cursus vitae congue mauris rhoncus aenean vel elit scelerisque. Mauris pellentesque pulvinar pellentesque habitant morbi tristique senectus et netus.</p>',
            'extra' => [
                'badge_number' => '15+',
                'badge_text' => 'Years Experience',
                'button_primary_text' => 'Get Consulting - It\'s Free',
                'button_primary_url' => '#contact',
                'button_secondary_text' => 'Open Account',
                'button_secondary_url' => '#',
            ],
            'is_active' => true,
        ]);

        PageSection::updateOrCreate(['slug' => 'about'], [
            'subtitle' => 'ABOUT US',
            'title' => 'The primary goal of business consulting is to help organizations.',
            'content' => '<p>Viverra ipsum nunc aliquet bibendum enim facilisis gravida neque. Turpis egestas pretium aenean pharetra magna ac. Sem nulla pharetra diam sit amet nisl suscipit adipiscing bibendum.</p><p>Donec enim diam vulputate ut pharetra sit amet aliquam id. In ornare quam viverra orci sagittis eu. Non nisi est sit amet facilisis. Suscipit tellus mauris a diam maecenas.</p>',
            'extra' => [
                'founder_quote' => 'Odio eu feugiat pretium nibh ipsum. Pellentesque habitant morbi tristique senectus et netus et.',
                'founder_name' => 'Hendrik Morella',
                'founder_role' => 'CEO, DIRECTOR',
            ],
            'is_active' => true,
        ]);

        PageSection::updateOrCreate(['slug' => 'benefits'], [
            'subtitle' => 'KEY BENEFITS',
            'title' => 'Why should choose us?',
            'content' => '<p>At ultrices mi tempus imperdiet nulla elit eget. Congue nisi vitae suscipit tellus mauris a diam maecenas sed. Nunc id cursus metus aliquam eleifend mi.</p>',
            'extra' => [
                'benefit_items' => [
                    'Maecenas pharetra convallis posuere morbi leo urna',
                    'Nisi lacus sed viverra tellus in hac habitasse platea',
                    'Pretium lectus quam id leo in vitae turpis integer',
                    'Lacus vel facilisis volutpat est curabitur gravida arcu',
                    'Odio morbi quis commodo odio aenean sed adipiscing',
                ],
            ],
            'is_active' => true,
        ]);

        PageSection::updateOrCreate(['slug' => 'who-we-are'], [
            'subtitle' => 'WHO WE ARE',
            'title' => 'Consultants typically have expertise in a particular industry.',
            'extra' => [
                'vision_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus nisl vitae magna pulvinar laoreet. Nullam ac tortor vitae purus faucibus ornare suspendisse sed nisi.',
                'mission_text' => 'Massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Felis bibendum ut tristique et egestas quis ipsum suspendisse nec ullamcorper.',
            ],
            'is_active' => true,
        ]);

        PageSection::updateOrCreate(['slug' => 'contact'], [
            'subtitle' => 'CONTACT US',
            'title' => 'Get in touch with us.',
            'content' => '<p>Have a project in mind? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.</p>',
            'is_active' => true,
        ]);

        $services = [
            ['icon' => '📊', 'title' => 'Business Strategy', 'description' => 'Develop comprehensive strategies to achieve your business goals and maximize growth potential.', 'sort_order' => 1],
            ['icon' => '📈', 'title' => 'Financial Consulting', 'description' => 'Expert financial advice to optimize your operations and improve profitability.', 'sort_order' => 2],
            ['icon' => '🎯', 'title' => 'Market Research', 'description' => 'In-depth market analysis to identify opportunities and stay ahead of competition.', 'sort_order' => 3],
            ['icon' => '💼', 'title' => 'Management Consulting', 'description' => 'Streamline your operations and improve efficiency with our management expertise.', 'sort_order' => 4],
            ['icon' => '🚀', 'title' => 'Digital Transformation', 'description' => 'Modernize your business with cutting-edge digital solutions and technologies.', 'sort_order' => 5],
            ['icon' => '🤝', 'title' => 'Partnership', 'description' => 'Build strategic partnerships to expand your reach and accelerate growth.', 'sort_order' => 6],
        ];
        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }

        $projects = [
            ['title' => 'Strategic Planning', 'category' => 'Business', 'sort_order' => 1],
            ['title' => 'Market Analysis', 'category' => 'Finance', 'sort_order' => 2],
            ['title' => 'Digital Transformation', 'category' => 'Digital', 'sort_order' => 3],
        ];
        foreach ($projects as $project) {
            Project::updateOrCreate(['title' => $project['title']], $project);
        }

        $plans = [
            [
                'name' => 'Basic',
                'price' => 49,
                'period' => 'Monthly',
                'features' => ['5 Analytics Campaign', '3 User Team Member', '24/7 Support'],
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium',
                'price' => 99,
                'period' => 'Monthly',
                'features' => ['15 Analytics Campaign', '10 User Team Member', 'Priority Support', 'Custom Reports'],
                'is_popular' => true,
                'badge' => 'POPULAR',
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'price' => 199,
                'period' => 'Monthly',
                'features' => ['Unlimited Campaigns', 'Unlimited Team Members', '24/7 Priority Support', 'Dedicated Manager'],
                'is_popular' => false,
                'sort_order' => 3,
            ],
        ];
        foreach ($plans as $plan) {
            PricingPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }

        $testimonials = [
            ['name' => 'John Doe', 'role' => 'CEO, Tech Corp', 'rating' => 5, 'quote' => 'Excellent consulting service. They helped us increase our revenue by 40% in just 6 months. Highly recommended!', 'sort_order' => 1],
            ['name' => 'Sarah Miller', 'role' => 'Director, Finance Inc', 'rating' => 5, 'quote' => 'Professional team with deep industry knowledge. They transformed our business operations completely.', 'sort_order' => 2],
            ['name' => 'Robert Wilson', 'role' => 'Founder, StartupXYZ', 'rating' => 5, 'quote' => 'Their strategic insights were invaluable. We\'ve seen consistent growth since partnering with them.', 'sort_order' => 3],
        ];
        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(['name' => $testimonial['name']], $testimonial);
        }

        $stats = [
            ['number_value' => '15+', 'label' => 'Years Experience', 'sort_order' => 1],
            ['number_value' => '200+', 'label' => 'Project Completed', 'sort_order' => 2],
            ['number_value' => '50+', 'label' => 'Team Members', 'sort_order' => 3],
            ['number_value' => '98%', 'label' => 'Client Satisfaction', 'sort_order' => 4],
        ];
        foreach ($stats as $stat) {
            CounterStat::updateOrCreate(['label' => $stat['label']], $stat);
        }

        Post::updateOrCreate(
            ['slug' => 'how-to-grow-your-business-2025'],
            [
                'title' => 'How to Grow Your Business in 2025',
                'excerpt' => 'Discover the key strategies to scale your business this year...',
                'content' => '<p>Full article content here...</p>',
                'published_at' => '2025-01-15',
                'is_published' => true,
            ]
        );
        Post::updateOrCreate(
            ['slug' => 'digital-transformation-trends'],
            [
                'title' => 'Digital Transformation Trends',
                'excerpt' => 'Stay ahead with the latest digital transformation trends...',
                'content' => '<p>Full article content here...</p>',
                'published_at' => '2025-01-10',
                'is_published' => true,
            ]
        );
        Post::updateOrCreate(
            ['slug' => 'financial-planning-startups'],
            [
                'title' => 'Financial Planning for Startups',
                'excerpt' => 'Essential financial planning tips for new businesses...',
                'content' => '<p>Full article content here...</p>',
                'published_at' => '2025-01-05',
                'is_published' => true,
            ]
        );
    }
}
