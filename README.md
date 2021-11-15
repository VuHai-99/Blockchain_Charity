## Blockchain Charity


## Getting Started

This is an example of how you may give instructions on setting up your project locally.
To get a local copy up and running follow these simple example steps.

### Prerequisites

* node.js (Website node.js version : 14.17.5)
* npm (Website npm version : 6.14.4)
* composer (Website composer version : 2.5.4)
* xampp (Website xampp version : 3.3.0)
* ganache (Website Ganache version : 2.5.4)

### Installation

1. Install truffle globally.
   ```sh
   npm install -g truffle@5.4.16
   ```
2. Install NPM packages in folders : API_Blockchain
   ```sh
   cd API_Blockchain
   npm install
   change API_Blockchain\app\config\laravel_db.config.js variable DB to your new DB for website
   cd ../
   ```
3. Reproduce Laravel Project : Tutorial https://viblo.asia/p/cach-cai-dat-du-an-laravel-clone-tu-github-63vKjkpkZ2R
   ```js
   cd blockchain_charity_repo
   -- Tutorial https://viblo.asia/p/cach-cai-dat-du-an-laravel-clone-tu-github-63vKjkpkZ2R
   Change this in .env : 
      MAIL_MAILER=smtp
      MAIL_HOST=smtp.gmail.com
      MAIL_PORT=587
      MAIL_USERNAME=<gmail_username>
      MAIL_PASSWORD=<gmail_password>
      MAIL_ENCRYPTION=tls
      MAIL_FROM_ADDRESS=<gmail_username>
      MAIL_FROM_NAME="Laravel Blockchain"
   npm run dev & npm run watch
   ```
4. Install Metamask extension in Chrome (Website Metamask version : 10.5.1))
   ```sh
   create account in metamask
   ```
5. Connect Metamask to local blockchain (ganache) and import all account inside metamask

    ```sh
   "Setting up MetaMask" section in https://www.trufflesuite.com/docs/truffle/getting-started/truffle-with-metamask
   ```

6. Initial Blockchain Contract & store API in laravel project
   ```sh
   open ganache -> new workspace : Save this workplace once and use it everytime run website
   cd Blockchain_Truffle
   truffle migrate --reset
   copy (if exist replace) folder Blockchain_Truffle/build/contracts into blockchain_charity_repo/public --> blockchain_charity_repo/public/
   replace 2 file Campaign.json and CampaignFactory.json in API_Blockchain\contracts with new Campaign.json and CampaignFactory.json in blockchain_charity_repo/public/
   ```


## Usage

1. Run Node.js
   ```sh
   cd API_Blockchain
   node server.js
   cd ../
   ```
2. Run Laravel
   ```sh
   cd blockchain_charity_repo
   php artisan serve
   cd ../
   ```

