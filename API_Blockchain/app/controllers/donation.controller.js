const Donation = require("../models/donation.model.js");

// Create and Save a new Donation
exports.create = (req, res) => {
    // Validate request
    if (!req.body) {
      res.status(400).send({
        message: "Content can not be empty!"
      });
    }
  
    // Create a Donation
    const donation = new Donation({
      donation_transaction_hash : req.body.donation_transaction_hash ,
      donator_address: req.body.donator_address,
      campaign_address: req.body.campaign_address,
      donation_amount: req.body.donation_amount,
    });
  
    // Save Donation in the database
    Donation.create(donation, (err, data) => {
      if (err)
        res.status(500).send({
          message:
            err.message || "Some error occurred while creating the Donation."
        });
      else res.send(data);
    });
  };

// // Retrieve all Donations from the database.
// exports.findAll = (req, res) => {
//     Donation.getAll((err, data) => {
//       if (err)
//         res.status(500).send({
//           message:
//             err.message || "Some error occurred while retrieving donations."
//         });
//       else res.send(data);
//     });
//   };

// // Find a single Donation with a donationId
// exports.findOne = (req, res) => {
//     Donation.findById(req.params.donationId, (err, data) => {
//       if (err) {
//         if (err.kind === "not_found") {
//           res.status(404).send({
//             message: `Not found Donation with id ${req.params.donationId}.`
//           });
//         } else {
//           res.status(500).send({
//             message: "Error retrieving Donation with id " + req.params.donationId
//           });
//         }
//       } else res.send(data);
//     });
//   };
  
// // Update a Donation identified by the donationId in the request
// exports.update = (req, res) => {
//     // Validate Request
//     if (!req.body) {
//       res.status(400).send({
//         message: "Content can not be empty!"
//       });
//     }
  
//     Donation.updateById(
//       req.params.donationId,
//       new Donation(req.body),
//       (err, data) => {
//         if (err) {
//           if (err.kind === "not_found") {
//             res.status(404).send({
//               message: `Not found Donation with id ${req.params.donationId}.`
//             });
//           } else {
//             res.status(500).send({
//               message: "Error updating Donation with id " + req.params.donationId
//             });
//           }
//         } else res.send(data);
//       }
//     );
//   };
// // Delete a Donation with the specified donationId in the request
// exports.delete = (req, res) => {
//     Donation.remove(req.params.donationId, (err, data) => {
//       if (err) {
//         if (err.kind === "not_found") {
//           res.status(404).send({
//             message: `Not found Donation with id ${req.params.donationId}.`
//           });
//         } else {
//           res.status(500).send({
//             message: "Could not delete Donation with id " + req.params.donationId
//           });
//         }
//       } else res.send({ message: `Donation was deleted successfully!` });
//     });
//   };

// // Delete all Donations from the database.
// exports.deleteAll = (req, res) => {
//     Donation.removeAll((err, data) => {
//       if (err)
//         res.status(500).send({
//           message:
//             err.message || "Some error occurred while removing all donations."
//         });
//       else res.send({ message: `All Donations were deleted successfully!` });
//     });
//   };