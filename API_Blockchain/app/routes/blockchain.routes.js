module.exports = app => {
    const campaignFactoryBlockchain = require("../controllers/campaign.factory.blockchain.controller.js");
    const campaignBlockchain = require("../controllers/campaign.blockchain.controller.js");

    app.get("/create/newAccount", campaignFactoryBlockchain.createNewWallet);
    app.get("/fetch/balance/:user_address", campaignBlockchain.fetchBalanceAccount);
    app.get("/sync/balance/:user_address", campaignBlockchain.syncBalanceAccount);
    app.get("/sync/balance/campaign/:campaign_address", campaignBlockchain.syncBalanceCampaign);
    app.post("/validate/metaMaskSignature", campaignFactoryBlockchain.validateSignature);
};