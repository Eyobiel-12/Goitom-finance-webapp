# User Registration Flow - Complete Guide

## 🎯 Overview

The Goitom Finance application features a **3-step multi-step registration flow** with email verification (OTP) to ensure secure user onboarding.

## 📋 Registration Process

### Step 1: Basic Information
- **Name** (minimum 3 characters)
- **Email** (must be unique and valid)

### Step 2: Password Setup
- **Password** (minimum 8 characters)
- **Password Confirmation**
- Generates and sends **6-digit OTP** to email

### Step 3: Email Verification
- User enters the **OTP code** received via email
- OTP expires after **10 minutes**
- Upon successful verification:
  - User account is created
  - Organization is automatically created
  - Welcome email is sent
  - User is logged in automatically
  - Redirected to dashboard

## 🔧 Technical Implementation

### Components Used
- **Livewire Component**: `RegisterMultiStep.php`
- **Email Models**: 
  - `OtpVerificationMail` - Sends OTP code
  - `WelcomeMail` - Welcome message after registration
- **Database Models**:
  - `EmailVerification` - Stores OTP codes
  - `User` - User accounts
  - `Organization` - Auto-created business entity

### Default Settings
- **User Role**: `ondernemer` (Entrepreneur)
- **Organization Country**: Netherlands (NL)
- **Default Currency**: EUR
- **Default VAT Rate**: 21%
- **Branding Color**: Gold (#d4af37)

## 🧪 Testing the Flow

### Method 1: Web Interface
1. Navigate to http://127.0.0.1:8000/register
2. Fill in the registration form
3. Check your email for the OTP code
4. Enter the OTP and complete registration

### Method 2: Artisan Command (Testing)
```bash
# Create user without sending emails
php artisan user:create-test "User Name" "email@example.com"

# Create user and send actual emails
php artisan user:create-test "User Name" "email@example.com" --send-emails

# Specify custom password
php artisan user:create-test "User Name" "email@example.com" --password=mySecurePassword123
```

## 👥 Created Test Users

### 1. Admin User
- **Email**: admin@goitom-finance.com
- **Password**: password
- **Role**: admin
- **Purpose**: System administration and Filament admin panel access

### 2. Test Ondernemer
- **Email**: ondernemer@example.com
- **Password**: password
- **Role**: ondernemer
- **Organization**: Goitom Finance BV

### 3. Sarah Johnson
- **Email**: sarah.johnson@example.com
- **Password**: password123
- **Role**: ondernemer
- **Organization**: Sarah Johnson Business
- **Slug**: sarah-johnson-business

### 4. Michael Brown
- **Email**: michael.brown@example.com
- **Password**: password123
- **Role**: ondernemer
- **Organization**: Michael Brown Business
- **Slug**: michael-brown-business
- **Emails Sent**: ✅ OTP + Welcome

### 5. Test User
- **Email**: test@example.com
- **Password**: password
- **Role**: ondernemer

## 📧 Email Configuration

### Provider: Resend (via Hostinger SMTP)
- **Sender**: goitomfinance@goitomfinance.email
- **From Name**: Goitom Finance
- **SMTP Host**: smtp.hostinger.com
- **Port**: 587
- **Encryption**: TLS

### Email Templates
1. **OTP Verification Email**
   - Contains 6-digit code
   - Expires in 10 minutes
   - Clean, professional design

2. **Welcome Email**
   - Sent after successful registration
   - Includes login URL and getting started guide
   - Personalized with user name

## 🔐 Security Features

### Email Verification
- OTP codes are **single-use** only
- Automatic expiration after **10 minutes**
- Old OTP codes are invalidated when new ones are generated
- Stored in `email_verifications` table

### Password Security
- Minimum 8 characters required
- Hashed using Laravel's bcrypt
- Must match confirmation

### Organization Isolation
- Each user gets their own organization
- Slug is unique and auto-generated
- Multi-tenant data scoping

## 📊 Database Structure

### Users Table
- `id`, `name`, `email`, `password`
- `role` (admin, ondernemer)
- `organization_id` (foreign key)
- `email_verified_at`

### Organizations Table
- `id`, `name`, `slug`
- `owner_user_id` (foreign key)
- `vat_number`, `country`, `currency`
- `default_vat_rate`, `branding_color`
- `status` (active, suspended)

### Email Verifications Table
- `id`, `email`, `otp_code`
- `expires_at`, `is_used`

## 🚀 Access Points

### Web Interface
- **Registration**: http://127.0.0.1:8000/register
- **Login**: http://127.0.0.1:8000/login
- **Dashboard**: http://127.0.0.1:8000/app/dashboard
- **Admin Panel**: http://127.0.0.1:8000/admin (admin users only)

### Routes
- `GET /register` - Display registration form
- `POST /register` - Process registration (handled by Livewire)

## ✅ Validation Rules

### Name
- Required
- String
- Minimum 3 characters
- Maximum 255 characters

### Email
- Required
- Valid email format
- Maximum 255 characters
- Unique in database

### Password
- Required
- String
- Minimum 8 characters
- Must match confirmation

### OTP Code
- Required
- String
- Exactly 6 digits
- Must be valid and not expired

## 🎉 Post-Registration Actions

1. ✅ User account created
2. ✅ Email marked as verified
3. ✅ Organization automatically created
4. ✅ User linked to organization
5. ✅ Welcome email sent (queued)
6. ✅ User logged in automatically
7. ✅ Onboarding tour flag set
8. ✅ Redirected to dashboard

## 📝 Notes

- All created users have the role `ondernemer` by default
- Admin users can be created through seeders or manually
- Organization slugs are auto-generated from user names
- Welcome emails are queued for asynchronous sending
- Queue worker must be running for background email processing
- OTP codes are 6 digits (100000-999999)

## 🔄 Queue Processing

Email sending is handled asynchronously through Laravel's queue system:

```bash
# Start queue worker
php artisan queue:work --daemon

# Check queue status
php artisan queue:failed

# Restart queue workers
php artisan queue:restart
```

## 🎨 UI/UX Features

- Multi-step progress indicator
- Real-time validation
- Error messages in Dutch
- Loading states during OTP sending
- Responsive design
- Dark theme with gold accents
- Smooth transitions between steps

---

**Created**: November 3, 2025  
**Application**: Goitom Finance  
**Laravel Version**: 12.x  
**Livewire Version**: 3.x

