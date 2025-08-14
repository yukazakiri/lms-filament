# Enterprise LMS Database Schema Design for Laravel React Inertia

## Overview

This document presents a comprehensive database schema design for an enterprise-grade Learning Management System (LMS) built with Laravel, React, and Inertia.js. The design is based on extensive research of existing LMS platforms and enterprise requirements, ensuring scalability, flexibility, and adherence to industry best practices.

The schema is designed to support a wide range of enterprise features including multi-tenancy, complex user hierarchies, advanced course structures, detailed progress tracking, comprehensive reporting, and robust security measures. The design follows Laravel conventions and utilizes modern database design principles to ensure optimal performance and maintainability.

## Core Design Principles

### 1. Scalability and Performance
The database schema is designed to handle large volumes of users, courses, and learning data. Key performance considerations include:
- Proper indexing strategies for frequently queried fields
- Normalized structure to reduce data redundancy
- Efficient relationship design to minimize complex joins
- Support for database partitioning and sharding strategies

### 2. Flexibility and Extensibility
The schema accommodates various learning scenarios and can be extended without major structural changes:
- Generic attribute tables for custom fields
- Polymorphic relationships for flexible content associations
- Modular design allowing for feature additions
- Support for different course types and learning paths

### 3. Data Integrity and Security
Robust data integrity constraints and security measures are built into the schema:
- Foreign key constraints to maintain referential integrity
- Soft deletes for data preservation and audit trails
- Comprehensive logging and audit capabilities
- Role-based access control at the database level

### 4. Laravel Integration
The schema is optimized for Laravel's ORM (Eloquent) and follows Laravel conventions:
- Standard naming conventions for tables and columns
- Support for Laravel's built-in features (timestamps, soft deletes, etc.)
- Relationship definitions that map cleanly to Eloquent models
- Migration-friendly structure for version control and deployment

## Database Schema Structure

The database schema is organized into several logical groups, each serving specific functional areas of the LMS:

1. **User Management and Authentication**
2. **Organizational Structure and Permissions**
3. **Course and Content Management**
4. **Learning Delivery and Progress Tracking**
5. **Assessment and Grading**
6. **Communication and Collaboration**
7. **Reporting and Analytics**
8. **System Administration and Configuration**

Each group contains multiple related tables that work together to provide comprehensive functionality while maintaining clear separation of concerns and optimal database performance.



## 1. User Management and Authentication

The user management system forms the foundation of the LMS, providing comprehensive user profiles, authentication, and basic organizational structure. This section includes tables for managing user accounts, profiles, authentication methods, and basic role assignments.

### Users Table

The central users table stores core user information and serves as the primary reference point for all user-related activities throughout the system.

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    username VARCHAR(100) UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    display_name VARCHAR(255),
    avatar_url VARCHAR(500),
    phone VARCHAR(20),
    mobile VARCHAR(20),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other', 'prefer_not_to_say'),
    timezone VARCHAR(50) DEFAULT 'UTC',
    locale VARCHAR(10) DEFAULT 'en',
    status ENUM('active', 'inactive', 'suspended', 'pending') DEFAULT 'pending',
    last_login_at TIMESTAMP NULL,
    last_activity_at TIMESTAMP NULL,
    password_changed_at TIMESTAMP NULL,
    must_change_password BOOLEAN DEFAULT FALSE,
    two_factor_enabled BOOLEAN DEFAULT FALSE,
    two_factor_secret VARCHAR(255),
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    INDEX idx_users_email (email),
    INDEX idx_users_username (username),
    INDEX idx_users_status (status),
    INDEX idx_users_last_activity (last_activity_at),
    INDEX idx_users_created_at (created_at)
);
```

The users table includes comprehensive profile information while maintaining flexibility for different user types. The UUID field provides a stable external identifier that can be safely exposed in APIs without revealing internal database IDs. The status field allows for various user states including pending activation, suspension, and soft deletion support.

### User Profiles Table

Extended user profile information is stored separately to maintain performance of the core users table while providing rich profile capabilities.

```sql
CREATE TABLE user_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    employee_id VARCHAR(50),
    job_title VARCHAR(255),
    department VARCHAR(255),
    manager_id BIGINT UNSIGNED,
    hire_date DATE,
    location VARCHAR(255),
    address_line_1 VARCHAR(255),
    address_line_2 VARCHAR(255),
    city VARCHAR(100),
    state_province VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    emergency_contact_relationship VARCHAR(100),
    bio TEXT,
    skills JSON,
    interests JSON,
    social_links JSON,
    custom_fields JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_profiles_user_id (user_id),
    INDEX idx_user_profiles_employee_id (employee_id),
    INDEX idx_user_profiles_manager_id (manager_id),
    INDEX idx_user_profiles_department (department)
);
```

The user profiles table extends the basic user information with enterprise-specific fields such as employee ID, department, and manager relationships. The JSON fields provide flexibility for storing custom attributes, skills, and social media links without requiring schema changes.

### User Authentication Methods Table

This table supports multiple authentication methods per user, enabling SSO, social login, and other authentication providers.

```sql
CREATE TABLE user_authentication_methods (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    provider VARCHAR(50) NOT NULL,
    provider_id VARCHAR(255) NOT NULL,
    provider_email VARCHAR(255),
    provider_data JSON,
    is_primary BOOLEAN DEFAULT FALSE,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_provider_user (provider, provider_id),
    INDEX idx_auth_methods_user_id (user_id),
    INDEX idx_auth_methods_provider (provider)
);
```

This table enables the LMS to support various authentication providers such as Google, Microsoft, LDAP, or custom SSO solutions. The provider_data JSON field stores additional information from the authentication provider.

### User Sessions Table

Enhanced session management for tracking user activity and enabling advanced security features.

```sql
CREATE TABLE user_sessions (
    id VARCHAR(40) PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent TEXT,
    device_type VARCHAR(50),
    browser VARCHAR(100),
    platform VARCHAR(100),
    location VARCHAR(255),
    is_mobile BOOLEAN DEFAULT FALSE,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_sessions_user_id (user_id),
    INDEX idx_sessions_last_activity (last_activity)
);
```

The enhanced sessions table provides detailed information about user sessions, enabling security monitoring, device management, and user activity analytics.

### Password Reset Tokens Table

Secure password reset functionality with enhanced tracking and security measures.

```sql
CREATE TABLE password_reset_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_password_reset_token (token),
    INDEX idx_password_reset_user_id (user_id),
    INDEX idx_password_reset_expires (expires_at)
);
```

This table manages password reset tokens with enhanced security tracking, including IP address and user agent logging for security audit purposes.


## 2. Organizational Structure and Permissions

The organizational structure system provides comprehensive support for enterprise hierarchies, role-based access control, and multi-tenancy. This system enables complex organizational structures while maintaining flexibility and performance.

### Organizations Table

The organizations table supports multi-tenancy and organizational hierarchies, allowing the LMS to serve multiple companies or departments within a single installation.

```sql
CREATE TABLE organizations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    parent_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    type ENUM('company', 'division', 'department', 'team', 'group') DEFAULT 'company',
    logo_url VARCHAR(500),
    website VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    address_line_1 VARCHAR(255),
    address_line_2 VARCHAR(255),
    city VARCHAR(100),
    state_province VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    timezone VARCHAR(50) DEFAULT 'UTC',
    locale VARCHAR(10) DEFAULT 'en',
    settings JSON,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (parent_id) REFERENCES organizations(id) ON DELETE SET NULL,
    INDEX idx_organizations_parent_id (parent_id),
    INDEX idx_organizations_slug (slug),
    INDEX idx_organizations_type (type),
    INDEX idx_organizations_status (status)
);
```

The organizations table supports hierarchical structures through the parent_id relationship, enabling complex organizational trees. The settings JSON field allows for organization-specific configurations and customizations.

### User Organization Memberships Table

This table manages the many-to-many relationship between users and organizations, supporting multiple organizational affiliations and roles.

```sql
CREATE TABLE user_organization_memberships (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    organization_id BIGINT UNSIGNED NOT NULL,
    role VARCHAR(100) NOT NULL DEFAULT 'member',
    title VARCHAR(255),
    is_primary BOOLEAN DEFAULT FALSE,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    left_at TIMESTAMP NULL,
    status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_org_active (user_id, organization_id, status),
    INDEX idx_user_org_user_id (user_id),
    INDEX idx_user_org_organization_id (organization_id),
    INDEX idx_user_org_role (role),
    INDEX idx_user_org_status (status)
);
```

This table enables users to belong to multiple organizations with different roles and statuses. The is_primary flag identifies the user's main organizational affiliation.

### Roles Table

The roles table defines system-wide and organization-specific roles with detailed permissions and hierarchical relationships.

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    type ENUM('system', 'organization', 'course', 'custom') DEFAULT 'custom',
    level INTEGER DEFAULT 0,
    parent_role_id BIGINT UNSIGNED,
    is_default BOOLEAN DEFAULT FALSE,
    is_system BOOLEAN DEFAULT FALSE,
    permissions JSON,
    settings JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_role_id) REFERENCES roles(id) ON DELETE SET NULL,
    UNIQUE KEY unique_role_org_slug (organization_id, slug),
    INDEX idx_roles_organization_id (organization_id),
    INDEX idx_roles_type (type),
    INDEX idx_roles_parent_role_id (parent_role_id),
    INDEX idx_roles_is_system (is_system)
);
```

