# AWS EC2 Ubuntu Deployment Guide
## Complaint Management System - Manual Deployment

---

## Prerequisites
- AWS Account
- SSH client (PuTTY for Windows or Terminal for Mac/Linux)
- Your project files ready to upload

---

## Step 1: Launch EC2 Instance

### 1.1 Create EC2 Instance
1. Log into AWS Console → EC2 Dashboard
2. Click **"Launch Instance"**
3. Configure:
   - **Name**: ComplaintManagementSystem
   - **AMI**: Ubuntu Server 22.04 LTS (Free tier eligible)
   - **Instance Type**: t2.micro (1GB RAM) or t2.small (2GB RAM - recommended)
   - **Key Pair**: Create new key pair → Download `.pem` file (save securely!)
   - **Network Settings**:
     - Allow SSH (port 22) from your IP
     - Allow HTTP (port 80) from anywhere
     - Allow HTTPS (port 443) from anywhere
     - Custom TCP (port 5000) from anywhere (for Flask ML API)

### 1.2 Allocate Elastic IP (Optional but Recommended)
1. EC2 → Elastic IPs → Allocate Elastic IP
2. Associate with your instance (prevents IP change on restart)

---

## Step 2: Connect to EC2 Instance

### For Windows:
```bash
# Convert .pem to .ppk using PuTTYgen, then use PuTTY
# Or use Git Bash:
ssh -i "your-key.pem" ubuntu@your-ec2-public-ip
```

### For Mac/Linux:
```bash
chmod 400 your-key.pem
ssh -i "your-key.pem" ubuntu@your-ec2-public-ip
```

---

## Step 3: Update System & Install Required Software

### 3.1 Update System
```bash
sudo apt update && sudo apt upgrade -y
```

### 3.2 Install Apache Web Server
```bash
sudo apt install apache2 -y
sudo systemctl start apache2
sudo systemctl enable apache2
```

### 3.3 Install MySQL
```bash
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql

# Secure MySQL installation
sudo mysql_secure_installation
# Set root password, remove anonymous users, disallow root login remotely
```

### 3.4 Install PHP and Extensions
```bash
sudo apt install php8.1 php8.1-mysql php8.1-curl php8.1-json php8.1-mbstring php8.1-xml libapache2-mod-php8.1 -y
```

### 3.5 Install Python and Required Packages
```bash
sudo apt install python3 python3-pip python3-venv -y
```

---

## Step 4: Configure MySQL Database

