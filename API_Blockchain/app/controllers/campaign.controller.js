const Campaign = require("../models/campaign.model.js");

// Create and Save a new Campaign
exports.create = (req, res) => {
    // Validate request
    if (!req.body) {
      res.status(400).send({
        message: "Content can not be empty!"
      });
    }
  
    // Create a Campaign
    const campaign = new Campaign({
      campaign_address: req.body.campaign_address,
      host_address: req.body.host_address,
      minimum_contribution: req.body.minimum_contribution,
      minimum_target: req.body.minimum_target,
      current_balance: req.body.current_balance,
      start_date: req.body.start_date,
      end_date: req.body.end_date,
    });
  
    // Save Campaign in the database
    Campaign.create(campaign, (err, data) => {
      if (err)
        res.status(500).send({
          message:
            err.message || "Some error occurred while creating the Campaign."
        });
      else res.send(data);
    });
  };

