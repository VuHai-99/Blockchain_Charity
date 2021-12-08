module.exports = app => {
  const campaignBlockchain = require("../controllers/campaign.blockchain.controller.js");
  const campaignFactoryBlockchain = require("../controllers/campaign.factory.blockchain.controller.js");

  app.post("/host/donate/campaign/:campaign_address", campaignBlockchain.donateToCampaign);
  app.post("/host/validate/request", campaignFactoryBlockchain.requestToBeValidHost);
  app.post("/host/create/campaign/request", campaignFactoryBlockchain.requestToOpenCampaign);
  app.post("/host/create/donationActivity/request", campaignBlockchain.requestToCreateDonationActivity);
  app.post("/host/create/donationActivityCashout/request", campaignBlockchain.requestToCreateDonationActivityCashout);
  app.post("/host/withdraw/campaign/request", campaignFactoryBlockchain.requestToWithdrawMoney);
  app.post("/host/list/openCampaign/request", campaignFactoryBlockchain.getHostRequestToOpenCampaignList);
  app.post("/host/cancel/openCampaign/request", campaignFactoryBlockchain.cancelRequestOpenCampaign);
  app.post("/host/cancel/openDonationActivity/request", campaignBlockchain.cancelRequestOpenDonationActivity);
  app.post("/host/cancel/createDonationActivityCashout/request", campaignBlockchain.cancelRequestCreateDonationActivityCashout);
  
};