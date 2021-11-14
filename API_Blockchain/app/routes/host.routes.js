module.exports = app => {
  const campaignBlockchain = require("../controllers/campaign.blockchain.controller.js");
  const campaignFactoryBlockchain = require("../controllers/campaign.factory.blockchain.controller.js");

  app.post("/host/donate/campaign/:campaign_address", campaignBlockchain.donateToCampaign);
  app.post("/host/validate/request", campaignFactoryBlockchain.requestToBeValidHost);
  app.post("/host/create/campaign/request", campaignFactoryBlockchain.requestToOpenCampaign);
  app.post("/host/withdraw/campaign/request", campaignFactoryBlockchain.requestToWithdrawMoney);
  app.post("/host/list/openCampaign/request", campaignFactoryBlockchain.getHostRequestToOpenCampaignList);
};