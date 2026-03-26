<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TeamMember;
use App\Models\NewsEvent;
use App\Models\Publication;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\TopFlash;
use App\Models\Award;
use App\Models\Competition;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\Suggestion;
use App\Models\Opinion;
use App\Models\Page;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permissions ───────────────────────────────
        $permissions = [
            "manage_users", "manage_roles", "manage_team", "manage_sliders",
            "manage_news", "manage_publications", "manage_gallery",
            "manage_testimonials", "manage_contacts", "manage_awards",
            "manage_competitions", "manage_eip", "manage_pages",
            "manage_top_flash", "manage_opinions", "view_dashboard",
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(["name" => $permission]);
        }

        // ── Roles ─────────────────────────────────────
        $superAdmin = Role::firstOrCreate(["name" => "super_admin"]);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(["name" => "admin"]);
        $admin->givePermissionTo([
            "manage_team", "manage_sliders", "manage_news", "manage_publications",
            "manage_gallery", "manage_testimonials", "manage_contacts",
            "manage_awards", "manage_competitions", "manage_eip",
            "manage_pages", "manage_top_flash", "manage_opinions", "view_dashboard",
        ]);

        $editor = Role::firstOrCreate(["name" => "editor"]);
        $editor->givePermissionTo(["manage_news", "manage_publications", "manage_eip", "view_dashboard"]);

        // ── Users ─────────────────────────────────────
        $u1 = User::firstOrCreate(["email" => "admin@teachersofbihar.org"], [
            "name" => "Super Admin", "password" => Hash::make("password"),
            "designation" => "Administrator", "is_active" => true,
        ]);
        $u1->assignRole("super_admin");

        $u2 = User::firstOrCreate(["email" => "editor@teachersofbihar.org"], [
            "name" => "Content Editor", "password" => Hash::make("password"),
            "designation" => "Editor", "is_active" => true,
        ]);
        $u2->assignRole("editor");

        // ── Sliders ───────────────────────────────────
        $sliders = [
            ["title" => "Teachers of Bihar — Empowering Educators", "image" => "slider1.jpg", "link" => "/about-us", "sort_order" => 1, "is_active" => true],
            ["title" => "Bagless Saturday Initiative",              "image" => "slider2.jpg", "link" => "/bagless-saturday", "sort_order" => 2, "is_active" => true],
            ["title" => "Science Corner — Learning Made Fun",       "image" => "slider3.jpg", "link" => "/science-corner", "sort_order" => 3, "is_active" => true],
            ["title" => "Annual Conference 2025",                   "image" => "slider4.jpg", "link" => "/news-events", "sort_order" => 4, "is_active" => true],
        ];
        foreach ($sliders as $slider) {
            Slider::firstOrCreate(["title" => $slider["title"]], $slider);
        }

        // ── Top Flash ─────────────────────────────────
        $flashes = [
            ["title" => "TOB Calendar 2026 Released", "link" => "#", "is_new" => true, "sort_order" => 1, "is_active" => true],
            ["title" => "Calendar of Leave 2026",      "link" => "#", "is_new" => true, "sort_order" => 2, "is_active" => true],
            ["title" => "Your Opinion Matters — Share Now", "link" => "/youropinionmatters", "is_new" => false, "sort_order" => 3, "is_active" => true],
            ["title" => "New Publication: Science Corner Vol. 5", "link" => "/science-corner", "is_new" => true, "sort_order" => 4, "is_active" => true],
        ];
        foreach ($flashes as $flash) {
            TopFlash::firstOrCreate(["title" => $flash["title"]], $flash);
        }

        // ── Team Members ──────────────────────────────
        $teamMembers = [
            ["name" => "Dr. Rajesh Kumar",  "designation" => "Founder & President",  "department" => "Leadership",                "phone" => "9430000001", "email" => "founder@teachersofbihar.org",   "about" => "Ph.D. (Education), M.Ed., B.Ed. Founder of Teachers of Bihar. 20+ years of experience in education reform.", "role_type" => "founder",    "sort_order" => 1, "is_active" => true],
            ["name" => "Dr. Priya Singh",   "designation" => "Co-Founder",           "department" => "Leadership",                "phone" => "9430000002", "email" => "cofounder@teachersofbihar.org", "about" => "M.Ed., Ph.D. (Education). Co-founder and core member driving curriculum innovation.", "role_type" => "co_founder", "sort_order" => 2, "is_active" => true],
            ["name" => "Dr. Anju Kumari",   "designation" => "Lecturer",             "department" => "CMDE",                      "phone" => "9470333667", "email" => "anju@teachersofbihar.org",      "about" => "M.Sc. (Zoology), M.Ed., Ph.D.(Education), UGC-NET. Expert in curriculum development.", "role_type" => "lecturer",   "sort_order" => 3, "is_active" => true],
            ["name" => "Mr. Amit Verma",    "designation" => "Core Member",          "department" => "Technology & Innovation",   "phone" => "9430000004", "email" => "amit@teachersofbihar.org",      "about" => "B.Tech, M.Ed. Technology enthusiast bridging tech and education.", "role_type" => "core_team",  "sort_order" => 4, "is_active" => true],
            ["name" => "Mrs. Sunita Devi",  "designation" => "Content Specialist",   "department" => "Content Development",       "phone" => "9430000005", "email" => "sunita@teachersofbihar.org",    "about" => "M.A. (Hindi), B.Ed. Specializes in Hindi content for primary students.", "role_type" => "member",     "sort_order" => 5, "is_active" => true],
            ["name" => "Mr. Vivek Sharma",  "designation" => "District Coordinator", "department" => "Field Operations",          "phone" => "9430000006", "email" => "vivek@teachersofbihar.org",     "about" => "B.Ed., M.A. Coordinates activities across 10 districts of Bihar.", "role_type" => "member",     "sort_order" => 6, "is_active" => true],
        ];
        foreach ($teamMembers as $tm) {
            TeamMember::firstOrCreate(["email" => $tm["email"]], $tm);
        }

        // ── News & Events ─────────────────────────────
        $newsItems = [
            ["title" => "Teachers of Bihar Annual Conference 2025",     "slug" => "annual-conference-2025",        "short_description" => "Annual conference held in Patna with 500+ teachers.", "content" => "<p>The annual conference was held at Patna with over 500 teachers from across Bihar.</p>", "category" => "event",  "event_date" => "2025-12-15", "is_published" => true],
            ["title" => "Bagless Saturday Initiative Expanded",          "slug" => "bagless-saturday-expanded",     "short_description" => "Bagless Saturday now in 10 more districts of Bihar.", "content" => "<p>The initiative has been expanded to 10 more districts.</p>", "category" => "news", "is_published" => true],
            ["title" => "New Science Corner Publication Released",        "slug" => "science-corner-vol5",           "short_description" => "Volume 5 of Science Corner is now available.", "content" => "<p>Science Corner Vol. 5 has been released with new experiments.</p>", "category" => "news", "is_published" => true],
            ["title" => "Bihar Teacher of the Year Award Ceremony",       "slug" => "teacher-of-year-2025",          "short_description" => "Annual award ceremony honoring best teachers.", "content" => "<p>Award ceremony was held at Bihar Bhawan, Patna.</p>", "category" => "event", "event_date" => "2025-11-05", "is_published" => true],
            ["title" => "Workshop on Activity Based Learning",            "slug" => "abl-workshop-2025",             "short_description" => "Workshop on ABL methodology for primary teachers.", "content" => "<p>2-day workshop on Activity Based Learning conducted in Gaya.</p>", "category" => "event", "event_date" => "2025-10-20", "is_published" => true],
            ["title" => "TOB Launches New Mobile App for Teachers",       "slug" => "tob-mobile-app-launch",         "short_description" => "New mobile app to connect Bihar teachers.", "content" => "<p>TOB launched its official mobile app for better connectivity.</p>", "category" => "news", "is_published" => true],
        ];
        foreach ($newsItems as $item) {
            NewsEvent::firstOrCreate(["slug" => $item["slug"]], $item);
        }

        // ── Publications ──────────────────────────────
        $publications = [
            ["title" => "Science Corner Volume 5",        "slug" => "science-corner-vol-5",       "description" => "Activity-based science experiments for primary students.", "category" => "science_corner", "issue_number" => "Vol. 5",  "published_date" => "2025-12-01", "is_active" => true],
            ["title" => "Science Corner Volume 4",        "slug" => "science-corner-vol-4",       "description" => "Hands-on science activities for classroom learning.", "category" => "science_corner", "issue_number" => "Vol. 4",  "published_date" => "2025-06-01", "is_active" => true],
            ["title" => "TLM Handbook 2025",              "slug" => "tlm-handbook-2025",          "description" => "Teaching Learning Materials guide for government school teachers.", "category" => "tlm",            "issue_number" => "2025",    "published_date" => "2025-01-15", "is_active" => true],
            ["title" => "Anusandhaanam Issue 3",          "slug" => "anusandhaanam-issue-3",      "description" => "Research journal on innovative teaching practices.", "category" => "anusandhaanam",  "issue_number" => "Issue 3", "published_date" => "2025-09-01", "is_active" => true],
            ["title" => "Abhimat Teachers Opinion 2025",  "slug" => "abhimat-2025",               "description" => "Collection of teachers opinions and experiences.", "category" => "abhimat",        "issue_number" => "2025",    "published_date" => "2025-07-01", "is_active" => true],
            ["title" => "E-Magazine January 2026",        "slug" => "emagazine-jan-2026",         "description" => "Monthly e-magazine for teachers with updates and activities.", "category" => "emagazine",      "issue_number" => "Jan 2026","published_date" => "2026-01-01", "is_active" => true],
            ["title" => "E-Magazine February 2026",       "slug" => "emagazine-feb-2026",         "description" => "Monthly e-magazine with classroom stories.", "category" => "emagazine",      "issue_number" => "Feb 2026","published_date" => "2026-02-01", "is_active" => true],
            ["title" => "Karmana — Action Stories Vol 2", "slug" => "karmana-vol-2",              "description" => "Stories of teachers making a difference in Bihar.", "category" => "karmana",        "issue_number" => "Vol. 2",  "published_date" => "2025-08-01", "is_active" => true],
            ["title" => "Balman — Children Special",      "slug" => "balman-children-special",   "description" => "Special edition for children with stories and activities.", "category" => "balman",         "issue_number" => "2025",    "published_date" => "2025-11-14", "is_active" => true],
            ["title" => "Suvichar — Daily Wisdom 2025",   "slug" => "suvichar-2025",              "description" => "Daily inspirational thoughts for educators.", "category" => "suvichar",       "issue_number" => "2025",    "published_date" => "2025-01-01", "is_active" => true],
        ];
        foreach ($publications as $pub) {
            Publication::firstOrCreate(["slug" => $pub["slug"]], $pub);
        }

        // ── Gallery ───────────────────────────────────
        $galleries = [
            ["title" => "Annual Conference 2025 — Opening Ceremony",    "type" => "image", "category" => "conference",   "is_active" => true],
            ["title" => "Annual Conference 2025 — Group Photo",          "type" => "image", "category" => "conference",   "is_active" => true],
            ["title" => "Bagless Saturday — Patna Schools",              "type" => "image", "category" => "bagless",      "is_active" => true],
            ["title" => "Bagless Saturday — Students Activity",          "type" => "image", "category" => "bagless",      "is_active" => true],
            ["title" => "Science Corner Workshop — Muzaffarpur",         "type" => "image", "category" => "workshop",     "is_active" => true],
            ["title" => "TLM Training Session — Gaya",                   "type" => "image", "category" => "training",     "is_active" => true],
            ["title" => "Award Ceremony 2025",                           "type" => "image", "category" => "award",        "is_active" => true],
            ["title" => "TOB Mobile App Launch Event",                   "type" => "image", "category" => "event",        "is_active" => true],
            ["title" => "Annual Conference 2025 Highlights",             "type" => "video", "video_url" => "https://www.youtube.com/watch?v=example1", "category" => "conference", "is_active" => true],
            ["title" => "Bagless Saturday Documentary",                  "type" => "video", "video_url" => "https://www.youtube.com/watch?v=example2", "category" => "bagless",    "is_active" => true],
            ["title" => "Teacher Interviews 2025",                       "type" => "media", "video_url" => "https://www.youtube.com/watch?v=example3", "category" => "interview",  "is_active" => true],
        ];
        foreach ($galleries as $g) {
            Gallery::firstOrCreate(["title" => $g["title"]], $g);
        }

        // ── Awards ────────────────────────────────────
        $awards = [
            ["title" => "Best Innovation in Education 2024",   "slug" => "best-innovation-2024",   "description" => "Awarded for outstanding contribution to education innovation in Bihar.", "year" => 2024, "is_active" => true],
            ["title" => "State Level Education Award 2023",    "slug" => "state-education-2023",   "description" => "Recognized by Bihar government for excellence in teacher training.", "year" => 2023, "is_active" => true],
            ["title" => "National Teaching Excellence 2023",   "slug" => "national-excellence-2023","description" => "National level recognition for TOB's grassroots education programs.", "year" => 2023, "is_active" => true],
            ["title" => "Community Impact Award 2022",         "slug" => "community-impact-2022",  "description" => "Awarded for impacting 10,000+ students through Bagless Saturday.", "year" => 2022, "is_active" => true],
        ];
        foreach ($awards as $award) {
            Award::firstOrCreate(["slug" => $award["slug"]], $award);
        }

        // ── Competitions ──────────────────────────────
        $competitions = [
            ["title" => "Best Classroom Decoration 2026",        "slug" => "classroom-decoration-2026", "description" => "Annual competition for best decorated classroom in Bihar government schools.", "last_date" => "2026-04-30", "is_active" => true],
            ["title" => "Student Science Model Competition",      "slug" => "science-model-2026",        "description" => "Students showcase innovative science models.", "last_date" => "2026-05-15", "is_active" => true],
            ["title" => "Teacher Innovation Challenge 2026",      "slug" => "innovation-challenge-2026", "description" => "Teachers submit innovative teaching methods for evaluation.", "last_date" => "2026-06-30", "is_active" => true],
            ["title" => "Best TLM Creation Contest",              "slug" => "tlm-creation-2026",         "description" => "Create the best Teaching Learning Material from local resources.", "last_date" => "2026-04-15", "is_active" => true],
        ];
        foreach ($competitions as $comp) {
            Competition::firstOrCreate(["slug" => $comp["slug"]], $comp);
        }

        // ── Testimonials ──────────────────────────────
        $testimonials = [
            ["name" => "Ramesh Kumar",    "designation" => "Primary Teacher",       "organization" => "Govt. School, Patna",        "content" => "Teachers of Bihar has completely transformed my teaching approach. The training sessions and publications are invaluable.", "rating" => 5, "is_active" => true],
            ["name" => "Sunita Sharma",   "designation" => "Middle School Teacher",  "organization" => "Govt. School, Muzaffarpur",  "content" => "Bagless Saturday is the best initiative I have seen. Students love it and I can see real learning happening.", "rating" => 5, "is_active" => true],
            ["name" => "Mohan Lal",       "designation" => "Senior Teacher",         "organization" => "Govt. School, Gaya",         "content" => "TOB publications have greatly improved our classroom teaching methods. Science Corner is especially wonderful.", "rating" => 4, "is_active" => true],
            ["name" => "Geeta Devi",      "designation" => "Head Teacher",           "organization" => "Govt. School, Bhagalpur",    "content" => "The workshops organized by TOB helped me become a better teacher and leader in my school.", "rating" => 5, "is_active" => true],
            ["name" => "Arun Singh",      "designation" => "Science Teacher",        "organization" => "Govt. School, Darbhanga",    "content" => "TLM training was eye opening. Now I create my own teaching aids from local materials.", "rating" => 5, "is_active" => true],
            ["name" => "Meena Kumari",    "designation" => "Primary Teacher",        "organization" => "Govt. School, Vaishali",     "content" => "I feel proud to be part of this movement. TOB is truly changing education in Bihar.", "rating" => 4, "is_active" => true],
        ];
        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(["name" => $t["name"]], $t);
        }

        // ── Opinions ──────────────────────────────────
        $opinions = [
            ["name" => "Rakesh Yadav",  "email" => "rakesh@gmail.com",  "district" => "Patna",      "school" => "PS Phulwarisharif",  "opinion" => "Bagless Saturday is amazing. Children are more creative now.",  "is_approved" => true],
            ["name" => "Puja Kumari",   "email" => "puja@gmail.com",    "district" => "Nalanda",    "school" => "UMS Biharsharif",    "opinion" => "TOB ke trainings se mera teaching kaafi improve hua hai.",       "is_approved" => true],
            ["name" => "Sanjay Mehta",  "email" => "sanjay@gmail.com",  "district" => "Gaya",       "school" => "PS Bodh Gaya",       "opinion" => "Science Corner ka material bahut useful hai classroom ke liye.", "is_approved" => true],
            ["name" => "Anita Singh",   "email" => "anita@gmail.com",   "district" => "Muzaffarpur","school" => "MS Muzaffarpur",      "opinion" => "TLM training changed how I look at teaching completely.",        "is_approved" => true],
        ];
        foreach ($opinions as $op) {
            \App\Models\Opinion::firstOrCreate(["email" => $op["email"]], $op);
        }

        // ── Suggestions ───────────────────────────────
        $suggestions = [
            ["name" => "Vijay Kumar",  "email" => "vijay@gmail.com",  "type" => "suggestion", "message" => "Please add more video content for Science Corner. Visual learning helps students better.", "is_read" => false],
            ["name" => "Rita Devi",    "email" => "rita@gmail.com",   "type" => "suggestion", "message" => "TOB should organize workshops in remote districts like Kaimur and Araria.", "is_read" => false],
            ["name" => "Suresh Pal",   "email" => "suresh@gmail.com", "type" => "complaint",  "message" => "The website sometimes loads slowly on mobile. Please optimize it.", "is_read" => false],
        ];
        foreach ($suggestions as $s) {
            \App\Models\Suggestion::firstOrCreate(["email" => $s["email"]], $s);
        }

        // ── Contacts ──────────────────────────────────
        Contact::firstOrCreate(["email" => "inquiry@example.com"], [
            "name"    => "Rohit Sharma",
            "email"   => "inquiry@example.com",
            "phone"   => "9876543210",
            "subject" => "Joining TOB",
            "message" => "I am a government school teacher in Patna. I want to join Teachers of Bihar.",
            "is_read" => false,
        ]);

        // ── Pages ─────────────────────────────────────
        $pages = [
            ["title" => "About Teachers of Bihar", "slug" => "about-us",        "content" => "<h2>About Teachers of Bihar</h2><p>ToB is a voluntary organization of government school teachers established in 2016 in Bihar. Our mission is to transform education through innovation, collaboration, and community.</p>", "is_active" => true],
            ["title" => "Bagless Saturday",         "slug" => "bagless-saturday","content" => "<h2>Bagless Saturday</h2><p>Every Saturday, students come to school without bags. Instead, they participate in activity-based learning, art, sports, and discussions.</p>", "is_active" => true],
        ];
        foreach ($pages as $page) {
            Page::firstOrCreate(["slug" => $page["slug"]], $page);
        }

        $this->command->info('✅ Sab tables mein data seed ho gaya!');
        $this->command->info('📧 Admin login: admin@teachersofbihar.org / password');
    }
}
