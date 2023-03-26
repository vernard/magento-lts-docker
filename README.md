This repository is based off [OpenMage/Magento-LTS](https://github.com/OpenMage/magento-lts). 

# Installation

> I did a screen recording while installing this repository on a [Linux](https://www.loom.com/share/33d53f2140574e5a95e70d14e72562b0) and [Windows](https://www.loom.com/share/7329342460314171b8a1f15ea99048c5) OS. If you prefer watching videos than reading, you may want to watch these videos instead.

1. You must have these installed. I've documented the installation instructions at the bottom of this document.
    - [git](#how-to-install-git), 
    - [composer 2](#how-to-install-php-and-composer-2), 
    - [docker, and docker-compose](#how-to-docker-and-docker-compose)

2. Clone this repository to your machine

3. Run `composer install`

4. Run `docker-compose up -d`. Make sure that port 80 (http), 443 (https), 3306 (mysql), 1080, and 8080 are open.

5. Update your hosts file and add whatever host you want. You can skip this step and stick to `localhost`, but it's a good idea to use a different virtual host name per project.
    
    In this case, we'll use `magento-lts.local`.
    > Hosts file is located at `/etc/hosts` in Linux OS 
    while it's located at `C:/Windows/system32/drivers/etc/hosts` in Windows OS
    
    Add this line to your hosts file:
    ```
    127.0.0.1       magento-lts.local
    ```

6. Run the wizard by visiting `magento-lts.local` in your browser, or run the install script.

    **Linux OS (docker-based installation)**
    ```bash
    docker-compose exec -u application php php -f install.php -- --license_agreement_accepted yes \
      --locale en_US --timezone "America/Los_Angeles" --default_currency USD \
      --db_host db --db_name magento --db_user magento --db_pass magento \
      --url "http://magento-lts.local/" --use_rewrites yes \
      --use_secure yes --secure_base_url "https://magento-lts.local/" --use_secure_admin yes \
      --admin_lastname Owner --admin_firstname Store --admin_email "admin@example.com" \
      --admin_username admin --admin_password 123123password
    ```

    **Windows OS (wamp-based installation)**
    ```bash
    php -f install.php -- --license_agreement_accepted yes \
      --locale en_US --timezone "America/Los_Angeles" --default_currency USD \
      --db_host db --db_name magento --db_user magento --db_pass magento \
      --url "http://magento-lts.local/" --use_rewrites yes \
      --use_secure yes --secure_base_url "https://magento-lts.local/" --use_secure_admin yes \
      --admin_lastname Owner --admin_firstname Store --admin_email "admin@example.com" \
      --admin_username admin --admin_password 123123password
    ```
    
    This creates ad admin user `admin` with a password of `123123password` (14 alphanumeric characters required for password, so deal with it). 
    
    Change the script if you want to use a different **username, password, or if you used a different host name**. 
    
    Check out the file in `pub/install.php` if you want to know the possible options and how to customize this.
    
## Setting up your local development machine (Linux OS) 

<a name="how-to-docker-and-docker-compose"></a>
### How to install Docker & Docker Compose
You must have [docker](https://docker.com/) and [docker-compose](https://docs.docker.com/compose/install/) command installed to use this repository.


Follow the Docker installation instructions here: https://docs.docker.com/engine/install/ubuntu/ or just copy paste the instructions below.
1. Set up the repository
    ```
    sudo apt-get update
    sudo apt-get install \
        ca-certificates \
        curl \
        gnupg \
        lsb-release
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
    echo \
      "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
      $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    ```
2. Install Docker Engine
    ```
    sudo apt-get update
    sudo apt-get install docker-ce docker-ce-cli containerd.io
    ```

3. Verify that docker is installed
    ```
    docker -v
    ```

4. Install Docker Compose by following these instructions: https://docs.docker.com/compose/install/ or just copy paste the instructions below.
    ```
    sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
    docker-compose --version # Check if it's installed
    ```

5. Change the permission of /var/run/docker.sock
    ```
    sudo nano /etc/systemd/system/sockets.target.wants/docker.socket
    ```
    Change the file content to this: (don't forget to change the `SocketUser` value)
    ```
    [Unit]
    Description=Docker Socket for the API
    
    [Socket]
    ListenStream=/var/run/docker.sock
    SocketMode=0660
    SocketUser=YOUR_USERNAME_HERE     #### Edit this line to what your linux user is
    SocketGroup=docker
    
    [Install]
    WantedBy=sockets.target
    ```

6. Add the group `docker` to the current user.
```bash
### This creates the group if it doesn't exist yet
sudo groupadd docker    

### This attaches current user to `docker` group
sudo usermod -aG docker $USER

### Reload user to reflect new group
su - $USER

### Double check that `docker` is in your current group
groups
```


<a name="how-to-install-git"></a>
### How to install Git
```bash
sudo apt-get update
sudo apt-get install git

git --version # Verify that it's installed

# Replace with your actual name and email
git config --global user.name "Your Name"
git config --global user.email "youremail@example.com"
```

<a name="how-to-install-php-and-composer-2"></a>
### How to install PHP and Composer 2 

```bash
sudo apt-get update && sudo apt-get upgrade
sudo apt-get install php

### Remove apache2 in case it got installed with PHP
sudo apt remove apache2

### Install Composer 2
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo chmod +x composer.phar
sudo mv composer.phar /usr/local/bin/composer
```