The roles table supports both system-wide roles (like super admin) and organization-specific roles. The hierarchical structure through parent_role_id enables role inheritance and complex permission structures.

### User Roles Table

This table assigns roles to users with support for context-specific assignments and time-based role assignments.

```sql
CREATE TABLE user_roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    organization_id BIGINT UNSIGNED,
    context_type VARCHAR(100),
    context_id BIGINT UNSIGNED,
    assigned_by BIGINT UNSIGNED,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    revoked_at TIMESTAMP NULL,
    revoked_by BIGINT UNSIGNED,
    revoke_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (revoked_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_roles_user_id (user_id),
    INDEX idx_user_roles_role_id (role_id),
    INDEX idx_user_roles_organization_id (organization_id),
    INDEX idx_user_roles_context (context_type, context_id),
    INDEX idx_user_roles_assigned_at (assigned_at),
    INDEX idx_user_roles_expires_at (expires_at)
);
```

This table provides flexible role assignment with support for context-specific roles (e.g., instructor role for specific courses), time-based assignments, and comprehensive audit trails.

### Permissions Table

The permissions table defines granular permissions that can be assigned to roles or directly to users.

```sql
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    category VARCHAR(100),
    resource VARCHAR(100),
    action VARCHAR(100),
    is_system BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_permissions_category (category),
    INDEX idx_permissions_resource (resource),
    INDEX idx_permissions_action (action),
    INDEX idx_permissions_is_system (is_system)
);
```

The permissions table provides granular access control with categorization and resource-action mapping for clear permission management.

### Role Permissions Table

This table assigns permissions to roles, enabling flexible permission combinations and inheritance.

```sql
CREATE TABLE role_permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    granted BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_role_permission (role_id, permission_id),
    INDEX idx_role_permissions_role_id (role_id),
    INDEX idx_role_permissions_permission_id (permission_id)
);
```

This table enables complex permission assignments to roles with support for both granting and explicitly denying permissions.

### User Permissions Table

Direct permission assignments to users, providing override capabilities and temporary permission grants.

```sql
CREATE TABLE user_permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    context_type VARCHAR(100),
    context_id BIGINT UNSIGNED,
    granted BOOLEAN DEFAULT TRUE,
    assigned_by BIGINT UNSIGNED,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    revoked_at TIMESTAMP NULL,
    revoked_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (revoked_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_permissions_user_id (user_id),
    INDEX idx_user_permissions_permission_id (permission_id),
    INDEX idx_user_permissions_context (context_type, context_id),
    INDEX idx_user_permissions_expires_at (expires_at)
);
```

This table provides direct permission assignments to users with context support, enabling fine-grained access control and temporary permission grants.


## 3. Course and Content Management

The course and content management system provides comprehensive support for complex course structures, content organization, and learning path management. This system is designed to handle various course types and content formats while maintaining flexibility for future enhancements.

### Course Categories Table

The course categories table provides hierarchical categorization for courses, enabling complex taxonomies and organizational structures.

```sql
CREATE TABLE course_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    parent_id BIGINT UNSIGNED,
    organization_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(255),
    color VARCHAR(7),
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (parent_id) REFERENCES course_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    INDEX idx_course_categories_parent_id (parent_id),
    INDEX idx_course_categories_organization_id (organization_id),
    INDEX idx_course_categories_slug (slug),
    INDEX idx_course_categories_sort_order (sort_order)
);
```

The course categories table supports hierarchical categorization with organizational scope, enabling different category structures for different organizations or departments.

### Courses Table

The central courses table stores comprehensive course information and serves as the foundation for all course-related activities.

```sql
CREATE TABLE courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED,
    code VARCHAR(50) UNIQUE,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    subtitle VARCHAR(500),
    description TEXT,
    objectives TEXT,
    prerequisites TEXT,
    target_audience TEXT,
    difficulty_level ENUM('beginner', 'intermediate', 'advanced', 'expert') DEFAULT 'beginner',
    estimated_duration INTEGER, -- in minutes
    language VARCHAR(10) DEFAULT 'en',
    thumbnail_url VARCHAR(500),
    trailer_url VARCHAR(500),
    status ENUM('draft', 'review', 'published', 'archived', 'suspended') DEFAULT 'draft',
    type ENUM('self_paced', 'instructor_led', 'blended', 'webinar', 'workshop') DEFAULT 'self_paced',
    delivery_method ENUM('online', 'classroom', 'hybrid') DEFAULT 'online',
    max_enrollments INTEGER,
    price DECIMAL(10,2) DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'USD',
    is_free BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE,
    is_public BOOLEAN DEFAULT TRUE,
    requires_approval BOOLEAN DEFAULT FALSE,
    certificate_template_id BIGINT UNSIGNED,
    completion_criteria JSON,
    tags JSON,
    metadata JSON,
    seo_title VARCHAR(255),
    seo_description TEXT,
    seo_keywords TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    published_at TIMESTAMP NULL,
    archived_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES course_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_courses_organization_id (organization_id),
    INDEX idx_courses_category_id (category_id),
    INDEX idx_courses_code (code),
    INDEX idx_courses_slug (slug),
    INDEX idx_courses_status (status),
    INDEX idx_courses_type (type),
    INDEX idx_courses_created_by (created_by),
    INDEX idx_courses_published_at (published_at),
    FULLTEXT idx_courses_search (title, description, objectives)
);
```

The courses table provides comprehensive course management with support for various course types, pricing, SEO optimization, and detailed metadata storage.

### Course Versions Table

This table manages course versioning, enabling content updates while preserving historical versions and learner progress.

```sql
CREATE TABLE course_versions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    version_number VARCHAR(20) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content_hash VARCHAR(64),
    is_current BOOLEAN DEFAULT FALSE,
    is_published BOOLEAN DEFAULT FALSE,
    change_log TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    published_by BIGINT UNSIGNED,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (published_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_course_version (course_id, version_number),
    INDEX idx_course_versions_course_id (course_id),
    INDEX idx_course_versions_is_current (is_current),
    INDEX idx_course_versions_published_at (published_at)
);
```

The course versions table enables comprehensive version control for courses, supporting content updates, rollbacks, and parallel development of course content.

### Course Modules Table

Course modules provide the primary structural organization within courses, grouping related lessons and activities.

```sql
CREATE TABLE course_modules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    course_id BIGINT UNSIGNED NOT NULL,
    course_version_id BIGINT UNSIGNED,
    parent_module_id BIGINT UNSIGNED,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    objectives TEXT,
    estimated_duration INTEGER, -- in minutes
    sort_order INTEGER DEFAULT 0,
    is_required BOOLEAN DEFAULT TRUE,
    is_active BOOLEAN DEFAULT TRUE,
    unlock_conditions JSON,
    completion_criteria JSON,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (course_version_id) REFERENCES course_versions(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    INDEX idx_course_modules_course_id (course_id),
    INDEX idx_course_modules_course_version_id (course_version_id),
    INDEX idx_course_modules_parent_module_id (parent_module_id),
    INDEX idx_course_modules_sort_order (sort_order)
);
```

The course modules table supports hierarchical module structures with flexible unlock conditions and completion criteria, enabling complex learning sequences.

### Course Lessons Table

Lessons represent individual learning units within modules, containing the actual learning content and activities.

