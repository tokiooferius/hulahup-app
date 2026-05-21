# GitHub Setup Instructions

## Step-by-Step GitHub Setup untuk Hulahup App

### 1️⃣ CREATE GITHUB ACCOUNT (Jika belum punya)

- Buka: https://github.com/join
- Isi email, password, username
- Verify email
- Selesai!

### 2️⃣ CREATE NEW REPOSITORY

**Option A: Melalui Website**

1. Buka: https://github.com/new
2. Repository name: `hulahup-app`
3. Description: `Hulahup - Canteen Order System`
4. Visibility: **Public** (atau Private)
5. ❌ Jangan initialize dengan README/gitignore/license
6. Klik **Create repository**

**Result:** Anda akan dibawa ke halaman dengan instruksi git

### 3️⃣ PUSH CODE KE GITHUB

Buka PowerShell, masuk folder project:

```powershell
cd c:\xampp\hulahup-app

# Initialize git (jika belum ada .git)
git init

# Konfigurasi user (hanya sekali)
git config user.name "Your Full Name"
git config user.email "your.email@example.com"

# Verify config
git config user.name
git config user.email

# Add semua file
git add .

# Commit dengan pesan deskriptif
git commit -m "Initial commit: Hulahup App - Canteen Order System

- User authentication & role-based access
- Menu & order management
- Payment integration with Midtrans
- Canteen settlement system
- Mobile responsive design"

# Add GitHub repository (ganti USERNAME dengan GitHub username Anda)
git remote add origin https://github.com/USERNAME/hulahup-app.git

# Rename branch ke main (GitHub standard)
git branch -M main

# Push ke GitHub
git push -u origin main

# Output akan seperti:
# Enumerating objects: 1234, done.
# ...
# * [new branch] main -> main
# Branch 'main' set up to track remote branch 'main' from 'origin'.
```

### 4️⃣ VERIFY DI GITHUB

1. Buka: https://github.com/USERNAME/hulahup-app
2. Verify file-file ada:
   - ✅ app/ folder
   - ✅ routes/ folder
   - ✅ database/ folder
   - ✅ composer.json
   - ✅ package.json
   - ✅ Semua deployment files
3. Lihat commits: Klik "Commits" tab

---

## GITHUB WORKFLOW SETELAH SETUP

### Membuat Perubahan & Push

```powershell
# 1. Buat perubahan file
# (Edit di VS Code, test locally)

# 2. Check status
git status

# 3. Stage perubahan
git add .
# atau specific file:
git add app/Models/User.php

# 4. Commit
git commit -m "Feature: Add user phone number field"

# 5. Push
git push origin main
```

### Pull Changes (Dari Komputer Lain)

```powershell
# Clone repository
git clone https://github.com/USERNAME/hulahup-app.git
cd hulahup-app

# Pull latest changes
git pull origin main
```

---

## GITHUB FEATURES UNTUK DEPLOYMENT

### Setting up GitHub for Auto-Deployment

**Railway dapat membaca dari GitHub & auto-deploy pada setiap push:**

1. Railway connect dengan GitHub account Anda
2. Railway monitor repository
3. Setiap push ke main branch → Auto-deploy! 🚀

---

## 🔐 SECURITY TIPS

### Jangan Commit Sensitive Files!

Sudah ada di `.gitignore`:
- ✅ `.env` - Environment variables
- ✅ `/vendor` - Composer dependencies
- ✅ `/node_modules` - NPM dependencies  
- ✅ `/storage/logs` - Log files
- ✅ Private keys

### Good Practices

- ✅ Gunakan `.env.production.example` untuk template
- ✅ Keep API keys di environment variables
- ✅ Don't commit passwords
- ✅ Use GitHub Secrets untuk CI/CD (advanced)

---

## USEFUL GITHUB COMMANDS

```powershell
# Check remote URL
git remote -v

# Change remote URL (jika salah)
git remote set-url origin https://github.com/NEW_USERNAME/repo.git

# View commit history
git log --oneline
git log --graph --oneline --all

# Undo last commit (belum push)
git reset --soft HEAD~1

# Force push (hati-hati!)
git push origin main --force

# View file history
git log -p -- app/Models/User.php

# See who changed what
git blame app/Models/User.php
```

---

## TROUBLESHOOTING GITHUB

### Error: "fatal: 'origin' does not appear to be a 'git' repository"

```powershell
# Set remote origin
git remote add origin https://github.com/USERNAME/hulahup-app.git
```

### Error: "Permission denied (publickey)"

**Solution 1: Use HTTPS (Recommended)**
```powershell
git remote set-url origin https://github.com/USERNAME/hulahup-app.git
```

**Solution 2: Setup SSH Key**
- https://docs.github.com/en/authentication/connecting-to-github-with-ssh

### Error: "Updates were rejected"

```powershell
# Pull latest first
git pull origin main

# Resolve conflicts if any, then:
git add .
git commit -m "Merge latest changes"
git push origin main
```

### Repository Already Exists

```powershell
# Remove old git
rmdir /s .git

# Initialize new git
git init
git remote add origin https://github.com/USERNAME/hulahup-app.git
git add .
git commit -m "Initial commit"
git push -u origin main
```

---

## GITHUB COLLABORATION (Untuk Tim)

### Invite Team Members

1. Repository Settings → Collaborators
2. Add collaborators by username
3. They get permission to push

### Using Branches untuk Teamwork

```powershell
# Create branch
git checkout -b feature/payment-integration

# Make changes & commit
git add .
git commit -m "Add Midtrans integration"

# Push branch
git push origin feature/payment-integration

# Di GitHub: Create Pull Request (PR)
# - Review & discuss
# - Merge ke main saat ready
```

---

## NEXT STEPS

✅ Create GitHub repository  
✅ Push code  
✅ Verify on GitHub  
✅ Connect to Railway for auto-deployment  

---

**Reference:**
- https://github.com/new - Create repository
- https://docs.github.com - GitHub documentation
- https://git-scm.com - Git documentation

