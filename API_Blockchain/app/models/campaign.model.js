const sql = require("./db.js");

// constructor
const Campaign = function(campaign) {
  this.campaign_address = campaign.campaign_address;
  this.host_address = campaign.host_address;
  this.minimum_contribution = campaign.minimum_contribution;
  this.minimum_target = campaign.minimum_target;
  this.current_balance = campaign.current_balance;
  this.start_date = campaign.start_date;
  this.end_date = campaign.end_date;
};

Campaign.create = (newCampaign, result) => {
  sql.query("INSERT INTO campaigns SET ?", newCampaign, (err, res) => {
    if (err) {
      // console.log("error: ", err);
      result(err, null);
      return;
    }
    console.log("created campaign: ", { address: res.campaign_address, ...newCampaign });
    result(null, { address: res.campaign_address, ...newCampaign });
  });
};

Campaign.updateBalance = async (campaign_address,amount, result) => {
  sql.query(`UPDATE campaigns SET current_balance = "${amount}" WHERE campaigns.campaign_address = "${campaign_address}"`, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);
      return err;
    }
    if (res.length) {
      // console.log("found user: ", JSON.stringify(res[0]));
      result(null, JSON.stringify(res[0]));
      return result;
    }
    result({ kind: "not_found" }, null);
  });
};

module.exports = Campaign;