```sql
CREATE TABLE course_lessons (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    module_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content TEXT,
    content_type ENUM('text', 'video', 'audio', 'document', 'presentation', 'interactive', 'external') DEFAULT 'text',
    content_url VARCHAR(500),
    content_metadata JSON,
    estimated_duration INTEGER, -- in minutes
    sort_order INTEGER DEFAULT 0,
    is_required BOOLEAN DEFAULT TRUE,
    is_active BOOLEAN DEFAULT TRUE,
    is_preview BOOLEAN DEFAULT FALSE,
    unlock_conditions JSON,
    completion_criteria JSON,
    resources JSON,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    INDEX idx_course_lessons_module_id (module_id),
    INDEX idx_course_lessons_content_type (content_type),
    INDEX idx_course_lessons_sort_order (sort_order),
    INDEX idx_course_lessons_is_preview (is_preview)
);
```

The course lessons table provides flexible content management with support for various content types and detailed completion tracking.

### Course Activities Table

Activities represent interactive elements within lessons, such as quizzes, assignments, discussions, and other learning activities.

```sql
CREATE TABLE course_activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    lesson_id BIGINT UNSIGNED,
    module_id BIGINT UNSIGNED,
    course_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructions TEXT,
    activity_type ENUM('quiz', 'assignment', 'discussion', 'survey', 'scorm', 'xapi', 'external') NOT NULL,
    activity_data JSON,
    max_attempts INTEGER DEFAULT 1,
    time_limit INTEGER, -- in minutes
    passing_score DECIMAL(5,2),
    weight DECIMAL(5,2) DEFAULT 1.00,
    is_graded BOOLEAN DEFAULT FALSE,
    is_required BOOLEAN DEFAULT TRUE,
    is_active BOOLEAN DEFAULT TRUE,
    unlock_conditions JSON,
    completion_criteria JSON,
    feedback_settings JSON,
    sort_order INTEGER DEFAULT 0,
    due_date TIMESTAMP NULL,
    available_from TIMESTAMP NULL,
    available_until TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (lesson_id) REFERENCES course_lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    INDEX idx_course_activities_lesson_id (lesson_id),
    INDEX idx_course_activities_module_id (module_id),
    INDEX idx_course_activities_course_id (course_id),
    INDEX idx_course_activities_type (activity_type),
    INDEX idx_course_activities_due_date (due_date),
    INDEX idx_course_activities_sort_order (sort_order)
);
```

The course activities table provides comprehensive support for various interactive learning activities with flexible configuration and assessment capabilities.

### Course Resources Table

This table manages supplementary resources associated with courses, modules, or lessons.

```sql
CREATE TABLE course_resources (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    course_id BIGINT UNSIGNED NOT NULL,
    module_id BIGINT UNSIGNED,
    lesson_id BIGINT UNSIGNED,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    resource_type ENUM('document', 'video', 'audio', 'image', 'link', 'file', 'tool') NOT NULL,
    file_path VARCHAR(500),
    file_url VARCHAR(500),
    file_size BIGINT UNSIGNED,
    mime_type VARCHAR(100),
    is_downloadable BOOLEAN DEFAULT TRUE,
    is_required BOOLEAN DEFAULT FALSE,
    access_level ENUM('public', 'enrolled', 'premium') DEFAULT 'enrolled',
    sort_order INTEGER DEFAULT 0,
    metadata JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES course_lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_course_resources_course_id (course_id),
    INDEX idx_course_resources_module_id (module_id),
    INDEX idx_course_resources_lesson_id (lesson_id),
    INDEX idx_course_resources_type (resource_type),
    INDEX idx_course_resources_sort_order (sort_order)
);
```

The course resources table provides comprehensive resource management with flexible access control and detailed metadata tracking.


## 4. Learning Delivery and Progress Tracking

The learning delivery and progress tracking system manages student enrollments, learning progress, and completion tracking. This system provides comprehensive analytics and reporting capabilities while maintaining detailed audit trails.

### Course Enrollments Table

The course enrollments table manages the relationship between learners and courses, tracking enrollment status and progress.

```sql
CREATE TABLE course_enrollments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    course_version_id BIGINT UNSIGNED,
    enrollment_type ENUM('self', 'admin', 'manager', 'automatic', 'invitation') DEFAULT 'self',
    status ENUM('enrolled', 'in_progress', 'completed', 'failed', 'withdrawn', 'expired', 'suspended') DEFAULT 'enrolled',
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,
    completion_percentage DECIMAL(5,2) DEFAULT 0.00,
    grade DECIMAL(5,2),
    grade_letter VARCHAR(5),
    points_earned INTEGER DEFAULT 0,
    points_possible INTEGER DEFAULT 0,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    started_at TIMESTAMP NULL,
    last_accessed_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    expired_at TIMESTAMP NULL,
    withdrawn_at TIMESTAMP NULL,
    withdrawal_reason TEXT,
    enrolled_by BIGINT UNSIGNED,
    completion_criteria_met JSON,
    custom_fields JSON,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (course_version_id) REFERENCES course_versions(id) ON DELETE SET NULL,
    FOREIGN KEY (enrolled_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_course_enrollment (user_id, course_id),
    INDEX idx_enrollments_user_id (user_id),
    INDEX idx_enrollments_course_id (course_id),
    INDEX idx_enrollments_status (status),
    INDEX idx_enrollments_enrolled_at (enrolled_at),
    INDEX idx_enrollments_completed_at (completed_at),
    INDEX idx_enrollments_last_accessed_at (last_accessed_at)
);
```

The course enrollments table provides comprehensive enrollment management with detailed progress tracking and flexible status management.

### Learning Progress Table

This table tracks detailed progress through course content at the lesson and activity level.

```sql
CREATE TABLE learning_progress (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    module_id BIGINT UNSIGNED,
    lesson_id BIGINT UNSIGNED,
    activity_id BIGINT UNSIGNED,
    content_type ENUM('course', 'module', 'lesson', 'activity') NOT NULL,
    content_id BIGINT UNSIGNED NOT NULL,
    status ENUM('not_started', 'in_progress', 'completed', 'failed', 'skipped') DEFAULT 'not_started',
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,
    time_spent INTEGER DEFAULT 0, -- in seconds
    attempts_count INTEGER DEFAULT 0,
    max_attempts INTEGER,
    score DECIMAL(5,2),
    max_score DECIMAL(5,2),
    passed BOOLEAN,
    first_accessed_at TIMESTAMP NULL,
    last_accessed_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    data JSON, -- for storing activity-specific progress data
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES course_lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES course_activities(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_content_progress (user_id, content_type, content_id),
    INDEX idx_progress_user_id (user_id),
    INDEX idx_progress_course_id (course_id),
    INDEX idx_progress_content (content_type, content_id),
    INDEX idx_progress_status (status),
    INDEX idx_progress_last_accessed_at (last_accessed_at)
);
```

The learning progress table provides granular tracking of learner progress through all course content with comprehensive timing and scoring data.

### Learning Sessions Table

This table tracks individual learning sessions, providing detailed analytics on learner engagement and behavior.

```sql
CREATE TABLE learning_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    enrollment_id BIGINT UNSIGNED NOT NULL,
    session_token VARCHAR(255),
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ended_at TIMESTAMP NULL,
    duration INTEGER DEFAULT 0, -- in seconds
    ip_address VARCHAR(45),
    user_agent TEXT,
    device_type VARCHAR(50),
    browser VARCHAR(100),
    platform VARCHAR(100),
    location VARCHAR(255),
    activities_completed INTEGER DEFAULT 0,
    lessons_viewed INTEGER DEFAULT 0,
    interactions_count INTEGER DEFAULT 0,
    idle_time INTEGER DEFAULT 0, -- in seconds
    session_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES course_enrollments(id) ON DELETE CASCADE,
    INDEX idx_sessions_user_id (user_id),
    INDEX idx_sessions_course_id (course_id),
    INDEX idx_sessions_enrollment_id (enrollment_id),
    INDEX idx_sessions_started_at (started_at),
    INDEX idx_sessions_duration (duration)
);
```

The learning sessions table provides detailed session tracking for analytics and engagement monitoring.

### Learning Bookmarks Table

This table allows learners to bookmark specific content for easy access and review.

```sql
CREATE TABLE learning_bookmarks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    module_id BIGINT UNSIGNED,
    lesson_id BIGINT UNSIGNED,
    activity_id BIGINT UNSIGNED,
    content_type ENUM('course', 'module', 'lesson', 'activity') NOT NULL,
    content_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255),
    notes TEXT,
    tags JSON,
    is_private BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES course_lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES course_activities(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_content_bookmark (user_id, content_type, content_id),
    INDEX idx_bookmarks_user_id (user_id),
    INDEX idx_bookmarks_course_id (course_id),
    INDEX idx_bookmarks_content (content_type, content_id)
);
```

