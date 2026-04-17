---
name: laravel-news-portal-ai-module-guide
description: Expert workflow for implementing modules (CRUD, Auth, Localization) in the Laravel News Portal AI project using Stisla Admin Template.
applyTo: ["**/*.php", "**/*.blade.php", "routes/web.php", "routes/admin.php"]
---

# Laravel News Portal AI Development Guide

This skill encapsulates the project-specific patterns and standards for building modules in the News Portal AI application.

## 🏗 Project Architecture & Tech Stack

- **Framework:** Laravel 11.x
- **Admin Template:** Stisla (included in `public/admin/assets`)
- **Main Layout:** `admin.layouts.master`
- **Auth Guards:** `web` (Users), `admin` (Admins)
- **Database:** SQLite (default for development)
- **Frontend Stack:** Blade, jQuery, Bootstrap 4 (Stisla), SweetAlert2, DataTables, Select2.

---

## 🚀 Module Implementation Pattern (The "Standard Flow")

When the user asks to "Create a [Module]", follow these sequential steps:

### 1. Database & Model

- Create Model + Migration: `php artisan make:model [Name] -m`
- **Migration Standards:**
    - Use `text('image')` for file paths.
    - Use `boolean('status')->default(1)` for toggles.
    - Ensure foreign keys use `constrained()->cascadeOnDelete()`.
- **Model Standards:**
    - Add `$fillable` fields.
    - Set up relationships (e.g., `belongsTo`, `hasMany`).

### 2. Controller & Request

- Create a Resource Controller: `php artisan make:controller Admin/[Name]Controller --resource`
- Create Form Request for validation: `php artisan make:request Admin/[Name]StoreRequest`
- **Controller Logic:**
    - Use `try-catch` blocks for database operations.
    - Return `toastr` notifications or similar SweetAlert2 responses.
    - Handle image uploads using `File` or `Storage` facades.

### 3. Routing

- Register routes in `routes/admin.php` within the appropriate middleware group.
- Always use **Named Routes** (e.g., `admin.category.index`).

### 4. Views (The Stisla Pattern)

- **Location:** `resources/views/admin/[module]/`
- **Template Extension:** `@extends('admin.layouts.master')`
- **Content Section:** `@section('content')`
- **DataTables Implementation:**
    ```html
    <table class="table table-striped" id="table-1">
        <!-- ... -->
    </table>
    ```
    Push scripts to the `@stack('scripts')` stack.

---

## 🎨 UI/UX Guidelines (Mandatory)

### Icons

- Use **FontAwesome 5** (e.g., `<i class="fas fa-plus"></i>`).
- **User Request Exception:** If asked to "remove left/right icons" in sidebar, use `display: none !important;` in a `<style>` block in `sidebar.blade.php`.

### Notifications & Feedback

- Use **SweetAlert2** for delete confirmations.
- Ensure all forms have error validation blocks:
    ```html
    @error('field')
    <span class="text-danger">{{ $message }}</span>
    @enderror
    ```

---

## 🔧 Maintenance Commands

- **Migrations:** `php artisan migrate`
- **Cache Clear:** `php artisan optimize:clear`
- **Vite (if used):** `npm run dev`

## 📝 Change Logging

- After every major feature, update or create a log file in the root (e.g., `0XX_FEATURE_NAME_LOG.md`) summarizing:
    - Task description
    - Files created/modified
    - Database changes
    - Verification steps

---

# 🤖 Claude Copilot Code Skills for Laravel Development

## ✨ Code Generation Best Practices

### 1. Model & Migration Generation

**Claude-Optimized Prompt Pattern:**

```
"Create a Laravel model named [ModelName] with:
- Relationships: [list them]
- Fillable fields: [list them]
- Casting fields: [specify types]
- Database migration with [columns]
And include: Query scopes for [mention common queries]"
```

**What Claude Will Generate:**

- Models with proper relationships and fillable arrays
- Migrations with proper column types and indices
- Query scopes for common filtering
- Accessor/mutator methods when needed
- Soft delete support if requested

### 2. Controller Generation

**Claude-Optimized Prompt Pattern:**

```
"Create a Laravel resource controller for [Model]:
- Use repository pattern: [true/false]
- Include request validation
- Add error handling with try-catch
- Return [JSON/view] responses
- Use eager loading: [relationships]"
```

**Key Directives:**

- Always specify if you want Form Requests (validation)
- Mention eager loading relationships to prevent N+1 queries
- Specify error handling strategy (exceptions vs. redirects)

### 3. Blade Template Generation

**Claude-Optimized Prompt Pattern:**

```
"Create a Blade template for [feature]:
- Extend: admin.layouts.master
- Use Stisla components: [buttons, cards, etc.]
- Include DataTables: [true/false]
- Form fields: [list them]
- Validation error display: [true/false]"
```

