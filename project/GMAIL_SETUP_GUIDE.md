# 📧 Gmail SMTP Setup for Jiffy HR System

## 🔧 Step-by-Step Gmail Configuration

### Step 1: Enable 2-Factor Authentication
1. Go to [Google Account Settings](https://myaccount.google.com)
2. Click **Security** in the left sidebar
3. Under "Signing in to Google", click **2-Step Verification**
4. Follow the setup process to enable 2FA

### Step 2: Generate App Password
1. Still in **Security** settings, click **App passwords**
2. Select **Mail** from the dropdown
3. Click **Generate**
4. Copy the 16-character password (e.g., `abcd efgh ijkl mnop`)

### Step 3: Update Jiffy Configuration
1. Open `project/loginverify.php`
2. Find line with `YOUR_GMAIL_APP_PASSWORD_HERE`
3. Replace it with your generated app password:
   ```php
   $this->mail->Password = 'abcd efgh ijkl mnop'; // Your actual app password
   ```

### Step 4: Test Configuration
1. Visit: `http://localhost/Jiffy-new/project/test_gmail.php`
2. Update the password in the test file with your app password
3. Run the test to verify email sending works

### Step 5: Test Forgot Password
1. Go to: `http://localhost/Jiffy-new/project/index.php?login=password`
2. Enter a valid email address from your employee database
3. Check your email for the OTP

## 🔄 Alternative Email Services

If Gmail doesn't work, you can use these alternatives:

### Option 1: Outlook/Hotmail
```php
$this->mail->Host = 'smtp-mail.outlook.com';
$this->mail->Port = 587;
$this->mail->Username = 'your-email@outlook.com';
$this->mail->Password = 'your-password';
```

### Option 2: Yahoo Mail
```php
$this->mail->Host = 'smtp.mail.yahoo.com';
$this->mail->Port = 587;
$this->mail->Username = 'your-email@yahoo.com';
$this->mail->Password = 'your-app-password';
```

### Option 3: SendGrid (Recommended for Production)
```php
$this->mail->Host = 'smtp.sendgrid.net';
$this->mail->Port = 587;
$this->mail->Username = 'apikey';
$this->mail->Password = 'your-sendgrid-api-key';
```

## 🚨 Common Issues & Solutions

### Issue: "SMTP Error: Could not authenticate"
- **Solution:** Generate new Gmail app password
- **Check:** 2FA is enabled on Gmail account

### Issue: "Connection timeout"
- **Solution:** Try port 465 instead of 587
- **Check:** Firewall/antivirus blocking outbound SMTP

### Issue: "SSL connection error"
- **Solution:** Update OpenSSL or use different email provider

## 📝 Quick Fix Commands

1. **Enable PHP OpenSSL extension** (if missing):
   - Uncomment `;extension=openssl` in `php.ini`
   - Restart Apache

2. **Test SMTP connectivity**:
   ```bash
   telnet smtp.gmail.com 587
   ```

3. **Check PHP mail configuration**:
   ```php
   phpinfo(); // Look for mail configuration
   ```

## ✅ Verification Checklist

- [ ] 2FA enabled on Gmail
- [ ] App password generated
- [ ] Password updated in `loginverify.php`
- [ ] Test email sent successfully
- [ ] Forgot password feature working
- [ ] OTP received in email (not displayed on screen)

## 🆘 Still Having Issues?

1. Check server error logs: `C:\xampp\apache\logs\error.log`
2. Enable PHPMailer debug: Set `SMTPDebug = 2` in configuration
3. Try different email provider (Outlook, SendGrid)
4. Contact system administrator

---

**Last Updated:** October 2025  
**Status:** Ready for implementation