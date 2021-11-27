module.exports = app => {
    const campaignFactoryBlockchain = require("../controllers/campaign.factory.blockchain.controller.js");

    app.get("/create/newAccount", campaignFactoryBlockchain.createNewWallet);
    app.post("/validate/metaMaskSignature", campaignFactoryBlockchain.validateSignature);
};