The learning bookmarks table enables learners to save and organize important content for future reference.

### Learning Notes Table

This table stores learner-generated notes associated with course content.

```sql
CREATE TABLE learning_notes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    module_id BIGINT UNSIGNED,
    lesson_id BIGINT UNSIGNED,
    activity_id BIGINT UNSIGNED,
    content_type ENUM('course', 'module', 'lesson', 'activity') NOT NULL,
    content_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255),
    content TEXT NOT NULL,
    content_html TEXT,
    is_private BOOLEAN DEFAULT TRUE,
    is_shared BOOLEAN DEFAULT FALSE,
    tags JSON,
    attachments JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES course_lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES course_activities(id) ON DELETE CASCADE,
    INDEX idx_notes_user_id (user_id),
    INDEX idx_notes_course_id (course_id),
    INDEX idx_notes_content (content_type, content_id),
    INDEX idx_notes_created_at (created_at),
    FULLTEXT idx_notes_search (title, content)
);
```

The learning notes table provides comprehensive note-taking capabilities with support for rich content and sharing options.

### Course Completions Table

This table tracks course completions and certificate issuance with detailed completion criteria verification.

```sql
CREATE TABLE course_completions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    enrollment_id BIGINT UNSIGNED NOT NULL,
    completion_type ENUM('automatic', 'manual', 'admin_override') DEFAULT 'automatic',
    completion_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    final_grade DECIMAL(5,2),
    final_grade_letter VARCHAR(5),
    total_points_earned INTEGER DEFAULT 0,
    total_points_possible INTEGER DEFAULT 0,
    completion_time INTEGER, -- total time spent in seconds
    criteria_met JSON,
    certificate_issued BOOLEAN DEFAULT FALSE,
    certificate_id VARCHAR(100),
    certificate_url VARCHAR(500),
    certificate_issued_at TIMESTAMP NULL,
    completed_by BIGINT UNSIGNED, -- for manual completions
    notes TEXT,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES course_enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (completed_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_course_completion (user_id, course_id),
    INDEX idx_completions_user_id (user_id),
    INDEX idx_completions_course_id (course_id),
    INDEX idx_completions_completion_date (completion_date),
    INDEX idx_completions_certificate_issued (certificate_issued)
);
```

The course completions table provides comprehensive completion tracking with certificate management and detailed completion criteria verification.


## 5. Assessment and Grading

The assessment and grading system provides comprehensive support for various assessment types, detailed scoring, and flexible grading schemes. This system enables complex assessment scenarios while maintaining detailed audit trails and analytics.

### Assessments Table

The assessments table stores comprehensive information about all types of assessments within the LMS.

```sql
CREATE TABLE assessments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    course_id BIGINT UNSIGNED NOT NULL,
    activity_id BIGINT UNSIGNED,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructions TEXT,
    assessment_type ENUM('quiz', 'exam', 'assignment', 'project', 'survey', 'peer_review', 'self_assessment') NOT NULL,
    question_count INTEGER DEFAULT 0,
    max_score DECIMAL(8,2) DEFAULT 0.00,
    passing_score DECIMAL(8,2),
    weight DECIMAL(5,2) DEFAULT 1.00,
    time_limit INTEGER, -- in minutes
    max_attempts INTEGER DEFAULT 1,
    attempt_delay INTEGER DEFAULT 0, -- in minutes
    randomize_questions BOOLEAN DEFAULT FALSE,
    randomize_answers BOOLEAN DEFAULT FALSE,
    show_results ENUM('immediately', 'after_submission', 'after_due_date', 'never') DEFAULT 'after_submission',
    show_correct_answers BOOLEAN DEFAULT TRUE,
    allow_review BOOLEAN DEFAULT TRUE,
    require_lockdown_browser BOOLEAN DEFAULT FALSE,
    require_webcam BOOLEAN DEFAULT FALSE,
    auto_grade BOOLEAN DEFAULT TRUE,
    is_practice BOOLEAN DEFAULT FALSE,
    is_required BOOLEAN DEFAULT TRUE,
    available_from TIMESTAMP NULL,
    available_until TIMESTAMP NULL,
    due_date TIMESTAMP NULL,
    late_submission_allowed BOOLEAN DEFAULT FALSE,
    late_penalty_percentage DECIMAL(5,2) DEFAULT 0.00,
    settings JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES course_activities(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_assessments_course_id (course_id),
    INDEX idx_assessments_activity_id (activity_id),
    INDEX idx_assessments_type (assessment_type),
    INDEX idx_assessments_due_date (due_date),
    INDEX idx_assessments_available_from (available_from),
    INDEX idx_assessments_created_by (created_by)
);
```

The assessments table provides comprehensive assessment configuration with support for various assessment types and detailed timing controls.

### Assessment Questions Table

This table stores individual questions that make up assessments, supporting various question types and configurations.

```sql
CREATE TABLE assessment_questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    assessment_id BIGINT UNSIGNED NOT NULL,
    question_bank_id BIGINT UNSIGNED,
    question_type ENUM('multiple_choice', 'true_false', 'short_answer', 'essay', 'fill_blank', 'matching', 'ordering', 'numeric', 'file_upload') NOT NULL,
    question_text TEXT NOT NULL,
    question_html TEXT,
    explanation TEXT,
    points DECIMAL(6,2) DEFAULT 1.00,
    difficulty_level ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    sort_order INTEGER DEFAULT 0,
    is_required BOOLEAN DEFAULT TRUE,
    time_limit INTEGER, -- in seconds
    question_data JSON, -- stores question-specific data like options, correct answers, etc.
    media_files JSON,
    tags JSON,
    metadata JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_questions_assessment_id (assessment_id),
    INDEX idx_questions_question_bank_id (question_bank_id),
    INDEX idx_questions_type (question_type),
    INDEX idx_questions_sort_order (sort_order),
    INDEX idx_questions_difficulty (difficulty_level)
);
```

The assessment questions table supports various question types with flexible configuration and rich content support.

### Question Banks Table

Question banks allow for reusable question collections that can be shared across multiple assessments.

```sql
CREATE TABLE question_banks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    subject VARCHAR(255),
    category VARCHAR(255),
    difficulty_level ENUM('mixed', 'easy', 'medium', 'hard') DEFAULT 'mixed',
    question_count INTEGER DEFAULT 0,
    is_public BOOLEAN DEFAULT FALSE,
    tags JSON,
    metadata JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_question_banks_organization_id (organization_id),
    INDEX idx_question_banks_subject (subject),
    INDEX idx_question_banks_category (category),
    INDEX idx_question_banks_created_by (created_by)
);
```

The question banks table enables efficient question management and reuse across multiple assessments and courses.

### Assessment Attempts Table

This table tracks individual assessment attempts by learners with comprehensive attempt data.

```sql
CREATE TABLE assessment_attempts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    assessment_id BIGINT UNSIGNED NOT NULL,
    enrollment_id BIGINT UNSIGNED NOT NULL,
    attempt_number INTEGER NOT NULL,
    status ENUM('in_progress', 'submitted', 'graded', 'abandoned', 'expired') DEFAULT 'in_progress',
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    submitted_at TIMESTAMP NULL,
    graded_at TIMESTAMP NULL,
    time_spent INTEGER DEFAULT 0, -- in seconds
    score DECIMAL(8,2),
    max_score DECIMAL(8,2),
    percentage DECIMAL(5,2),
    passed BOOLEAN,
    auto_graded BOOLEAN DEFAULT FALSE,
    late_submission BOOLEAN DEFAULT FALSE,
    ip_address VARCHAR(45),
    user_agent TEXT,
    browser_lockdown BOOLEAN DEFAULT FALSE,
    webcam_recording BOOLEAN DEFAULT FALSE,
    attempt_data JSON,
    grader_notes TEXT,
    graded_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES course_enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_assessment_attempt (user_id, assessment_id, attempt_number),
    INDEX idx_attempts_user_id (user_id),
    INDEX idx_attempts_assessment_id (assessment_id),
    INDEX idx_attempts_enrollment_id (enrollment_id),
    INDEX idx_attempts_status (status),
    INDEX idx_attempts_started_at (started_at),
    INDEX idx_attempts_submitted_at (submitted_at)
);
```

