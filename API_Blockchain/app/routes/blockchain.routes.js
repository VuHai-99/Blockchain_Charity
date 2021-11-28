module.exports = app => {
    const campaignFactoryBlockchain = require("../controllers/campaign.factory.blockchain.controller.js");
    const campaignBlockchain = require("../controllers/campaign.blockchain.controller.js");

    app.get("/create/newAccount", campaignFactoryBlockchain.createNewWallet);
    app.get("/fetch/balance/:user_address", campaignBlockchain.fetchBalanceAccount);
    app.post("/validate/metaMaskSignature", campaignFactoryBlockchain.validateSignature);
};