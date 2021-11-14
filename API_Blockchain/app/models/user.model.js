// const sql = require("./db.js");

// // constructor
// const User = function(user) {
//   this.user_address = user.user_address;
//   this.role = user.role;
//   this.validate_state = user.validate_state;
//   this.private_key = user.private_key;
//   this.current_balance = user.current_balance;
// };

// // User.create = (newUser, result) => {
// //   sql.query("INSERT INTO users SET ?", newUser, (err, res) => {
// //     if (err) {
// //       console.log("error: ", err);
// //       result(err, null);
// //       return;
// //     }

// //     console.log("created user: ", {...newUser });
// //     result(null, { address: res.user_address, ...newUser });
// //   });
// // };

// User.queryFindByAddress = async (user_address, result) => {
//   sql.query(`SELECT * FROM users WHERE user_address = "${user_address}"`, (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(err, null);
//       return err;
//     }
//     if (res.length) {
//       // console.log("found user: ", JSON.stringify(res[0]));
//       result(null, JSON.stringify(res[0]));
//       return result;
//     }
//     result({ kind: "not_found" }, null);
//   });
// };

// User.queryHostFindByAddress = async (user_address, result) => {
//   sql.query(`SELECT * FROM users WHERE user_address = "${user_address}" AND ROLE = "Host" `, (err, res) => {
//     if (err) {
//       console.log("error: ", err);
//       result(err, null);
//       return err;
//     }
//     if (res.length) {
//       // console.log("found user: ", JSON.stringify(res[0]));
//       result(null, JSON.stringify(res[0]));
//       return result;
//     }
//     result({ kind: "not_found" }, null);
//   });
// };


// // User.getAll = result => {
// //   sql.query("SELECT * FROM users", (err, res) => {
// //     if (err) {
// //       console.log("error: ", err);
// //       result(null, err);
// //       return;
// //     }

// //     console.log("users: ", res);
// //     result(null, res);
// //   });
// // };

// // User.updateById = (id, user, result) => {
// //   sql.query(
// //     "UPDATE users SET email = ?, name = ?, active = ? WHERE id = ?",
// //     [user.email, user.name, user.active, id],
// //     (err, res) => {
// //       if (err) {
// //         console.log("error: ", err);
// //         result(null, err);
// //         return;
// //       }

// //       if (res.affectedRows == 0) {
// //         // not found User with the id
// //         result({ kind: "not_found" }, null);
// //         return;
// //       }

// //       console.log("updated user: ", { id: id, ...user });
// //       result(null, { id: id, ...user });
// //     }
// //   );
// // };

// // User.remove = (id, result) => {
// //   sql.query("DELETE FROM users WHERE id = ?", id, (err, res) => {
// //     if (err) {
// //       console.log("error: ", err);
// //       result(null, err);
// //       return;
// //     }

// //     if (res.affectedRows == 0) {
// //       // not found User with the id
// //       result({ kind: "not_found" }, null);
// //       return;
// //     }

// //     console.log("deleted user with id: ", id);
// //     result(null, res);
// //   });
// // };

// // User.removeAll = result => {
// //   sql.query("DELETE FROM users", (err, res) => {
// //     if (err) {
// //       console.log("error: ", err);
// //       result(null, err);
// //       return;
// //     }

// //     console.log(`deleted ${res.affectedRows} users`);
// //     result(null, res);
// //   });
// // };

// module.exports = User;

const sql = require("./db.js");

// constructor
const User = function(user) {
  this.user_address = user.user_address;
  this.role = user.role;
  this.validate_state = user.validate_state;
  this.private_key = user.private_key;
  this.current_balance = user.current_balance;
};

User.queryFindByAddress = async (user_address, result) => {
  sql.query(`SELECT * FROM users WHERE user_address = "${user_address}"`, (err, res) => {
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

User.queryHostFindByAddress = async (user_address, result) => {
  sql.query(`SELECT * FROM users WHERE user_address = "${user_address}" AND ROLE = 1 `, (err, res) => {
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


module.exports = User;