This repository is based off [OpenMage/Magento-LTS](https://github.com/OpenMage/magento-lts). 

## Setting up your local development machine (Linux OS) 

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