### 4. Route Configuration

**Claude-Optimized Prompt Pattern:**

```
"Create routes in routes/admin.php for [Module]:
- Resource routes for: [Model]
- Middleware: [auth:admin, etc.]
- Named routes pattern: admin.[module].[action]
- Additional routes: [custom actions]"
```

---

## 🎯 Laravel Architecture Patterns

### Eloquent Query Optimization

```php
// ✅ GOOD: Eager loading
$articles = Article::with(['author', 'category', 'tags'])->get();

// ✅ GOOD: Constrained eager loading
$articles = Article::with(['comments' => function($query) {
    $query->where('approved', true);
}])->get();

// ❌ BAD: N+1 queries
foreach($articles as $article) {
    echo $article->author->name; // Query per iteration
}
```

**Claude Directive:**
When generating queries, always include: `->with([relationships])` for eager loading

### Relationship Best Practices

```php
// Use type-hinting for relationships
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

// Use constrained relationships
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
```

**Claude Directive:**
Ask: "Use typed return hints for all relationships"

### Model Scopes (Query Builders)

```php
// Local scope
public function scopeActive($query)
{
    return $query->where('status', true);
}

// Global scope for automatic filtering
protected static function boot()
{
    parent::boot();
    static::addGlobalScope(new PublishedScope);
}

// Usage
$articles = Article::active()->get();
```

**Claude Directive:**
For complex queries: "Create query scopes for: [active, archived, featured, etc.]"

---

## 🔍 Performance & Code Quality

### Query Optimization Patterns

```php
// Pagination with counts
$articles = Article::with('comments')
    ->withCount('comments')
    ->paginate(15);

// Chunking for large datasets
Article::chunk(100, function($articles) {
    foreach($articles as $article) {
        // Process batch
    }
});

// Lazy loading with cursor
Article::cursor()->each(function($article) {
    // Process one at a time
});
```

**Claude Directive:**
"Optimize query: use eager loading for relationships, add pagination, include counts"

### Collection Methods

```php
// ✅ GOOD: Use collection methods
$popular = $articles->sortByDesc('views')
    ->take(10)
    ->pluck('title');

// ❌ BAD: Query in loop
foreach($articles as $article) {
    $comments = Comment::where('article_id', $article->id)->get();
}
```

**Claude Directive:**
"Avoid database queries in loops. Use collections or eager loading"

### Caching Strategies

```php
// Cache query results
$languages = Cache::remember('active_languages', 60*24, function() {
    return Language::where('is_active', true)->get();
});

// Cache invalidation on updates
public function updated()
{
    Cache::forget('active_languages');
}
```

**Claude Directive:**
"Add caching for database queries that don't change frequently"

---

## 🛡️ Security Best Practices

### Form Requests & Validation

```php
// Always use Form Requests
public function store(ArticleStoreRequest $request)
{
    $validated = $request->validated();
    Article::create($validated);
}

// In Form Request class
public function rules(): array
{
    return [
        'title' => 'required|string|max:255|unique:articles',
        'content' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
    ];
}
```

**Claude Directive:**
"Always include form validation using Form Requests"

### Authorization (Gates & Policies)

```php
// In Model
public function delete()
{
    return auth('admin')->check() && auth('admin')->user()->is_admin;
}

// In views
@can('delete', $article)
    <button class="btn-danger">Delete</button>
@endcan
```

**Claude Directive:**
"Add authorization checks using gates or policies"

### SQL Injection Prevention

```php
// ✅ GOOD: Parameterized queries
User::where('email', $email)->first();

// ❌ BAD: Direct string interpolation
User::whereRaw("email = '$email'");
```

**Claude Directive:**
"Use parameterized queries only. Never use string interpolation in queries"

---

## 📦 Service Layer Pattern

### Service Classes for Complex Logic

```php
// app/Services/ArticleService.php
class ArticleService
{
    public function publishArticle(Article $article): bool
    {
        try {
            DB::beginTransaction();

            $article->update(['status' => true, 'published_at' => now()]);
            $this->notifySubscribers($article);

            DB::commit();
            return true;
        } catch(Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}

// In Controller
public function publish(Article $article)
{
    $this->articleService->publishArticle($article);
    return redirect()->back()->with('success', 'Article published');
}
```

**Claude Directive:**
"Use service classes for complex business logic, not in controllers"

---

## 🧪 Testing Patterns

### Feature Tests

```php
// tests/Feature/ArticleTest.php
public function test_can_create_article()
{
    $response = $this->post('/admin/articles', [
        'title' => 'Test Article',
        'content' => 'Test content',
    ]);

    $this->assertDatabaseHas('articles', ['title' => 'Test Article']);
}

public function test_unauthorized_user_cannot_create()
{
    $response = $this->post('/admin/articles', [...]);
    $response->assertRedirect('/login');
}
```

