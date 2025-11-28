<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Breeder;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Judge;
use App\Models\School;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CmsDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBlogs();
        $this->seedServices();
        $this->seedBreeders();
        $this->seedCertificates();
        $this->seedEvents();
        $this->seedSchools();
        $this->seedJudges();
        $this->seedSiteSettings();
    }

    private function seedBlogs(): void
    {
        $json = File::get(public_path('data/blogs.json'));
        $data = json_decode($json, true);

        foreach ($data['posts'] ?? [] as $post) {
            Blog::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'title' => $post['title'],
                    'short_description' => $post['shortDescription'] ?? null,
                    'main_image' => $post['mainImage'] ?? null,
                    'date' => $post['date'] ? date('Y-m-d', strtotime($post['date'])) : null,
                    'author' => $post['author'] ?? null,
                    'author_url' => $post['authorUrl'] ?? null,
                    'tags' => $post['tags'] ?? [],
                    'tags_url' => $post['tagsUrl'] ?? null,
                    'excerpt' => $post['excerpt'] ?? null,
                    'content' => $post['content'] ?? [],
                    'related_posts' => $post['relatedPosts'] ?? [],
                    'gallery' => $post['gallery'] ?? [],
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedServices(): void
    {
        $json = File::get(public_path('data/services.json'));
        $data = json_decode($json, true);

        foreach ($data['services'] ?? [] as $index => $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                [
                    'title' => $service['title'],
                    'type' => $service['type'] ?? null,
                    'short_description' => $service['shortDescription'] ?? null,
                    'main_image' => $service['mainImage'] ?? null,
                    'image' => $service['image'] ?? null,
                    'show_in_services' => $service['showInServices'] ?? true,
                    'show_in_pricing' => $service['showInPricing'] ?? false,
                    'pricing_category' => $service['pricingCategory'] ?? null,
                    'pricing_features' => $service['pricingFeatures'] ?? [],
                    'description' => $service['description'] ?? null,
                    'featured' => $service['featured'] ?? null,
                    'gallery' => $service['gallery'] ?? [],
                    'requirements' => $service['requirements'] ?? [],
                    'cost' => $service['cost'] ?? null,
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }

    private function seedBreeders(): void
    {
        $json = File::get(public_path('data/breeders.json'));
        $data = json_decode($json, true);

        foreach ($data['breeders'] ?? [] as $index => $breeder) {
            Breeder::updateOrCreate(
                ['slug' => $breeder['slug']],
                [
                    'name' => $breeder['name'],
                    'logo' => $breeder['logo'] ?? null,
                    'feature_image' => $breeder['featureImage'] ?? null,
                    'breeds' => $breeder['breeds'] ?? [],
                    'location' => $breeder['location'] ?? null,
                    'member_since' => $breeder['memberSince'] ?? null,
                    'rating' => $breeder['rating'] ?? 0,
                    'total_reviews' => $breeder['totalReviews'] ?? 0,
                    'description' => $breeder['description'] ?? null,
                    'short_description' => $breeder['shortDescription'] ?? null,
                    'website' => $breeder['website'] ?? null,
                    'email' => $breeder['email'] ?? null,
                    'phone' => $breeder['phone'] ?? null,
                    'whatsapp' => $breeder['whatsapp'] ?? null,
                    'social_links' => $breeder['socialLinks'] ?? [],
                    'certifications' => $breeder['certifications'] ?? [],
                    'features' => $breeder['features'] ?? [],
                    'responsible' => $breeder['responsible'] ?? null,
                    'about' => $breeder['about'] ?? null,
                    'sires' => $breeder['sires'] ?? [],
                    'care' => $breeder['care'] ?? null,
                    'awards' => $breeder['awards'] ?? [],
                    'gallery' => $breeder['gallery'] ?? [],
                    'reviews' => $breeder['reviews'] ?? [],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }

    private function seedCertificates(): void
    {
        $json = File::get(public_path('data/certificates.json'));
        $data = json_decode($json, true);

        foreach ($data['certificates'] ?? [] as $cert) {
            Certificate::updateOrCreate(
                ['microchip' => $cert['microchip']],
                [
                    'registration_number' => $cert['registrationNumber'],
                    'name' => $cert['name'],
                    'breed' => $cert['breed'] ?? null,
                    'variety' => $cert['variety'] ?? null,
                    'sex' => $cert['sex'] ?? null,
                    'color' => $cert['color'] ?? null,
                    'birth_place' => $cert['birthPlace'] ?? null,
                    'birth_date' => $cert['birthDate'] ?? null,
                    'image' => $cert['image'] ?? null,
                    'valid' => $cert['valid'] ?? true,
                    'certificate_number' => $cert['certificateNumber'] ?? null,
                    'certificate_date' => $cert['certificateDate'] ?? null,
                    'breeder' => $cert['breeder'] ?? null,
                    'owner' => $cert['owner'] ?? null,
                    'co_owner' => $cert['coOwner'] ?? null,
                    'address' => $cert['address'] ?? null,
                    'zip_code' => $cert['zipCode'] ?? null,
                    'neighborhood' => $cert['neighborhood'] ?? null,
                    'city' => $cert['city'] ?? null,
                    'phone' => $cert['phone'] ?? null,
                    'titles' => $cert['titles'] ?? [],
                    'observations' => $cert['observations'] ?? null,
                    'status' => $cert['status'] ?? 'VIGENTE',
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedEvents(): void
    {
        $json = File::get(public_path('data/events.json'));
        $data = json_decode($json, true);

        foreach ($data['events'] ?? [] as $index => $event) {
            Event::updateOrCreate(
                ['slug' => $event['slug']],
                [
                    'title' => $event['title'],
                    'type' => $event['type'] ?? null,
                    'image' => $event['image'] ?? null,
                    'start_date' => $event['startDate'] ?? null,
                    'end_date' => $event['endDate'] ?? null,
                    'start_time' => $event['startTime'] ?? null,
                    'end_time' => $event['endTime'] ?? null,
                    'location' => $event['location'] ?? null,
                    'organizer' => $event['organizer'] ?? null,
                    'judges' => $event['judges'] ?? [],
                    'breeds' => $event['breeds'] ?? [],
                    'description' => $event['description'] ?? null,
                    'details' => $event['details'] ?? null,
                    'requirements' => $event['requirements'] ?? [],
                    'inscription_info' => $event['inscriptionInfo'] ?? null,
                    'myths' => $event['myths'] ?? [],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }

    private function seedSchools(): void
    {
        $json = File::get(public_path('data/schools.json'));
        $data = json_decode($json, true);

        foreach ($data['schools'] ?? [] as $index => $school) {
            School::updateOrCreate(
                ['slug' => $school['slug']],
                [
                    'name' => $school['name'],
                    'logo' => $school['logo'] ?? null,
                    'feature_image' => $school['featureImage'] ?? null,
                    'programs_list' => $school['programsList'] ?? $school['programs'] ?? [],
                    'location' => $school['location'] ?? null,
                    'member_since' => $school['memberSince'] ?? null,
                    'rating' => $school['rating'] ?? 0,
                    'total_reviews' => $school['totalReviews'] ?? 0,
                    'description' => $school['description'] ?? null,
                    'short_description' => $school['shortDescription'] ?? null,
                    'website' => $school['website'] ?? null,
                    'email' => $school['email'] ?? null,
                    'phone' => $school['phone'] ?? null,
                    'whatsapp' => $school['whatsapp'] ?? null,
                    'social_links' => $school['socialLinks'] ?? [],
                    'certifications' => $school['certifications'] ?? [],
                    'features' => $school['features'] ?? [],
                    'responsible' => $school['responsible'] ?? null,
                    'about' => $school['about'] ?? null,
                    'programs' => $school['programs'] ?? [],
                    'facilities' => $school['facilities'] ?? null,
                    'awards' => $school['awards'] ?? [],
                    'gallery' => $school['gallery'] ?? [],
                    'reviews' => $school['reviews'] ?? [],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }

    private function seedJudges(): void
    {
        $json = File::get(public_path('data/judges.json'));
        $data = json_decode($json, true);

        foreach ($data['judges'] ?? [] as $index => $judge) {
            Judge::updateOrCreate(
                ['id' => $judge['id']],
                [
                    'name' => $judge['name'],
                    'email' => $judge['email'] ?? null,
                    'phone' => $judge['phone'] ?? null,
                    'city' => $judge['city'] ?? null,
                    'photo' => $judge['photo'] ?? null,
                    'license_type' => $judge['licenseType'] ?? null,
                    'categories' => $judge['categories'] ?? [],
                    'breeds' => $judge['breeds'] ?? [],
                    'description' => $judge['description'] ?? null,
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }

    private function seedSiteSettings(): void
    {
        // Header settings
        $headerJson = File::get(public_path('data/header.json'));
        $headerData = json_decode($headerJson, true);

        SiteSetting::setByKey('logo', $headerData['logo'] ?? null, 'header');
        SiteSetting::setByKey('ctaButton', $headerData['ctaButton'] ?? null, 'header');
        SiteSetting::setByKey('menuItems', $headerData['menuItems'] ?? [], 'header');
        SiteSetting::setByKey('socialLinks', $headerData['socialLinks'] ?? [], 'header');
        SiteSetting::setByKey('contactInfo', $headerData['contactInfo'] ?? null, 'header');

        // Footer settings
        $footerJson = File::get(public_path('data/footer.json'));
        $footerData = json_decode($footerJson, true);

        SiteSetting::setByKey('logo', $footerData['logo'] ?? null, 'footer');
        SiteSetting::setByKey('name', $footerData['name'] ?? '', 'footer');
        SiteSetting::setByKey('legend', $footerData['legend'] ?? '', 'footer');
    }
}