The assessment attempts table provides comprehensive tracking of assessment attempts with detailed timing and security information.

### Assessment Responses Table

This table stores individual responses to assessment questions with detailed answer data.

```sql
CREATE TABLE assessment_responses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    attempt_id BIGINT UNSIGNED NOT NULL,
    question_id BIGINT UNSIGNED NOT NULL,
    response_data JSON NOT NULL,
    response_text TEXT,
    response_files JSON,
    points_earned DECIMAL(6,2) DEFAULT 0.00,
    points_possible DECIMAL(6,2) DEFAULT 0.00,
    is_correct BOOLEAN,
    auto_graded BOOLEAN DEFAULT FALSE,
    manual_grade_override BOOLEAN DEFAULT FALSE,
    feedback TEXT,
    time_spent INTEGER DEFAULT 0, -- in seconds
    flagged_for_review BOOLEAN DEFAULT FALSE,
    graded_by BIGINT UNSIGNED,
    graded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (attempt_id) REFERENCES assessment_attempts(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES assessment_questions(id) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_attempt_question_response (attempt_id, question_id),
    INDEX idx_responses_attempt_id (attempt_id),
    INDEX idx_responses_question_id (question_id),
    INDEX idx_responses_is_correct (is_correct),
    INDEX idx_responses_flagged (flagged_for_review)
);
```

The assessment responses table stores detailed response data with support for various answer types and comprehensive grading information.

### Gradebook Table

The gradebook provides a centralized view of all grades for a course with flexible grading schemes.

```sql
CREATE TABLE gradebooks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    enrollment_id BIGINT UNSIGNED NOT NULL,
    current_grade DECIMAL(5,2),
    current_grade_letter VARCHAR(5),
    final_grade DECIMAL(5,2),
    final_grade_letter VARCHAR(5),
    total_points_earned DECIMAL(10,2) DEFAULT 0.00,
    total_points_possible DECIMAL(10,2) DEFAULT 0.00,
    weighted_score DECIMAL(5,2),
    grade_status ENUM('current', 'final', 'incomplete', 'withdrawn') DEFAULT 'current',
    last_calculated_at TIMESTAMP NULL,
    grade_locked BOOLEAN DEFAULT FALSE,
    grade_locked_by BIGINT UNSIGNED,
    grade_locked_at TIMESTAMP NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (enrollment_id) REFERENCES course_enrollments(id) ON DELETE CASCADE,
    FOREIGN KEY (grade_locked_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_course_user_gradebook (course_id, user_id),
    INDEX idx_gradebook_course_id (course_id),
    INDEX idx_gradebook_user_id (user_id),
    INDEX idx_gradebook_enrollment_id (enrollment_id),
    INDEX idx_gradebook_grade_status (grade_status)
);
```

The gradebook table provides centralized grade management with support for various grading schemes and grade locking capabilities.

### Grade Items Table

This table defines individual grade items within a course and their contribution to the overall grade.

```sql
CREATE TABLE grade_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    assessment_id BIGINT UNSIGNED,
    activity_id BIGINT UNSIGNED,
    category_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    item_type ENUM('assessment', 'activity', 'participation', 'manual', 'calculated') NOT NULL,
    points_possible DECIMAL(8,2) DEFAULT 0.00,
    weight DECIMAL(5,2) DEFAULT 0.00,
    is_extra_credit BOOLEAN DEFAULT FALSE,
    drop_lowest INTEGER DEFAULT 0,
    multiply_factor DECIMAL(5,2) DEFAULT 1.00,
    due_date TIMESTAMP NULL,
    sort_order INTEGER DEFAULT 0,
    is_published BOOLEAN DEFAULT TRUE,
    calculation_formula TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES course_activities(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_grade_items_course_id (course_id),
    INDEX idx_grade_items_assessment_id (assessment_id),
    INDEX idx_grade_items_activity_id (activity_id),
    INDEX idx_grade_items_category_id (category_id),
    INDEX idx_grade_items_type (item_type),
    INDEX idx_grade_items_sort_order (sort_order)
);
```

The grade items table provides flexible grade item configuration with support for various calculation methods and weighting schemes.


## 6. Communication and Collaboration

The communication and collaboration system enables rich interaction between learners, instructors, and administrators through various channels including discussions, messaging, announcements, and social learning features.

### Discussion Forums Table

The discussion forums table provides structured discussion spaces within courses and organizations.

```sql
CREATE TABLE discussion_forums (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    course_id BIGINT UNSIGNED,
    organization_id BIGINT UNSIGNED,
    parent_forum_id BIGINT UNSIGNED,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    forum_type ENUM('course', 'general', 'announcement', 'q_and_a', 'social') DEFAULT 'general',
    visibility ENUM('public', 'course_members', 'organization', 'private') DEFAULT 'course_members',
    moderation_level ENUM('none', 'pre_moderation', 'post_moderation') DEFAULT 'none',
    allow_anonymous BOOLEAN DEFAULT FALSE,
    allow_attachments BOOLEAN DEFAULT TRUE,
    max_attachment_size INTEGER DEFAULT 10485760, -- 10MB in bytes
    sort_order INTEGER DEFAULT 0,
    is_locked BOOLEAN DEFAULT FALSE,
    is_archived BOOLEAN DEFAULT FALSE,
    post_count INTEGER DEFAULT 0,
    topic_count INTEGER DEFAULT 0,
    last_post_id BIGINT UNSIGNED,
    last_post_at TIMESTAMP NULL,
    settings JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_forum_id) REFERENCES discussion_forums(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_forums_course_id (course_id),
    INDEX idx_forums_organization_id (organization_id),
    INDEX idx_forums_parent_forum_id (parent_forum_id),
    INDEX idx_forums_type (forum_type),
    INDEX idx_forums_visibility (visibility),
    INDEX idx_forums_last_post_at (last_post_at)
);
```

The discussion forums table provides comprehensive forum management with hierarchical organization and flexible access control.

### Discussion Topics Table

This table stores individual discussion topics within forums.

```sql
CREATE TABLE discussion_topics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    forum_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    content_html TEXT,
    topic_type ENUM('discussion', 'question', 'announcement', 'poll') DEFAULT 'discussion',
    status ENUM('open', 'closed', 'locked', 'pinned', 'archived') DEFAULT 'open',
    is_sticky BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    is_anonymous BOOLEAN DEFAULT FALSE,
    view_count INTEGER DEFAULT 0,
    reply_count INTEGER DEFAULT 0,
    like_count INTEGER DEFAULT 0,
    last_reply_id BIGINT UNSIGNED,
    last_reply_at TIMESTAMP NULL,
    last_reply_by BIGINT UNSIGNED,
    tags JSON,
    attachments JSON,
    poll_data JSON,
    moderation_status ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
    moderated_by BIGINT UNSIGNED,
    moderated_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (forum_id) REFERENCES discussion_forums(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (last_reply_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (moderated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_topics_forum_id (forum_id),
    INDEX idx_topics_user_id (user_id),
    INDEX idx_topics_type (topic_type),
    INDEX idx_topics_status (status),
    INDEX idx_topics_last_reply_at (last_reply_at),
    INDEX idx_topics_moderation_status (moderation_status),
    FULLTEXT idx_topics_search (title, content)
);
```

The discussion topics table supports various topic types with comprehensive moderation and engagement tracking.

### Discussion Posts Table

This table stores individual posts within discussion topics.

```sql
CREATE TABLE discussion_posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    topic_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    parent_post_id BIGINT UNSIGNED,
    content TEXT NOT NULL,
    content_html TEXT,
    is_anonymous BOOLEAN DEFAULT FALSE,
    like_count INTEGER DEFAULT 0,
    reply_count INTEGER DEFAULT 0,
    is_solution BOOLEAN DEFAULT FALSE,
    marked_as_solution_by BIGINT UNSIGNED,
    marked_as_solution_at TIMESTAMP NULL,
    attachments JSON,
    edit_count INTEGER DEFAULT 0,
    last_edited_at TIMESTAMP NULL,
    last_edited_by BIGINT UNSIGNED,
    moderation_status ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
    moderated_by BIGINT UNSIGNED,
    moderated_at TIMESTAMP NULL,
    moderation_reason TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (topic_id) REFERENCES discussion_topics(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_post_id) REFERENCES discussion_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (marked_as_solution_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (last_edited_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (moderated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_posts_topic_id (topic_id),
    INDEX idx_posts_user_id (user_id),
    INDEX idx_posts_parent_post_id (parent_post_id),
    INDEX idx_posts_moderation_status (moderation_status),
    INDEX idx_posts_created_at (created_at),
    FULLTEXT idx_posts_search (content)
);
```

