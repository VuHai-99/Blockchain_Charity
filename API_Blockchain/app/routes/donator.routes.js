module.exports = app => {
    const campaignBlockchain = require("../controllers/campaign.blockchain.controller.js");

    app.post("/donator/donate/campaign/:campaign_address", campaignBlockchain.donateToCampaign);

  };