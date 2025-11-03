<?php

$models = [
    'Users', 'Banner', 'Blog', 'Category', 'Language', 'Menu', 
    'Page', 'Permission', 'Product', 'ProductCategory', 
    'ProductReview', 'ProductTag', 'Review', 'Role', 
    'Setting', 'Tag', 'Widget'
];

$navigationGroups = [
    'Users' => 'User Management',
    'Banner' => 'Content Management',
    'Blog' => 'Content Management',
    'Category' => 'Product Management',
    'Language' => 'System Settings',
    'Menu' => 'Content Management',
    'Page' => 'Content Management',
    'Permission' => 'User Management',
    'Product' => 'Product Management',
    'ProductCategory' => 'Product Management',
    'ProductReview' => 'Product Management',
    'ProductTag' => 'Product Management',
    'Review' => 'Product Management',
    'Role' => 'User Management',
    'Setting' => 'System Settings',
    'Tag' => 'Content Management',
    'Widget' => 'Content Management'
];

$heroicons = [
    'Users' => 'Heroicon::Users',
    'Banner' => 'Heroicon::Photograph',
    'Blog' => 'Heroicon::DocumentText',
    'Category' => 'Heroicon::Folder',
    'Language' => 'Heroicon::GlobeAlt',
    'Menu' => 'Heroicon::Menu',
    'Page' => 'Heroicon::Document',
    'Permission' => 'Heroicon::LockClosed',
    'Product' => 'Heroicon::ShoppingBag',
    'ProductCategory' => 'Heroicon::Collection',
    'ProductReview' => 'Heroicon::Star',
    'ProductTag' => 'Heroicon::Tag',
    'Review' => 'Heroicon::ChatAlt2',
    'Role' => 'Heroicon::UserGroup',
    'Setting' => 'Heroicon::Cog',
    'Tag' => 'Heroicon::Tag',
    'Widget' => 'Heroicon::Cube'
];

function generateResourceFile($model) {
    $namespace = "App\\Filament\\Resources\\" . ($model === 'Users' ? 'Users' : "{$model}s");
    $resourceNamespace = $namespace;
    $modelNamespace = "App\\Models\\" . ($model === 'Users' ? 'User' : $model);
    $navigationGroup = $GLOBALS['navigationGroups'][$model];
    $heroicon = $GLOBALS['heroicons'][$model];

    $resourceContent = "<?php

namespace {$namespace};

use UnitEnum;
use BackedEnum;
use {$modelNamespace};
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\PageRegistration;
" . ($model === 'Users' ? 
"use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Users\Schemas\UserInfolist;" : 
"use {$namespace}\Pages\View{$model};
use {$namespace}\Pages\Edit{$model};
use {$namespace}\Pages\List{$model}s;
use {$namespace}\Pages\Create{$model};
use {$namespace}\Schemas\\{$model}Form;
use {$namespace}\Tables\\{$model}sTable;
use {$namespace}\Schemas\\{$model}Infolist;") . "
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;

class " . ($model === 'Users' ? 'UserResource' : "{$model}Resource") . " extends Resource
{
    /**
     * @var string|null \$model
     */
    protected static ?string \$model = " . ($model === 'Users' ? 'User' : $model) . "::class;

    /**
     * @var string \$routes
     */
    protected static string \$routes = '" . strtolower($model === 'Users' ? 'users' : $model) . "s';

    /**
     * @var int|null \$navigationSort
     */
    protected static ?int \$navigationSort = 1;

    /**
     * @return string|UnitEnum|null
     */
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('{$navigationGroup}');
    }

    /**
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('" . ($model === 'Users' ? 'Users' : "{$model}s") . "');
    }

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return __('" . ($model === 'Users' ? 'Users' : "{$model}s") . "');
    }

    /**
     * @return string|BackedEnum|Htmlable|null
     */
    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return {$heroicon};
    }

    /**
     * @param Schema \$schema
     * @return Schema
     */
    public static function form(Schema \$schema): Schema
    {
        return " . ($model === 'Users' ? 'UserForm' : "{$model}Form") . "::configure(\$schema);
    }

    /**
     * @param Schema \$schema
     * @return Schema
     */
    public static function infolist(Schema \$schema): Schema
    {
        return " . ($model === 'Users' ? 'UserInfolist' : "{$model}Infolist") . "::configure(\$schema);
    }

    /**
     * @param Table \$table
     * @return Table
     */
    public static function table(Table \$table): Table
    {
        return " . ($model === 'Users' ? 'UsersTable' : "{$model}sTable") . "::configure(\$table);
    }

    /**
     * @return array
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => " . ($model === 'Users' ? 'ListUsers' : "List{$model}s") . "::route('/'),
            'create' => " . ($model === 'Users' ? 'CreateUser' : "Create{$model}") . "::route('/create'),
            'view' => " . ($model === 'Users' ? 'ViewUser' : "View{$model}") . "::route('/{record}'),
            'edit' => " . ($model === 'Users' ? 'EditUser' : "Edit{$model}") . "::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder
     */
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}";

    return $resourceContent;
}