The discussion posts table provides comprehensive post management with threading, moderation, and solution marking capabilities.

### Messages Table

This table handles private messaging between users within the LMS.

```sql
CREATE TABLE messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    conversation_id BIGINT UNSIGNED NOT NULL,
    sender_id BIGINT UNSIGNED NOT NULL,
    message_type ENUM('text', 'file', 'system', 'announcement') DEFAULT 'text',
    subject VARCHAR(255),
    content TEXT NOT NULL,
    content_html TEXT,
    attachments JSON,
    is_system_message BOOLEAN DEFAULT FALSE,
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    read_receipt_requested BOOLEAN DEFAULT FALSE,
    delivery_receipt_requested BOOLEAN DEFAULT FALSE,
    expires_at TIMESTAMP NULL,
    parent_message_id BIGINT UNSIGNED,
    thread_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_message_id) REFERENCES messages(id) ON DELETE SET NULL,
    INDEX idx_messages_conversation_id (conversation_id),
    INDEX idx_messages_sender_id (sender_id),
    INDEX idx_messages_type (message_type),
    INDEX idx_messages_thread_id (thread_id),
    INDEX idx_messages_created_at (created_at),
    FULLTEXT idx_messages_search (subject, content)
);
```

The messages table provides comprehensive private messaging with support for threading, attachments, and delivery tracking.

### Message Conversations Table

This table manages message conversations between multiple participants.

```sql
CREATE TABLE message_conversations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    title VARCHAR(255),
    conversation_type ENUM('direct', 'group', 'broadcast', 'course_announcement') DEFAULT 'direct',
    is_group BOOLEAN DEFAULT FALSE,
    is_archived BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    participant_count INTEGER DEFAULT 0,
    message_count INTEGER DEFAULT 0,
    last_message_id BIGINT UNSIGNED,
    last_message_at TIMESTAMP NULL,
    last_activity_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    settings JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (last_message_id) REFERENCES messages(id) ON DELETE SET NULL,
    INDEX idx_conversations_type (conversation_type),
    INDEX idx_conversations_created_by (created_by),
    INDEX idx_conversations_last_activity_at (last_activity_at)
);
```

The message conversations table manages conversation metadata and participant information.

### Message Participants Table

This table tracks participants in message conversations with their specific settings and status.

```sql
CREATE TABLE message_participants (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    conversation_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    role ENUM('participant', 'moderator', 'admin') DEFAULT 'participant',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    left_at TIMESTAMP NULL,
    last_read_message_id BIGINT UNSIGNED,
    last_read_at TIMESTAMP NULL,
    unread_count INTEGER DEFAULT 0,
    is_muted BOOLEAN DEFAULT FALSE,
    is_archived BOOLEAN DEFAULT FALSE,
    is_pinned BOOLEAN DEFAULT FALSE,
    notification_settings JSON,
    added_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (conversation_id) REFERENCES message_conversations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (last_read_message_id) REFERENCES messages(id) ON DELETE SET NULL,
    FOREIGN KEY (added_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_conversation_participant (conversation_id, user_id),
    INDEX idx_participants_conversation_id (conversation_id),
    INDEX idx_participants_user_id (user_id),
    INDEX idx_participants_last_read_at (last_read_at)
);
```

The message participants table manages participant-specific conversation settings and read status tracking.

### Announcements Table

This table manages system-wide and course-specific announcements.

```sql
CREATE TABLE announcements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    course_id BIGINT UNSIGNED,
    organization_id BIGINT UNSIGNED,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    content_html TEXT,
    announcement_type ENUM('system', 'organization', 'course', 'emergency') DEFAULT 'course',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    target_audience ENUM('all', 'students', 'instructors', 'admins', 'custom') DEFAULT 'all',
    target_roles JSON,
    target_users JSON,
    is_published BOOLEAN DEFAULT FALSE,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_dismissible BOOLEAN DEFAULT TRUE,
    requires_acknowledgment BOOLEAN DEFAULT FALSE,
    show_popup BOOLEAN DEFAULT FALSE,
    send_email BOOLEAN DEFAULT FALSE,
    send_sms BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    view_count INTEGER DEFAULT 0,
    acknowledgment_count INTEGER DEFAULT 0,
    attachments JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_announcements_course_id (course_id),
    INDEX idx_announcements_organization_id (organization_id),
    INDEX idx_announcements_type (announcement_type),
    INDEX idx_announcements_priority (priority),
    INDEX idx_announcements_published_at (published_at),
    INDEX idx_announcements_expires_at (expires_at),
    FULLTEXT idx_announcements_search (title, content)
);
```

The announcements table provides comprehensive announcement management with flexible targeting and delivery options.

### Notifications Table

This table manages all system notifications to users across various channels.

```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    notification_type VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON,
    channels JSON, -- email, sms, push, in_app
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    is_actionable BOOLEAN DEFAULT FALSE,
    action_url VARCHAR(500),
    action_text VARCHAR(100),
    expires_at TIMESTAMP NULL,
    related_type VARCHAR(100),
    related_id BIGINT UNSIGNED,
    sent_via_email BOOLEAN DEFAULT FALSE,
    sent_via_sms BOOLEAN DEFAULT FALSE,
    sent_via_push BOOLEAN DEFAULT FALSE,
    email_sent_at TIMESTAMP NULL,
    sms_sent_at TIMESTAMP NULL,
    push_sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_notifications_user_id (user_id),
    INDEX idx_notifications_type (notification_type),
    INDEX idx_notifications_is_read (is_read),
    INDEX idx_notifications_priority (priority),
    INDEX idx_notifications_created_at (created_at),
    INDEX idx_notifications_related (related_type, related_id)
);
```

The notifications table provides comprehensive notification management with multi-channel delivery tracking and flexible data storage.


## 7. Reporting and Analytics

The reporting and analytics system provides comprehensive data collection, analysis, and reporting capabilities. This system enables detailed insights into learner behavior, course effectiveness, and system performance.

### Analytics Events Table

This table captures detailed user interactions and system events for comprehensive analytics.

```sql
CREATE TABLE analytics_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED,
    session_id VARCHAR(255),
    event_type VARCHAR(100) NOT NULL,
    event_category VARCHAR(100),
    event_action VARCHAR(100),
    event_label VARCHAR(255),
    event_value DECIMAL(10,2),
    course_id BIGINT UNSIGNED,
    module_id BIGINT UNSIGNED,
    lesson_id BIGINT UNSIGNED,
    activity_id BIGINT UNSIGNED,
    assessment_id BIGINT UNSIGNED,
    context_type VARCHAR(100),
    context_id BIGINT UNSIGNED,
    properties JSON,
    user_properties JSON,
    device_type VARCHAR(50),
    browser VARCHAR(100),
    platform VARCHAR(100),
    ip_address VARCHAR(45),
    user_agent TEXT,
    referrer VARCHAR(500),
    page_url VARCHAR(500),
    page_title VARCHAR(255),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY (module_id) REFERENCES course_modules(id) ON DELETE SET NULL,
    FOREIGN KEY (lesson_id) REFERENCES course_lessons(id) ON DELETE SET NULL,
    FOREIGN KEY (activity_id) REFERENCES course_activities(id) ON DELETE SET NULL,
    FOREIGN KEY (assessment_id) REFERENCES assessments(id) ON DELETE SET NULL,
    INDEX idx_events_user_id (user_id),
    INDEX idx_events_session_id (session_id),
    INDEX idx_events_type (event_type),
    INDEX idx_events_category (event_category),
    INDEX idx_events_course_id (course_id),
    INDEX idx_events_timestamp (timestamp),
    INDEX idx_events_context (context_type, context_id)
);
```

The analytics events table provides comprehensive event tracking for detailed user behavior analysis and system performance monitoring.

### Reports Table

This table manages custom and system-generated reports with scheduling and distribution capabilities.

