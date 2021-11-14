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

// Campaign.findById = (campaignId, result) => {
//   sql.query(`SELECT * FROM campaigns WHERE id = ${campaignId}`, (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(err, null);
//       return;
//     }

//     if (res.length) {
//       console.log("found campaign: ", res[0]);
//       result(null, res[0]);
//       return;
//     }

//     // not found Campaign with the id
//     result({ kind: "not_found" }, null);
//   });
// };

// Campaign.getAll = result => {
//   sql.query("SELECT * FROM campaigns", (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(null, err);
//       return;
//     }

//     console.log("campaigns: ", res);
//     result(null, res);
//   });
// };

// Campaign.updateById = (id, campaign, result) => {
//   sql.query(
//     "UPDATE campaigns SET email = ?, name = ?, active = ? WHERE id = ?",
//     [campaign.email, campaign.name, campaign.active, id],
//     (err, res) => {
//       if (err) {
//         console.log("error: ", err);
//         result(null, err);
//         return;
//       }

//       if (res.affectedRows == 0) {
//         // not found Campaign with the id
//         result({ kind: "not_found" }, null);
//         return;
//       }

//       console.log("updated campaign: ", { id: id, ...campaign });
//       result(null, { id: id, ...campaign });
//     }
//   );
// };

// Campaign.remove = (id, result) => {
//   sql.query("DELETE FROM campaigns WHERE id = ?", id, (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(null, err);
//       return;
//     }

//     if (res.affectedRows == 0) {
//       // not found Campaign with the id
//       result({ kind: "not_found" }, null);
//       return;
//     }

//     console.log("deleted campaign with id: ", id);
//     result(null, res);
//   });
// };

// Campaign.removeAll = result => {
//   sql.query("DELETE FROM campaigns", (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(null, err);
//       return;
//     }

//     console.log(`deleted ${res.affectedRows} campaigns`);
//     result(null, res);
//   });
// };

module.exports = Campaign;