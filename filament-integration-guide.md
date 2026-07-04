# Filament Integration Guide: Making Welcome Page Fully Editable

Step-by-step guide to replace all hardcoded data in `welcome.blade.php` with dynamic data managed through Filament admin panel.

Uses **Spatie Media Library** for centralized image/media management and **Tiptap Editor** for rich text content editing.

---

## Overview

Current state: `welcome.blade.php` has hardcoded text, images (placeholders), and content.
Goal: Every piece of content on the welcome page becomes editable from Filament admin panel.

### What will be editable

| Section | Content | Filament Control |
|---------|---------|-----------------|
| Header/Nav | Company name, phone number, logo | CompanySetting (singleton) |
| Hero | Tagline, title, description, buttons, image, badge | PageSection model (slug: hero) |
| Trusted By | Client logos | ClientLogo model (many) |
| Experience Counter | Number stats | CounterStat model (many) |
| About Us | Title, content, founder info, image | PageSection model (slug: about) |
| Key Benefits | Title, description, benefit list | PageSection model (slug: benefits) |
| Who We Are | Vision & Mission text | PageSection model (slug: who-we-are) |
| Services | Service cards (icon, title, desc) | Service model (many) |
| Projects | Project cards (image, category, title) | Project model (many) |
| Pricing | Plans (name, price, features, badge) | PricingPlan model (many) |
| Testimonials | Reviews (rating, quote, person info) | Testimonial model (many) |
| Blog/News | Articles (title, excerpt, image, date) | Post model (many) |
| Contact | Address, phone, email, form settings | PageSection model (slug: contact) |
| Footer | Description, links, social media | CompanySetting (singleton) |

---

## Step 1: Install Required Packages

### 1a. Spatie Media Library

```bash
sail composer require spatie/laravel-medialibrary
sail composer require filament/spatie-laravel-media-library-plugin
```

Publish the config and run migrations:

```bash
sail artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
sail artisan migrate
```

### 1b. Tiptap Editor for Filament

```bash
sail composer require awcodes/filament-tiptap-editor
```

> **Note:** Verify package compatibility with your Filament version. Check the package's README for supported Filament versions. For Filament v4, check if there's a v4-compatible branch or fork.

### 1c. Regenerate autoload & publish assets

```bash
sail artisan filament:upgrade
```

---

## Step 2: Database Migrations

### 2a. Company Settings (singleton)

Single row table for global company data (header, footer, contact info).

```bash
sail artisan make:migration create_company_settings_table
```

```php
// database/migrations/xxxx_create_company_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('Zeroxe Consulting');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
```

### 2b. Page Sections (singleton-like, keyed by slug)

Each row represents one content section on the welcome page. The `slug` column uniquely identifies which section the row belongs to (hero, about, benefits, etc.). The `content` column stores rich text (HTML from Tiptap). The `extra` JSON column holds section-specific structured data.

```bash
sail artisan make:migration create_page_sections_table
```

```php
// database/migrations/xxxx_create_page_sections_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();       // e.g. 'hero', 'about', 'benefits'
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();  // e.g. "ABOUT US", "KEY BENEFITS"
            $table->longText('content')->nullable(); // Rich text from Tiptap (HTML)
            $table->json('extra')->nullable();       // Section-specific data
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
```

### 2c. Services

```bash
sail artisan make:migration create_services_table
```

```php
// database/migrations/xxxx_create_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();  // emoji or icon class
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
```

### 2d. Projects

```bash
sail artisan make:migration create_projects_table
```

```php
// database/migrations/xxxx_create_projects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();  // e.g. "Business", "Finance"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            // Image stored via Spatie Media Library (collection: 'project-image')
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
```

### 2e. Pricing Plans

```bash
sail artisan make:migration create_pricing_plans_table
```

```php
// database/migrations/xxxx_create_pricing_plans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // e.g. "Basic", "Premium"
            $table->decimal('price', 8, 2);          // e.g. 49.00
            $table->string('period')->default('Monthly'); // e.g. "Monthly"
            $table->json('features');                // ["5 Analytics Campaign", ...]
            $table->boolean('is_popular')->default(false);
            $table->string('badge')->nullable();     // e.g. "POPULAR"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
```

### 2f. Testimonials

```bash
sail artisan make:migration create_testimonials_table
```

```php
// database/migrations/xxxx_create_testimonials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // e.g. "John Doe"
            $table->string('role')->nullable();   // e.g. "CEO, Tech Corp"
            $table->string('company')->nullable();
            $table->integer('rating')->default(5); // 1-5
            $table->text('quote');                 // testimonial text
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            // Avatar stored via Spatie Media Library (collection: 'avatar')
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
```

### 2g. Blog Posts

```bash
sail artisan make:migration create_posts_table
```

