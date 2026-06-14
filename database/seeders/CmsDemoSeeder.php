<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CmsDemoSeeder extends Seeder
{
    /**
     * Real ATSL (Safety & Security company, Mirpur, Dhaka) content,
     * using images that exist in public/image/{logo,photogallery,product}.
     */
    public function run()
    {
        /* ---- existing image assets (all WebP) ---- */
        $logo   = 'image/logo/202403160742202403091011logo.webp';
        $slide1 = 'image/photogallery/1711610060.webp';
        $slide2 = 'image/photogallery/2024032219023.webp';
        $slide3 = 'image/product/photo/1717789818.webp';
        $about1 = 'image/photogallery/1711610040.webp';
        $whyImg = 'image/product/photo/1731476455.webp';
        $prod   = [
            'image/product/photo/1717865124.webp',
            'image/product/photo/1717865323.webp',
            'image/product/photo/1717867724.webp',
            'image/product/photo/1731476970.webp',
            'image/product/photo/1731477392.webp',
            'image/product/photo/1750155644.webp',
        ];
        $blogImg = [
            'image/product/photo/202403211235blog-image1.webp',
            'image/product/photo/202403211234blog-image2.webp',
            'image/product/photo/202403211234blog-image3.webp',
            'image/product/photo/202403211235blog-image4.webp',
        ];

        /* ============ HOME ============ */
        Page::updateOrCreate(['slug' => 'home'], [
            'title' => 'Home', 'template' => 'fullwidth', 'show_in_menu' => 0, 'sort_order' => 0, 'status' => 1,
            'meta_title' => 'ATSL | Multiple Safety & Security Company in Bangladesh',
            'meta_description' => 'ATSL provides fire protection, CCTV surveillance, security and IT solutions across Bangladesh.',
            'template_data' => [
                ['id' => 'h1', 'type' => 'hero_slider', 'model' => ['slides' => [
                    ['image' => $slide1, 'title' => 'Your Safety Is Our Priority', 'subtitle' => 'Multiple safety & security, fire protection and IT solutions company in Bangladesh.', 'button_text' => 'Get A Quote', 'button_url' => '/contact'],
                    ['image' => $slide2, 'title' => 'Advanced CCTV & Surveillance', 'subtitle' => 'Protect your home and business 24/7 with modern security systems.', 'button_text' => 'Our Services', 'button_url' => '/services'],
                    ['image' => $slide3, 'title' => 'Complete Fire Protection', 'subtitle' => 'Certified fire detection, suppression and safety solutions you can trust.', 'button_text' => 'Learn More', 'button_url' => '/about'],
                ]]],
                ['id' => 'h2', 'type' => 'features', 'model' => [
                    'title' => 'What We Do', 'subtitle' => 'Complete safety & security solutions under one roof', 'columns' => '4',
                    'items' => [
                        ['icon' => 'fa-fire-extinguisher', 'title' => 'Fire Protection', 'text' => 'Fire detection, alarm and suppression systems.', 'link' => '/services'],
                        ['icon' => 'fa-video', 'title' => 'CCTV Surveillance', 'text' => 'IP & analog camera systems with 24/7 monitoring.', 'link' => '/services'],
                        ['icon' => 'fa-fingerprint', 'title' => 'Access Control', 'text' => 'Biometric, card and door access solutions.', 'link' => '/services'],
                        ['icon' => 'fa-network-wired', 'title' => 'IT Solutions', 'text' => 'Networking, servers and IT infrastructure.', 'link' => '/services'],
                    ],
                ]],
                ['id' => 'h3', 'type' => 'services_grid', 'model' => [
                    'title' => 'Our Security Solutions', 'subtitle' => 'Trusted protection for homes, offices & industries', 'columns' => '3',
                    'items' => [
                        ['image' => $prod[0], 'icon' => 'fa-video', 'title' => 'CCTV Camera', 'text' => 'High-definition surveillance for total visibility.', 'url' => '/services'],
                        ['image' => $prod[1], 'icon' => 'fa-fire', 'title' => 'Fire Alarm System', 'text' => 'Early detection that protects lives and property.', 'url' => '/services'],
                        ['image' => $prod[2], 'icon' => 'fa-door-closed', 'title' => 'Access Control', 'text' => 'Control and monitor every entry point.', 'url' => '/services'],
                        ['image' => $prod[3], 'icon' => 'fa-bell', 'title' => 'Burglar Alarm', 'text' => 'Intrusion detection with instant alerts.', 'url' => '/services'],
                        ['image' => $prod[4], 'icon' => 'fa-walkie-talkie', 'title' => 'Public Address', 'text' => 'PA & intercom systems for clear communication.', 'url' => '/services'],
                        ['image' => $prod[5], 'icon' => 'fa-network-wired', 'title' => 'Networking', 'text' => 'Structured cabling and IT infrastructure.', 'url' => '/services'],
                    ],
                ]],
                ['id' => 'h4', 'type' => 'stats', 'model' => ['title' => '', 'items' => [
                    ['value' => '1500', 'suffix' => '+', 'label' => 'Projects Completed'],
                    ['value' => '800', 'suffix' => '+', 'label' => 'Happy Clients'],
                    ['value' => '12', 'suffix' => '+', 'label' => 'Years of Service'],
                    ['value' => '24', 'suffix' => '/7', 'label' => 'Support & Monitoring'],
                ]]],
                ['id' => 'h5', 'type' => 'why_choose', 'model' => [
                    'title' => 'Why Choose ATSL', 'subtitle' => 'Bangladesh’s trusted safety & security partner', 'image' => $whyImg,
                    'items' => [
                        ['icon' => 'fa-certificate', 'title' => 'Certified & Experienced', 'text' => 'Skilled, certified engineers and technicians.'],
                        ['icon' => 'fa-headset', 'title' => '24/7 Support', 'text' => 'Round-the-clock monitoring and service.'],
                        ['icon' => 'fa-sack-dollar', 'title' => 'Affordable Pricing', 'text' => 'Premium quality at competitive rates.'],
                    ],
                ]],
                ['id' => 'h6', 'type' => 'testimonials', 'model' => [
                    'title' => 'What Our Clients Say', 'subtitle' => 'Trusted by businesses across Bangladesh',
                    'items' => [
                        ['quote' => 'ATSL installed our entire office CCTV and fire alarm system. Professional and reliable.', 'name' => 'Rahim Uddin', 'role' => 'Factory Owner, Gazipur', 'image' => ''],
                        ['quote' => 'Excellent service and 24/7 support. Highly recommended for any security need.', 'name' => 'Nasrin Akter', 'role' => 'Building Manager, Dhaka', 'image' => ''],
                    ],
                ]],
                ['id' => 'h7', 'type' => 'cta_banner', 'model' => ['title' => 'Secure Your Property Today', 'text' => 'Call us 24/7 — 01718-200298, 01618-200298 — for a free site survey and quote.', 'button_text' => 'Make a Quote', 'button_url' => '/contact', 'style' => 'gradient']],
            ],
        ]);

        /* ============ ABOUT ============ */
        $about = Page::updateOrCreate(['slug' => 'about'], [
            'title' => 'About Us', 'template' => 'default', 'show_in_menu' => 1, 'sort_order' => 1, 'status' => 1,
            'meta_title' => 'About ATSL | Safety & Security Company',
            'template_data' => [
                ['id' => 'a1', 'type' => 'page_header', 'model' => ['title' => 'About ATSL', 'subtitle' => 'Multiple Safety & Security company in Bangladesh', 'image' => $slide2, 'align' => 'center']],
                ['id' => 'a2', 'type' => 'feature_with_image', 'model' => [
                    'title' => 'Protecting What Matters Most', 'subtitle' => 'Who we are',
                    'content' => '<p>ATSL is a leading safety & security, fire protection and IT solutions company based in Mirpur, Dhaka. We design, supply, install and maintain complete security systems for homes, offices, factories and institutions across Bangladesh.</p>',
                    'image' => $about1, 'image_side' => 'right',
                    'points' => [['text' => 'CCTV & surveillance systems'], ['text' => 'Fire detection & protection'], ['text' => 'Access control & IT solutions']],
                    'button_text' => 'Contact Us', 'button_url' => '/contact',
                ]],
                ['id' => 'a3', 'type' => 'why_choose', 'model' => [
                    'title' => 'Why Choose ATSL', 'subtitle' => 'The advantages that set us apart', 'image' => $whyImg,
                    'items' => [
                        ['icon' => 'fa-medal', 'title' => 'Proven Experience', 'text' => '12+ years protecting Bangladeshi businesses.'],
                        ['icon' => 'fa-users', 'title' => 'Expert Team', 'text' => 'Certified security & fire safety engineers.'],
                        ['icon' => 'fa-clock', 'title' => 'On-Time Delivery', 'text' => 'Projects delivered on schedule, every time.'],
                    ],
                ]],
                ['id' => 'a4', 'type' => 'stats', 'model' => ['title' => '', 'items' => [
                    ['value' => '1500', 'suffix' => '+', 'label' => 'Projects'],
                    ['value' => '800', 'suffix' => '+', 'label' => 'Clients'],
                    ['value' => '12', 'suffix' => '+', 'label' => 'Years'],
                    ['value' => '50', 'suffix' => '+', 'label' => 'Team Members'],
                ]]],
            ],
        ]);

        /* ============ SERVICES ============ */
        $services = Page::updateOrCreate(['slug' => 'services'], [
            'title' => 'Our Services', 'template' => 'default', 'show_in_menu' => 1, 'sort_order' => 2, 'status' => 1,
            'meta_title' => 'Services | ATSL Safety & Security',
            'template_data' => [
                ['id' => 's1', 'type' => 'page_header', 'model' => ['title' => 'Our Services', 'subtitle' => 'Complete safety & security solutions', 'image' => $slide1, 'align' => 'center']],
                ['id' => 's2', 'type' => 'services_grid', 'model' => [
                    'title' => 'What We Offer', 'subtitle' => 'End-to-end protection for every need', 'columns' => '3',
                    'items' => [
                        ['image' => $prod[0], 'icon' => 'fa-video', 'title' => 'CCTV Surveillance', 'text' => 'HD/IP cameras, NVR/DVR and remote viewing.', 'url' => '#'],
                        ['image' => $prod[1], 'icon' => 'fa-fire-extinguisher', 'title' => 'Fire Protection', 'text' => 'Fire alarm, detection and suppression systems.', 'url' => '#'],
                        ['image' => $prod[2], 'icon' => 'fa-fingerprint', 'title' => 'Access Control', 'text' => 'Biometric and card-based door access.', 'url' => '#'],
                        ['image' => $prod[3], 'icon' => 'fa-bell', 'title' => 'Burglar Alarm', 'text' => 'Motion sensors and intrusion alarms.', 'url' => '#'],
                        ['image' => $prod[4], 'icon' => 'fa-walkie-talkie', 'title' => 'PA & Intercom', 'text' => 'Public address and intercom systems.', 'url' => '#'],
                        ['image' => $prod[5], 'icon' => 'fa-network-wired', 'title' => 'IT & Networking', 'text' => 'Structured cabling, servers and networks.', 'url' => '#'],
                    ],
                ]],
                ['id' => 's3', 'type' => 'gallery', 'model' => ['title' => 'Our Recent Work', 'columns' => '4', 'images' => [
                    ['image' => $blogImg[0], 'caption' => ''], ['image' => $blogImg[1], 'caption' => ''],
                    ['image' => $blogImg[2], 'caption' => ''], ['image' => $blogImg[3], 'caption' => ''],
                ]]],
                ['id' => 's4', 'type' => 'faq', 'model' => [
                    'title' => 'Frequently Asked Questions', 'subtitle' => 'Answers to common questions',
                    'items' => [
                        ['question' => 'Do you offer free site surveys?', 'answer' => 'Yes. Call 01718-200298 and our team will visit and assess your site free of charge.'],
                        ['question' => 'Which areas do you cover?', 'answer' => 'We serve clients across Dhaka and all over Bangladesh.'],
                        ['question' => 'Do you provide maintenance?', 'answer' => 'Yes, we offer annual maintenance contracts and 24/7 support.'],
                    ],
                ]],
                ['id' => 's5', 'type' => 'cta_banner', 'model' => ['title' => 'Need a Custom Security Solution?', 'text' => 'Talk to our experts today for a tailored quote.', 'button_text' => 'Get A Quote', 'button_url' => '/contact', 'style' => 'gradient']],
            ],
        ]);

        /* ============ CONTACT ============ */
        $contact = Page::updateOrCreate(['slug' => 'contact'], [
            'title' => 'Contact', 'template' => 'default', 'show_in_menu' => 1, 'sort_order' => 3, 'status' => 1,
            'meta_title' => 'Contact | ATSL',
            'template_data' => [
                ['id' => 'c1', 'type' => 'page_header', 'model' => ['title' => 'Contact Us', 'subtitle' => 'Call us 24/7 for a free quote', 'image' => $slide3, 'align' => 'center']],
                ['id' => 'c2', 'type' => 'contact', 'model' => [
                    'title' => 'Get In Touch', 'subtitle' => 'We respond fast — your safety can’t wait',
                    'address' => 'Ground Floor, House-07, Road-08, Block-D, Mirpur-12, Dhaka-1216',
                    'phone' => '01718-200298, 01618-200298', 'email' => 'info@atsl.com.bd', 'show_form' => '1',
                ]],
            ],
        ]);

        /* ============ Menus ============ */
        $headerMenu = Menu::updateOrCreate(['location' => 'header'], ['name' => 'Main Header Menu', 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Home', 'parent_id' => null], ['link_type' => 'custom', 'url' => '/', 'sort_order' => 1, 'status' => 1]);
        $sol = MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Solutions', 'parent_id' => null], ['link_type' => 'custom', 'url' => '#0', 'sort_order' => 2, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'CCTV Surveillance', 'parent_id' => $sol->id], ['link_type' => 'custom', 'url' => '/services', 'sort_order' => 1, 'status' => 1]);
        $fire = MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Fire Protection', 'parent_id' => $sol->id], ['link_type' => 'custom', 'url' => '#0', 'sort_order' => 2, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Fire Alarm', 'parent_id' => $fire->id], ['link_type' => 'custom', 'url' => '/services', 'sort_order' => 1, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Fire Suppression', 'parent_id' => $fire->id], ['link_type' => 'custom', 'url' => '/services', 'sort_order' => 2, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Services', 'parent_id' => null], ['link_type' => 'page', 'page_id' => $services->id, 'sort_order' => 3, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'About', 'parent_id' => null], ['link_type' => 'page', 'page_id' => $about->id, 'sort_order' => 4, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Blog', 'parent_id' => null], ['link_type' => 'custom', 'url' => '/blog', 'sort_order' => 5, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $headerMenu->id, 'title' => 'Contact', 'parent_id' => null], ['link_type' => 'page', 'page_id' => $contact->id, 'sort_order' => 6, 'status' => 1]);

        $footerMenu = Menu::updateOrCreate(['location' => 'footer'], ['name' => 'Footer Quick Links', 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $footerMenu->id, 'title' => 'About Us', 'parent_id' => null], ['link_type' => 'page', 'page_id' => $about->id, 'sort_order' => 1, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $footerMenu->id, 'title' => 'Services', 'parent_id' => null], ['link_type' => 'page', 'page_id' => $services->id, 'sort_order' => 2, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $footerMenu->id, 'title' => 'Blog', 'parent_id' => null], ['link_type' => 'custom', 'url' => '/blog', 'sort_order' => 3, 'status' => 1]);
        MenuItem::updateOrCreate(['menu_id' => $footerMenu->id, 'title' => 'Contact', 'parent_id' => null], ['link_type' => 'page', 'page_id' => $contact->id, 'sort_order' => 4, 'status' => 1]);

        /* ============ Settings (real ATSL) ============ */
        $settings = [
            ['key' => 'site_name',        'value' => 'ATSL',                                                   'group' => 'general', 'type' => 'text'],
            ['key' => 'site_logo',        'value' => $logo,                                                    'group' => 'general', 'type' => 'image'],
            ['key' => 'site_tagline',     'value' => 'Multiple Safety & Security company in Bangladesh',        'group' => 'general', 'type' => 'text'],
            ['key' => 'show_topbar',      'value' => '1',                                                      'group' => 'header',  'type' => 'boolean'],
            ['key' => 'show_header_cta',  'value' => '1',                                                      'group' => 'header',  'type' => 'boolean'],
            ['key' => 'header_cta_text',  'value' => 'Make a Quote',                                           'group' => 'header',  'type' => 'text'],
            ['key' => 'header_cta_url',   'value' => '/contact',                                               'group' => 'header',  'type' => 'text'],
            ['key' => 'footer_title',     'value' => 'ATSL',                                                   'group' => 'footer',  'type' => 'text'],
            ['key' => 'footer_about',     'value' => 'ATSL is a multiple safety & security, fire protection and IT solutions company based in Mirpur, Dhaka, Bangladesh.', 'group' => 'footer', 'type' => 'textarea'],
            ['key' => 'footer_copyright', 'value' => '© {year} ATSL. All Copyright by atsl.com.bd',            'group' => 'footer',  'type' => 'text'],
            ['key' => 'contact_email',    'value' => 'info@atsl.com.bd',                                       'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone',    'value' => '01718-200298, 01618-200298',                             'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_address',  'value' => 'Ground Floor, House-07, Road-08, Block-D, Mirpur-12, Dhaka-1216', 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'facebook_url',     'value' => 'https://www.facebook.com/',                              'group' => 'social',  'type' => 'text'],
            ['key' => 'twitter_url',      'value' => 'https://twitter.com/',                                   'group' => 'social',  'type' => 'text'],
            ['key' => 'linkedin_url',     'value' => 'https://www.linkedin.com/',                              'group' => 'social',  'type' => 'text'],
            ['key' => 'meta_keywords',    'value' => 'ATSL, security, CCTV, fire protection, Bangladesh, Mirpur', 'group' => 'seo',  'type' => 'text'],
        ];
        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        /* ============ Blog (security themed, real images) ============ */
        $catNews = PostCategory::updateOrCreate(['slug' => 'news'], ['name' => 'Company News', 'status' => 1]);
        $catTips = PostCategory::updateOrCreate(['slug' => 'safety-tips'], ['name' => 'Safety Tips', 'status' => 1]);
        $catCase = PostCategory::updateOrCreate(['slug' => 'case-studies'], ['name' => 'Case Studies', 'status' => 1]);

        $posts = [
            ['slug' => 'why-every-business-needs-cctv', 'title' => 'Why Every Business Needs CCTV Surveillance', 'category' => $catTips->id, 'author' => 'ATSL Team', 'image' => $blogImg[0],
             'excerpt' => 'CCTV is no longer a luxury — it is essential protection for your people, property and peace of mind.',
             'content' => '<p>Modern CCTV systems deter crime, provide evidence, and let you monitor your premises from anywhere. Here is why your business should invest today.</p>', 'tags' => 'cctv, security, business', 'days_ago' => 1],
            ['slug' => 'fire-safety-checklist-for-offices', 'title' => 'Fire Safety Checklist for Offices', 'category' => $catTips->id, 'author' => 'Safety Team', 'image' => $blogImg[1],
             'excerpt' => 'A practical checklist to keep your workplace safe from fire hazards.',
             'content' => '<p>From smoke detectors to clearly marked exits, follow this checklist to protect your staff and assets from fire.</p>', 'tags' => 'fire, safety, office', 'days_ago' => 5],
            ['slug' => 'atsl-completes-major-security-project', 'title' => 'ATSL Completes Major Security Project in Dhaka', 'category' => $catCase->id, 'author' => 'ATSL Team', 'image' => $blogImg[2],
             'excerpt' => 'A look at how we secured a large commercial complex with integrated CCTV, fire and access control.',
             'content' => '<p>Our team delivered a complete integrated security solution covering surveillance, fire protection and access control for a major Dhaka client.</p>', 'tags' => 'case study, project', 'days_ago' => 9],
        ];
        foreach ($posts as $p) {
            Post::updateOrCreate(['slug' => $p['slug']], [
                'category_id' => $p['category'], 'title' => $p['title'], 'author' => $p['author'], 'image' => $p['image'],
                'excerpt' => $p['excerpt'], 'content' => $p['content'], 'tags' => $p['tags'],
                'status' => 1, 'published_at' => now()->subDays($p['days_ago']),
            ]);
        }

        /* ============ Demo admin user ============ */
        User::updateOrCreate(['email' => 'admin@atsl.com.bd'], ['name' => 'ATSL Admin', 'password' => Hash::make('password')]);
    }
}
