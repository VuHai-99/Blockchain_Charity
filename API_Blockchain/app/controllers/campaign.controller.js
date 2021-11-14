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

// // Retrieve all Campaigns from the database.
// exports.findAll = (req, res) => {
//     Campaign.getAll((err, data) => {
//       if (err)
//         res.status(500).send({
//           message:
//             err.message || "Some error occurred while retrieving campaigns."
//         });
//       else res.send(data);
//     });
//   };

// // Find a single Campaign with a campaignId
// exports.findOne = (req, res) => {
//     Campaign.findById(req.params.campaignId, (err, data) => {
//       if (err) {
//         if (err.kind === "not_found") {
//           res.status(404).send({
//             message: `Not found Campaign with id ${req.params.campaignId}.`
//           });
//         } else {
//           res.status(500).send({
//             message: "Error retrieving Campaign with id " + req.params.campaignId
//           });
//         }
//       } else res.send(data);
//     });
//   };
  
// // Update a Campaign identified by the campaignId in the request
// exports.update = (req, res) => {
//     // Validate Request
//     if (!req.body) {
//       res.status(400).send({
//         message: "Content can not be empty!"
//       });
//     }
  
//     Campaign.updateById(
//       req.params.campaignId,
//       new Campaign(req.body),
//       (err, data) => {
//         if (err) {
//           if (err.kind === "not_found") {
//             res.status(404).send({
//               message: `Not found Campaign with id ${req.params.campaignId}.`
//             });
//           } else {
//             res.status(500).send({
//               message: "Error updating Campaign with id " + req.params.campaignId
//             });
//           }
//         } else res.send(data);
//       }
//     );
//   };
// // Delete a Campaign with the specified campaignId in the request
// exports.delete = (req, res) => {
//     Campaign.remove(req.params.campaignId, (err, data) => {
//       if (err) {
//         if (err.kind === "not_found") {
//           res.status(404).send({
//             message: `Not found Campaign with id ${req.params.campaignId}.`
//           });
//         } else {
//           res.status(500).send({
//             message: "Could not delete Campaign with id " + req.params.campaignId
//           });
//         }
//       } else res.send({ message: `Campaign was deleted successfully!` });
//     });
//   };

// // Delete all Campaigns from the database.
// exports.deleteAll = (req, res) => {
//     Campaign.removeAll((err, data) => {
//       if (err)
//         res.status(500).send({
//           message:
//             err.message || "Some error occurred while removing all campaigns."
//         });
//       else res.send({ message: `All Campaigns were deleted successfully!` });
//     });
//   };