```php
// database/migrations/xxxx_create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable(); // Rich text from Tiptap (HTML)
            $table->date('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            // Featured image via Spatie Media Library (collection: 'featured-image')
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

### 2h. Client Logos

```bash
sail artisan make:migration create_client_logos_table
```

```php
// database/migrations/xxxx_create_client_logos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();      // optional link
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            // Logo image via Spatie Media Library (collection: 'logo')
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_logos');
    }
};
```

### 2i. Counter Stats

```bash
sail artisan make:migration create_counter_stats_table
```

```php
// database/migrations/xxxx_create_counter_stats_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counter_stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');                // e.g. "Years Experience"
            $table->string('number_value');          // e.g. "15+", "200+", "98%"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counter_stats');
    }
};
```

### 2j. Run All Migrations

```bash
sail artisan migrate
```

---

## Step 3: Create Eloquent Models

### 3a. CompanySetting

```php
// app/Models/CompanySetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CompanySetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'address',
        'footer_description',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
    ];

    /**
     * Get the single instance (singleton pattern).
     * Creates one if none exists.
     */
    public static function instance(): static
    {
        return static::firstOrCreate([], [
            'company_name' => 'Zeroxe Consulting',
        ]);
    }

    /**
     * Register media collections.
     * - 'logo': company logo displayed in header/footer
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();  // Only one logo at a time
    }
}
```

### 3b. PageSection

```php
// app/Models/PageSection.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'content',
        'extra',
        'is_active',
    ];

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Find a section by its slug.
     * Returns null if not found.
     */
    public static function getBySlug(string $slug): ?static
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }

    /**
     * Get a value from the extra JSON column.
     */
    public function getExtra(string $key, $default = null)
    {
        return data_get($this->extra, $key, $default);
    }
}
```

### 3c. Service

```php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

### 3d. Project

```php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project-image')
            ->singleFile();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

### 3e. PricingPlan

```php
// app/Models/PricingPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'period',
        'features',
        'is_popular',
        'badge',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

### 3f. Testimonial

```php
// app/Models/Testimonial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'role',
        'company',
        'rating',
        'quote',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

### 3g. Post

```php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured-image')
            ->singleFile();
    }

    /**
     * Auto-generate slug from title when creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->orderByDesc('published_at');
    }
}
```

### 3h. ClientLogo

```php
// app/Models/ClientLogo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ClientLogo extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

### 3i. CounterStat

```php
// app/Models/CounterStat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterStat extends Model
{
    protected $fillable = [
        'label',
        'number_value',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
```

---

## Step 4: Create Filament Resources

### 4a. Company Setting (Singleton Page)

Filament doesn't have a native "singleton" resource, but you can create a custom Page for this. Alternatively, use a resource with `manageString` to force single-record editing.

```bash
sail artisan make:filament-resource CompanySetting --generate
```

Edit the generated resource to make it singleton-like:

```php
// app/Filament/Admin/Resources/CompanySettingResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanySettingResource\Pages;
use App\Models\CompanySetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

class CompanySettingResource extends Resource
{
    protected static ?string $model = CompanySetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Company Settings';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Company Information')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Logo')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('logo')
                            ->label('Company Logo')
                            ->disk('public')
                            ->directory('company')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->visibleOn('edit'),
                    ]),

                Forms\Components\Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('Twitter / X URL')
                            ->url()
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Footer')
                    ->schema([
                        Forms\Components\Textarea::make('footer_description')
                            ->rows(3)
                            ->maxLength(500),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        // This is a singleton - redirect to edit on list visit.
        // But Filament requires a table() method. Return empty or redirect.
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanySettings::route('/'),
            'edit' => Pages\EditCompanySetting::route('/{record}/edit'),
        ];
    }
}
```

Create the List and Edit pages. The List page should auto-redirect to the edit page:

```php
// app/Filament/Admin/Resources/CompanySettingResource/Pages/ListCompanySettings.php

namespace App\Filament\Admin\Resources\CompanySettingResource\Pages;

use App\Filament\Admin\Resources\CompanySettingResource;
use App\Models\CompanySetting;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Redirect;

class ListCompanySettings extends ListRecords
{
    protected static string $resource = CompanySettingResource::class;

    /**
     * Auto-redirect to the singleton edit page.
     */
    public function mount(): void
    {
        $setting = CompanySetting::instance(); // creates if not exists
        Redirect::route('filament.admin.resources.company-settings.edit', ['record' => $setting])->send();
    }
}
```

```php
// app/Filament/Admin/Resources/CompanySettingResource/Pages/EditCompanySetting.php

namespace App\Filament\Admin\Resources\CompanySettingResource\Pages;

use App\Filament\Admin\Resources\CompanySettingResource;
use Filament\Resources\Pages\EditRecord;

class EditCompanySetting extends EditRecord
{
    protected static string $resource = CompanySettingResource::class;
}
```

### 4b. Page Sections Resource

```bash
sail artisan make:filament-resource PageSection --generate
```

Edit the generated resource:

```php
// app/Filament/Admin/Resources/PageSectionResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageSectionResource\Pages;
use App\Models\PageSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

class PageSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Page Sections';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Section Info')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Unique identifier: hero, about, benefits, who-we-are, contact')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtitle')
                            ->helperText('Small label above title, e.g. "ABOUT US", "KEY BENEFITS"')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->helperText('Main heading for this section')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        TiptapEditor::make('content')
                            ->label('Section Content')
                            ->profile('default')  // or 'minimal', 'full'
                            ->columnSpanFull()
                            ->helperText('Rich text content for this section. Use for about paragraphs, benefit descriptions, etc.'),
                    ]),

                Forms\Components\Section::make('Extra Data (JSON)')
                    ->schema([
                        Forms\Components\KeyValue::make('extra')
                            ->label('Additional Data')
                            ->helperText('Key-value pairs for section-specific data. Examples below:')
                            ->reorderable(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->note('
                        <strong>Extra data examples per section:</strong><br>
                        <code>hero</code>: badge_number="15+", badge_text="Years Experience", button_primary_text="Get Consulting", button_primary_url="#contact", button_secondary_text="Open Account", image_url="..."<br>
                        <code>about</code>: founder_name="Hendrik Morella", founder_role="CEO, DIRECTOR", founder_quote="...", founder_image_url="..."<br>
                        <code>benefits</code>: benefit_items=["Benefit 1", "Benefit 2", ...]<br>
                        <code>who-we-are</code>: vision_text="...", mission_text="..."<br>
                        <code>contact</code>: address_text="...", phone_text="...", email_text="..."<br>
                    '),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->defaultSort('slug');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageSections::route('/'),
            'create' => Pages\CreatePageSection::route('/create'),
            'edit' => Pages\EditPageSection::route('/{record}/edit'),
        ];
    }
}
```

> **About the extra JSON column:** Using `Forms\Components\KeyValue` lets admins add key-value pairs without touching code. For more complex structured data (like benefit_items which is an array), consider using `Forms\Components\Repeater` with a custom approach, or store JSON strings in the KeyValue and decode them in the blade.

### 4c. Service Resource

```bash
sail artisan make:filament-resource Service --generate
```

```php
// app/Filament/Admin/Resources/ServiceResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('icon')
                            ->helperText('Emoji or icon class, e.g. 📊')
                            ->maxLength(10),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('icon')->label('Icon'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
```

### 4d. Project Resource (with Spatie Media)

```bash
sail artisan make:filament-resource Project --generate
```

```php
// app/Filament/Admin/Resources/ProjectResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('category')
                            ->helperText('e.g. Business, Finance, Digital')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Project Image')
                    ->schema([
                        FileUpload::make('project-image')
                            ->label('Project Image')
                            ->disk('public')
                            ->directory('projects')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
```

### 4e. Pricing Plan Resource

```bash
sail artisan make:filament-resource PricingPlan --generate
```

```php
// app/Filament/Admin/Resources/PricingPlanResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PricingPlanResource\Pages;
use App\Models\PricingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('period')
                            ->default('Monthly')
                            ->maxLength(50),
                        Forms\Components\Toggle::make('is_popular')
                            ->default(false),
                        Forms\Components\TextInput::make('badge')
                            ->helperText('e.g. POPULAR')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\Repeater::make('features')
                            ->schema([
                                Forms\Components\TextInput::make('feature')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->defaultItems(3)
                            ->addActionLabel('Add Feature')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('period'),
                Tables\Columns\IconColumn::make('is_popular')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPricingPlans::route('/'),
            'create' => Pages\CreatePricingPlan::route('/create'),
            'edit' => Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }
}
```

> **Note on features Repeater:** The `features` field uses a Repeater that stores an array of strings. In the blade template, you'll need to handle the fact that Repeater stores `[{feature: "..."}, ...]` format. You may need to transform it or adjust the Repeater to store flat strings. See blade section below.

### 4f. Testimonial Resource (with Spatie Media)

```bash
sail artisan make:filament-resource Testimonial --generate
```

```php
// app/Filament/Admin/Resources/TestimonialResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('role')
                            ->helperText('e.g. CEO, Tech Corp')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company')
                            ->maxLength(255),
                        Forms\Components\Select::make('rating')
                            ->options([
                                5 => '★★★★★',
                                4 => '★★★★☆',
                                3 => '★★★☆☆',
                                2 => '★★☆☆☆',
                                1 => '★☆☆☆☆',
                            ])
                            ->default(5)
                            ->required(),
                        Forms\Components\Textarea::make('quote')
                            ->required()
                            ->rows(3),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Avatar')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Client Avatar')
                            ->disk('public')
                            ->directory('testimonials')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
```

### 4g. Post Resource (with Spatie Media + Tiptap)

```bash
sail artisan make:filament-resource Post --generate
```

```php
// app/Filament/Admin/Resources/PostResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use FilamentTiptapEditor\TiptapEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Blog / News';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Post Info')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                                $set('slug', \Illuminate\Support\Str::slug($state ?? ''))
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Publish Date'),
                        Forms\Components\Toggle::make('is_published')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\Textarea::make('excerpt')
                            ->rows(2)
                            ->helperText('Short summary shown on blog listing')
                            ->columnSpanFull(),
                        TiptapEditor::make('content')
                            ->label('Full Content')
                            ->profile('default')
                            ->columnSpanFull()
                            ->helperText('Full article content with rich text formatting'),
                    ]),

                Forms\Components\Section::make('Featured Image')
                    ->schema([
                        FileUpload::make('featured-image')
                            ->label('Featured Image')
                            ->disk('public')
                            ->directory('posts')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->defaultSortDesc('published_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
```

### 4h. Client Logo Resource (with Spatie Media)

```bash
sail artisan make:filament-resource ClientLogo --generate
```

```php
// app/Filament/Admin/Resources/ClientLogoResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientLogoResource\Pages;
use App\Models\ClientLogo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class ClientLogoResource extends Resource
{
    protected static ?string $model = ClientLogo::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Client Logos';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('url')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Optional link when logo is clicked'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Logo Image')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Client Logo')
                            ->disk('public')
                            ->directory('clients')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientLogos::route('/'),
            'create' => Pages\CreateClientLogo::route('/create'),
            'edit' => Pages\EditClientLogo::route('/{record}/edit'),
        ];
    }
}
```

### 4i. Counter Stat Resource

```bash
sail artisan make:filament-resource CounterStat --generate
```

```php
// app/Filament/Admin/Resources/CounterStatResource.php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CounterStatResource\Pages;
use App\Models\CounterStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CounterStatResource extends Resource
{
    protected static ?string $model = CounterStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Counter Stats';
    protected static ?string $navigationGroup = 'Website Content';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number_value')
                    ->required()
                    ->helperText('e.g. 15+, 200+, 98%')
                    ->maxLength(20),
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->helperText('e.g. Years Experience, Project Completed')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number_value')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCounterStats::route('/'),
            'create' => Pages\CreateCounterStat::route('/create'),
            'edit' => Pages\EditCounterStat::route('/{record}/edit'),
        ];
    }
}
```

---

## Step 5: Register Navigation Group

Add navigation group labels in your `AdminPanelProvider.php`:

```php
// app/Providers/Filament/AdminPanelProvider.php