```sql
CREATE TABLE reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    report_type ENUM('standard', 'custom', 'dashboard', 'scheduled') DEFAULT 'standard',
    category VARCHAR(100),
    data_source VARCHAR(100),
    query_definition JSON,
    parameters JSON,
    filters JSON,
    columns JSON,
    chart_config JSON,
    is_public BOOLEAN DEFAULT FALSE,
    is_system BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    schedule_enabled BOOLEAN DEFAULT FALSE,
    schedule_frequency ENUM('daily', 'weekly', 'monthly', 'quarterly', 'yearly') DEFAULT 'weekly',
    schedule_config JSON,
    last_generated_at TIMESTAMP NULL,
    next_generation_at TIMESTAMP NULL,
    generation_count INTEGER DEFAULT 0,
    recipients JSON,
    delivery_methods JSON,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_reports_organization_id (organization_id),
    INDEX idx_reports_type (report_type),
    INDEX idx_reports_category (category),
    INDEX idx_reports_created_by (created_by),
    INDEX idx_reports_schedule_enabled (schedule_enabled),
    INDEX idx_reports_next_generation_at (next_generation_at)
);
```

The reports table provides comprehensive report management with scheduling, parameterization, and automated distribution capabilities.

### Report Instances Table

This table stores generated report instances with their data and metadata.

```sql
CREATE TABLE report_instances (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    report_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255),
    description TEXT,
    parameters_used JSON,
    filters_used JSON,
    data_snapshot JSON,
    file_path VARCHAR(500),
    file_url VARCHAR(500),
    file_format ENUM('pdf', 'excel', 'csv', 'json', 'html') DEFAULT 'pdf',
    file_size BIGINT UNSIGNED,
    generation_status ENUM('pending', 'generating', 'completed', 'failed') DEFAULT 'pending',
    generation_started_at TIMESTAMP NULL,
    generation_completed_at TIMESTAMP NULL,
    generation_duration INTEGER, -- in seconds
    error_message TEXT,
    row_count INTEGER DEFAULT 0,
    is_cached BOOLEAN DEFAULT FALSE,
    cache_expires_at TIMESTAMP NULL,
    download_count INTEGER DEFAULT 0,
    last_downloaded_at TIMESTAMP NULL,
    generated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE,
    FOREIGN KEY (generated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_report_instances_report_id (report_id),
    INDEX idx_report_instances_status (generation_status),
    INDEX idx_report_instances_generated_by (generated_by),
    INDEX idx_report_instances_created_at (created_at),
    INDEX idx_report_instances_cache_expires_at (cache_expires_at)
);
```

The report instances table manages generated report files with caching, download tracking, and comprehensive generation metadata.

### Learning Analytics Table

This table stores aggregated learning analytics data for performance optimization and quick reporting.

```sql
CREATE TABLE learning_analytics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    organization_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    time_spent INTEGER DEFAULT 0, -- in seconds
    sessions_count INTEGER DEFAULT 0,
    lessons_viewed INTEGER DEFAULT 0,
    activities_completed INTEGER DEFAULT 0,
    assessments_taken INTEGER DEFAULT 0,
    assessments_passed INTEGER DEFAULT 0,
    discussion_posts INTEGER DEFAULT 0,
    resources_downloaded INTEGER DEFAULT 0,
    login_count INTEGER DEFAULT 0,
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,
    engagement_score DECIMAL(5,2) DEFAULT 0.00,
    performance_score DECIMAL(5,2) DEFAULT 0.00,
    last_activity_at TIMESTAMP NULL,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_course_date (user_id, course_id, date),
    INDEX idx_analytics_user_id (user_id),
    INDEX idx_analytics_course_id (course_id),
    INDEX idx_analytics_organization_id (organization_id),
    INDEX idx_analytics_date (date),
    INDEX idx_analytics_engagement_score (engagement_score),
    INDEX idx_analytics_performance_score (performance_score)
);
```

The learning analytics table provides pre-aggregated analytics data for efficient reporting and dashboard generation.

### System Metrics Table

This table tracks system-wide performance and usage metrics for operational monitoring.

```sql
CREATE TABLE system_metrics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    metric_name VARCHAR(100) NOT NULL,
    metric_category VARCHAR(100),
    metric_value DECIMAL(15,4) NOT NULL,
    metric_unit VARCHAR(50),
    dimensions JSON,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_metrics_name (metric_name),
    INDEX idx_metrics_category (metric_category),
    INDEX idx_metrics_timestamp (timestamp),
    INDEX idx_metrics_recorded_at (recorded_at)
);
```

The system metrics table provides comprehensive system monitoring with flexible metric storage and dimensional analysis.

### Audit Logs Table

This table maintains comprehensive audit trails for security, compliance, and troubleshooting purposes.

```sql
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED,
    organization_id BIGINT UNSIGNED,
    action VARCHAR(100) NOT NULL,
    resource_type VARCHAR(100),
    resource_id BIGINT UNSIGNED,
    description TEXT,
    old_values JSON,
    new_values JSON,
    metadata JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    session_id VARCHAR(255),
    request_id VARCHAR(255),
    severity ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    category ENUM('authentication', 'authorization', 'data_change', 'system', 'security') DEFAULT 'data_change',
    tags JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE SET NULL,
    INDEX idx_audit_logs_user_id (user_id),
    INDEX idx_audit_logs_organization_id (organization_id),
    INDEX idx_audit_logs_action (action),
    INDEX idx_audit_logs_resource (resource_type, resource_id),
    INDEX idx_audit_logs_severity (severity),
    INDEX idx_audit_logs_category (category),
    INDEX idx_audit_logs_created_at (created_at)
);
```

The audit logs table provides comprehensive audit trail capabilities with detailed change tracking and security monitoring.

### Dashboard Widgets Table

This table manages customizable dashboard widgets for different user roles and contexts.

```sql
CREATE TABLE dashboard_widgets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED,
    organization_id BIGINT UNSIGNED,
    widget_type VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    configuration JSON NOT NULL,
    data_source VARCHAR(100),
    refresh_interval INTEGER DEFAULT 300, -- in seconds
    position_x INTEGER DEFAULT 0,
    position_y INTEGER DEFAULT 0,
    width INTEGER DEFAULT 4,
    height INTEGER DEFAULT 3,
    is_visible BOOLEAN DEFAULT TRUE,
    is_shared BOOLEAN DEFAULT FALSE,
    permissions JSON,
    last_refreshed_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_widgets_user_id (user_id),
    INDEX idx_widgets_organization_id (organization_id),
    INDEX idx_widgets_type (widget_type),
    INDEX idx_widgets_created_by (created_by),
    INDEX idx_widgets_is_visible (is_visible)
);
```

The dashboard widgets table enables customizable dashboard creation with flexible widget positioning and configuration.


## 8. System Administration and Configuration

The system administration and configuration section provides comprehensive management capabilities for system settings, integrations, and operational features. This system enables flexible configuration while maintaining security and auditability.

### System Settings Table

This table stores system-wide configuration settings with hierarchical organization and type safety.

```sql
CREATE TABLE system_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_id BIGINT UNSIGNED,
    category VARCHAR(100) NOT NULL,
    key_name VARCHAR(255) NOT NULL,
    display_name VARCHAR(255),
    description TEXT,
    value TEXT,
    default_value TEXT,
    data_type ENUM('string', 'integer', 'decimal', 'boolean', 'json', 'array', 'file', 'url') DEFAULT 'string',
    validation_rules JSON,
    is_encrypted BOOLEAN DEFAULT FALSE,
    is_public BOOLEAN DEFAULT FALSE,
    is_system BOOLEAN DEFAULT FALSE,
    requires_restart BOOLEAN DEFAULT FALSE,
    sort_order INTEGER DEFAULT 0,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_org_category_key (organization_id, category, key_name),
    INDEX idx_settings_organization_id (organization_id),
    INDEX idx_settings_category (category),
    INDEX idx_settings_key_name (key_name),
    INDEX idx_settings_is_system (is_system)
);
```

The system settings table provides comprehensive configuration management with organization-specific overrides and data type validation.

### Integrations Table

This table manages external system integrations with authentication and configuration details.

