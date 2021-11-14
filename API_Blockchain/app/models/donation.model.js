const sql = require("./db.js");

// constructor
const Donation = function(donation) {
  this.donation_transaction_hash = donation.donation_transaction_hash;
  this.donator_address = donation.donator_address;
  this.campaign_address = donation.campaign_address;
  this.donation_amount = donation.donation_amount;
  // this.donation_time = donation.donation_time;
};

Donation.create = (newDonation, result) => {
  sql.query("INSERT INTO donations SET ?", newDonation, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);
      return;
    }

    console.log("created donation: ", {...newDonation });
    result(null, {...newDonation });
  });
};

// Donation.findById = (donationId, result) => {
//   sql.query(`SELECT * FROM donations WHERE id = ${donationId}`, (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(err, null);
//       return;
//     }

//     if (res.length) {
//       console.log("found donation: ", res[0]);
//       result(null, res[0]);
//       return;
//     }

//     // not found Donation with the id
//     result({ kind: "not_found" }, null);
//   });
// };

// Donation.getAll = result => {
//   sql.query("SELECT * FROM donations", (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(null, err);
//       return;
//     }

//     console.log("donations: ", res);
//     result(null, res);
//   });
// };

// Donation.updateById = (id, donation, result) => {
//   sql.query(
//     "UPDATE donations SET email = ?, name = ?, active = ? WHERE id = ?",
//     [donation.email, donation.name, donation.active, id],
//     (err, res) => {
//       if (err) {
//         console.log("error: ", err);
//         result(null, err);
//         return;
//       }

//       if (res.affectedRows == 0) {
//         // not found Donation with the id
//         result({ kind: "not_found" }, null);
//         return;
//       }

//       console.log("updated donation: ", { id: id, ...donation });
//       result(null, { id: id, ...donation });
//     }
//   );
// };

// Donation.remove = (id, result) => {
//   sql.query("DELETE FROM donations WHERE id = ?", id, (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(null, err);
//       return;
//     }

//     if (res.affectedRows == 0) {
//       // not found Donation with the id
//       result({ kind: "not_found" }, null);
//       return;
//     }

//     console.log("deleted donation with id: ", id);
//     result(null, res);
//   });
// };

// Donation.removeAll = result => {
//   sql.query("DELETE FROM donations", (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(null, err);
//       return;
//     }

//     console.log(`deleted ${res.affectedRows} donations`);
//     result(null, res);
//   });
// };

module.exports = Donation;