use Filament\Navigation\NavigationGroup;

// Inside the panel() method, add:
->navigationGroups([
    NavigationGroup::make()
        ->label('Dashboard'),
    NavigationGroup::make()
        ->label('Website Content')
        ->icon('heroicon-o-globe-alt'),
])
```

---

## Step 6: Create Seeder for Initial Data

This seeds all sections with the current hardcoded data from `welcome.blade.php`, so you have content to work with immediately.

```bash
sail artisan make:seeder WebsiteContentSeeder
```

```php
// database/seeders/WebsiteContentSeeder.php

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
        // Company Settings
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

        // Hero Section
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

        // About Section
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

        // Benefits Section
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

        // Who We Are Section
        PageSection::updateOrCreate(['slug' => 'who-we-are'], [
            'subtitle' => 'WHO WE ARE',
            'title' => 'Consultants typically have expertise in a particular industry.',
            'extra' => [
                'vision_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus nisl vitae magna pulvinar laoreet. Nullam ac tortor vitae purus faucibus ornare suspendisse sed nisi.',
                'mission_text' => 'Massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Felis bibendum ut tristique et egestas quis ipsum suspendisse nec ullamcorper.',
            ],
            'is_active' => true,
        ]);

        // Contact Section
        PageSection::updateOrCreate(['slug' => 'contact'], [
            'subtitle' => 'CONTACT US',
            'title' => 'Get in touch with us.',
            'content' => '<p>Have a project in mind? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.</p>',
            'is_active' => true,
        ]);

        // Services
        $services = [
            ['icon' => '📊', 'title' => 'Business Strategy', 'description' => 'Develop comprehensive strategies to achieve your business goals and maximize growth potential.', 'sort_order' => 1],
            ['icon' => '📈', 'title' => 'Financial Consulting', 'description' => 'Expert financial advice to optimize your operations and improve profitability.', 'sort_order' => 2],
            ['icon' => '🎯', 'title' => 'Market Research', 'description' => 'In-depth market analysis to identify opportunities and stay ahead of competition.', 'sort_order' => 3],
            ['icon' => '💼', 'title' => 'Management Consulting', 'description' => 'Streamline your operations and improve efficiency with our management expertise.', 'sort_order' => 4],
            ['icon' => '🚀', 'title' => 'Digital Transformation', 'description' => 'Modernize your business with cutting-edge digital solutions and technologies.', 'sort_order' => 5],
            ['icon' => '🤝', 'title' => 'Partnership', 'description' => 'Build strategic partnerships to expand your reach and accelerate growth.', 'sort_order' => 6],
        ];
        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service
            );
        }

        // Projects (just metadata - images uploaded via admin)
        $projects = [
            ['title' => 'Strategic Planning', 'category' => 'Business', 'sort_order' => 1],
            ['title' => 'Market Analysis', 'category' => 'Finance', 'sort_order' => 2],
            ['title' => 'Digital Transformation', 'category' => 'Digital', 'sort_order' => 3],
        ];
        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['title' => $project['title']],
                $project
            );
        }

        // Pricing Plans
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
            PricingPlan::updateOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }

        // Testimonials
        $testimonials = [
            ['name' => 'John Doe', 'role' => 'CEO, Tech Corp', 'rating' => 5, 'quote' => 'Excellent consulting service. They helped us increase our revenue by 40% in just 6 months. Highly recommended!', 'sort_order' => 1],
            ['name' => 'Sarah Miller', 'role' => 'Director, Finance Inc', 'rating' => 5, 'quote' => 'Professional team with deep industry knowledge. They transformed our business operations completely.', 'sort_order' => 2],
            ['name' => 'Robert Wilson', 'role' => 'Founder, StartupXYZ', 'rating' => 5, 'quote' => 'Their strategic insights were invaluable. We\'ve seen consistent growth since partnering with them.', 'sort_order' => 3],
        ];
        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                $testimonial
            );
        }

        // Counter Stats
        $stats = [
            ['number_value' => '15+', 'label' => 'Years Experience', 'sort_order' => 1],
            ['number_value' => '200+', 'label' => 'Project Completed', 'sort_order' => 2],
            ['number_value' => '50+', 'label' => 'Team Members', 'sort_order' => 3],
            ['number_value' => '98%', 'label' => 'Client Satisfaction', 'sort_order' => 4],
        ];
        foreach ($stats as $stat) {
            CounterStat::updateOrCreate(
                ['label' => $stat['label']],
                $stat
            );
        }

        // Blog Posts
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
```

Register in `DatabaseSeeder.php`:

```php
// database/seeders/DatabaseSeeder.php