### 4.1 Create Database and User
```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE complaint_management_system;
CREATE USER 'complaint_app'@'localhost' IDENTIFIED BY 'your_secure_password_here';
GRANT ALL PRIVILEGES ON complaint_management_system.* TO 'complaint_app'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4.2 Import Database Schema
```bash
# Upload your schema.sql file first (see Step 5)
sudo mysql -u root -p complaint_management_system < /var/www/html/ComplaintManagementSystem/database/schema.sql
```

---

## Step 5: Upload Project Files

### Option 1: Using SCP (from your local machine)
```bash
# Windows (Git Bash) / Mac / Linux
scp -i "your-key.pem" -r "c:/wamp64/www/Complaint Priority Classifier/ComplaintManagementSystem" ubuntu@your-ec2-ip:/home/ubuntu/
scp -i "your-key.pem" "c:/wamp64/www/Complaint Priority Classifier/data.csv" ubuntu@your-ec2-ip:/home/ubuntu/
scp -i "your-key.pem" "c:/wamp64/www/Complaint Priority Classifier/*.pkl" ubuntu@your-ec2-ip:/home/ubuntu/
```

### Option 2: Using Git (Recommended)
```bash
# On EC2 instance
cd /home/ubuntu
sudo apt install git -y
git clone https://github.com/MathewX470/Complaint-Priority-Classifier.git
```

### Move Files to Web Directory
```bash
sudo mkdir -p /var/www/html/ComplaintManagementSystem
sudo cp -r /home/ubuntu/ComplaintManagementSystem/* /var/www/html/ComplaintManagementSystem/
sudo cp /home/ubuntu/*.pkl /var/www/html/
sudo cp /home/ubuntu/data.csv /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

---

## Step 6: Configure Apache

### 6.1 Create Virtual Host
```bash
sudo nano /etc/apache2/sites-available/complaint-system.conf
```

Add this configuration:
```apache
<VirtualHost *:80>
    ServerAdmin admin@yourdomain.com
    DocumentRoot /var/www/html/ComplaintManagementSystem/frontend
    ServerName your-ec2-public-ip-or-domain

    <Directory /var/www/html/ComplaintManagementSystem/frontend>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/complaint_error.log
    CustomLog ${APACHE_LOG_DIR}/complaint_access.log combined
</VirtualHost>
```

### 6.2 Enable Site and Rewrite Module
```bash
sudo a2ensite complaint-system.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## Step 7: Update Configuration Files

### 7.1 Update Database Configuration
```bash
sudo nano /var/www/html/ComplaintManagementSystem/backend/config.php
```

Update these lines:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'complaint_app');
define('DB_PASS', 'your_secure_password_here');
define('DB_NAME', 'complaint_management_system');

define('APP_URL', 'http://your-ec2-public-ip');
define('ML_API_URL', 'http://localhost:5000/predict');
```

---

## Step 8: Set Up Python ML API

### 8.1 Create Virtual Environment
```bash
cd /var/www/html/ComplaintManagementSystem/ml_model
sudo python3 -m venv venv
sudo chown -R ubuntu:ubuntu venv
source venv/bin/activate
```

### 8.2 Install Python Dependencies
```bash
pip install -r requirements.txt
```

### 8.3 Create Systemd Service for Flask API
```bash
sudo nano /etc/systemd/system/ml-api.service
```

Add this configuration:
```ini
[Unit]
Description=Complaint ML API Flask Service
After=network.target

[Service]
User=ubuntu
WorkingDirectory=/var/www/html/ComplaintManagementSystem/ml_model
Environment="PATH=/var/www/html/ComplaintManagementSystem/ml_model/venv/bin"
ExecStart=/var/www/html/ComplaintManagementSystem/ml_model/venv/bin/python ml_api.py
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

### 8.4 Start ML API Service
```bash
sudo systemctl daemon-reload
sudo systemctl start ml-api
sudo systemctl enable ml-api
sudo systemctl status ml-api
```

---

## Step 9: Configure Firewall

```bash
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw allow 5000/tcp  # ML API (optional - only if accessing externally)
sudo ufw enable
```

---

## Step 10: Test the Application

### 10.1 Test Apache
```bash
curl http://localhost
```

### 10.2 Test ML API
```bash
curl -X POST http://localhost:5000/predict \
  -H "Content-Type: application/json" \
  -d '{"complaint_text":"The server is down"}'
```

### 10.3 Access Application
Open browser: `http://your-ec2-public-ip`

---

## Step 11: Create Admin Account

```bash
sudo mysql -u root -p complaint_management_system
```

```sql
-- Create admin user (password: admin123 - change in production!)
INSERT INTO users (full_name, email, password_hash, role) 
VALUES ('Admin User', 'admin@complaint.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Create regular user for testing
INSERT INTO users (full_name, email, password_hash, role) 
VALUES ('Test User', 'user@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');
```

---

## Step 12: Optional - Set Up Domain & SSL

### 12.1 Point Domain to EC2
1. In your domain registrar (GoDaddy, Namecheap, etc.)
2. Create an **A Record** pointing to your EC2 Elastic IP

### 12.2 Install Let's Encrypt SSL
```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
sudo systemctl restart apache2
```

---

## Troubleshooting

### Check Apache Logs
```bash
sudo tail -f /var/log/apache2/complaint_error.log
```

### Check ML API Logs
```bash
sudo journalctl -u ml-api -f
```

### Restart Services
```bash
sudo systemctl restart apache2
sudo systemctl restart ml-api
sudo systemctl restart mysql
```

### Fix Permissions
```bash
sudo chown -R www-data:www-data /var/www/html/ComplaintManagementSystem
sudo chmod -R 755 /var/www/html/ComplaintManagementSystem
```

---

## Monitoring & Maintenance

### Monitor System Resources
```bash
htop  # Install: sudo apt install htop
```

### Check Disk Space
```bash
df -h
```

### Enable Automatic Backups
```bash
# Create backup script
sudo nano /home/ubuntu/backup.sh
```

Add:
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u complaint_app -p'your_password' complaint_management_system > /home/ubuntu/backups/db_backup_$DATE.sql
find /home/ubuntu/backups/ -name "*.sql" -mtime +7 -delete
```

```bash
sudo chmod +x /home/ubuntu/backup.sh
sudo mkdir -p /home/ubuntu/backups
# Add to crontab: 0 2 * * * /home/ubuntu/backup.sh
```

---

## Security Best Practices

1. **Change Default Passwords**: Update all default passwords
2. **Disable Root SSH Login**: Edit `/etc/ssh/sshd_config`
3. **Use SSH Keys Only**: Disable password authentication
4. **Keep System Updated**: 
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```
5. **Monitor Logs**: Regularly check application and system logs
6. **Enable HTTPS**: Always use SSL/TLS in production
7. **Database Security**: Use strong passwords, limit user privileges
8. **Backup Regularly**: Automate database and file backups

---

## Useful Commands

```bash
# Restart all services
sudo systemctl restart apache2 ml-api mysql

# View active services
sudo systemctl list-units --type=service --state=running

# Check open ports
sudo netstat -tuln

# Monitor real-time logs
sudo tail -f /var/log/apache2/complaint_error.log
sudo journalctl -u ml-api -f

# Test ML API health
curl http://localhost:5000/health

# Check PHP info
echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php
# Access: http://your-ip/info.php (remove after checking!)
```

---

## Estimated Costs (AWS)

- **t2.micro (1GB RAM)**: ~$8.50/month (Free tier: 750 hours/month for 12 months)
- **t2.small (2GB RAM)**: ~$17/month (Recommended for production)
- **Elastic IP**: Free when attached to running instance
- **Storage (20GB EBS)**: ~$2/month
- **Data Transfer**: First 1GB free, then $0.09/GB

**Total**: ~$10-20/month depending on instance type and usage

---

## Next Steps

1. Test all functionality (login, submit complaints, admin dashboard)
2. Create backup strategy
3. Set up monitoring (CloudWatch, custom scripts)
4. Configure domain and SSL certificate
5. Optimize database queries and add indexes
6. Set up log rotation
7. Implement rate limiting for API endpoints
8. Add automated health checks

---

## Support & Resources

- AWS EC2 Documentation: https://docs.aws.amazon.com/ec2/
- Ubuntu Server Guide: https://ubuntu.com/server/docs
- Apache Documentation: https://httpd.apache.org/docs/
- MySQL Documentation: https://dev.mysql.com/doc/
- Flask Deployment: https://flask.palletsprojects.com/en/latest/deploying/

---

**Deployment Date**: January 3, 2026
**Document Version**: 1.0