**Claude Directive:**
"Include unit tests for critical functionality"

---

## 🎨 Blade Template Patterns

### Component-Based Templates

```blade
<!-- resources/views/components/form-field.blade.php -->
<div class="form-group">
    <label>{{ $label }}</label>
    <input type="text" class="form-control" name="{{ $name }}">
    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<!-- Usage -->
<x-form-field name="title" label="Article Title" />
```

**Claude Directive:**
"Use Blade components for reusable UI elements"

### Conditional Rendering

```blade
<!-- Check multiple conditions -->
@if(auth('admin')->check() && $article->author_id === auth('admin')->id())
    <button class="btn-edit">Edit</button>
@endif

<!-- Use @unless -->
@unless($article->is_published)
    <span class="badge-draft">Draft</span>
@endunless

<!-- Use @forelse -->
@forelse($articles as $article)
    <p>{{ $article->title }}</p>
@empty
    <p>No articles found</p>
@endforelse
```

**Claude Directive:**
"Use Blade directives (@if, @unless, @forelse, etc.) for clarity"

---

## 🚀 Artisan Commands to Know

### Model/Migration/Controller Generation

```bash
# Generate model with migration
php artisan make:model Article -m

# Generate model with migration, factory, seeder, controller, resource
php artisan make:model Article -mfsr

# Generate controller
php artisan make:controller Admin/ArticleController --resource

# Generate form request
php artisan make:request Admin/ArticleStoreRequest

# Generate migration
php artisan make:migration create_articles_table
```

### Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Create seeder
php artisan make:seeder ArticleSeeder

# Run seeders
php artisan db:seed
```

### Optimization & Cache

```bash
# Clear all cache
php artisan optimize:clear

# Cache routes
php artisan route:cache

# Cache config
php artisan config:cache
```

---

## 💡 Claude Copilot Prompt Templates

### 1. Complete Module Creation

```
"Create a complete [Module] module for the News Portal with:

Database:
- Model: [Name] with [fields]
- Migration with: [columns]
- Relationships: [specify]

Backend:
- Resource controller with CRUD
- Form validation requests
- Error handling & try-catch
- Query optimization with eager loading

Frontend:
- Index view with DataTables
- Create/Edit form with validation display
- Delete confirmation with SweetAlert2
- Use Stisla components

Routes:
- Named routes following admin.[module].[action] pattern
- Middleware: auth:admin

Include: change log documentation"
```

### 2. Feature Enhancement

```
"Add [feature] to the [Module] module:

Requirements:
- [Requirement 1]
- [Requirement 2]

Database changes: [migrations needed]
Model changes: [scopes, relationships, etc.]
API changes: [new endpoints]

Include:
- Query optimization
- Error handling
- Form validation
- Tests
- Documentation"
```

### 3. Bug Fix

```
"Fix the [issue] in [file]:

Current behavior: [what's happening]
Expected behavior: [what should happen]

Root cause: [if known]
Files affected: [list]

Include:
- Root cause analysis
- Fix implementation
- Test case
- Prevention mechanism"
```

### 4. Refactoring Request

```
"Refactor [code/module] to:
- Improve readability
- Optimize performance
- Follow Laravel best practices
- Add proper typing

Current issues:
- [List any known issues]

Include:
- Before/after comparison
- Performance improvements
- Updated tests"
```

---

## 📋 Code Review Checklist (For Claude)

When asking Claude to review code, request:

- [ ] SOLID principles compliance
- [ ] N+1 query prevention
- [ ] Type hints on methods
- [ ] Error handling coverage
- [ ] Security vulnerabilities
- [ ] Code duplication
- [ ] Performance bottlenecks
- [ ] Test coverage
- [ ] Documentation completeness
- [ ] Laravel conventions
- [ ] Blade template optimization
- [ ] Reusable component extraction

---

## 🔗 Integration with Project

### Helper Functions Usage

```php
// In models, controllers, views
getLanguage()              // Current language
getActiveLanguages()       // All active languages
convertToKFormat(1500)     // Returns "1.5K"
truncate($text, 50)        // Truncates text
```

**Claude Directive:**
"Use global helper functions: getLanguage(), getActiveLanguages(), convertToKFormat(), truncate()"

### Middleware Usage

```php
// Auto-applied to web routes
SetLocale::class          // Sets language from session
// Check app/Http/Middleware/ for others
```

### Frontend Language System Integration

```blade
<!-- In templates, always consider language -->
{{ getLanguage() }}        <!-- Current language -->
@foreach(getActiveLanguages() as $lang)
    {{ $lang->name }}
@endforeach
```

**Claude Directive:**
"Remember: This is a multilingual app. Use getLanguage() for language-aware queries"

---

## ✅ Implementation Workflow

1. **Ask Claude to Generate**
    - Use templates from "Claude Copilot Prompt Templates"
    - Be specific about requirements
    - Mention tech stack (Stisla, SweetAlert2, etc.)

2. **Copy & Customize**
    - Claude generates base code
    - Customize field names, logic, etc.
    - Test thoroughly

3. **Optimize & Document**
    - Ask Claude to optimize queries
    - Request unit tests
    - Create change log

4. **Verify**
    - Run: `php artisan migrate`
    - Test in browser
    - Clear cache: `php artisan optimize:clear`

---

## 🎓 Learning Resources

### Laravel Documentation Links

- Models: laravel.com/docs/eloquent
- Controllers: laravel.com/docs/controllers
- Migrations: laravel.com/docs/migrations
- Testing: laravel.com/docs/testing
- Security: laravel.com/docs/authentication

### Your Project Docs

- Language System: `docus/078_FRONTEND_LANGUAGE_SYSTEM.md`
- News Details: `079_NEWS_DETAILS_PAGE_SYSTEM.md`
- Integration Report: `080_FRONTEND_LANGUAGE_SYSTEM_INTEGRATION_REPORT.md`

---

## 🎯 Summary

**Best Claude Copilot Skills for Laravel:**

1. Use specific prompt templates
2. Always request eager loading & query optimization
3. Include validation & error handling in requests
4. Use Form Requests for validation
5. Ask for service classes for complex logic
6. Request tests alongside code
7. Specify UI framework (Stisla) and components
8. Remember multilingual context (getLanguage())
9. Use Blade components for reusability
10. Always request change log documentation

---

# 🔍 Find & Discover Skills Meta-Skill

## Overview

This meta-skill helps you discover, evaluate, install, and manage Claude Copilot skills effectively. Skills enhance Claude's knowledge about your project, frameworks, and conventions.

---

## 🎯 What Are Skills?

**Skills** are structured knowledge documents that teach Claude about:

- Your project's architecture and conventions
- Framework-specific best practices
- Coding standards and patterns
- Domain-specific expertise
- Project structure and organization

**Location in VS Code:**

```
.vscode/
  └── claude_skills.md      (Main skills file)
  └── SKILL.md              (Project skills - this file!)
```

---

## 🔎 How to Find Existing Skills

### 1. **Check Your Workspace**

```bash
# List all skill files in project
find . -name "*SKILL*" -o -name "*skill*" -o -name "*claude_skills*"

# In VS Code:
# Press Ctrl+P and search for:
# - SKILL.md
# - claude_skills.md
# - skills (any file with "skills" in name)
```

### 2. **Check VS Code Settings**

```
Ctrl+Shift+P → "Copilot: View Profile"
→ Check for linked skills
```

### 3. **Current Project Skills**

In this project, we have:

- **SKILL.md** - Laravel News Portal AI specific patterns
    - Module implementation patterns (CRUD)
    - Stisla admin template conventions
    - Multilingual system integration
    - Claude code generation best practices

---

## 🧠 Understanding Skill Structure

### Basic Skill Format

```markdown
---
name: skill-name
description: What this skill teaches Claude
applyTo: ["**/*.php", "**/*.blade.php"] # File patterns
---

# Main Skill Title

## Section 1

Content and guidelines...

## Section 2

Patterns and best practices...
```

### Key Metadata

| Field         | Purpose                               |
| ------------- | ------------------------------------- |
| `name`        | Unique identifier for the skill       |
| `description` | What Claude learns from this skill    |
| `applyTo`     | File patterns where skill is relevant |

### Skill Content Guidelines

- **Patterns** - Show good and bad examples
- **Directives** - Tell Claude what to do (e.g., "Always use...")
- **Examples** - Real code snippets from your project
- **Context** - Your project's specific constraints
- **Rules** - Mandatory practices and conventions

---

## 📝 Creating New Skills

### Skill Template

```markdown
---
name: your-skill-name
description: Brief description of what this skill teaches
applyTo: ["**/*.extension", "path/to/files/**"]
---

# Your Skill Title

## 🎯 Purpose

What problem does this skill solve?

## 📋 Key Patterns

Show good/bad examples

## 💡 Best Practices

Specific directives for Claude

## 🔗 Integration

How this skill connects to your project

## ✅ Checklist

How to verify Claude is using this skill correctly
```

### Example: Creating a "Database Optimization" Skill

```markdown
---
name: database-optimization-laravel
description: Teaches Claude best practices for optimizing database queries in Laravel
applyTo: ["app/Models/**", "app/Http/Controllers/**"]
---

# Database Query Optimization for News Portal

## 🎯 Goal

Prevent N+1 queries and write efficient Eloquent code

## ❌ Bad Patterns

[Show examples of problematic code]

## ✅ Good Patterns

[Show optimized approaches]

## 💡 Directives

- Always use eager loading with ->with()
- Add query counts with ->withCount()
- Cache frequently accessed data
```

---

## 🚀 Installing & Activating Skills

### Step 1: Create or Find Skill

Save skill as `.md` file in your project or `.vscode/` folder

### Step 2: Reference in Claude

**Option A: In Chat**

```
I have a skill file called [skill-name].md. Apply these patterns to [task]
```

**Option B: In Code Comments**

```php
// @skill: database-optimization-laravel
// This query needs optimization
```

### Step 3: Verify Claude Uses It

Ask Claude:

```
"What skills are you aware of for this project?"
"Summarize the Laravel module implementation pattern"
```

---

## 🎨 Skill Categories for Laravel Projects

### 1. **Architecture Skills**

- Module/CRUD patterns
- Service layer usage
- Repository pattern
- Event-driven design

**Example:** This SKILL.md file!

### 2. **Performance Skills**

- Query optimization
- Caching strategies
- Eager loading patterns
- N+1 prevention

### 3. **Security Skills**

- Form validation patterns
- Authorization gates/policies
- CSRF protection
- SQL injection prevention

### 4. **Testing Skills**

- Unit test patterns
- Feature test patterns
- Test database setup
- Assertion examples

### 5. **UI/UX Skills**

- Component design
- Accessibility guidelines
- Responsive patterns
- User interaction flows

### 6. **Domain Skills**

- Business logic patterns
- Domain-specific terminology
- Industry standards
- Client requirements

---

## 📚 Discovering Skills From Other Projects

### Popular Laravel Skills

1. **Laravel Best Practices**

    ```
    Patterns for models, controllers, middleware
    ```

2. **Stisla Admin Template**

    ```
    Component usage and layout patterns
    ```

3. **Vue/Blade Integration**

    ```
    Reactive components and state management
    ```

4. **API Development**

    ```
    RESTful endpoints, resource transformers
    ```

5. **Testing Strategies**
    ```
    PHPUnit, Pest, feature/unit test patterns
    ```

### Where to Find Skills

- **GitHub**: Search `Laravel-skills` or `copilot-skills`
- **Project Repos**: Check `.vscode/` or root for `*.md` files
- **Community**: VS Code Marketplace, GitHub Gists
- **Documentation**: Framework docs often have best practices

---

## ✏️ Modifying Existing Skills

### When to Update Skills

- When project architecture changes
- When new frameworks are added
- When conventions evolve
- When onboarding new team members

### How to Update

1. **Identify** - Find skill file
2. **Edit** - Add/modify patterns
3. **Test** - Ask Claude to apply new pattern
4. **Document** - Note changes in a log

### Update Checklist

- [ ] Bad patterns clearly marked (❌)
- [ ] Good patterns clearly marked (✅)
- [ ] Real examples from project
- [ ] Clear directives for Claude
- [ ] Integration with other skills mentioned
- [ ] Verification steps documented

---

## 🧪 Testing Your Skills

### Skill Testing Workflow

1. **Create Test Case**

    ```
    Ask Claude to perform a task using the skill
    ```

2. **Verify Output**

    ```
    Does Claude follow the patterns?
    Are conventions maintained?
    ```

3. **Iterate**
    ```
    If patterns not followed, refine skill description
    Re-test with clearer directives
    ```

### Test Prompts

```
"Using the Laravel module pattern, create [Module]"
"Following security best practices, validate [Form]"
"Optimize this query using the caching strategy"
"Refactor this code following our architectural patterns"
```

---

## 🔄 Skill Discovery Workflow

### For New Developers

1. **List available skills**

    ```
    "What skills are available for this Laravel project?"
    ```

2. **Learn specific skill**

    ```
    "Teach me the module implementation pattern from SKILL.md"
    ```

3. **Apply to task**
    ```
    "Create [Module] following the standard flow in SKILL.md"
    ```

### For Experienced Developers

1. **Review current skills**

    ```
    grep -r "^name:" *.md .vscode/*.md
    ```

2. **Identify gaps**

    ```
    "What skills are missing for [feature]?"
    ```

3. **Create new skill**
    ```
    "Create a skill for [domain/pattern]"
    ```

---

## 💡 Pro Tips for Managing Skills

### 1. **Name Skills Clearly**

✅ `laravel-module-crud-pattern`
❌ `skill1`, `best-practices`

### 2. **Keep Skills Focused**

✅ One skill per major pattern/domain
❌ 100 unrelated patterns in one skill

### 3. **Use Real Examples**

✅ Code snippets from your actual project
❌ Generic hypothetical examples

### 4. **Document Integration**

✅ Link related skills together
❌ Isolated, disconnected skills

### 5. **Version Control**

✅ Track skill changes in git
❌ Constantly changing without documentation

### 6. **Regular Reviews**

✅ Update skills quarterly with new patterns
❌ Skills become stale and inaccurate

---

## 📋 Quick Reference: Skill Checklist

When creating or updating a skill:

- [ ] Clear `name` identifier
- [ ] Descriptive `description`
- [ ] Accurate `applyTo` patterns
- [ ] Examples marked ✅ (good) and ❌ (bad)
- [ ] Explicit Claude directives
- [ ] Integration notes with other skills
- [ ] Real code from your project
- [ ] Clear rationale for each pattern
- [ ] Verification steps documented
- [ ] Links to related documentation

---

## 🎯 Using "find-skills" Prompt

When you want to discover skills:

```
"Use the find-skills approach to:
1. List all available skills in this project
2. Explain what each skill teaches
3. Recommend skills for [specific task]
4. Suggest new skills that are missing"
```

---

## 🚀 Next Steps

1. **Review SKILL.md** - You have a comprehensive Laravel skill
2. **Test Skills** - Ask Claude to create modules using patterns
3. **Expand Skills** - Add skills for new features as needed
4. **Share Skills** - Document for team knowledge base
5. **Iterate** - Refine skills based on results

---

## ✅ Summary

The **find-skills** meta-skill teaches you to:

✅ Locate existing skills in your workspace  
✅ Understand skill structure and purpose  
✅ Create new skills for your project  
✅ Activate and test skills with Claude  
✅ Maintain and update skills over time  
✅ Build a knowledge base for your team

**Your project now has TWO powerful skills:**

1. **Laravel News Portal AI** - Core development patterns
2. **Find-Skills** - Meta-skill for discovering and managing skills

Use them together to build better code with Claude Copilot! 🚀

---

# 🌐 GitHub Claude Code Skills for Laravel (Downloaded)

This section integrates the best Claude code skills available on GitHub for Laravel development.

## 📥 Available GitHub Skills

### 1. **Laravel Agent** (Recommended ⭐⭐⭐⭐⭐)

**Repository:** `hadyfayed/laravel-agent`  
**Stars:** 10+ | **Updated:** 14 days ago  
**Features:** 29 agents, 47 commands, 21 auto-invoked skills, 9 hooks

#### Installation

```bash
/plugin marketplace add hadyfayed/laravel-agent
/plugin install laravel-agent@hadyfayed-laravel-agent
```

#### Core Commands

- `/laravel-agent:build` - Intelligent build (architect delegates)
- `/laravel-agent:patterns` - View current pattern usage

#### Builder Commands

- `/laravel-agent:feature:make` - Complete feature (CRUD + views + API)
- `/laravel-agent:module:make` - Reusable domain module
- `/laravel-agent:service:make` - Service or action
- `/laravel-agent:scaffold:app` - Full app scaffolding

#### API Commands

- `/laravel-agent:api:make` - Versioned API resource
- `/laravel-agent:api:docs` - OpenAPI documentation

#### Testing Commands

- `/laravel-agent:test:make` - Generate Pest tests
- `/laravel-agent:test:coverage` - Coverage analysis

#### Database Commands

- `/laravel-agent:db:optimize` - Query & index optimization
- `/laravel-agent:db:diagram` - ER diagram generation

#### Frontend Commands

- `/laravel-agent:livewire:make` - Livewire 3 components
- `/laravel-agent:filament:make` - Filament resources

#### Security & Auth

- `/laravel-agent:auth:setup` - Setup authentication
- `/laravel-agent:security:audit` - OWASP security audit
- `/laravel-agent:sanctum:setup` - API token auth
- `/laravel-agent:passport:setup` - OAuth2 server

#### Async & Notifications

- `/laravel-agent:job:make` - Queued jobs
- `/laravel-agent:notification:make` - Multi-channel notifications (55+ channels)
- `/laravel-agent:broadcast:make` - Broadcast events

#### DevOps & Infrastructure

- `/laravel-agent:deploy:setup` - Forge, Vapor, Docker deployment
- `/laravel-agent:cicd:setup` - CI/CD pipeline setup
- `/laravel-agent:reverb:setup` - WebSockets
- `/laravel-agent:telescope:setup` - Debugging & monitoring
- `/laravel-agent:horizon:setup` - Queue monitoring
- `/laravel-agent:pulse:setup` - Production monitoring

#### Code Review & Git

- `/laravel-agent:review:staged` - Review staged changes
- `/laravel-agent:review:pr` - Code review
- `/laravel-agent:refactor` - Refactor for SOLID/DRY
- `/laravel-agent:git:commit` - Conventional commits
- `/laravel-agent:git:pr` - Pull requests
- `/laravel-agent:analyze:codebase` - Full health report

#### Auto-Invoked Skills

These activate automatically based on context:

| Trigger                           | Skill                 | Purpose              |
| --------------------------------- | --------------------- | -------------------- |
| "build feature", "create feature" | `laravel-feature`     | Complete features    |
| "build api", "endpoint"           | `laravel-api`         | REST APIs            |
| "migration", "query", "N+1"       | `laravel-database`    | DB optimization      |
| "test", "pest", "coverage"        | `laravel-testing`     | Pest testing         |
| "auth", "permission", "role"      | `laravel-auth`        | Auth & authorization |
| "livewire", "reactive"            | `laravel-livewire`    | Livewire components  |
| "filament", "admin panel"         | `laravel-filament`    | Admin panels         |
| "slow", "optimize", "cache"       | `laravel-performance` | Performance          |
| "security", "vulnerability"       | `laravel-security`    | Security audits      |
| "deploy", "production"            | `laravel-deploy`      | Deployment           |

#### Supported Packages (70+)

- **Architecture**: laravel-modules, laravel-actions
- **AI/LLM**: prism-php, laravel/mcp
- **API**: lighthouse, passport, sanctum
- **Auth**: laravel-permission, laratrust
- **Billing**: cashier
- **Admin**: filament, nova
- **Testing**: pest, dusk
- **Database**: medialibrary, activitylog
- **Performance**: octane, horizon, query-detector
- **WebSockets**: reverb
- **Multi-Tenancy**: stancl/tenancy
- **Deployment**: bref, vapor, envoy
- **Search**: scout, meilisearch
- **PDF**: laravel-pdf, dompdf
- **SEO**: sitemap, seotools
- And many more...

#### Usage Examples

```bash
# Intelligent build
/laravel-agent:build invoice management with PDF export

# Complete feature
/laravel-agent:feature:make Products with categories and variants

# API with versioning
/laravel-agent:api:make Products v2

# Generate tests
/laravel-agent:test:make OrderService

# Livewire component
/laravel-agent:livewire:make ProductsTable

# Filament admin
/laravel-agent:filament:make Products

# Security audit
/laravel-agent:security:audit

# Setup deployment
/laravel-agent:deploy:setup vapor

# Review staged changes
/laravel-agent:review:staged
```

---

### 2. **Laravel Developer Skill** (Modern)

**Repository:** `umutsevimcann/laravel-developer-skill`  
**Updated:** Nov 27, 2025  
**Focus:** Laravel 12+ best practices

**Topics Covered:**

- Project structure and organization
- Authentication and authorization
- Database design and optimization
- API development
- Testing strategies
- Security best practices

---

### 3. **Claude PHP Laravel Integration**

**Repository:** `TapanDerasari/claude-php-laravel`  
**Updated:** 3 days ago  
**Features:** Rules, skills, subagents, slash commands, hooks

---

### 4. **Laravel Production Readiness Audit**

**Repository:** `meirdick/laravel-prod-ready`  
**Updated:** 29 days ago  
**Features:** 6-dimension scored review:

- Security
- Scalability
- Reliability
- Hardening
- Code Quality
- Operations

**Usage:** Ask Claude for a production readiness audit

---

### 5. **Filament PHP Admin Skill**

**Repository:** `olakunlevpn/olakunlevpn-filament-skills`  
**Updated:** 18 days ago  
**Focus:** Filament v5 + Livewire + Admin development
**Coverage:** 18+ areas including resources, forms, tables, multi-tenancy

---

### 6. **AI-Driven Scaffolding & Review**

**Repository:** `tal7aouy/skills`  
**Updated:** Mar 9  
**Features:** Scaffolding and code review helpers for PHP/Laravel/Node

---

## 🚀 How to Use GitHub Skills

### Method 1: Copy Individual Patterns

1. Find skill on GitHub
2. Read the patterns
3. Ask Claude to apply them to your task
4. Reference skill name in prompt

### Method 2: Request Skill Features

```
"Use the Laravel Agent 'feature' skill to create [feature]"
"Apply the production readiness skill to audit [component]"
"Using Laravel Agent, generate tests for [code]"
```

### Method 3: Combine Multiple Skills

```
"Create a feature using Laravel Agent:
- Feature builder for complete CRUD
- Security audit for vulnerabilities
- Pest testing for comprehensive coverage
- Production readiness check"
```

---

## 📋 Integration Checklist

- [ ] Review Laravel Agent commands
- [ ] Understand auto-invoked skills
- [ ] Know production readiness dimensions
- [ ] Familiar with 70+ package integrations
- [ ] Know when to use feature vs module vs service
- [ ] Understand Git workflow automation
- [ ] Know deployment options (Forge/Vapor/Docker)

---

## 💡 Pro Tips: Combining Skills

### Tip 1: Use Intelligent Build

```
/laravel-agent:build [your requirement]
# Architect analyzes and delegates to best builder
```

### Tip 2: Chain Commands

```
# Build feature first
/laravel-agent:feature:make Products

# Then test it
/laravel-agent:test:make Products

# Then audit security
/laravel-agent:security:audit

# Then prepare for production
/laravel-agent:deploy:setup
```

### Tip 3: Reference Your SKILL.md

```
"Create a module following our SKILL.md patterns
AND apply Laravel Agent best practices"
```

### Tip 4: Production Checklist

```
"Review this code for production readiness:
1. Security (OWASP)
2. Scalability (caching, queries)
3. Reliability (error handling)
4. Hardening (validation, authorization)
5. Code Quality (SOLID/DRY)
6. Operations (monitoring, logs)"
```

---

## 🎯 When to Use Each Skill

| Need                                  | Use This Skill                 |
| ------------------------------------- | ------------------------------ |
| Complete feature with CRUD + UI + API | Laravel Agent Feature Builder  |
| Reusable, sharable logic              | Laravel Agent Module Builder   |
| Single operation/action               | Laravel Agent Service Builder  |
| Full app scaffolding                  | Laravel Agent Scaffold Builder |
| API with versioning                   | Laravel Agent API Builder      |
| Unit/Feature/API tests                | Laravel Agent Testing Skill    |
| Query optimization                    | Laravel Agent Database Skill   |
| Component development                 | Laravel Agent Livewire Skill   |
| Admin panel                           | Laravel Agent Filament Skill   |
| Production check                      | Production Readiness Skill     |
| Security audit                        | Laravel Agent Security Skill   |
| Deployment                            | Laravel Agent Deploy Skill     |
| Pull request review                   | Laravel Agent Review Skill     |

---

## 🔗 Best Practices From GitHub Skills

### Pattern Limit

**Rule:** Maximum 5 design patterns per project  
**Prevents:** Over-engineering and unnecessary complexity

### SOLID/DRY Enforcement

All generated code follows:

- **S**ingle Responsibility
- **O**pen/Closed Principle
- **L**iskov Substitution
- **I**nterface Segregation
- **D**ependency Inversion

### Multi-Tenancy Support

Optional tenant isolation (opt-in, not forced)

- Detects existing multi-tenancy
- Applies isolation automatically
- No tenant data leakage

### Pre-configured Hooks

Git hooks for code quality:

- Pint linting & formatting
- PHPStan static analysis
- Security scanning
- Migration safety checks
- Blade template validation
- Test runners
- Environment validation

---

## 📝 Recommended Setup

### For Your News Portal Project:

1. **Core Development**
    - Use Laravel Agent Feature Builder for news modules
    - Apply your SKILL.md patterns first
    - Generate tests with Pest

2. **Quality Assurance**
    - Run security audits regularly
    - Check production readiness
    - Review code before deployment

3. **Testing**
    - Use auto-invoked testing skill
    - Generate coverage reports
    - Test API endpoints

4. **Deployment**
    - Setup CI/CD with Laravel Agent
    - Configure deployment (Vapor/Docker)
    - Monitor with Pulse/Telescope

---

## 🎓 Learning Path

### Beginner: Start Here

1. Learn SKILL.md patterns (your project)
2. Use Laravel Agent intelligent build
3. Review generated code
4. Run production readiness check

### Intermediate: Expand Skills

1. Use specific command builders
2. Combine multiple agents
3. Apply security best practices
4. Write comprehensive tests

### Advanced: Mastery

1. Create custom agents for your domain
2. Integrate multiple skills seamlessly
3. Optimize for production (scaling, caching)
4. Mentor others on patterns

---

## ✅ Summary

**GitHub Claude Skills Available:**

1. ⭐ **Laravel Agent** - 29 agents, 47 commands, 21 skills (RECOMMENDED)
2. **Laravel Developer Skill** - Modern L12+ patterns
3. **PHP/Laravel Integration** - Rules, skills, hooks
4. **Production Readiness** - 6-dimension audit
5. **Filament Admin Skill** - Admin development
6. **Scaffolding & Review** - Multi-framework

**How to Use:**

- Reference skills in Claude prompts
- Combine with your SKILL.md
- Use auto-invoked skills automatically
- Apply best practices to your code

**Your Project Now Has:**

1. **SKILL.md** - Your project-specific patterns
2. **Find-Skills** - Skill discovery meta-skill
3. **GitHub Skills** - Industry best practices (this section)

**Next Step:** Ask Claude to use these skills for your next feature! 🚀