function generatePageFiles($model) {
    $namespace = "App\\Filament\\Resources\\" . ($model === 'Users' ? 'Users\\Pages' : "{$model}s\\Pages");
    $resourceNamespace = "App\\Filament\\Resources\\" . ($model === 'Users' ? 'Users' : "{$model}s");

    $pages = [
        'List' => "<?php

namespace {$namespace};

use " . ($model === 'Users' ? 'App\Filament\Resources\Users\UserResource' : "{$resourceNamespace}\\{$model}Resource") . ";
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class " . ($model === 'Users' ? 'ListUsers' : "List{$model}s") . " extends ListRecords
{
    protected static string \$resource = " . ($model === 'Users' ? 'UserResource' : "{$model}Resource") . "::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}",
        'Create' => "<?php

namespace {$namespace};

use " . ($model === 'Users' ? 'App\Filament\Resources\Users\UserResource' : "{$resourceNamespace}\\{$model}Resource") . ";
use Filament\Resources\Pages\CreateRecord;

class " . ($model === 'Users' ? 'CreateUser' : "Create{$model}") . " extends CreateRecord
{
    protected static string \$resource = " . ($model === 'Users' ? 'UserResource' : "{$model}Resource") . "::class;

    protected function getRedirectUrl(): string
    {
        return \$this->getResource()::getUrl('index');
    }
}",
        'Edit' => "<?php

namespace {$namespace};

use " . ($model === 'Users' ? 'App\Filament\Resources\Users\UserResource' : "{$resourceNamespace}\\{$model}Resource") . ";
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class " . ($model === 'Users' ? 'EditUser' : "Edit{$model}") . " extends EditRecord
{
    protected static string \$resource = " . ($model === 'Users' ? 'UserResource' : "{$model}Resource") . "::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return \$this->getResource()::getUrl('index');
    }
}",
        'View' => "<?php

namespace {$namespace};

use " . ($model === 'Users' ? 'App\Filament\Resources\Users\UserResource' : "{$resourceNamespace}\\{$model}Resource") . ";
use Filament\Resources\Pages\ViewRecord;

class " . ($model === 'Users' ? 'ViewUser' : "View{$model}") . " extends ViewRecord
{
    protected static string \$resource = " . ($model === 'Users' ? 'UserResource' : "{$model}Resource") . "::class;
}"
    ];

    return $pages;
}

function generateSchemaFiles($model) {
    $namespace = "App\\Filament\\Resources\\" . ($model === 'Users' ? 'Users\\Schemas' : "{$model}s\\Schemas");

    $form = "<?php

namespace {$namespace};

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class " . ($model === 'Users' ? 'UserForm' : "{$model}Form") . "
{
    public static function configure(Schema \$schema): Schema
    {
        return \$schema
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                
                Toggle::make('is_active')
                    ->label(__('Active'))
                    ->default(true),
            ]);
    }
}";

    $infolist = "<?php

namespace {$namespace};

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;

class " . ($model === 'Users' ? 'UserInfolist' : "{$model}Infolist") . "
{
    public static function configure(Schema \$schema): Schema
    {
        return \$schema
            ->schema([
                TextEntry::make('name')
                    ->label(__('Name')),
                
                IconEntry::make('is_active')
                    ->label(__('Active'))
                    ->icon(fn (bool \$state): string => \$state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn (bool \$state): string => \$state ? 'success' : 'danger'),
            ]);
    }
}";

    return [
        'Form' => $form,
        'Infolist' => $infolist
    ];
}

function generateTableFile($model) {
    $namespace = "App\\Filament\\Resources\\" . ($model === 'Users' ? 'Users\\Tables' : "{$model}s\\Tables");

    $table = "<?php

namespace {$namespace};

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class " . ($model === 'Users' ? 'UsersTable' : "{$model}sTable") . "
{
    public static function configure(Table \$table): Table
    {
        return \$table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                
                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->icon(fn (bool \$state): string => \$state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn (bool \$state): string => \$state ? 'success' : 'danger'),
            ])
            ->filters([
                // Filtreler eklenebilir
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                // Toplu işlemler eklenebilir
            ]);
    }
}";

    return $table;
}

// Ana dizin
$baseDir = '/Users/beycanbeycanov/Projects/vapeart-v2/app/Filament/Resources/';

foreach ($models as $model) {
    // Dizin yapısını ayarla
    $resourceDir = $model === 'Users' ? "{$baseDir}Users/" : "{$baseDir}{$model}s/";
    
    // Dizinleri oluştur
    mkdir("{$resourceDir}Pages", 0755, true);
    mkdir("{$resourceDir}Schemas", 0755, true);
    mkdir("{$resourceDir}Tables", 0755, true);

    // Resource dosyası
    $resourcePath = $model === 'Users' ? "{$baseDir}Users/UserResource.php" : "{$resourceDir}{$model}Resource.php";
    file_put_contents($resourcePath, generateResourceFile($model));

    // Page dosyaları
    $pageFiles = generatePageFiles($model);
    $pagePath = $model === 'Users' ? "{$baseDir}Users/Pages/" : "{$resourceDir}Pages/";
    foreach ($pageFiles as $pageType => $pageContent) {
        file_put_contents("{$pagePath}" . ($model === 'Users' ? 
            ($pageType === 'List' ? 'ListUsers.php' : ucfirst($pageType) . 'User.php') : 
            ($pageType === 'List' ? "List{$model}s.php" : ucfirst($pageType) . "{$model}.php")), 
            $pageContent
        );
    }

    // Schema dosyaları
    $schemaFiles = generateSchemaFiles($model);
    $schemaPath = $model === 'Users' ? "{$baseDir}Users/Schemas/" : "{$resourceDir}Schemas/";
    foreach ($schemaFiles as $schemaType => $schemaContent) {
        file_put_contents("{$schemaPath}" . ($model === 'Users' ? 
            "User{$schemaType}.php" : 
            "{$model}{$schemaType}.php"), 
            $schemaContent
        );
    }

    // Table dosyası
    $tablePath = $model === 'Users' ? "{$baseDir}Users/Tables/UsersTable.php" : "{$resourceDir}Tables/{$model}sTable.php";
    file_put_contents($tablePath, generateTableFile($model));
}

echo "Tüm Resource dosyaları oluşturuldu.";
