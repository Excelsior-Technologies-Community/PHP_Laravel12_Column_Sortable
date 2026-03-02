# PHP_Laravel12_Column_Sortable

Complete step-by-step implementation of column sorting in Laravel using the kyslik/column-sortable package.

This project demonstrates:

* Column-based sorting
* Pagination with sorting
* CRUD operations
* Bootstrap 5 UI integration
* Query string preservation
* Sort indicators

---

## Step 1: Create New Laravel Project

```bash
composer create-project laravel/laravel sortable-demo
cd sortable-demo
```

---

## Step 2: Install Column Sortable Package

```bash
composer require kyslik/column-sortable
```

---

## Step 3: Publish Configuration (Optional)

```bash
php artisan vendor:publish --provider="Kyslik\ColumnSortable\ColumnSortableServiceProvider" --tag="config"
```

---

## Step 4: Configure Database

Update `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sortable_demo
DB_USERNAME=root
DB_PASSWORD=
```

Create database:

```sql
CREATE DATABASE sortable_demo;
```

---

## Step 5: Create Tasks Migration

```bash
php artisan make:migration create_tasks_table
```

Migration structure:

```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
    $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
    $table->date('due_date')->nullable();
    $table->timestamps();
});
```

Run migration:

```bash
php artisan migrate
```

---

## Step 6: Task Model with Sortable Trait

```php
use Kyslik\ColumnSortable\Sortable;

class Task extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date'
    ];

    public $sortable = [
        'id',
        'title',
        'priority',
        'status',
        'due_date',
        'created_at',
        'updated_at'
    ];
}
```

---

## Step 7: Create Seeder

```bash
php artisan make:seeder TaskSeeder
```

Seed sample task data and run:

```bash
php artisan db:seed --class=TaskSeeder
```

---

## Step 8: Create Controller

```bash
php artisan make:controller TaskController
```

Index method using sortable:

```php
public function index()
{
    $tasks = Task::sortable()->paginate(10);
    return view('tasks.index', compact('tasks'));
}
```

Includes full CRUD methods: create, store, edit, update, destroy.

---

## Step 9: Create Routes

```php
Route::resource('tasks', TaskController::class);
Route::get('/', [TaskController::class, 'index'])->name('home');
```

---

## Step 10: Create Views

Layout includes:

* Bootstrap 5
* Bootstrap Icons
* Navbar
* Flash messages

Index View Features:

* @sortablelink('column', 'Label') for sorting
* Pagination with query preservation
* Priority and status badges
* Overdue indicator
* Edit and delete actions

Create and Edit Views include:

* Validation handling
* Old input repopulation
* Bootstrap form styling

---

## Step 11: Run Application

```bash
php artisan serve
```

Visit:

[http://localhost:8000](http://localhost:8000)
<img width="1817" height="847" alt="image" src="https://github.com/user-attachments/assets/aa70a288-433b-4f12-8eef-c755c1ba4838" />
<img width="1796" height="802" alt="image" src="https://github.com/user-attachments/assets/c9b59025-4dbb-4f6e-b56c-3cfa23843631" />

---

## Features Implemented

* Column Sorting (click table headers)
* Pagination (10 per page)
* Full CRUD functionality
* Bootstrap 5 responsive UI
* Sort indicators
* Query string preservation

---

## How Sorting Works

* @sortablelink('column', 'Label') generates sortable links
* Sort parameters persist with pagination
* Multiple columns can be sorted sequentially
* Default sorting can be configured in model

---

## Customization Options

Example advanced sortable configuration:

```php
public $sortable = [
    'id',
    'title',
    'priority' => [
        'asc' => ['priority' => 'asc'],
        'desc' => ['priority' => 'desc']
    ],
];

protected $sortableAs = ['column_name'];
```

---

## Conclusion

This project demonstrates practical implementation of sortable table columns in Laravel with pagination and CRUD functionality.

It is ideal for admin panels, dashboards, and data-driven applications where users need flexible sorting options.

