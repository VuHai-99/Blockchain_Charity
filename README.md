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
   Variable campaignFactoryAddress in API_Blockchain/Autofetch_Blockchain.js have to change to current deployed campaign.
   In .env add CAMPAIGN_FACTORY_ADDRESS="<<current campaign factory address>>"
   ```

7. Default testing wallet ( ít nhất 6 tài khoản )
Owner	0xdB9d76207E8398f140c3346B8A03745e720Bc152
Admin	0x4C713A3983548984D6B9F5adBB2328CC6c3c0530
Authority	0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d
Retailer	0xeF1f703ad77d3c3B0fe8e6BE6735D734f0EFCada
Host_1 (Cold-Wallet)	0x9EF5f229045f9aB196188ebf80bBf80450777816
Host_2 (Hot-Wallet)(website tự tạo cho người dùng)
Donator_1 (Cold-Wallet)	0x93C790c75bC431Aa548BB788786408e9aAC776d4
Donator_2 (Hot-Wallet)(website tự tạo cho người dùng)


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
3. (Optional) Run Fetch & Sync Blockchain with Node JS
   ```sh
   cd API_Blockchain
   node Autofetch_Blockchain.js
   cd ../
   ```


