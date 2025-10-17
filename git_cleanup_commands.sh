# 🚨 EMERGENCY GIT CLEANUP COMMANDS
# Run these commands to clean exposed credentials from Git history

# Step 1: Check current status
git status

# Step 2: Add all cleaned files
git add .
git add .gitignore
git add .env.example

# Step 3: Commit the security fixes
git commit -m "SECURITY: Remove exposed email credentials and implement secure configuration"

# Step 4: Clean Git history (DANGEROUS - creates new history)
# Option A: Using git filter-repo (recommended)
git filter-repo --invert-paths --path-glob '**/loginverify.php' --path-glob '**/insertdata.php'

# Option B: Using BFG Repo Cleaner (if you have it installed)
# bfg --replace-text passwords.txt

# Step 5: Force push the cleaned repository (WARNING: This rewrites history)
git push --force-with-lease origin main

# Step 6: Verify the credentials are gone
git log --all --full-history -- "**/loginverify.php" | grep -i password

# Alternative: Create entirely new repository
# If history cleanup fails, consider:
# 1. Create new repository on GitHub
# 2. Copy only current cleaned files
# 3. Initialize fresh Git history
# 4. Push to new repository
# 5. Update all references to new repository

echo "⚠️  WARNING: Force push will rewrite Git history!"
echo "🔐 Make sure to change your email password IMMEDIATELY"
echo "📧 Monitor your email account for suspicious activity"