# 📁 Project Reorganization Plan

## 🎯 Tujuan Reorganisasi:
1. **Pisahkan berdasarkan role**: Admin, SuperAdmin, User
2. **Kelompokkan berdasarkan domain**: Auth, Product, Order, etc.
3. **Gabungkan migrasi** yang berkaitan (hapus add_* files)
4. **Struktur yang scalable** dan mudah maintain

## 📂 New Folder Structure:

### Controllers:
```
app/Http/Controllers/
├── Controller.php (base)
├── Auth/
│   ├── AuthController.php
│   └── ProfileController.php
├── Admin/
│   ├── DashboardController.php
│   ├── Product/
│   │   ├── ProductController.php
│   │   └── CategoryController.php
│   ├── Order/
│   │   └── OrderController.php
│   ├── Content/
│   │   └── LandingContentController.php
│   └── Infaq/
│       └── InfaqController.php
├── SuperAdmin/
│   ├── DashboardController.php
│   ├── User/
│   │   └── UserController.php
│   └── System/
│       └── SettingController.php
└── User/
    ├── HomeController.php
    ├── Product/
    │   └── ProductController.php
    ├── Cart/
    │   └── CartController.php
    ├── Order/
    │   └── OrderController.php
    ├── Infaq/
    │   └── InfaqController.php
    └── Contact/
        └── ContactController.php
```

### Models:
```
app/Models/
├── User.php
├── Auth/
│   └── (jika perlu model auth tambahan)
├── Product/
│   ├── Product.php
│   └── Category.php
├── Order/
│   ├── Order.php
│   ├── OrderItem.php
│   └── Cart.php
├── Content/
│   └── LandingContent.php
├── Infaq/
│   └── Infaq.php
└── System/
    └── Setting.php
```

### Views:
```
resources/views/
├── layouts/
│   ├── app.blade.php (user layout)
│   ├── admin.blade.php
│   └── superadmin.blade.php
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── profile.blade.php
├── user/
│   ├── home.blade.php
│   ├── about.blade.php
│   ├── contact/
│   │   └── index.blade.php
│   ├── products/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   ├── category.blade.php
│   │   └── type.blade.php
│   ├── cart/
│   │   └── index.blade.php
│   ├── orders/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   └── checkout.blade.php
│   └── infaq/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── show.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── products/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── categories/
│   │   └── index.blade.php
│   ├── orders/
│   │   ├── index.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── content/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── infaq/
│       ├── index.blade.php
│       └── show.blade.php
├── superadmin/
│   ├── dashboard.blade.php
│   ├── users/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── settings/
│       └── index.blade.php
└── emails/
    └── contact.blade.php
```

### Seeders:
```
database/seeders/
├── DatabaseSeeder.php
├── Auth/
│   └── UserSeeder.php
├── Product/
│   ├── CategorySeeder.php
│   └── ProductSeeder.php
├── Content/
│   └── LandingContentSeeder.php
└── System/
    └── SettingSeeder.php
```

## 🔄 Migration Consolidation:

### Gabung migrations yang sama:

#### 1. Users Table:
- Gabung: `create_users_table.php` + `add_role_to_users_table.php`
- Result: `create_users_table.php` (with role column)

#### 2. Products Table:
- Gabung: `create_products_table.php` + `add_type_to_products_table.php` + `add_slug_to_products_table.php`
- Result: `create_products_table.php` (with type & slug)

#### 3. Categories Table:
- Gabung: `create_categories_table.php` + `add_type_to_categories_table.php`
- Result: `create_categories_table.php` (with type)

#### 4. Keep separate:
- `create_orders_table.php`
- `create_order_items_table.php`
- `create_carts_table.php`
- `create_infaqs_table.php`
- `create_settings_table.php`
- `create_landing_contents_table.php`
- Laravel default migrations

## 🛣️ Routes Organization:

### File structure:
```
routes/
├── web.php (main routes)
├── auth.php (authentication routes)
├── admin.php (admin routes)
├── superadmin.php (superadmin routes)
└── api.php (api routes if needed)
```

## 📝 Implementation Steps:

1. **Backup database** current state
2. **Create new folder structure**
3. **Move and rename files** with updated namespaces
4. **Consolidate migrations**
5. **Update routes** to new structure
6. **Update all imports/namespaces**
7. **Run fresh migration**
8. **Test all functionality**

## 🎯 Benefits:

- ✅ **Clear separation** of concerns
- ✅ **Easier navigation** and maintenance
- ✅ **Scalable structure** for future features
- ✅ **Role-based organization**
- ✅ **Clean migration history**
- ✅ **Better code organization**

Ready to proceed with implementation! 🚀