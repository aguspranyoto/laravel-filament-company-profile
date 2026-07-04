<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use App\Models\CompanySetting;
use App\Models\CounterStat;
use App\Models\PageSection;
use App\Models\PricingPlan;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Project;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome', [
            'settings'       => CompanySetting::instance(),
            'hero'           => PageSection::getBySlug('hero'),
            'about'          => PageSection::getBySlug('about'),
            'benefits'       => PageSection::getBySlug('benefits'),
            'whoWeAre'       => PageSection::getBySlug('who-we-are'),
            'contact'        => PageSection::getBySlug('contact'),
            'services'       => Service::active()->get(),
            'projects'       => Project::active()->get(),
            'pricingPlans'   => PricingPlan::active()->get(),
            'testimonials'   => Testimonial::active()->get(),
            'posts'          => Post::published()->limit(3)->get(),
            'clientLogos'    => ClientLogo::active()->get(),
            'counterStats'   => CounterStat::active()->get(),
        ]);
    }
}