public function run(): void
{
    // ... existing user seeder ...
    $this->call(WebsiteContentSeeder::class);
}
```

Run the seeder:

```bash
sail artisan db:seed --class=WebsiteContentSeeder
```

---

## Step 7: Update Welcome Controller & Blade

### 7a. Create a Controller

```bash
sail artisan make:controller WelcomeController
```

```php
// app/Http/Controllers/WelcomeController.php

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
```

### 7b. Register Route

```php
// routes/web.php

use App\Http\Controllers\WelcomeController;

Route::get('/', WelcomeController::class)->name('welcome');
```

Remove the default Laravel welcome route if it exists.

### 7c. Key Blade Template Patterns

Below are the critical patterns for replacing hardcoded data in `welcome.blade.php`. These show the syntax for each type of content.

**Header - Company name and phone from settings:**
```blade
{{-- Replace hardcoded logo text --}}
<a href="/" class="text-2xl font-bold">
    <span class="text-[#f59e0b]">{{ Str::before($settings->company_name, ' ') }}</span>
    {{ Str::after($settings->company_name, ' ') }}
</a>

{{-- Replace hardcoded phone --}}
<span class="font-semibold ml-2">{{ $settings->phone }}</span>
```

**Hero Section - content from PageSection model:**
```blade
@if($hero)
<section class="bg-[#0f172a] text-white py-20 lg:py-32">
    <div class="container grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <div class="text-[#f59e0b] text-xs font-bold tracking-[0.2em] mb-4">
                {{ $hero->subtitle }}
            </div>
            <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-6">
                {{ $hero->title }}
            </h1>
            <div class="text-gray-400 text-lg mb-8 max-w-lg">
                {!! $hero->content !!}
            </div>
            <div class="flex flex-wrap gap-4">
                @if($hero->getExtra('button_primary_text'))
                    <a href="{{ $hero->getExtra('button_primary_url', '#') }}" class="btn-primary">
                        {{ $hero->getExtra('button_primary_text') }}
                    </a>
                @endif
                @if($hero->getExtra('button_secondary_text'))
                    <a href="{{ $hero->getExtra('button_secondary_url', '#') }}" class="btn-outline">
                        {{ $hero->getExtra('button_secondary_text') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="relative">
            {{-- Hero image: upload via admin or use placeholder --}}
            @if(isset($hero->extra['image_url']))
                <img src="{{ asset('storage/' . $hero->extra['image_url']) }}" alt="Consulting" class="rounded-lg shadow-2xl">
            @else
                <img src="https://placehold.co/600x400/1e293b/f59e0b?text=Consulting+Expert" alt="Consulting" class="rounded-lg shadow-2xl">
            @endif
            @if($hero->getExtra('badge_number'))
                <div class="absolute -bottom-6 -left-6 bg-[#f59e0b] text-white p-6 rounded-lg">
                    <div class="text-3xl font-bold">{{ $hero->getExtra('badge_number') }}</div>
                    <div class="text-sm">{{ $hero->getExtra('badge_text', '') }}</div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif
```

**Client Logos - from ClientLogo model with Spatie Media:**
```blade
@if($clientLogos->count())
<section class="py-12 bg-white border-b">
    <div class="container">
        <div class="text-center mb-8">
            <span class="text-sm font-semibold text-gray-500 tracking-wider">
                TRUSTED BY {{ $clientLogos->count() }}+ POPULAR COMPANY
            </span>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-8 lg:gap-16 opacity-60">
            @foreach($clientLogos as $logo)
                <a href="{{ $logo->url ?? '#' }}" class="block">
                    <img
                        src="{{ $logo->getFirstMediaUrl('logo') ?: 'https://placehold.co/120x40/fff/333?text=' . urlencode($logo->name) }}"
                        alt="{{ $logo->name }}"
                        class="h-8"
                    >
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
```

**Counter Stats:**
```blade
@if($counterStats->count())
<section class="py-16 bg-[#f8fafc]">
    <div class="container grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
        @foreach($counterStats as $stat)
            <div>
                <div class="text-4xl lg:text-5xl font-bold text-[#0f172a] mb-2">{{ $stat->number_value }}</div>
                <div class="text-sm text-gray-500 uppercase tracking-wider">{{ $stat->label }}</div>
            </div>
        @endforeach
    </div>
</section>
@endif
```

**About Section - with founder info from extra JSON:**
```blade
@if($about)
<section id="about" class="py-20">
    <div class="container grid lg:grid-cols-2 gap-16 items-center">
        <div>
            @if(isset($about->extra['image_url']))
                <img src="{{ asset('storage/' . $about->extra['image_url']) }}" alt="About" class="rounded-lg shadow-xl">
            @else
                <img src="https://placehold.co/600x500/0f172a/f59e0b?text=About+Us" alt="About" class="rounded-lg shadow-xl">
            @endif
        </div>
        <div>
            <div class="section-subtitle">{{ $about->subtitle }}</div>
            <h2 class="section-title">{!! $about->title !!}</h2>
            <div class="text-gray-500 mb-8 leading-relaxed">
                {!! $about->content !!}
            </div>
            @if($about->getExtra('founder_quote'))
                <div class="bg-[#f8fafc] p-6 rounded-lg border-l-4 border-[#f59e0b]">
                    <p class="italic text-gray-600 mb-4">"{{ $about->getExtra('founder_quote') }}"</p>
                    <div class="flex items-center gap-4">
                        @if($about->getExtra('founder_image_url'))
                            <img src="{{ asset('storage/' . $about->getExtra('founder_image_url')) }}" alt="Founder" class="rounded-full w-12 h-12">
                        @else
                            <img src="https://placehold.co/50x50/0f172a/fff?text=HM" alt="Founder" class="rounded-full">
                        @endif
                        <div>
                            <div class="font-semibold">{{ $about->getExtra('founder_name') }}</div>
                            <div class="text-sm text-gray-500">{{ $about->getExtra('founder_role') }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif
```

**Benefits Section - with benefit items from extra JSON:**
```blade
@if($benefits)
<section class="py-20 bg-[#0f172a] text-white">
    <div class="container grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <div class="section-subtitle">{{ $benefits->subtitle }}</div>
            <h2 class="section-title text-white">{{ $benefits->title }}</h2>
            <div class="text-gray-400 mb-8">
                {!! $benefits->content !!}
            </div>
            @if($benefits->getExtra('benefit_items'))
                <ul class="space-y-4">
                    @foreach($benefits->getExtra('benefit_items') as $item)
                        <li class="flex items-start gap-3">
                            <span class="text-[#f59e0b] mt-1">✓</span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div>
            @if(isset($benefits->extra['image_url']))
                <img src="{{ asset('storage/' . $benefits->extra['image_url']) }}" alt="Benefits" class="rounded-lg shadow-xl">
            @else
                <img src="https://placehold.co/600x500/1e293b/f59e0b?text=Benefits" alt="Benefits" class="rounded-lg shadow-xl">
            @endif
        </div>
    </div>
</section>
@endif
```

**Who We Are - Vision & Mission from extra JSON:**
```blade
@if($whoWeAre)
<section class="py-20">
    <div class="container">
        <div class="text-center mb-16">
            <div class="section-subtitle">{{ $whoWeAre->subtitle }}</div>
            <h2 class="section-title">{{ $whoWeAre->title }}</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-[#f8fafc] p-8 rounded-lg">
                <div class="w-14 h-14 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-2xl font-bold mb-6">V</div>
                <h3 class="text-xl font-bold mb-4">VISION</h3>
                <div class="text-gray-500 leading-relaxed">
                    {!! $whoWeAre->getExtra('vision_text', '') !!}
                </div>
            </div>
            <div class="bg-[#f8fafc] p-8 rounded-lg">
                <div class="w-14 h-14 bg-[#0f172a] rounded-lg flex items-center justify-center text-white text-2xl font-bold mb-6">M</div>
                <h3 class="text-xl font-bold mb-4">MISSION</h3>
                <div class="text-gray-500 leading-relaxed">
                    {!! $whoWeAre->getExtra('mission_text', '') !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif
```

**Services:**
```blade
@if($services->count())
<section id="services" class="py-20 bg-[#f8fafc]">
    <div class="container">
        <div class="text-center mb-16">
            <div class="section-subtitle">WHAT WE DO</div>
            <h2 class="section-title">Our Expertise & Services.</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-xl mb-6">
                        {{ $service->icon }}
                    </div>
                    <h3 class="text-lg font-bold mb-3">{{ $service->title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $service->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
```

**Projects - with Spatie Media for images:**
```blade
@if($projects->count())
<section id="projects" class="py-20">
    <div class="container">
        <div class="text-center mb-16">
            <div class="section-subtitle">PROJECT</div>
            <h2 class="section-title">Thinking forward for your results.</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <div class="relative group overflow-hidden rounded-lg">
                    <img
                        src="{{ $project->getFirstMediaUrl('project-image') ?: 'https://placehold.co/600x400/0f172a/f59e0b?text=' . urlencode($project->title) }}"
                        alt="{{ $project->title }}"
                        class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <div class="text-[#f59e0b] text-sm font-semibold mb-1">{{ $project->category }}</div>
                            <div class="text-white font-bold">{{ $project->title }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
```

**Pricing Plans:**
```blade
@if($pricingPlans->count())
<section class="py-20 bg-[#f8fafc]">
    <div class="container">
        <div class="text-center mb-16">
            <div class="section-subtitle">PLAN & PRICING</div>
            <h2 class="section-title">Effective & Flexible Pricing.</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($pricingPlans as $plan)
                @if($plan->is_popular)
                    <div class="bg-[#0f172a] text-white p-8 rounded-lg shadow-lg text-center relative">
                        @if($plan->badge)
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#f59e0b] text-white text-xs font-bold px-4 py-1 rounded-full">{{ $plan->badge }}</div>
                        @endif
                        <div class="text-lg font-bold mb-2">{{ $plan->name }}</div>
                        <div class="text-4xl font-bold mb-1">${{ $plan->price }}</div>
                        <div class="text-sm text-gray-400 mb-6">/{{ $plan->period }}</div>
                        <ul class="text-left space-y-3 mb-8">
                            @foreach($plan->features as $feature)
                                <li class="flex items-center gap-2 text-sm text-gray-300">
                                    <span class="text-[#f59e0b]">✓</span>
                                    {{ is_array($feature) ? $feature['feature'] ?? '' : $feature }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="#contact" class="btn-primary w-full text-center">Choose Plan</a>
                    </div>
                @else
                    <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                        <div class="text-lg font-bold mb-2">{{ $plan->name }}</div>
                        <div class="text-4xl font-bold text-[#0f172a] mb-1">${{ $plan->price }}</div>
                        <div class="text-sm text-gray-500 mb-6">/{{ $plan->period }}</div>
                        <ul class="text-left space-y-3 mb-8">
                            @foreach($plan->features as $feature)
                                <li class="flex items-center gap-2 text-sm text-gray-600">
                                    <span class="text-[#f59e0b]">✓</span>
                                    {{ is_array($feature) ? $feature['feature'] ?? '' : $feature }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="#contact" class="btn-primary w-full text-center">Choose Plan</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif
```

**Testimonials - with Spatie Media for avatars:**
```blade
@if($testimonials->count())
<section class="py-20 bg-[#0f172a] text-white">
    <div class="container">
        <div class="text-center mb-16">
            <div class="section-subtitle">TESTIMONIALS</div>
            <h2 class="section-title text-white">What our clients say.</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <div class="bg-[#1e293b] p-8 rounded-lg">
                    <div class="flex gap-1 text-[#f59e0b] mb-4">
                        @for($i = 0; $i < $testimonial->rating; $i++)★@endfor
                    </div>
                    <p class="text-gray-400 mb-6 italic">"{{ $testimonial->quote }}"</p>
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $testimonial->getFirstMediaUrl('avatar') ?: 'https://placehold.co/50x50/f59e0b/0f172a?text=' . urlencode(substr($testimonial->name, 0, 2)) }}"
                            alt="{{ $testimonial->name }}"
                            class="rounded-full"
                        >
                        <div>
                            <div class="font-semibold">{{ $testimonial->name }}</div>
                            <div class="text-sm text-gray-500">{{ $testimonial->role }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
```

**Blog Posts - with Spatie Media for featured image:**
```blade
@if($posts->count())
<section id="blog" class="py-20">
    <div class="container">
        <div class="text-center mb-16">
            <div class="section-subtitle">NEWS & ARTICLE</div>
            <h2 class="section-title">Latest insights & updates.</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                    <img
                        src="{{ $post->getFirstMediaUrl('featured-image') ?: 'https://placehold.co/600x300/0f172a/f59e0b?text=' . urlencode($post->title) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-48 object-cover"
                    >
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">{{ $post->published_at->format('M d, Y') }}</div>
                        <h3 class="font-bold mb-2 hover:text-[#f59e0b] transition-colors cursor-pointer">
                            {{ $post->title }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $post->excerpt }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
```

**Contact Section - with settings:**
```blade
@if($contact)
<section id="contact" class="py-20 bg-[#f8fafc]">
    <div class="container grid lg:grid-cols-2 gap-16">
        <div>
            <div class="section-subtitle">{{ $contact->subtitle }}</div>
            <h2 class="section-title">{{ $contact->title }}</h2>
            <div class="text-gray-500 mb-8">
                {!! $contact->content !!}
            </div>
            <div class="space-y-6">
                @if($settings->address)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white">📍</div>
                        <div>
                            <div class="font-semibold mb-1">Our Office</div>
                            <div class="text-gray-500 text-sm">{{ $settings->address }}</div>
                        </div>
                    </div>
                @endif
                @if($settings->phone)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0f172a] rounded-lg flex items-center justify-center text-white">📞</div>
                        <div>
                            <div class="font-semibold mb-1">Call Us</div>
                            <div class="text-gray-500 text-sm">{{ $settings->phone }}</div>
                        </div>
                    </div>
                @endif
                @if($settings->email)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white">✉️</div>
                        <div>
                            <div class="font-semibold mb-1">Email Us</div>
                            <div class="text-gray-500 text-sm">{{ $settings->email }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{-- Contact form stays the same (not managed by Filament) --}}
        <div class="bg-white p-8 rounded-lg shadow-sm">
            <form class="space-y-6">
                {{-- ... existing form fields ... --}}
            </form>
        </div>
    </div>
</section>
@endif
```

**Footer - with settings:**
```blade
<footer class="bg-[#0f172a] text-white py-16">
    <div class="container grid md:grid-cols-2 lg:grid-cols-4 gap-12">
        <div>
            <a href="/" class="text-2xl font-bold mb-4 block">
                <span class="text-[#f59e0b]">{{ Str::before($settings->company_name, ' ') }}</span>
                {{ Str::after($settings->company_name, ' ') }}
            </a>
            <p class="text-gray-400 text-sm leading-relaxed mb-6">
                {{ $settings->footer_description }}
            </p>
            <div class="flex gap-4">
                @if($settings->facebook_url)
                    <a href="{{ $settings->facebook_url }}" class="w-10 h-10 bg-[#1e293b] rounded-lg flex items-center justify-center hover:bg-[#f59e0b] transition-colors">f</a>
                @endif
                @if($settings->linkedin_url)
                    <a href="{{ $settings->linkedin_url }}" class="w-10 h-10 bg-[#1e293b] rounded-lg flex items-center justify-center hover:bg-[#f59e0b] transition-colors">in</a>
                @endif
                @if($settings->twitter_url)
                    <a href="{{ $settings->twitter_url }}" class="w-10 h-10 bg-[#1e293b] rounded-lg flex items-center justify-center hover:bg-[#f59e0b] transition-colors">tw</a>
                @endif
            </div>
        </div>
        {{-- ... rest of footer links ... --}}
    </div>
    <div class="container mt-12 pt-8 border-t border-gray-800">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ $settings->company_name }}. All rights reserved.</p>
            {{-- ... --}}
        </div>
    </div>
</footer>
```

---

## Step 8: Media Storage Configuration

Make sure your `.env` has the right disk configuration:

```env
FILESYSTEM_DISK=public
```

Create storage symlink (if not already done):

```bash
sail artisan storage:link
```

Media files uploaded through Filament will be stored in:
- `storage/app/public/company/` - company logo
- `storage/app/public/projects/` - project images
- `storage/app/public/testimonials/` - testimonial avatars
- `storage/app/public/posts/` - blog featured images
- `storage/app/public/clients/` - client logos

Accessible via `https://your-domain/storage/projects/image.jpg` etc.

---

## Step 9: Configure Spatie Media Library (Optional)

Publish the config for advanced media settings:

```bash
sail artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-config"
```

This creates `config/medialibrary.php` where you can configure:
- Custom URL generators
- Responsive image generation
- Media conversions (thumbnails, etc.)

For this project, the defaults work fine. No changes needed unless you want automatic thumbnail generation.

---

## Step 10: Tiptap Editor Configuration

The `awcodes/filament-tiptap-editor` comes with default profiles. You can customize available tools:

```php
// In a service provider or panel provider:

use FilamentTiptapEditor\TiptapEditor;
use FilamentTiptapEditor\Enums\TiptapTool;

TiptapEditor::configureUsing(function (TiptapEditor $editor) {
    $editor
        ->tools([
            'bold',
            'italic',
            'underline',
            'strike',
            'h2',
            'h3',
            'bulletList',
            'orderedList',
            'link',
            'blockquote',
            'codeBlock',
        ])
        ->profile('default');
});
```

Or configure per-field in the resource:

```php
TiptapEditor::make('content')
    ->tools([
        'bold', 'italic', 'h2', 'h3',
        'bulletList', 'orderedList',
        'link', 'blockquote',
    ])
```

---

## Final Project Structure

```
app/
├── Filament/Admin/Resources/
│   ├── ClientLogoResource.php          (+ Pages/)
│   ├── CompanySettingResource.php      (+ Pages/)
│   ├── CounterStatResource.php         (+ Pages/)
│   ├── PageSectionResource.php         (+ Pages/)
│   ├── PricingPlanResource.php         (+ Pages/)
│   ├── PostResource.php                (+ Pages/)
│   ├── ProjectResource.php             (+ Pages/)
│   ├── ServiceResource.php             (+ Pages/)
│   └── TestimonialResource.php         (+ Pages/)
├── Http/Controllers/
│   └── WelcomeController.php
├── Models/
│   ├── ClientLogo.php
│   ├── CompanySetting.php
│   ├── CounterStat.php
│   ├── PageSection.php
│   ├── PricingPlan.php
│   ├── Post.php
│   ├── Project.php
│   ├── Service.php
│   └── Testimonial.php
├── Providers/Filament/
│   └── AdminPanelProvider.php
database/
├── migrations/
│   ├── ..._create_company_settings_table.php
│   ├── ..._create_page_sections_table.php
│   ├── ..._create_services_table.php
│   ├── ..._create_projects_table.php
│   ├── ..._create_pricing_plans_table.php
│   ├── ..._create_testimonials_table.php
│   ├── ..._create_posts_table.php
│   ├── ..._create_client_logos_table.php
│   └── ..._create_counter_stats_table.php
├── seeders/
│   └── WebsiteContentSeeder.php
resources/views/
└── welcome.blade.php
```

---

## Troubleshooting

**Spatie Media not found:**
Make sure you ran `sail artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"` and then `sail artisan migrate`.

**Tiptap editor not rendering:**
Ensure the Filament assets are published:
```bash
sail artisan filament:upgrade
sail npm run build
```

**Singleton CompanySetting not saving:**
Make sure your CompanySetting model has `CompanySetting::instance()` and the factory creates a row on first access. Check that `fillable` array includes all your fields.

**Feature array format in PricingPlan:**
Filament Repeater stores data as `[{feature: "..."}, ...]`. In the blade, use:
```blade
{{ is_array($feature) ? $feature['feature'] ?? '' : $feature }}
```
Or customize the Repeater to store flat strings using a custom state path.

**Media URLs returning 404:**
Run `sail artisan storage:link` and make sure `FILESYSTEM_DISK=public` in `.env`.

**Page sections not showing:**
Check that `is_active` is `true` and the `slug` matches exactly (case-sensitive). The seeder creates them with the correct slugs.