```sql
CREATE TABLE integrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    integration_type ENUM('sso', 'lti', 'api', 'webhook', 'scorm', 'xapi', 'custom') NOT NULL,
    provider VARCHAR(100),
    version VARCHAR(20),
    status ENUM('active', 'inactive', 'error', 'pending') DEFAULT 'pending',
    configuration JSON NOT NULL,
    credentials JSON,
    endpoints JSON,
    webhook_url VARCHAR(500),
    webhook_secret VARCHAR(255),
    api_key VARCHAR(255),
    api_secret VARCHAR(255),
    oauth_config JSON,
    rate_limit_config JSON,
    last_sync_at TIMESTAMP NULL,
    last_error TEXT,
    error_count INTEGER DEFAULT 0,
    is_system BOOLEAN DEFAULT FALSE,
    is_enabled BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_integrations_organization_id (organization_id),
    INDEX idx_integrations_slug (slug),
    INDEX idx_integrations_type (integration_type),
    INDEX idx_integrations_provider (provider),
    INDEX idx_integrations_status (status),
    INDEX idx_integrations_created_by (created_by)
);
```

The integrations table provides comprehensive external system integration management with flexible configuration and monitoring capabilities.

### Email Templates Table

This table manages email templates for various system notifications and communications.

```sql
CREATE TABLE email_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    template_type ENUM('system', 'notification', 'marketing', 'transactional') DEFAULT 'system',
    subject VARCHAR(500) NOT NULL,
    body_text TEXT,
    body_html TEXT,
    variables JSON,
    attachments JSON,
    is_system BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    language VARCHAR(10) DEFAULT 'en',
    version INTEGER DEFAULT 1,
    parent_template_id BIGINT UNSIGNED,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_template_id) REFERENCES email_templates(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_org_slug (organization_id, slug),
    INDEX idx_email_templates_organization_id (organization_id),
    INDEX idx_email_templates_slug (slug),
    INDEX idx_email_templates_category (category),
    INDEX idx_email_templates_type (template_type),
    INDEX idx_email_templates_language (language)
);
```

The email templates table provides comprehensive email template management with versioning and localization support.

### File Storage Table

This table manages file uploads and storage with comprehensive metadata and access control.

```sql
CREATE TABLE file_storage (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED NOT NULL,
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_url VARCHAR(500),
    storage_driver VARCHAR(50) DEFAULT 'local',
    storage_bucket VARCHAR(255),
    storage_key VARCHAR(500),
    mime_type VARCHAR(100),
    file_size BIGINT UNSIGNED NOT NULL,
    file_hash VARCHAR(64),
    file_type ENUM('image', 'video', 'audio', 'document', 'archive', 'other') DEFAULT 'other',
    is_public BOOLEAN DEFAULT FALSE,
    is_temporary BOOLEAN DEFAULT FALSE,
    expires_at TIMESTAMP NULL,
    download_count INTEGER DEFAULT 0,
    last_downloaded_at TIMESTAMP NULL,
    virus_scan_status ENUM('pending', 'clean', 'infected', 'error') DEFAULT 'pending',
    virus_scan_at TIMESTAMP NULL,
    metadata JSON,
    tags JSON,
    related_type VARCHAR(100),
    related_id BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_file_storage_organization_id (organization_id),
    INDEX idx_file_storage_user_id (user_id),
    INDEX idx_file_storage_file_hash (file_hash),
    INDEX idx_file_storage_file_type (file_type),
    INDEX idx_file_storage_related (related_type, related_id),
    INDEX idx_file_storage_expires_at (expires_at),
    INDEX idx_file_storage_virus_scan_status (virus_scan_status)
);
```

The file storage table provides comprehensive file management with security scanning, access control, and flexible storage backend support.

### Scheduled Jobs Table

This table manages background jobs and scheduled tasks with comprehensive monitoring and retry capabilities.

```sql
CREATE TABLE scheduled_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    job_name VARCHAR(255) NOT NULL,
    job_class VARCHAR(255) NOT NULL,
    job_method VARCHAR(100),
    description TEXT,
    job_data JSON,
    schedule_expression VARCHAR(255), -- cron expression
    timezone VARCHAR(50) DEFAULT 'UTC',
    is_enabled BOOLEAN DEFAULT TRUE,
    is_recurring BOOLEAN DEFAULT FALSE,
    max_attempts INTEGER DEFAULT 3,
    retry_delay INTEGER DEFAULT 60, -- in seconds
    timeout INTEGER DEFAULT 300, -- in seconds
    priority INTEGER DEFAULT 0,
    last_run_at TIMESTAMP NULL,
    next_run_at TIMESTAMP NULL,
    last_run_status ENUM('success', 'failed', 'timeout', 'cancelled') NULL,
    last_run_duration INTEGER, -- in seconds
    last_error TEXT,
    run_count INTEGER DEFAULT 0,
    success_count INTEGER DEFAULT 0,
    failure_count INTEGER DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_scheduled_jobs_organization_id (organization_id),
    INDEX idx_scheduled_jobs_job_name (job_name),
    INDEX idx_scheduled_jobs_is_enabled (is_enabled),
    INDEX idx_scheduled_jobs_next_run_at (next_run_at),
    INDEX idx_scheduled_jobs_last_run_status (last_run_status)
);
```

The scheduled jobs table provides comprehensive background job management with scheduling, monitoring, and retry capabilities.

### API Keys Table

This table manages API keys for external access to the LMS with comprehensive access control and monitoring.

```sql
CREATE TABLE api_keys (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    organization_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    key_hash VARCHAR(255) NOT NULL UNIQUE,
    key_prefix VARCHAR(20) NOT NULL,
    permissions JSON,
    rate_limit_per_minute INTEGER DEFAULT 60,
    rate_limit_per_hour INTEGER DEFAULT 1000,
    rate_limit_per_day INTEGER DEFAULT 10000,
    allowed_ips JSON,
    allowed_domains JSON,
    is_active BOOLEAN DEFAULT TRUE,
    expires_at TIMESTAMP NULL,
    last_used_at TIMESTAMP NULL,
    usage_count INTEGER DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    revoked_by BIGINT UNSIGNED,
    revoked_at TIMESTAMP NULL,
    revoke_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (revoked_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_api_keys_organization_id (organization_id),
    INDEX idx_api_keys_user_id (user_id),
    INDEX idx_api_keys_key_prefix (key_prefix),
    INDEX idx_api_keys_is_active (is_active),
    INDEX idx_api_keys_expires_at (expires_at),
    INDEX idx_api_keys_created_by (created_by)
);
```

The API keys table provides comprehensive API access management with rate limiting, IP restrictions, and detailed usage tracking.

### System Maintenance Table

This table tracks system maintenance activities and scheduled downtime.

```sql
CREATE TABLE system_maintenance (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    maintenance_type ENUM('scheduled', 'emergency', 'update', 'patch') DEFAULT 'scheduled',
    status ENUM('planned', 'in_progress', 'completed', 'cancelled') DEFAULT 'planned',
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    affects_system BOOLEAN DEFAULT TRUE,
    affects_organizations JSON,
    affects_features JSON,
    scheduled_start_at TIMESTAMP NOT NULL,
    scheduled_end_at TIMESTAMP NOT NULL,
    actual_start_at TIMESTAMP NULL,
    actual_end_at TIMESTAMP NULL,
    estimated_duration INTEGER, -- in minutes
    actual_duration INTEGER, -- in minutes
    notification_sent BOOLEAN DEFAULT FALSE,
    notification_sent_at TIMESTAMP NULL,
    completion_notes TEXT,
    created_by BIGINT UNSIGNED NOT NULL,
    updated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_maintenance_type (maintenance_type),
    INDEX idx_maintenance_status (status),
    INDEX idx_maintenance_priority (priority),
    INDEX idx_maintenance_scheduled_start_at (scheduled_start_at),
    INDEX idx_maintenance_created_by (created_by)
);
```

The system maintenance table provides comprehensive maintenance activity tracking with notification management and impact assessment.

## Database Indexes and Performance Optimization

The schema includes comprehensive indexing strategies designed to optimize query performance for common LMS operations:

### Primary Indexes
- All tables include primary key indexes on the `id` field
- UUID fields are indexed for external API access
- Foreign key relationships are properly indexed

### Composite Indexes
- User-course relationships are indexed for enrollment queries
- Time-based queries are optimized with date/timestamp indexes
- Multi-column indexes support complex filtering scenarios

### Full-Text Search Indexes
- Course content, discussions, and messages support full-text search
- Search indexes enable efficient content discovery and filtering

### Performance Considerations
- Proper use of data types to minimize storage overhead
- JSON fields for flexible data storage without schema changes
- Soft deletes preserve data integrity while maintaining performance
- Partitioning strategies can be implemented for large-scale deployments

This comprehensive database schema provides a solid foundation for an enterprise-grade LMS while maintaining flexibility for future enhancements and customizations.

